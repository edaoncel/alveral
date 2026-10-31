@extends('layouts.admin')

@section('title', 'Alveral - Kategori Yönetimi')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-extrabold text-brandDark">Kategori Yönetimi</h1>
        <p class="text-sm text-slate-500">Vitrin için yeni kategoriler ekleyin ve mevcut kategorileri yönetin.</p>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl mb-6 text-sm shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6 text-sm">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- SOL TARAF: TEK VE DÜZENLİ KATEGORİ EKLEME FORMU -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 h-fit">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Yeni Kategori Ekle</h2>
            
            <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-gray-700 font-medium mb-1 text-sm">Kategori Adı</label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Örn: YILBAŞI" class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-emerald-500 focus:outline-none text-sm" required>
                </div>

                <!-- ÜST MENÜDE GÖSTER KUTUCUĞU -->
                <div class="flex items-center gap-2.5 py-1">
                    <input type="checkbox" name="show_in_menu" value="1" id="show_in_menu" class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500 cursor-pointer">
                    <label for="show_in_menu" class="text-xs font-semibold text-gray-700 cursor-pointer">Bu kategoriyi üst menüde (navbar) göster</label>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1 text-sm">Kapak Fotoğrafı</label>
                    <input type="file" name="image" accept="image/*" class="w-full border border-gray-300 rounded-xl p-2.5 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-emerald-800 hover:file:bg-emerald-100">
                </div>

                <button type="submit" class="w-full bg-emerald-800 text-white py-3 rounded-xl font-bold hover:bg-emerald-900 transition shadow-sm text-sm">Kategori Ekle</button>
            </form>
        </div>

        <!-- SAĞ TARAF: KATEGORİLER TABLOSU -->
        <div class="md:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-slate-600 uppercase text-xs font-semibold tracking-wider border-b border-slate-200">
                            <th class="py-4 px-4 w-16 text-center">Görsel</th>
                            <th class="py-4 px-4">Kategori Adı</th>
                            <th class="py-4 px-4">Slug (URL)</th>
                            <th class="py-4 px-4 text-center">Ürün Sayısı</th>
                            <th class="py-4 px-4 text-center">İşlem</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm text-slate-600">
                        @forelse($categories as $category)
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="py-4 px-4 text-center">
                                    @if($category->image)
                                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="w-10 h-10 object-cover rounded-xl border border-slate-200 shadow-2xs mx-auto">
                                    @else
                                        <div class="w-10 h-10 bg-slate-100 rounded-xl border border-slate-200 flex items-center justify-center text-slate-400 text-xs font-bold mx-auto">
                                            Yok
                                        </div>
                                    @endif
                                </td>
                                <td class="py-4 px-4 font-bold text-gray-900 flex items-center gap-2">
                                    <span>{{ $category->name }}</span>
                                    @if($category->show_in_menu)
                                        <span class="bg-emerald-100 text-emerald-800 text-[10px] px-2.5 py-0.5 rounded-full font-bold uppercase tracking-wider">Menüde</span>
                                    @endif
                                </td>
                                <td class="py-4 px-4 text-xs font-mono text-slate-500">{{ $category->slug }}</td>
                                <td class="py-4 px-4 text-center">
                                    <span class="bg-sky-50 text-brandBlue px-2.5 py-1 rounded-lg text-xs font-semibold">{{ $category->products_count ?? $category->products->count() }}</span>
                                </td>
                                <td class="py-4 px-4 text-center whitespace-nowrap">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('admin.categories.edit', $category->id) }}" class="bg-amber-500 hover:bg-amber-600 text-white px-3 py-1.5 rounded-lg text-xs font-semibold transition shadow-sm">
                                            Düzenle
                                        </a>

                                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Bu kategoriyi silmek istediğinize emin misiniz?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-lg text-xs font-semibold transition shadow-sm">Sil</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center text-slate-400 font-medium">
                                    Henüz eklenmiş bir kategori bulunmuyor.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection