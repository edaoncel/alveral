@extends('layouts.admin')

@section('title', 'Alveral - Ürün Düzenle')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-slate-200">
    <h1 class="text-2xl font-extrabold text-gray-800 mb-6">Ürünü Düzenle</h1>

    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-4 text-sm">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')

        <div x-data="{ count: {{ mb_strlen(old('name', $product->name ?? '')) }} }">
            <div class="flex justify-between items-center mb-1">
                <label class="block text-gray-700 font-medium text-sm">Ürün Adı</label>
                <span class="text-xs font-semibold text-gray-400" x-text="count + ' / 36'"></span>
            </div>
            <input type="text" 
                name="name" 
                value="{{ old('name', $product->name) }}" 
                maxlength="36" 
                @input="count = $el.value.length" 
                class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-blue-500 focus:outline-none text-sm" 
                required>
        </div>

        <div>
            <label class="block text-gray-700 font-medium mb-1 text-sm">Stok Kodu (SKU) <span class="text-xs text-slate-400 font-normal">(Benzersiz Kod)</span></label>
            <input type="text" 
                name="sku" 
                value="{{ old('sku', $product->sku ?? '') }}" 
                class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-blue-500 focus:outline-none text-sm uppercase" 
                placeholder="Örn: PRD-2026-001">
        </div>

        <div>
            <label class="block text-gray-700 font-medium mb-1 text-sm">Kategori</label>
            <select name="category_id" class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-blue-500 focus:outline-none text-sm bg-white">
                <option value="">Kategori Seçin</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ (old('category_id', $product->category_id) == $cat->id) ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>
        
        <div x-data="{ count: {{ mb_strlen(old('description', $product->description ?? '')) }} }">
            <div class="flex justify-between items-center mb-1">
                <label class="block text-gray-700 font-medium text-sm">Ürün Açıklaması</label>
                <span class="text-xs font-semibold text-gray-400" x-text="count + ' / 505'"></span>
            </div>
            <textarea name="description" 
                    rows="3" 
                    maxlength="505" 
                    @input="count = $el.value.length" 
                    class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-blue-500 focus:outline-none text-sm" 
                    placeholder="Ürün hakkında detaylar...">{{ old('description', $product->description) }}</textarea>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label class="block text-gray-700 font-medium mb-1 text-sm">Fiyat (₺)</label>
                <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-blue-500 focus:outline-none text-sm" required>
            </div>
            <div>
                <label class="block text-gray-700 font-medium mb-1 text-sm">İndirimli Fiyat (₺) <span class="text-xs text-gray-400 font-normal">(İsteğe Bağlı)</span></label>
                <input type="number" step="0.01" name="discount_price" value="{{ old('discount_price', $product->discount_price ?? '') }}" class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-blue-500 focus:outline-none text-sm" placeholder="Varsa indirimli fiyat">
            </div>
            <div>
                <label class="block text-gray-700 font-medium mb-1 text-sm">Stok Adedi</label>
                <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-blue-500 focus:outline-none text-sm" required>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
            <div>
                <label class="block text-xs font-bold uppercase text-gray-600 mb-1">Trendyol Linki</label>
                <input type="url" name="trendyol_url" value="{{ old('trendyol_url', $product->trendyol_url ?? '') }}" class="w-full border rounded-xl px-4 py-2 text-sm" placeholder="https://www.trendyol.com/...">
            </div>
            <div>
                <label class="block text-xs font-bold uppercase text-gray-600 mb-1">Hepsiburada Linki</label>
                <input type="url" name="hepsiburada_url" value="{{ old('hepsiburada_url', $product->hepsiburada_url ?? '') }}" class="w-full border rounded-xl px-4 py-2 text-sm" placeholder="https://www.hepsiburada.com/...">
            </div>
            <!-- <div>
                <label class="block text-xs font-bold uppercase text-gray-600 mb-1">İdefix Linki</label>
                <input type="url" name="idefix_url" value="{{ old('idefix_url', $product->idefix_url ?? '') }}" class="w-full border rounded-xl px-4 py-2 text-sm" placeholder="https://www.idefix.com/...">
            </div>
            <div>
                <label class="block text-xs font-bold uppercase text-gray-600 mb-1">Amazon Linki</label>
                <input type="url" name="amazon_url" value="{{ old('amazon_url', $product->amazon_url ?? '') }}" class="w-full border rounded-xl px-4 py-2 text-sm" placeholder="https://www.amazon.com.tr/...">
            </div>
            <div class="md:col-span-2">
                <label class="block text-xs font-bold uppercase text-gray-600 mb-1">Pazarama Linki</label>
                <input type="url" name="pazarama_url" value="{{ old('pazarama_url', $product->pazarama_url ?? '') }}" class="w-full border rounded-xl px-4 py-2 text-sm" placeholder="https://www.pazarama.com/...">
            </div> -->
        </div>

        @if($product->images && count($product->images) > 0)
            <div>
                <label class="block text-gray-700 font-medium mb-2 text-sm">Mevcut Görseller (Silmek istediklerinizi seçin)</label>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    @foreach($product->images as $img)
                        <div class="relative bg-slate-50 border border-slate-200 rounded-xl p-2.5 flex flex-col items-center shadow-sm">
                            <img src="{{ asset($img) }}" class="w-20 h-20 object-cover rounded-lg shadow-sm mb-2">
                            <label class="flex items-center gap-1.5 text-xs text-red-600 font-semibold cursor-pointer hover:underline">
                                <input type="checkbox" name="delete_images[]" value="{{ $img }}" class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                                Bu resmi sil
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div>
            <label class="block text-gray-700 font-medium mb-1 text-sm">Yeni Görsel Ekle (İsteğe bağlı)</label>
            <input type="file" name="images[]" multiple accept=".jpg, .jpeg, .png, .webp" class="w-full border border-gray-300 rounded-xl p-2.5 bg-white text-sm">
        </div>

        <div class="flex items-center gap-3 bg-slate-50 p-4 rounded-xl border border-slate-200">
            <input type="checkbox" name="is_best_seller" id="is_best_seller" value="1" {{ (isset($product) && $product->is_best_seller) || old('is_best_seller') ? 'checked' : '' }} class="w-5 h-5 text-brandOrange border-gray-300 rounded focus:ring-brandOrange">
            <label for="is_best_seller" class="text-sm font-bold text-gray-800 cursor-pointer">
                Haftanın En Çok Satanlar Listesine Ekle <span class="text-xs font-normal text-slate-500">(Vitrin üst kısmında özel bento alanda sergilenir, max 7 ürün)</span>
            </label>
        </div>

        <div class="flex justify-between items-center pt-4 border-t border-slate-100">
            <a href="{{ route('admin.products.index') }}" class="text-gray-600 hover:underline text-sm font-medium">Geri Dön</a>
            <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-blue-700 transition text-sm shadow-sm">Değişiklikleri Kaydet</button>
        </div>
    </form>
</div>
@endsection