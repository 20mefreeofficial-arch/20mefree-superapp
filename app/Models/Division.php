<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'slug', 'description'])]
class Division extends Model
{
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
