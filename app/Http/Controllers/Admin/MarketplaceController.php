<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Str;

class MarketplaceController extends Controller
{
    // Pazaryeri Yönetimi / Ayarlar Sayfası
    public function settings()
    {
        $urunler = Product::latest()->get();
        return view('admin.marketplaces.settings', compact('urunler'));
    }

// Pazaryeri Ayarlarını ve API Bilgilerini Günceller
    public function updateMargin(Request $request)
    {
        $pazaryeri = $request->input('pazaryeri');
        $yeni_kar = floatval($request->input('varsayilan_kar', 26));
        $aktif = $request->has('aktif') ? true : false;
        
        // API Bilgileri
        $api_key = $request->input('api_key');
        $api_secret = $request->input('api_secret');
        $merchant_id = $request->input('merchant_id');

        // Ayarları session içerisinde pazaryerine özel saklıyoruz
        session([
            "mp_{$pazaryeri}_kar" => $yeni_kar,
            "mp_{$pazaryeri}_aktif" => $aktif,
            "mp_{$pazaryeri}_key" => $api_key,
            "mp_{$pazaryeri}_secret" => $api_secret,
            "mp_{$pazaryeri}_merchant" => $merchant_id,
        ]);

        return redirect()->back()->with('success', ucfirst($pazaryeri) . " pazaryeri ayarları başarıyla güncellendi!");
    }

    // XML Yükleme ve SKU ile Senkronizasyon
    public function uploadAndSync(Request $request)
    {
        if ($request->hasFile('xml_dosyasi') && $request->file('xml_dosyasi')->isValid()) {
            $file = $request->file('xml_dosyasi');
            $xmlPath = $file->getRealPath();
            
            if (file_exists($xmlPath)) {
                $previous_value = libxml_use_internal_errors(true);
                $xml = simplexml_load_file($xmlPath);
                
                if ($xml === false) {
                    libxml_clear_errors();
                    return redirect()->back()->with('error', "XML dosyası okunamadı veya geçersiz formatta!");
                }

                $firma_kar = session('alveral_kar', 26.00); 
                $sayac = 0;

                $urunlerListesi = isset($xml->Urun) ? $xml->Urun : ($xml->item ?? $xml->children());

                foreach ($urunlerListesi as $urun) {
                    $stok_kodu = trim((string)($urun->StokKodu ?? $urun->sku ?? $urun->ProductCode ?? ''));
                    $urun_adi = (string)($urun->UrunAdi ?? $urun->name ?? $urun->Title ?? 'İsimsiz Ürün');
                    $alis_fiyati = floatval($urun->Fiyat ?? $urun->price ?? $urun->BuyingPrice ?? 0);
                    $stok = intval($urun->Stok ?? $urun->stock ?? 0);
                    $affiliate_url = (string)($urun->Link ?? $urun->url ?? '#');
                    
                    if (empty($stok_kodu)) {
                        continue;
                    }

                    $satis_fiyati = round($alis_fiyati * (1 + ($firma_kar / 100)), 2);

                    // Mevcut ürününüzü SKU üzerinden bulup güncelliyoruz, yoksa ekliyoruz
                    $dbProduct = Product::where('sku', $stok_kodu)->first();

                    if ($dbProduct) {
                        $dbProduct->name = $urun_adi;
                        $dbProduct->price = $satis_fiyati;
                        $dbProduct->stock = $stok;
                        if (isset($dbProduct->affiliate_url)) {
                            $dbProduct->affiliate_url = $affiliate_url;
                        }
                        $dbProduct->save();
                    } else {
                        Product::create([
                            'sku' => $stok_kodu,
                            'name' => $urun_adi,
                            'slug' => Str::slug($urun_adi) . '-' . rand(1000, 9999),
                            'price' => $satis_fiyati,
                            'stock' => $stok,
                            'affiliate_url' => $affiliate_url,
                        ]);
                    }
                    $sayac++;
                }

                return redirect()->back()->with('success', "Alveral XML başarıyla işlendi: <b>{$sayac}</b> adet ürün güncellendi/eklendi!");
            }
        }

        return redirect()->back()->with('error', "Geçerli bir XML dosyası yüklenemedi!");
    }
}