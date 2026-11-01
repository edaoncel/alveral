<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'discount_price',
        'stock',
        'sku',
        'trendyol_url',
        'hepsiburada_url',
        'idefix_url',
        'amazon_url',
        'pazarama_url',
        'images',
        'category_id',
        'is_best_seller'
    ];

    protected $casts = [
        'images' => 'array',
    ];

public function category()
{
    return $this->belongsTo(Category::class, 'category_id');
}
}