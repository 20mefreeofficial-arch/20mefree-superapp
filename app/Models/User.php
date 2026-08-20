<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role_id', 'division_id', 'reports_to_id', 'is_active'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Default di level model (bukan cuma default kolom DB) supaya user yang
     * baru dibuat langsung punya is_active=true di memori juga, tanpa harus
     * di-refresh dulu dari database.
     */
    protected $attributes = [
        'is_active' => true,
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function reportsTo()
    {
        return $this->belongsTo(User::class, 'reports_to_id');
    }

    public function subordinates()
    {
        return $this->hasMany(User::class, 'reports_to_id');
    }

    public function hasRole(string $slug): bool
    {
        return $this->role?->slug === $slug;
    }

    /**
     * Super Admin selalu full access (bypass), tanpa bergantung pada baris
     * di role_permissions — supaya sistem tidak pernah terkunci total kalau
     * data permission belum/salah diatur.
     */
    public function isSuperAdmin(): bool
    {
        return $this->hasRole('super_admin');
    }

    /**
     * Cek hak akses CRUD user ini terhadap satu fungsi modul, dengan
     * mempertimbangkan konteks divisi user (permission yang di-scope ke
     * divisi lain tidak berlaku baginya).
     *
     * @param  'view'|'create'|'update'|'delete'  $action
     */
    public function hasPermission(string $moduleSlug, string $functionSlug, string $action): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        if (! $this->is_active || ! $this->role_id) {
            return false;
        }

        $column = 'can_'.$action;

        return RolePermission::query()
            ->where('role_id', $this->role_id)
            ->where($column, true)
            ->whereHas('moduleFunction', function ($query) use ($moduleSlug, $functionSlug) {
                $query->where('slug', $functionSlug)
                    ->whereHas('module', fn ($q) => $q->where('slug', $moduleSlug));
            })
            ->where(function ($query) {
                $query->whereNull('division_id')
                    ->orWhere('division_id', $this->division_id);
            })
            ->exists();
    }
}
