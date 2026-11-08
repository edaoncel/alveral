<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use App\Models\Setting;
use App\Models\Category;
use App\Models\Product;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->latest()->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'show_in_menu' => 'nullable|boolean',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('categories', 'public');
        }

        $bannerPath = null;
        if ($request->hasFile('banner_image')) {
            $bannerPath = $request->file('banner_image')->store('categories/banners', 'public');
        }

        $slug = Str::slug($validated['name']);
        $originalSlug = $slug;
        $count = 1;

        while (Category::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        Category::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'image' => $imagePath,
            'banner_image' => $bannerPath,
            'show_in_menu' => $request->has('show_in_menu') ? 1 : 0,
        ]);

        return back()->with('success', 'Kategori ve görselleri başarıyla eklendi.');
    }

    public function edit(Category $category)
    {
        $categories = Category::withCount('products')->latest()->get();
        return view('admin.categories.edit', compact('category', 'categories'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'show_in_menu' => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            $category->image = $request->file('image')->store('categories', 'public');
        }

        if ($request->hasFile('banner_image')) {
            if ($category->banner_image) {
                Storage::disk('public')->delete($category->banner_image);
            }
            $category->banner_image = $request->file('banner_image')->store('categories/banners', 'public');
        }

        $slug = Str::slug($validated['name']);
        $originalSlug = $slug;
        $count = 1;

        while (Category::where('slug', $slug)->where('id', '!=', $category->id)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        $category->name = $validated['name'];
        $category->slug = $slug;
        $category->show_in_menu = $request->has('show_in_menu') ? 1 : 0;
        $category->save();

        return redirect()->route('admin.categories.index')->with('success', 'Kategori başarıyla güncellendi.');
    }

    public function destroy(Category $category)
    {
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }
        
        if ($category->banner_image) {
            Storage::disk('public')->delete($category->banner_image);
        }
        
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Kategori başarıyla silindi.');
    }

public function syncFromXml()
{
    $savedSetting = Setting::where('key', 'saved_xml_url')->first();
    $pathSetting = Setting::where('key', 'saved_xml_path')->first();
    
    $xmlContent = null;

    if ($savedSetting && !empty($savedSetting->value)) {
        try {
            $xmlContent = @file_get_contents($savedSetting->value . '?t=' . time());
        } catch (\Exception $e) {
            // URL okunamazsa dosya yolunu deneriz
        }
    } 
    
    if (!$xmlContent && $pathSetting && file_exists($pathSetting->value)) {
        $xmlContent = @file_get_contents($pathSetting->value);
    }

    if (!$xmlContent) {
        return redirect()->back()->with('error', "Kayıtlı bir XML URL adresi veya dosyası bulunamadı!");
    }

    $xml = @simplexml_load_string($xmlContent);
    if ($xml === false) {
        return redirect()->back()->with('error', "XML içeriği okunamadı veya bozuk formatta!");
    }

    $urunlerListesi = isset($xml->product) ? $xml->product : ($xml->Urun ?? ($xml->item ?? $xml->children()));
    $eklenenSayisi = 0;
    $firma_kar = 26.00;

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
        $eklenenSayisi++;
    }

    return redirect()->back()->with('success', "Senkronizasyon başarılı: <b>{$eklenenSayisi}</b> ürün başarıyla işlendi ve güncellendi!");
}

public function deleteAllCategories()
{
    // 1. Ürünlerin kategori bağlantılarını sıfırlıyoruz (Veritabanı ilişkisi hatası almamak için)
    \App\Models\Product::whereNotNull('category_id')->update(['category_id' => null]);

    // 2. Tüm kategorileri siliyoruz
    \App\Models\Category::query()->delete();

    return redirect()->back()->with('success', 'Tüm kategoriler başarıyla silindi ve ürün bağları temizlendi!');
}
}