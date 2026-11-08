<?php

use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Log;
use App\Models\Setting;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

Schedule::call(function () {
    try {
        $savedSetting = Setting::where('key', 'saved_xml_url')->first();
        $pathSetting = Setting::where('key', 'saved_xml_path')->first();
        
        $xmlContent = null;

        if ($savedSetting && !empty($savedSetting->value)) {
            $urlWithCache = $savedSetting->value . '?t=' . time();
            $xmlContent = @file_get_contents($urlWithCache);
        } elseif ($pathSetting && file_exists($pathSetting->value)) {
            $xmlContent = @file_get_contents($pathSetting->value);
        }

        if (!$xmlContent) {
            Log::warning("XML Otomatik Senkronizasyon: XML içeriği bulunamadı.");
            return;
        }

        $xml = @simplexml_load_string($xmlContent);
        if ($xml === false) {
            Log::warning("XML Otomatik Senkronizasyon: XML parse edilemedi.");
            return;
        }

        $firma_kar = 26.00;
        $urunlerListesi = isset($xml->product) ? $xml->product : ($xml->Urun ?? ($xml->item ?? $xml->children()));

        foreach ($urunlerListesi as $urun) {
            $stok_kodu = trim((string)($urun->sku ?? $urun->StokKodu ?? ''));
            if (empty($stok_kodu)) continue;

            $urun_adi = (string)($urun->name ?? $urun->UrunAdi ?? 'İsimsiz');
            $alis_fiyati = floatval($urun->price ?? $urun->Fiyat ?? 0);
            $stok = intval($urun->stock ?? $urun->Stok ?? 10);
            $kategoriAdi = trim((string)($urun->category ?? $urun->Kategori ?? 'Genel'));

            if (!empty($kategoriAdi)) {
                Category::firstOrCreate(
                    ['name' => $kategoriAdi],
                    ['slug' => Str::slug($kategoriAdi), 'show_in_menu' => 1]
                );
            }

            $gorseller = [];
            if (isset($urun->images->image)) {
                foreach ($urun->images->image as $img) {
                    $gorseller[] = (string)$img;
                }
            }

            $satis_fiyati = round($alis_fiyati * (1 + ($firma_kar / 100)), 2);

            Product::updateOrCreate(
                ['sku' => $stok_kodu],
                [
                    'name'              => $urun_adi,
                    'slug'              => Str::slug($urun_adi) . '-' . rand(1000, 9999),
                    'price'             => $satis_fiyati > 0 ? $satis_fiyati : 100.00,
                    'stock'             => $stok,
                    'images'            => $gorseller,
                    'affiliate_url'     => '#',
                    'is_synced_updated' => true,
                ]
            );
        }
        Log::info("XML Otomatik Senkronizasyon: Başarıyla tamamlandı.");
    } catch (\Exception $e) {
        Log::error("XML Otomatik Senkronizasyon Hatası: " . $e->getMessage());
    }
})->everyThirtyMinutes();