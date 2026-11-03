<?php

use Illuminate\Support\Facades\Schedule;
use App\Models\Setting;
use App\Models\Product;
use App\Models\Category;

Schedule::call(function () {
    $savedSetting = Setting::where('key', 'saved_xml_url')->first();
    $pathSetting = Setting::where('key', 'saved_xml_path')->first();
    
    $xmlContent = null;

    if ($savedSetting && !empty($savedSetting->value)) {
        $xmlContent = @file_get_contents($savedSetting->value);
    } elseif ($pathSetting && file_exists($pathSetting->value)) {
        $xmlContent = @file_get_contents($pathSetting->value);
    }

    if (!$xmlContent) return;

    $xml = @simplexml_load_string($xmlContent);
    if ($xml === false) return;

    $firma_kar = 26.00;
    $urunlerListesi = isset($xml->product) ? $xml->product : ($xml->Urun ?? []);

    foreach ($urunlerListesi as $urun) {
        $stok_kodu = trim((string)($urun->sku ?? $urun->StokKodu ?? ''));
        if (empty($stok_kodu)) continue;

        $urun_adi = (string)($urun->name ?? $urun->UrunAdi ?? 'İsimsiz');
        $alis_fiyati = floatval($urun->price ?? $urun->Fiyat ?? 0);
        $stok = intval($urun->stock ?? $urun->Stok ?? 10);
        
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
                'name' => $urun_adi,
                'slug' => \Illuminate\Support\Str::slug($urun_adi) . '-' . rand(1000, 9999),
                'price' => $satis_fiyati > 0 ? $satis_fiyati : 100.00,
                'stock' => $stok,
                'images' => $gorseller,
                'affiliate_url' => '#'
            ]
        );
    }
})->everyFifteenMinutes();