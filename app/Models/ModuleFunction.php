<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['module_id', 'name', 'slug', 'description', 'sort_order'])]
class ModuleFunction extends Model
{
    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function rolePermissions()
    {
        return $this->hasMany(RolePermission::class);
    }
}
