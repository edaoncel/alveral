@extends('layouts.admin')

@section('title', 'Alveral - Yönetim Paneli')

@section('content')
<div class="max-w-6xl mx-auto space-y-10">
    
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-900 px-6 py-4 rounded-2xl flex justify-between items-center shadow-sm" x-data="{ show: true }" x-show="show">
            <div class="flex items-center gap-3">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 shrink-0"></span>
                <span class="text-xs font-bold tracking-wide">{{ session('success') }}</span>
            </div>
            <button @click="show = false" class="text-emerald-700 hover:text-emerald-900 text-xs font-black">✕</button>
        </div>
    @endif

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 pb-6 border-b border-slate-100">
        <div>
            <span class="text-[10px] text-brandOrange font-black uppercase tracking-widest">Alveral Kontrol Merkezi</span>
            <h1 class="text-3xl font-black text-gray-900 mt-1 tracking-tight">Hoş Geldiniz, {{ Auth::guard('admin')->user()?->name ?? 'Yönetici' }}</h1>
            <p class="text-gray-500 text-xs sm:text-sm font-light mt-1">Platformun ürünlerini, gelen mesajları ve kategorileri buradan yönetin.</p>
        </div>

        <div class="bg-gray-50 border border-gray-100 text-gray-800 px-5 py-3 rounded-2xl flex items-center gap-3 shadow-sm w-full md:w-auto">
            <span class="flex h-2.5 w-2.5 relative">
              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-brandOrange opacity-75"></span>
              <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-brandOrange"></span>
            </span>
            <div class="text-xs">
                <span class="font-bold block uppercase tracking-wider text-gray-900">Sistem Aktif</span>
                <span class="text-gray-500 font-light">Tüm veri akışları senkronize.</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-5">
        
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between hover:border-brandOrange transition group">
            <div>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider group-hover:text-brandOrange transition">Toplam Ürün</span>
                <h2 class="text-3xl font-black text-gray-900 mt-1">{{ $productsCount }}</h2>
            </div>
            <div class="w-12 h-12 rounded-xl bg-orange-50 text-brandOrange flex items-center justify-center group-hover:scale-105 transition shadow-sm">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between hover:border-blue-500 transition group">
            <div>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider group-hover:text-blue-600 transition">Kategoriler</span>
                <h2 class="text-3xl font-black text-gray-900 mt-1">{{ $categories->count() }}</h2>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center group-hover:scale-105 transition shadow-sm">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>
            </div>
        </div>

        <a href="{{ route('admin.messages.index') }}" class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between hover:border-purple-500 transition group">
            <div>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider group-hover:text-purple-600 transition">Yeni Mesajlar</span>
                <div class="flex items-baseline gap-2 mt-1">
                    <h2 class="text-3xl font-black text-gray-900">{{ $unreadMessagesCount }}</h2>
                    @if($unreadMessagesCount > 0)
                        <span class="text-[10px] font-bold text-white bg-rose-500 px-2 py-0.5 rounded-full animate-pulse">Yeni</span>
                    @else
                        <span class="text-[10px] font-bold text-slate-400 bg-slate-50 px-2 py-0.5 rounded-full">Okundu</span>
                    @endif
                </div>
            </div>
            <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center group-hover:scale-105 transition shadow-sm">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            </div>
        </a>

        <a href="{{ route('admin.visitors') }}" class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between hover:border-emerald-500 transition group">
            <div>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider group-hover:text-emerald-600 transition">Ziyaretçiler</span>
                <div class="flex items-baseline gap-2 mt-1">
                    <h2 class="text-3xl font-black text-gray-900">{{ $totalVisitors }}</h2>
                    <span class="text-[10px] text-emerald-600 font-bold bg-emerald-50 px-2 py-0.5 rounded-full">+{{ $todayVisitors ?? 0 }} bugün</span>
                </div>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:scale-105 transition shadow-sm">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
            </div>
        </a>

        <div x-data="{ 
    timeLeft: {{ $timeLeft ?? 900 }}, 
    init() {
        setInterval(() => {
            if (this.timeLeft > 0) {
                this.timeLeft--;
            } else {
                this.timeLeft = 900; // Süre bittiğinde tekrar 15 dk başa sarar
            }
        }, 1000);
    },
    get formattedTime() {
        let minutes = Math.floor(this.timeLeft / 60);
        let seconds = this.timeLeft % 60;
        return `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
    }
}" class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between gap-4 hover:border-amber-500 transition group">
    
    <div class="flex-1">
        <div class="flex flex-wrap items-center gap-2 mb-1">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider group-hover:text-amber-600 transition">Pazaryeri & XML</span>
            
            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-amber-50 text-amber-700 border border-amber-200 shadow-xs animate-pulse whitespace-nowrap">
                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-ping shrink-0"></span>
                <span>Kalan Süre: <span x-text="formattedTime" class="font-mono font-bold"></span></span>
            </span>
        </div>
        
        <div class="flex flex-wrap items-baseline gap-2">
            <h2 class="text-3xl font-black text-gray-900 leading-none">{{ $syncedProductsCount ?? 0 }}</h2>
            <span class="text-xs text-amber-600 font-bold bg-amber-50 px-2.5 py-1 rounded-full whitespace-nowrap">Senkronize Ürün</span>
        </div>
    </div>
    
    <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center group-hover:scale-105 transition shadow-sm shrink-0">
        <svg class="w-6 h-6 animate-spin-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
        </svg>
    </div>
</div>

    </div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
    
    {{-- 1. GRAFİK: TÜM KATEGORİLERİN DAĞILIMI --}}
<div class="bg-white border border-slate-200 p-6 sm:p-8 rounded-3xl shadow-sm">
    <div class="flex justify-between items-center mb-6 border-b border-slate-100 pb-4">
        <div>
            <span class="text-[10px] text-slate-400 font-black uppercase tracking-widest">Genel Dağılım</span>
            <h3 class="text-lg font-black text-gray-900 mt-0.5">Tüm Kategoriler</h3>
        </div>
        <span class="text-xs text-slate-400 font-bold uppercase tracking-wider">ALVERAL</span>
    </div>

    @if(isset($categories) && count($categories) > 0)
        @php
            $generalColors = ['#3b82f6', '#10b981', '#8b5cf6', '#f59e0b', '#ef4444', '#6366f1', '#14b8a6', '#d946ef'];
            
            // products_count gelmese bile ilişki üzerinden güvenle sayar
            $totalGeneralProd = $categories->sum(function($cat) {
                return $cat->products_count ?? $cat->products->count();
            });

            $generalCurrentDegree = 0;
            $generalGradientStops = [];

            if ($totalGeneralProd > 0) {
                foreach($categories as $index => $cat) {
                    $count = $cat->products_count ?? $cat->products->count();
                    if ($count > 0) {
                        $angle = ($count / $totalGeneralProd) * 360;
                        $nextDegree = $generalCurrentDegree + $angle;
                        $color = $generalColors[$index % count($generalColors)];
                        $generalGradientStops[] = "{$color} {$generalCurrentDegree}deg {$nextDegree}deg";
                        $generalCurrentDegree = $nextDegree;
                    }
                }
            }
            $generalGradientString = count($generalGradientStops) > 0 ? implode(', ', $generalGradientStops) : '#e2e8f0 0deg 360deg';
        @endphp

        <div class="flex flex-col sm:flex-row items-center justify-center gap-6 py-2">
            {{-- Grafik (Halka Tasarımı) --}}
            <div class="relative w-44 h-44 rounded-full shadow-inner shrink-0" style="background: conic-gradient({{ $generalGradientString }});">
                <div class="absolute inset-7 bg-white rounded-full flex flex-col items-center justify-center shadow-sm">
                    <span class="text-[9px] text-slate-400 uppercase font-bold tracking-wider">Toplam Ürün</span>
                    <span class="text-xl font-black text-slate-800">{{ $totalGeneralProd }}</span>
                </div>
            </div>

            {{-- Kategori Listesi ve Renk Göstergeleri --}}
            <div class="flex flex-col gap-2 w-full max-h-48 overflow-y-auto pr-1">
                @foreach($categories as $index => $cat)
                    @php
                        $pCount = $cat->products_count ?? $cat->products->count();
                        $pct = $totalGeneralProd > 0 ? round(($pCount / $totalGeneralProd) * 100, 1) : 0;
                        $dotColor = $generalColors[$index % count($generalColors)];
                    @endphp
                    <div class="flex items-center justify-between p-2.5 rounded-xl bg-slate-50/70 border border-slate-100">
                        <div class="flex items-center gap-2 overflow-hidden">
                            <span class="w-2.5 h-2.5 rounded-full shrink-0" style="background-color: {{ $dotColor }};"></span>
                            <span class="text-xs font-bold text-slate-700 truncate">{{ $cat->name }}</span>
                        </div>
                        <span class="text-xs font-black text-slate-900 shrink-0 ml-2">%{{ $pct }} <span class="text-[10px] text-slate-400 font-normal">({{ $pCount }})</span></span>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="text-center py-8 text-slate-400 text-sm">Sistemde kayıtlı kategori bulunamadı.</div>
    @endif
</div>


    {{-- 2. GRAFİK: SADECE MENÜDE GÖSTERİLEN ÖZEL KATEGORİLER --}}
{{-- 2. KART: MENÜDEKİ ÖZEL KATEGORİLER (Modern Grid Kart Tasarımı) --}}
<div class="bg-white border border-slate-200 p-6 sm:p-8 rounded-3xl shadow-sm">
    <div class="flex justify-between items-center mb-6 border-b border-slate-100 pb-4">
        <div>
            <span class="text-[10px] text-brandOrange font-black uppercase tracking-widest">Özel Koleksiyonlar</span>
            <h3 class="text-lg font-black text-gray-900 mt-0.5">Menüdeki Kategoriler</h3>
        </div>
        <span class="text-xs text-brandOrange font-bold uppercase tracking-wider">ALVERAL</span>
    </div>

    @if(isset($specialCategories) && count($specialCategories) > 0)
        @php
            $totalSpecialProd = $specialCategories->sum(function($cat) {
                return $cat->products_count ?? $cat->products->count();
            });
        @endphp

        <div class="flex flex-col gap-4 py-2">
            {{-- Üst Bilgi Banner'ı --}}
            <div class="flex items-center justify-between bg-gradient-to-r from-orange-500 to-amber-500 text-white px-5 py-3.5 rounded-2xl shadow-sm">
                <div>
                    <span class="text-[10px] font-bold uppercase tracking-wider opacity-90 block">Aktif Vitrin</span>
                    <span class="text-sm font-black">Özel Koleksiyon Dağılımı</span>
                </div>
                <div class="bg-white/20 backdrop-blur-md px-3 py-1 rounded-xl text-xs font-black">
                    {{ $totalSpecialProd }} Ürün
                </div>
            </div>

            {{-- Kategoriler için Grid (Kutucuk) Yapısı --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 max-h-52 overflow-y-auto pr-1">
                @foreach($specialCategories as $cat)
                    @php
                        $pCount = $cat->products_count ?? $cat->products->count();
                        $pct = $totalSpecialProd > 0 ? round(($pCount / $totalSpecialProd) * 100, 1) : 0;
                    @endphp
                    <div class="flex items-center justify-between p-3.5 rounded-2xl bg-slate-50 border border-slate-100 hover:border-orange-200 transition-all group">
                        <div class="flex flex-col gap-0.5 overflow-hidden pr-2">
                            <span class="text-xs font-bold text-slate-800 truncate group-hover:text-brandOrange transition-colors">{{ $cat->name }}</span>
                            <span class="text-[10px] text-slate-400 font-medium">%{{ $pct }} oran</span>
                        </div>
                        <div class="w-9 h-9 rounded-xl bg-orange-100/70 text-brandOrange flex items-center justify-center font-black text-xs shrink-0 shadow-2xs">
                            {{ $pCount }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="text-center py-8 text-slate-400 text-sm">Menüde gösterilen özel kategori bulunamadı.</div>
    @endif
</div>

</div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <!-- Modül 01: Ürün Yönetimi -->
        <div class="bg-white border border-slate-100 p-8 rounded-3xl shadow-sm hover:border-brandOrange/40 transition flex flex-col justify-between group">
            <div>
                <span class="text-[10px] text-brandOrange uppercase font-black tracking-widest block mb-3">Modül 01</span>
                <h3 class="text-xl font-black text-gray-900 mb-2 group-hover:text-brandOrange transition">Ürün Yönetimi</h3>
                <p class="text-xs text-gray-500 leading-relaxed font-light">Sergilenen en çok satan ürünleri, fiyatları ve görselleri düzenleyin.</p>
            </div>
            <div class="mt-8 pt-4 border-t border-slate-100 flex justify-between items-center">
                <span class="text-[11px] font-bold text-slate-400">Aktif</span>
                <a href="{{ route('admin.products.index') }}" class="text-xs bg-gray-900 text-white group-hover:bg-brandOrange px-5 py-2.5 rounded-full font-bold transition uppercase tracking-wider">Yönet →</a>
            </div>
        </div>

        <!-- Modül 02: Kategori Yönetimi -->
        <div class="bg-white border border-slate-100 p-8 rounded-3xl shadow-sm hover:border-brandOrange/40 transition flex flex-col justify-between group">
            <div>
                <span class="text-[10px] text-brandOrange uppercase font-black tracking-widest block mb-3">Modül 02</span>
                <h3 class="text-xl font-black text-gray-900 mb-2 group-hover:text-brandOrange transition">Kategori Yönetimi</h3>
                <p class="text-xs text-gray-500 leading-relaxed font-light">Vitrin kategorilerini yapılandırın ve filtreleme başlıklarını güncelleyin.</p>
            </div>
            <div class="mt-8 pt-4 border-t border-slate-100 flex justify-between items-center">
                <span class="text-[11px] font-bold text-slate-400">Aktif</span>
                <a href="{{ route('admin.categories.index') }}" class="text-xs bg-gray-900 text-white group-hover:bg-brandOrange px-5 py-2.5 rounded-full font-bold transition uppercase tracking-wider">Yönet →</a>
            </div>
        </div>

        <!-- Modül 03: Yönetici Listesi -->
        <div class="bg-white border border-slate-100 p-8 rounded-3xl shadow-sm hover:border-brandOrange/40 transition flex flex-col justify-between group">
            <div>
                <span class="text-[10px] text-brandOrange uppercase font-black tracking-widest block mb-3">Modül 03</span>
                <h3 class="text-xl font-black text-gray-900 mb-2 group-hover:text-brandOrange transition">Yönetici Listesi</h3>
                <p class="text-xs text-gray-500 leading-relaxed font-light">Ortakların erişim yetkilerini kontrol edin ve yeni ortak hesapları tanımlayın.</p>
            </div>
            <div class="mt-8 pt-4 border-t border-slate-100 flex justify-between items-center">
                <span class="text-[11px] font-bold text-slate-400">Ortak Alanı</span>
                <a href="{{ route('admin.admins.index') }}" class="text-xs bg-gray-900 text-white group-hover:bg-brandOrange px-5 py-2.5 rounded-full font-bold transition uppercase tracking-wider">Yönet →</a>
            </div>
        </div>

        <!-- Modül 04: Pazaryeri Yönetimi -->
        <div class="bg-white border border-slate-100 p-8 rounded-3xl shadow-sm hover:border-brandOrange/40 transition flex flex-col justify-between group">
            <div>
                <div class="flex justify-between items-center mb-3">
                    <span class="text-[10px] text-brandOrange uppercase font-black tracking-widest">Modül 04</span>
                    <span class="flex h-2 w-2 relative">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                    </span>
                </div>
                <h3 class="text-xl font-black text-gray-900 mb-2 group-hover:text-brandOrange transition">Pazaryeri Yönetimi</h3>
                <p class="text-xs text-gray-500 leading-relaxed font-light">Trendyol ve Hepsiburada API ayarlarını ve stok loglarını inceleyin.</p>
            </div>
            <div class="mt-8 pt-4 border-t border-slate-100 flex justify-between items-center">
                <span class="text-[11px] font-bold text-slate-400">Trendyol & HB</span>
                <a href="{{ route('admin.marketplaces.settings') }}" class="text-xs bg-gray-900 text-white group-hover:bg-brandOrange px-5 py-2.5 rounded-full font-bold transition uppercase tracking-wider">Yönet →</a>
            </div>
        </div>

    </div>
</div>
@endsection