<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class MarketplaceController extends Controller
{
    /**
     * Pazar yerleri ayarlar sayfasını görüntüler.
     */
    public function settings()
    {
        $urunler = Product::latest()->get();
        return view('admin.marketplaces.settings', compact('urunler'));
    }

    /**
     * Kâr Oranını Günceller
     */
    public function updateMargin(Request $request)
    {
        $yeni_kar = floatval($request->input('varsayilan_kar', 26));
        session(['alveral_kar' => $yeni_kar]);

        return redirect()->back()->with('success', "Alveral kâr oranı %{$yeni_kar} olarak güncellendi!");
    }

    /**
     * XML Dosyasını Yükler, SKU ile Eşleştirir ve Günceller
     */
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
            
            $eklenenSayisi = 0;
            $guncellenenSayisi = 0;

            $urunlerListesi = isset($xml->Urun) ? $xml->Urun : ($xml->item ?? $xml->children());

            foreach ($urunlerListesi as $urun) {
                $stok_kodu = trim((string)($urun->StokKodu ?? $urun->sku ?? $urun->ProductCode ?? ''));
                if (empty($stok_kodu)) {
                    continue;
                }

                $urun_adi = mb_substr(trim((string)($urun->UrunAdi ?? $urun->name ?? $urun->Title ?? 'İsimsiz Ürün')), 0, 255);
                $alis_fiyati = floatval($urun->Fiyat ?? $urun->price ?? $urun->BuyingPrice ?? 0);
                $stok = intval($urun->Stok ?? $urun->stock ?? 0);
                $affiliate_url = trim((string)($urun->Link ?? $urun->url ?? '#'));
                
                // DÜZELTİLDİ: Çarpı (*) işareti eklendi
                $satis_fiyati = round($alis_fiyati * (1 + ($firma_kar / 100)), 2);

                $dbProduct = Product::where('sku', $stok_kodu)->first();

                if ($dbProduct) {
                    // Mevcut ürünün bilgilerini XML'den gelen yeni verilerle atıyoruz
                    $dbProduct->name = $urun_adi;
                    $dbProduct->price = $satis_fiyati;
                    $dbProduct->stock = $stok;
                    $dbProduct->affiliate_url = $affiliate_url;

                    // Modelin herhangi bir alanı değiştiyse isDirty yakalayacak ve save() çalışacaktır
                    if ($dbProduct->isDirty()) {
                        Log::info("Güncellenen Ürün SKU: {$stok_kodu}");
                        
                        // save() metodu çağrıldığı an Model içindeki booted() tetiklenir 
                        // ve last_action_note otomatik doldurulur!
                        $dbProduct->save();
                        $guncellenenSayisi++;
                    }
                } else {
                    // Yeni ürün ilk kez ekleniyor
                    Product::create([
                        'sku' => $stok_kodu,
                        'name' => $urun_adi,
                        'slug' => Str::slug($urun_adi) . '-' . rand(1000, 9999),
                        'price' => $satis_fiyati,
                        'stock' => $stok,
                        'affiliate_url' => $affiliate_url,
                    ]);

                    $eklenenSayisi++;
                }
            }

            return redirect()->back()->with('success', "Senkronizasyon başarılı: Eklenen: {$eklenenSayisi}, Güncellenen: {$guncellenenSayisi}");
        }
    }

    return redirect()->back()->with('error', "Geçerli bir XML dosyası yüklenemedi!");
}
}