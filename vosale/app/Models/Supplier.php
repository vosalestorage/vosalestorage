<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = ['name', 'module', 'phone', 'email', 'address'];

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}