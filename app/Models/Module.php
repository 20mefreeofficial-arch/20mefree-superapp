<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'slug', 'description', 'sort_order', 'is_active'])]
class Module extends Model
{
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function functions()
    {
        return $this->hasMany(ModuleFunction::class)->orderBy('sort_order');
    }
}
