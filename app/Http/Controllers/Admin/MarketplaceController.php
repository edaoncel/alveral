<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Setting;
use Illuminate\Support\Str;

class MarketplaceController extends Controller
{
public function settings()
{
    $urunler = Product::latest()->get();
    $syncedProductsCount = Product::count();

    // Son senkronizasyon zamanını alıyoruz
    $lastSyncSetting = \App\Models\Setting::where('key', 'last_sync_time')->first();

    if ($lastSyncSetting) {
        $lastSyncTime = \Carbon\Carbon::parse($lastSyncSetting->value);
    } else {
        // Eğer veritabanında hiç kayıt yoksa, şimdi kaydediyoruz ki her yenilemede sıfırlanmasın
        $lastSyncTime = now();
        \App\Models\Setting::create([
            'key' => 'last_sync_time',
            'value' => $lastSyncTime
        ]);
    }

    // 15 dakika sonraki hedef zaman
    $nextSyncTime = $lastSyncTime->copy()->addMinutes(15);
    
    // Şu an ile hedef zaman arasındaki kalan saniye
    $timeLeft = now()->diffInSeconds($nextSyncTime, false);
    
    // Eğer 15 dakika geçmişse süreyi sıfırlayıp son senkronizasyon zamanını güncelliyoruz
    if ($timeLeft <= 0) {
        $lastSyncTime = now();
        $lastSyncSetting->update(['value' => $lastSyncTime]);
        $timeLeft = 900;
    }

    return view('admin.marketplaces.settings', compact('urunler', 'syncedProductsCount', 'timeLeft'));
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

public function uploadAndSync(Request $request)
    {
        // Zaman aşımı ve bellek sınırını artırıyoruz (Binlerce ürün için şart)
        set_time_limit(300);
        ini_set('memory_limit', '512M');

        $xmlContent = null;

        // 1. URL girildiyse veritabanına kalıcı olarak kaydedelim
        if ($request->filled('xml_url')) {
            $xmlUrl = $request->input('xml_url');
            Setting::updateOrCreate(
                ['key' => 'saved_xml_url'],
                ['value' => $xmlUrl]
            );
        } 

        // Kayıtlı URL'yi veritabanından çekelim
        $savedSetting = Setting::where('key', 'saved_xml_url')->first();
        $xmlUrl = $savedSetting ? $savedSetting->value : null;

        // 2. Eğer URL üzerinden çekilecekse
        if ($xmlUrl && !$request->hasFile('xml_dosyasi')) {
            try {
                $xmlContent = @file_get_contents($xmlUrl);
            } catch (\Exception $e) {
                return redirect()->back()->with('error', "Kaydedilmiş XML URL adresine ulaşılamadı!");
            }
        } 
        // 3. Eğer yeni bir dosya yüklendiyse
        elseif ($request->hasFile('xml_dosyasi') && $request->file('xml_dosyasi')->isValid()) {
            $file = $request->file('xml_dosyasi');
            $fileName = 'supplier_feed.xml';
            $file->move(public_path('uploads'), $fileName);
            
            $xmlPath = public_path('uploads/' . $fileName);
            $xmlContent = @file_get_contents($xmlPath);

            Setting::updateOrCreate(
                ['key' => 'saved_xml_path'],
                ['value' => $xmlPath]
            );
        }
        // 4. Önceden yüklenmiş sabit dosya veya URL var mı kontrol edelim
        else {
            $pathSetting = Setting::where('key', 'saved_xml_path')->first();
            if ($pathSetting && file_exists($pathSetting->value)) {
                $xmlContent = @file_get_contents($pathSetting->value);
            } elseif ($xmlUrl) {
                try {
                    $xmlContent = @file_get_contents($xmlUrl);
                } catch (\Exception $e) {}
            }
        }

        if (!$xmlContent) {
            return redirect()->back()->with('error', "Lütfen geçerli bir XML URL adresi girin veya XML dosyası yükleyin!");
        }

        $xml = @simplexml_load_string($xmlContent);
        if ($xml === false) {
            return redirect()->back()->with('error', "XML içeriği okunamadı veya bozuk formatta!");
        }

        $firma_kar = session('mp_trendyol_kar', 26.00);
        $eklenenSayisi = 0;
        $guncellenenSayisi = 0;
        
        $urunlerListesi = isset($xml->product) ? $xml->product : ($xml->Urun ?? ($xml->item ?? []));

        // Kategorileri hafızada tutarak her döngüde sorgu atmayı önleyelim
        $categoryCache = Category::pluck('id', 'name')->toArray();

        foreach ($urunlerListesi as $urun) {
            $stok_kodu = trim((string)($urun->sku ?? $urun->StokKodu ?? $urun->Stok_Kodu ?? ''));
            if (empty($stok_kodu)) continue;

            $urun_adi = mb_substr(trim((string)($urun->name ?? $urun->UrunAdi ?? $urun->Baslik ?? 'İsimsiz Ürün')), 0, 255);
            
            $model_code = trim((string)($urun->model_code ?? $urun->ModelCode ?? $urun->ModelKodu ?? $urun->Model ?? ''));
            $color      = trim((string)($urun->color ?? $urun->Color ?? $urun->Renk ?? ''));
            $aciklama   = (string)($urun->description ?? $urun->Aciklama ?? $urun->Detay ?? $urun->details ?? '');
            
            $marka      = 'Alveral'; 
            $barkod     = trim((string)($urun->barcode ?? $urun->Barcode ?? $urun->Barkod ?? $urun->GTIN ?? $urun->Ean ?? ''));
            
            $alis_fiyati = floatval($urun->price ?? $urun->Fiyat ?? $urun->AlisFiyati ?? 0);
            $stok = intval($urun->stock ?? $urun->Stok ?? $urun->Adet ?? 10);
            
            // Satış fiyatı hesaplama (Doğru matematiksel işlem)
            $satis_fiyati = round($alis_fiyati * (1 + ($firma_kar / 100)), 2);
            $gender = trim((string)($urun->gender ?? $urun->Gender ?? $urun->Cinsiyet ?? ''));

            // Kategori işleme (Önbellek destekli)
            $kategoriAdi = trim((string)($urun->category ?? $urun->Kategori ?? 'Genel'));
            $categoryId = null;
            if (!empty($kategoriAdi)) {
                if (!isset($categoryCache[$kategoriAdi])) {
                    $category = Category::firstOrCreate(
                        ['name' => $kategoriAdi],
                        ['slug' => Str::slug($kategoriAdi)]
                    );
                    $categoryCache[$kategoriAdi] = $category->id;
                }
                $categoryId = $categoryCache[$kategoriAdi];
            }

            // Görsel işleme
            $gorseller = [];
            if (isset($urun->images)) {
                if (isset($urun->images->image)) {
                    foreach ($urun->images->image as $img) {
                        $url = trim((string)$img);
                        if (!empty($url)) $gorseller[] = $url;
                    }
                } else {
                    foreach ($urun->images->children() as $img) {
                        $url = trim((string)$img);
                        if (!empty($url)) $gorseller[] = $url;
                    }
                }
            }

            // Ürün veritabanında var mı kontrol ediyoruz
            $existingProduct = Product::where('sku', $stok_kodu)->first();

            if ($existingProduct) {
                // Hassas float ve stok karşılaştırması
                $eskiFiyat = round((float)$existingProduct->price, 2);
                $yeniFiyat = round((float)($satis_fiyati > 0 ? $satis_fiyati : $existingProduct->price), 2);

                $eskiStok  = (int)$existingProduct->stock;
                $yeniStok  = (int)$stok;

                $isPriceChanged = abs($eskiFiyat - $yeniFiyat) > 0.001;
                $isStockChanged = $eskiStok !== $yeniStok;

                // SADECE Gerçekten Fiyat veya Stok Değiştiyse Güncelle (updated_at sadece o zaman oynar)
                if ($isPriceChanged || $isStockChanged) {
                    $existingProduct->update([
                        'price'       => $yeniFiyat,
                        'stock'       => $yeniStok,
                        'images'      => !empty($gorseller) ? $gorseller : $existingProduct->images,
                        'category_id' => $categoryId ?? $existingProduct->category_id,
                    ]);
                    $guncellenenSayisi++;
                }
            } else {
                // Yeni ürün ilk defa ekleniyor
                Product::create([
                    'sku'         => $stok_kodu,
                    'name'        => $urun_adi,
                    'brand'       => $marka,
                    'barcode'     => $barkod,
                    'model_code'  => $model_code,
                    'color'       => $color,
                    'gender'      => $gender,
                    'description' => $aciklama,
                    'slug'        => Str::slug($urun_adi) . '-' . uniqid(),
                    'price'       => $satis_fiyati > 0 ? $satis_fiyati : 100.00,
                    'stock'       => $stok,
                    'images'      => $gorseller,
                    'category_id' => $categoryId,
                ]);

                $eklenenSayisi++;
            }
        }

        Setting::updateOrCreate(['key' => 'last_sync_time'], ['value' => now()]);

        return redirect()->back()->with('success', "Senkronizasyon başarılı: Eklenen: {$eklenenSayisi}, Güncellenen: {$guncellenenSayisi}");
    }
}