<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['division_id', 'role_id', 'name', 'code'])]
class Position extends Model
{
    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
