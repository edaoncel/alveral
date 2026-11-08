<?php

namespace App\Models;
use App\Models\Category;

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
        'last_action_note', // YENİ: Otomatik değişiklik notu için eklendi
    ];

    protected $casts = [
        'images' => 'array',
    ];

    public function category()
{
    return $this->belongsTo(Category::class, 'category_id');
}

protected static function booted()
    {
        static::updating(function ($product) {
            $changes = [];
            $time = now()->format('H:i'); // O anki saat

            if ($product->isDirty('name')) {
                $changes[] = 'Ürün adı değiştirildi';
            }
            if ($product->isDirty('category_id')) {
                $changes[] = 'Kategori değiştirildi';
            }
            // YENİ: Fiyat ve indirimli fiyatı ayırdık
            if ($product->isDirty('price')) {
                $changes[] = 'Fiyat güncellendi';
            }
            if ($product->isDirty('discount_price')) {
                $changes[] = 'İndirimli fiyat güncellendi';
            }
            if ($product->isDirty('stock')) {
                $changes[] = 'Stok adedi güncellendi';
            }
            if ($product->isDirty('sku')) {
                $changes[] = 'SKU kodu güncellendi';
            }
            if ($product->isDirty('barcode')) {
                $changes[] = 'Barkod değiştirildi';
            }
            if ($product->isDirty('brand')) {
                $changes[] = 'Marka güncellendi';
            }
            if ($product->isDirty('model_code')) {
                $changes[] = 'Model kodu değiştirildi';
            }
            if ($product->isDirty('color')) {
                $changes[] = 'Renk güncellendi';
            }
            if ($product->isDirty('gender')) {
                $changes[] = 'Cinsiyet güncellendi';
            }
            if ($product->isDirty('description')) {
                $changes[] = 'Açıklama güncellendi';
            }
            if ($product->isDirty('images')) {
                $changes[] = 'Görseller güncellendi';
            }
            if (
                $product->isDirty('trendyol_url') || 
                $product->isDirty('hepsiburada_url') || 
                $product->isDirty('idefix_url') || 
                $product->isDirty('amazon_url') || 
                $product->isDirty('pazarama_url')
            ) {
                $changes[] = 'Pazaryeri linkleri güncellendi';
            }

            // Değişiklikleri birleştirme
            if (!empty($changes)) {
                $actionText = implode(', ', $changes);
                $product->last_action_note = "{$actionText} - {$time}";
            } else {
                $product->last_action_note = "Ürün bilgileri güncellendi - {$time}";
            }
        });
    }
}