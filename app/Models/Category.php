<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'image', 'show_in_menu'];

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}