@extends('layouts.admin')

@section('title', 'Alveral - Kategori Düzenle')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900">Kategori Düzenle</h1>
            <p class="text-sm text-slate-500">"{{ $category->name }}" kategorisini güncelleyebilirsiniz.</p>
        </div>
        <a href="{{ route('admin.categories.index') }}" class="bg-slate-200 hover:bg-slate-300 text-slate-700 px-4 py-2 rounded-xl text-sm font-bold transition">
            ← Geri Dön
        </a>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl mb-6 text-sm shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl mb-6 text-sm shadow-sm">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 sm:p-8">
        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">Kategori Adı</label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-medium text-slate-800 focus:outline-none focus:border-brandOrange focus:ring-1 focus:ring-brandOrange transition">
            </div>

            <!-- Menüde Göster Seçeneği -->
            <div class="flex items-center gap-3 bg-slate-50 border border-slate-200 rounded-xl p-4">
                <input type="checkbox" name="show_in_menu" id="show_in_menu" value="1" {{ old('show_in_menu', $category->show_in_menu) ? 'checked' : '' }} class="w-5 h-5 text-brandOrange border-slate-300 rounded focus:ring-brandOrange">
                <label for="show_in_menu" class="text-sm font-bold text-slate-700 cursor-pointer select-none">
                    Bu kategoriyi menülerde göster.
                </label>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">Mevcut Kapak Görseli</label>
                <div class="flex items-center gap-4 mb-4">
                    @if($category->image)
                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="w-20 h-20 object-cover rounded-xl border border-slate-200 shadow-sm">
                    @else
                        <div class="w-20 h-20 bg-slate-100 rounded-xl border border-slate-200 flex items-center justify-center text-slate-400 text-xs font-bold">
                            Görsel Yok
                        </div>
                    @endif
                    <span class="text-xs text-slate-500">Yeni bir görsel seçmezseniz mevcut görsel korunacaktır.</span>
                </div>

                <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">Yeni Kapak Görseli Seç (İsteğe bağlı)</label>
                <input type="file" name="image" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-brandOrange file:text-white hover:file:bg-orange-600 transition">
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.categories.index') }}" class="px-5 py-2.5 rounded-xl text-sm font-bold text-slate-600 hover:bg-slate-100 transition">İptal</a>
                <button type="submit" class="bg-brandOrange text-white px-6 py-2.5 rounded-xl text-sm font-bold hover:bg-orange-600 transition shadow-sm">Değişiklikleri Kaydet</button>
            </div>
        </form>
    </div>
</div>
@endsection