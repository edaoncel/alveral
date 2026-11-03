@extends('layouts.admin')

@section('title', 'Alveral - Ürün Yönetimi')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900">Ürün Yönetimi</h1>
            <p class="text-sm text-slate-500">Vitrin ürünlerini yönetebilir, arayabilir ve yenilerini ekleyebilirsiniz.</p>
        </div>

        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 w-full md:w-auto">
            
            <form action="{{ route('admin.products.index') }}" method="GET" class="relative w-full sm:w-72">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Ürün adı veya SKU ara..." 
                    class="w-full bg-white border border-slate-200 rounded-xl pl-10 pr-14 py-2 text-sm font-medium text-slate-800 focus:outline-none focus:border-brandOrange focus:ring-1 focus:ring-brandOrange transition shadow-sm placeholder:text-slate-400"
                >
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                @if(request('search'))
                    <a href="{{ route('admin.products.index') }}" class="absolute inset-y-0 right-0 pr-3 flex items-center text-xs font-bold text-rose-500 hover:underline">
                        Temizle
                    </a>
                @endif
            </form>

            <a href="{{ route('admin.products.create') }}" class="text-center bg-brandOrange text-white px-5 py-2 rounded-xl text-sm font-bold hover:bg-orange-600 transition shadow-sm whitespace-nowrap">+ Yeni Ürün Ekle</a>
            <a href="{{ route('admin.products.export') }}" class="bg-emerald-600 text-white px-4 py-2 rounded-xl text-sm font-bold hover:bg-emerald-700 transition shadow-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Excel Olarak İndir
            </a>
        </div>
    </div>
    
<div class="flex flex-wrap items-center justify-between gap-4 mb-6">
    
    <div class="flex items-center gap-2 overflow-x-auto pb-2 sm:pb-0">
        <a href="{{ route('admin.products.index', array_merge(request()->except('filter', 'page'), ['filter' => 'all'])) }}" 
           class="px-4 py-2 rounded-xl text-xs font-bold transition {{ !request('filter') || request('filter') == 'all' ? 'bg-slate-900 text-white shadow-sm' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}">
            Tüm Ürünler
        </a>
        <a href="{{ route('admin.products.index', array_merge(request()->except('filter', 'page'), ['filter' => 'discounted'])) }}" 
           class="px-4 py-2 rounded-xl text-xs font-bold transition {{ request('filter') == 'discounted' ? 'bg-red-600 text-white shadow-sm' : 'bg-white text-red-600 border border-red-200 hover:bg-red-50' }}">
            🔥 İndirimli Ürünler
        </a>
        <a href="{{ route('admin.products.index', array_merge(request()->except('filter', 'page'), ['filter' => 'bestseller'])) }}" 
           class="px-4 py-2 rounded-xl text-xs font-bold transition {{ request('filter') == 'bestseller' ? 'bg-amber-600 text-white shadow-sm' : 'bg-white text-amber-600 border border-amber-200 hover:bg-amber-50' }}">
            ⭐ Çok Satanlar
        </a>
    </div>

    <!-- SAĞ: TOPLU İŞLEM BUTONLARI -->
    <div class="flex items-center gap-2">
        <!-- YENİ: TÜM ÜRÜNLERİN MARKASINI DEĞİŞTİR -->
        <form action="{{ route('admin.products.update-brand-all') }}" method="POST" id="bulkBrandForm" class="flex items-center gap-2">
            @csrf
            @method('PUT')
            <input type="hidden" name="new_brand" id="newBrandInput">
            <button type="button" onclick="updateAllBrands()" class="bg-indigo-50 hover:bg-indigo-100 text-indigo-600 border border-indigo-200 px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-2 shadow-2xs">
                <i class="fa-solid fa-tags"></i> Tüm Ürünlerin Markasını Değiştir
            </button>
        </form>

        <!-- TÜM ÜRÜNLERİ SİL -->
        <form action="{{ route('admin.products.destroy-all') }}" method="POST" onsubmit="return confirm('DİKKAT: Veritabanındaki TÜM ürünler kalıcı olarak silinecek! Emin misiniz?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-2 shadow-2xs">
                <i class="fa-solid fa-trash-can"></i> Tüm Ürünleri Sil
            </button>
        </form>
    </div>
</div>

<!-- JavaScript İle Prompt Tetikleme -->
<script>
function updateAllBrands() {
    let brandName = prompt("Tüm ürünlere atanmasını istediğiniz yeni marka adını girin:");
    if (brandName !== null && brandName.trim() !== "") {
        document.getElementById('newBrandInput').value = brandName.trim();
        document.getElementById('bulkBrandForm').submit();
    }
}
</script>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl mb-6 text-sm shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow-sm border border-slate-200 rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 text-slate-600 uppercase text-xs font-semibold tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="py-4 px-4">Görseller</th>
                        <th class="py-4 px-4">Ürün Adı / Kategori</th>
                        <th class="py-4 px-4">Fiyat / İndirimli Fiyat</th>
                        <th class="py-4 px-4">Stok & SKU</th>
                        <th class="py-4 px-4">Marka, Model & Özellikler</th> <!-- Başlığı güncelledik -->
                        <th class="py-4 px-4">Affiliate Linkler</th>
                        <th class="py-4 px-4 text-center">İşlemler</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-600">
                    @forelse($products as $product)
                        <tr class="hover:bg-slate-50/50 transition">
                            <!-- Görseller -->
                            <td class="py-4 px-4 whitespace-nowrap">
                                @if($product->images && count($product->images) > 0)
                                    <div class="flex items-center gap-1.5 overflow-x-auto max-w-[140px] py-1">
                                        @foreach($product->images as $img)
                                            <img src="{{ Str::startsWith($img, 'http') ? $img : asset($img) }}" alt="{{ $product->name }}" class="w-10 h-10 object-cover rounded-lg border border-slate-200 shadow-sm flex-shrink-0">
                                        @endforeach
                                    </div>
                                @else
                                    <div class="w-10 h-10 bg-slate-100 rounded-lg flex items-center justify-center text-slate-400 text-xs font-medium border border-slate-200">
                                        Yok
                                    </div>
                                @endif
                            </td>

                            <!-- Ürün Adı / Kategori / Açıklama -->
                            <td class="py-4 px-4 max-w-xs">
                                <div class="font-bold text-gray-900 text-base mb-0.5">{{ $product->name }}</div>
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="text-xs text-brandBlue font-medium">{{ $product->category->name ?? 'Kategorisiz' }}</span>
                                </div>
                                <div class="text-slate-500 text-xs line-clamp-1">{{ $product->description ?? 'Açıklama girilmemiş.' }}</div>
                            </td>

                            <!-- Fiyat -->
                            <td class="py-4 px-4 whitespace-nowrap">
                                @if($product->discount_price && $product->price > 0)
                                    @php
                                        $discountPercent = round((($product->price - $product->discount_price) / $product->price) * 100);
                                    @endphp
                                    <div class="flex items-center gap-2">
                                        <span class="font-extrabold text-red-600 text-sm">{{ number_format($product->discount_price, 2) }} ₺</span>
                                        <span class="bg-red-100 text-red-700 text-xs font-bold px-2 py-0.5 rounded-full">-%{{ $discountPercent }}</span>
                                    </div>
                                    <div class="text-xs text-gray-400 line-through">Normal: {{ number_format($product->price, 2) }} ₺</div>
                                @else
                                    <div class="font-extrabold text-brandBlue text-base">{{ number_format($product->price, 2) }} ₺</div>
                                @endif
                            </td>

                            <!-- Stok & SKU -->
                            <td class="py-4 px-4 whitespace-nowrap">
                                <div class="text-xs text-slate-500 mb-1">
                                    Stok: <span class="font-semibold text-gray-700">{{ $product->stock }}</span>
                                </div>
                                @if($product->sku)
                                    <div>
                                        <span class="bg-slate-100 text-slate-700 text-[10px] font-mono px-2 py-0.5 rounded border border-slate-200 uppercase">
                                            SKU: {{ $product->sku }}
                                        </span>
                                    </div>
                                @endif
                            </td>

                            <!-- Marka, Barkod, Model, Renk & Cinsiyet -->
                            <td class="py-4 px-4">
                                <div class="flex flex-wrap items-center gap-1.5">
                                    @if($product->brand)
                                        <span class="bg-slate-100 text-slate-700 text-[10px] px-2 py-0.5 rounded-md font-semibold">Marka: {{ $product->brand }}</span>
                                    @endif
                                    @if($product->barcode)
                                        <span class="bg-indigo-50 text-indigo-700 text-[10px] px-2 py-0.5 rounded-md font-mono">Barkod: {{ $product->barcode }}</span>
                                    @endif
                                    @if($product->model_code)
                                        <span class="bg-emerald-50 text-emerald-700 text-[10px] px-2 py-0.5 rounded-md font-mono">Model: {{ $product->model_code }}</span>
                                    @endif
                                    @if($product->color)
                                        <span class="bg-amber-50 text-amber-700 text-[10px] px-2 py-0.5 rounded-md font-semibold">Renk: {{ $product->color }}</span>
                                    @endif
                                    @if($product->gender)
                                        <span class="bg-purple-50 text-purple-700 text-[10px] px-2 py-0.5 rounded-md font-semibold">Cinsiyet: {{ $product->gender }}</span>
                                    @endif
                                </div>
                            </td>
                            <td class="py-4 px-4 max-w-xs">
                                <div class="flex flex-wrap gap-1 max-w-[220px]">
                                    @if($product->trendyol_url)
                                        <a href="{{ $product->trendyol_url }}" target="_blank" class="bg-orange-100 text-orange-700 hover:bg-orange-200 text-[10px] font-bold px-2 py-0.5 rounded transition">Trendyol</a>
                                    @endif
                                    @if($product->hepsiburada_url)
                                        <a href="{{ $product->hepsiburada_url }}" target="_blank" class="bg-amber-100 text-amber-700 hover:bg-amber-200 text-[10px] font-bold px-2 py-0.5 rounded transition">Hepsiburada</a>
                                    @endif
                                    <!-- @if($product->idefix_url)
                                        <a href="{{ $product->idefix_url }}" target="_blank" class="bg-blue-100 text-blue-700 hover:bg-blue-200 text-[10px] font-bold px-2 py-0.5 rounded transition">İdefix</a>
                                    @endif
                                    @if($product->amazon_url)
                                        <a href="{{ $product->amazon_url }}" target="_blank" class="bg-yellow-100 text-yellow-800 hover:bg-yellow-200 text-[10px] font-bold px-2 py-0.5 rounded transition">Amazon</a>
                                    @endif
                                    @if($product->pazarama_url)
                                        <a href="{{ $product->pazarama_url }}" target="_blank" class="bg-red-100 text-red-700 hover:bg-red-200 text-[10px] font-bold px-2 py-0.5 rounded transition">Pazarama</a>
                                    @endif
                                    @if(!$product->trendyol_url && !$product->hepsiburada_url && !$product->idefix_url && !$product->amazon_url && !$product->pazarama_url)
                                        <span class="text-xs text-slate-400 italic">Link eklenmemiş</span>
                                    @endif -->
                                </div>
                            </td>
                            <td class="py-4 px-4 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="bg-amber-500 hover:bg-amber-600 text-white px-3 py-1.5 rounded-lg text-xs font-semibold transition shadow-sm">Düzenle</a>
                                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Bu ürünü silmek istediğinize emin misiniz?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-lg text-xs font-semibold transition shadow-sm">Sil</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400 font-medium">
                                @if(request('search'))
                                    Aramanıza uygun ürün bulunamadı. <a href="{{ route('admin.products.index') }}" class="text-brandOrange underline">Tüm ürünleri göster</a>
                                @else
                                    Henüz eklenmiş bir ürün bulunmuyor.
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $products->links() }}
    </div>
</div>
@endsection