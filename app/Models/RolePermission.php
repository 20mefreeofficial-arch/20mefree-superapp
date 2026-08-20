<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['role_id', 'module_function_id', 'division_id', 'can_view', 'can_create', 'can_update', 'can_delete'])]
class RolePermission extends Model
{
    protected function casts(): array
    {
        return [
            'can_view' => 'boolean',
            'can_create' => 'boolean',
            'can_update' => 'boolean',
            'can_delete' => 'boolean',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function moduleFunction()
    {
        return $this->belongsTo(ModuleFunction::class);
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }
}
