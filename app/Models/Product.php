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
        'is_best_seller',
        'brand',
        'barcode',
        'affiliate_url',
        'model_code',
        'gender',
        'color',
    ];

    protected $casts = [
        'images' => 'array',
    ];

    /**
     * Görüntüleri her zaman güvenli bir dizi (array) olarak döndürür.
     * Veritabanında string veya bozuk JSON olsa bile sistem asla patlamaz.
     */
    public function getImagesAttribute($value)
    {
        if (is_array($value)) {
            return $value;
        }

        if (is_string($value)) {
            $decoded = json_decode($value, true);
            if (is_array($decoded)) {
                return $decoded;
            }
            // Eğer JSON değil de düz metin (tek bir resim yolu) ise dizi içinde döndür
            return !empty($value) ? [$value] : [];
        }

        return [];
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // Trendyol için akıllı link (Direkt link varsa onu, yoksa arama linkini döndürür)
public function getTrendyolAffiliateUrlAttribute()
{
    if (!empty($this->attributes['trendyol_url'])) {
        return $this->attributes['trendyol_url'];
    }
    
    $query = urlencode($this->name);
    return "https://www.trendyol.com/sr?q={$query}";
}

    public function getHepsiburadaAffiliateUrlAttribute()
    {
        if (!empty($this->attributes['hepsiburada_url'])) {
            return $this->attributes['hepsiburada_url'];
        }

        $query = urlencode($this->name);
        return "https://www.hepsiburada.com/ara?q={$query}";
    }
}