<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('sku', 'like', '%' . $searchTerm . '%');
            });
        }

        if ($request->filled('filter')) {
            if ($request->filter == 'discounted') {
                $query->whereNotNull('discount_price')->where('discount_price', '>', 0);
            } elseif ($request->filter == 'bestseller') {
                $query->where('is_best_seller', true); 
            }
        }

        $products = $query->latest()->paginate(18)->fragment('urunler');

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:36',
            'sku' => 'nullable|string|max:50|unique:products,sku',
            'category_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string|max:505',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'stock' => 'required|integer|min:0',
            'trendyol_url' => 'nullable|url',
            'hepsiburada_url' => 'nullable|url',
            'idefix_url' => 'nullable|url',
            'amazon_url' => 'nullable|url',
            'pazarama_url' => 'nullable|url',
            'is_best_seller' => 'nullable|boolean',
        ]);

        // SKU boş bırakıldıysa otomatik üret
        if (empty($validated['sku'])) {
            $validated['sku'] = 'SKU-' . strtoupper(Str::random(8));
        } else {
            $validated['sku'] = strtoupper($validated['sku']);
        }

        if ($request->has('is_best_seller')) {
            $validated['is_best_seller'] = true;
            
            if (Product::where('is_best_seller', true)->count() >= 7) {
                $oldest = Product::where('is_best_seller', true)->oldest()->first();
                if ($oldest) {
                    $oldest->update(['is_best_seller' => false]);
                }
            }
        } else {
            $validated['is_best_seller'] = false;
        }

        $imagePaths = [];

        if ($request->hasFile('images')) {
            $destinationPath = public_path('img/products');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            foreach ($request->file('images') as $image) {
                if ($image && $image->isValid()) {
                    $ext = strtolower($image->getClientOriginalExtension());
                    if (in_array($ext, ['jpeg', 'png', 'jpg', 'webp']) && $image->getSize() <= (2048 * 1024)) {
                        $imageName = time() . '_' . uniqid() . '.' . $ext;
                        $image->move($destinationPath, $imageName);
                        $imagePaths[] = 'img/products/' . $imageName;
                    }
                }
            }
        }

        $validated['images'] = $imagePaths;
        $validated['slug'] = Str::slug($request->name) . '-' . uniqid();

        Product::create($validated);

        return redirect()->route('admin.products.index')->with('success', 'Ürün başarıyla eklendi.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

public function update(Request $request, Product $product)
{
    // Ürün adı 36 karakterden uzunsa otomatik olarak ilk 36 karakterini alıyoruz
    if ($request->has('name')) {
        $request->merge([
            'name' => mb_substr($request->input('name'), 0, 36)
        ]);
    }

    $validated = $request->validate([
        'name' => 'required|string|max:36',
        'brand' => 'nullable|string|max:255',
        'barcode' => 'nullable|string|max:255',
        'sku' => 'nullable|string|max:255',
        'category_id' => 'nullable|exists:categories,id',
        'description' => 'nullable|string|max:505',
        'price' => 'required|numeric',
        'discount_price' => 'nullable|numeric',
        'stock' => 'required|integer',
        'trendyol_url' => 'nullable|url|max:500',
        'hepsiburada_url' => 'nullable|url|max:500',
        'is_best_seller' => 'nullable|boolean',
    ]);

    // Temel alanları güncelleyelim
    $product->name = $validated['name'];
    $product->brand = $validated['brand'] ?? null;
    $product->barcode = $validated['barcode'] ?? null;
    $product->sku = $validated['sku'] ?? $product->sku;
    $product->category_id = $validated['category_id'] ?? null;
    $product->description = $validated['description'] ?? null;
    $product->price = $validated['price'];
    $product->discount_price = $validated['discount_price'] ?? null;
    $product->stock = $validated['stock'];
    $product->trendyol_url = $validated['trendyol_url'] ?? null;
    $product->hepsiburada_url = $validated['hepsiburada_url'] ?? null;
    $product->is_best_seller = $request->has('is_best_seller') ? 1 : 0;

    // Slug güncellemesi
    $product->slug = \Illuminate\Support\Str::slug($validated['name']) . '-' . $product->id;

    // Görsel silme ve ekleme işlemleri...
    if ($request->has('delete_images')) {
        $existingImages = $product->images ?? [];
        $imagesToKeep = [];
        foreach ($existingImages as $img) {
            if (in_array($img, $request->delete_images)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($img);
            } else {
                $imagesToKeep[] = $img;
            }
        }
        $product->images = $imagesToKeep;
    }

    if ($request->hasFile('images')) {
        $currentImages = $product->images ?? [];
        foreach ($request->file('images') as $file) {
            $path = $file->store('products', 'public');
            $currentImages[] = $path;
        }
        $product->images = $currentImages;
    }

    $product->save();

    return redirect()->route('admin.products.index')->with('success', 'Ürün başarıyla güncellendi.');
}

    public function destroy(Product $product)
    {
        if ($product->images) {
            foreach ($product->images as $img) {
                $filePath = public_path($img);
                if (file_exists($filePath)) {
                    @unlink($filePath);
                }
            }
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Ürün başarıyla silindi.');
    }

public function exportExcel()
{
    $fileName = 'alveral-urun-listesi-' . date('d-m-Y') . '.xls';
    
    $headers = [
        "Content-type"        => "application/vnd.ms-excel; charset=UTF-8",
        "Content-Disposition" => "attachment; filename=$fileName",
        "Pragma"              => "no-cache",
        "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
        "Expires"             => "0"
    ];

    $products = Product::with('category')->get();

    $trToEn = function ($text) {
        if (is_null($text)) return '-';
        $search  = ['ç', 'Ç', 'ğ', 'Ğ', 'ı', 'İ', 'ö', 'Ö', 'ş', 'Ş', 'ü', 'Ü'];
        $replace = ['c', 'C', 'g', 'G', 'i', 'I', 'o', 'O', 's', 'S', 'u', 'U'];
        return str_replace($search, $replace, (string)$text);
    };

    $callback = function() use ($products, $trToEn) {
        echo "\xEF\xBB\xBF"; // UTF-8 BOM
        
        echo '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">';
        echo '<head>';
        echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
        echo '<style>';
        echo '  table { border-collapse: collapse; font-family: "Segoe UI", Tahoma, Arial, sans-serif; font-size: 13px; width: 100%; }';
        echo '  th { background-color: #1b5e20; color: #ffffff; font-weight: bold; text-align: center; border: 1px solid #0d3b10; padding: 12px; white-space: nowrap; }';
        echo '  td { border: 1px solid #dcdcdc; padding: 10px; vertical-align: middle; }';
        echo '  .row-even { background-color: #f9f9f9; }';
        echo '  .num-cell { text-align: right; font-weight: 500; }';
        echo '  .center-cell { text-align: center; }';
        echo '</style>';
        echo '</head>';
        echo '<body>';
        echo '<table>';
        
        // Tablo Başlıkları (İstediğiniz Sütunlar - İdefix, Amazon ve Pazarama çıkarıldı)
        echo '<thead>';
        echo '<tr>';
        echo '<th style="width: 150px;">SKU</th>';
        echo '<th style="width: 150px;">Barkod</th>';
        echo '<th style="width: 150px;">Marka</th>';
        echo '<th style="width: 180px;">Kategori</th>';
        echo '<th style="width: 100px;">Stok Adedi</th>';
        echo '<th style="width: 300px;">Ürün Adı</th>';
        echo '<th style="width: 350px;">Açıklama</th>';
        echo '<th style="width: 120px;">Renk</th>';
        echo '<th style="width: 120px;">Cinsiyet</th>';
        echo '<th style="width: 130px;">Fiyat (TL)</th>';
        echo '<th style="width: 150px;">İndirimli Fiyat (TL)</th>';
        echo '<th style="width: 250px;">Trendyol Linki</th>';
        echo '<th style="width: 250px;">Hepsiburada Linki</th>';
        echo '<th style="width: 400px;">Görsel Linkleri</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $i = 0;
        foreach ($products as $product) {
            $rowClass = ($i % 2 === 0) ? '' : 'class="row-even"';
            
            // Görsel yollarını tam URL'ye dönüştürüp virgülle birleştiriyoruz
            $imageLinks = '-';
            if (!empty($product->images) && is_array($product->images)) {
                $fullImageUrls = array_map(function($img) {
                    return url($img);
                }, $product->images);
                $imageLinks = implode(', ', $fullImageUrls);
            }

            echo "<tr $rowClass>";
            echo '<td class="center-cell" style="font-weight: bold;">' . htmlspecialchars($trToEn($product->sku)) . '</td>';
            echo '<td class="center-cell">' . htmlspecialchars($trToEn($product->barcode ?? '-')) . '</td>';
            echo '<td>' . htmlspecialchars($trToEn($product->brand ?? '-')) . '</td>';
            echo '<td>' . htmlspecialchars($trToEn($product->category->name ?? 'Kategorisiz')) . '</td>';
            echo '<td class="center-cell" style="font-weight: bold; color: #2e7d32;">' . $product->stock . '</td>';
            echo '<td>' . htmlspecialchars($trToEn($product->name)) . '</td>';
            echo '<td>' . htmlspecialchars($trToEn(strip_tags($product->description ?? '-'))) . '</td>';
            echo '<td class="center-cell">' . htmlspecialchars($trToEn($product->color ?? '-')) . '</td>';
            echo '<td class="center-cell">' . htmlspecialchars($trToEn($product->gender ?? '-')) . '</td>';
            echo '<td class="num-cell">' . number_format($product->price, 2, ',', '.') . ' TL</td>';
            echo '<td class="num-cell">' . ($product->discount_price ? number_format($product->discount_price, 2, ',', '.') . ' TL' : '-') . '</td>';
            echo '<td>' . htmlspecialchars($trToEn($product->trendyol_url ?? '-')) . '</td>';
            echo '<td>' . htmlspecialchars($trToEn($product->hepsiburada_url ?? '-')) . '</td>';
            echo '<td>' . htmlspecialchars($imageLinks) . '</td>';
            echo '</tr>';
            
            $i++;
        }

        echo '</tbody>';
        echo '</table>';
        echo '</body>';
        echo '</html>';
    };

    return response()->stream($callback, 200, $headers);
}

    public function destroyAll()
    {
        \App\Models\Product::truncate();

        return redirect()->route('admin.products.index')->with('success', 'Veritabanındaki tüm ürünler başarıyla temizlendi.');
    }

        public function updateBrandAll(Request $request)
    {
        $request->validate([
            'new_brand' => 'required|string|max:255',
        ]);

        $newBrand = $request->input('new_brand');

        // Veritabanındaki tüm ürünlerin 'brand' sütununu yeni marka ile günceller
        \App\Models\Product::query()->update(['brand' => $newBrand]);

        return redirect()->route('admin.products.index')->with('success', "Tüm ürünlerin markası başarıyla {$newBrand} olarak güncellendi.");
    }
}