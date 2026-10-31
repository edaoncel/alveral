<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alveral - E- Ticaret Resmi Satış Sitesi</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo/link_logo.png') }}">
    <style>
        [x-cloak] { display: none !important; }
    </style>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brandBlue: '#0ea5e9',
                        brandDark: '#1e293b',
                        brandOrange: '#f97316'
                    }
                }
            }
        }
    </script>
</head>

    <body class="bg-white min-h-screen text-gray-900 antialiased" x-data="{ mobileMenu: false, mobileCatOpen: false }">

<nav class="bg-white/95 backdrop-blur-md border-b border-gray-100 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-8 h-20 flex justify-between items-center">
            
    <a href="{{ url('/') }}" class="flex items-center">
        <img src="{{ asset('img/logo/logo.png') }}" alt="Alveral" class="h-12 sm:h-12 w-auto object-contain">
    </a>

    <!-- Menüde gösterilecek kategorileri tek bir yerde çekiyoruz -->
    @php
        $menuCategories = \App\Models\Category::where('show_in_menu', true)->get();
    @endphp

    <div class="hidden md:flex items-center space-x-10 text-sm font-medium tracking-wide text-gray-700">
        <!-- 1. ANASAYFA -->
        <a href="{{ url('/') }}" class="text-brandOrange font-semibold transition">ANASAYFA</a>
        
        <!-- 2. KATEGORİLER (Dropdown) -->
        <div class="relative" x-data="{ catOpen: false }">
            <button @click="catOpen = !catOpen" @click.away="catOpen = false" type="button" class="flex items-center gap-1.5 hover:text-brandOrange transition focus:outline-none">
                KATEGORİLER
                <svg class="w-4 h-4 transition-transform duration-200" :class="catOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>
            
            <div x-show="catOpen" x-cloak 
                 x-transition:enter="transition ease-out duration-200" 
                 x-transition:enter-start="opacity-0 translate-y-2" 
                 x-transition:enter-end="opacity-100 translate-y-0" 
                 class="absolute left-0 mt-4 w-60 bg-white border border-gray-100 rounded-2xl shadow-2xl py-3 z-50">
                <a href="{{ url('/#urunler') }}" class="block px-5 py-2.5 text-xs uppercase tracking-wider font-bold text-gray-800 hover:bg-gray-50 hover:text-brandOrange transition">Tüm Ürünler</a>
                @foreach($menuCategories as $cat)
                    <a href="{{ url('/?category=' . $cat->slug . '#urunler') }}" class="block px-5 py-2.5 text-xs font-medium text-gray-600 hover:bg-gray-50 hover:text-brandOrange transition">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>
        </div>

        <!-- 3. MENÜ KATEGORİLERİ (Doğrudan Akışta) -->
        @foreach($menuCategories as $menuCat)
            <a href="{{ url('/?category=' . $menuCat->slug . '#urunler') }}" class="hover:text-brandOrange transition">
                {{ $menuCat->name }}
            </a>
        @endforeach

        <!-- 4. İLETİŞİM -->
        <a href="{{ route('contact') }}" class="hover:text-brandOrange transition">İLETİŞİM</a>
    </div>

    <div class="flex items-center gap-4">
        @auth('admin')
            <a href="{{ route('admin.dashboard') }}" class="hidden sm:inline-flex bg-gray-900 text-white hover:bg-brandOrange px-5 py-2.5 rounded-full text-xs font-semibold uppercase tracking-wider transition">Panel</a>
        @else
            <a href="{{ route('admin.login') }}" class="hidden sm:inline-flex bg-gray-900 text-white hover:bg-brandOrange px-5 py-2.5 rounded-full text-xs font-semibold uppercase tracking-wider transition">Admin Girişi</a>
        @endauth

        <button @click="mobileMenu = !mobileMenu" class="md:hidden p-2 text-gray-700 rounded-xl focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
        </button>
    </div>
</div>

        <div x-show="mobileMenu" x-cloak class="md:hidden bg-white border-b border-gray-100 px-6 py-5 space-y-4 shadow-xl">
    <!-- 1. ANASAYFA -->
    <a href="{{ url('/') }}" class="block text-sm font-bold text-brandOrange">ANASAYFA</a>
    
    <!-- Kategorileri tek bir yerde çekiyoruz -->
    @php
        $menuCategories = \App\Models\Category::where('show_in_menu', true)->get();
    @endphp

    <!-- 2. KATEGORİLER (Açılır Menü) -->
    <div>
        <button @click="mobileCatOpen = !mobileCatOpen" type="button" class="w-full flex justify-between items-center text-xs font-extrabold text-gray-400 uppercase tracking-widest pt-2 focus:outline-none">
            <span>KATEGORİLER</span>
            <svg class="w-4 h-4 transition-transform duration-200" :class="mobileCatOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
        </button>
        
        <div x-show="mobileCatOpen" x-cloak class="pl-3 mt-3 space-y-2.5 border-l-2 border-orange-100 max-h-48 overflow-y-auto">
            <a href="{{ url('/#urunler') }}" class="block text-xs font-semibold text-gray-800">Tüm Ürünler</a>
            @if(isset($categories))
                @foreach($categories as $cat)
                    <a href="{{ url('/?category=' . $cat->slug . '#urunler') }}" class="block text-xs text-gray-600 hover:text-brandOrange transition">{{ $cat->name }}</a>
                @endforeach
            @endif
        </div>
    </div>
    
    <!-- 3. MENÜ KATEGORİLERİ (Doğrudan Akışta) -->
    <div class="space-y-2 pt-1">
        @foreach($menuCategories as $menuCat)
            <a href="{{ url('/?category=' . $menuCat->slug . '#urunler') }}" class="block text-sm font-medium text-gray-700 hover:text-brandOrange transition">
                {{ $menuCat->name }}
            </a>
        @endforeach
    </div>

    <!-- 4. İLETİŞİM -->
    <div class="pt-2">
        <a href="{{ route('contact') }}" class="block text-sm font-bold text-brandOrange">İLETİŞİM</a>
    </div>
    
    <!-- 5. ADMIN GİRİŞİ -->
    <div class="pt-2">
        @auth('admin')
            <a href="{{ route('admin.dashboard') }}" class="block text-center bg-gray-900 text-white py-3 rounded-full text-xs font-bold uppercase tracking-wider">Panel</a>
        @else
            <a href="{{ route('admin.login') }}" class="block text-center bg-gray-900 text-white py-3 rounded-full text-xs font-bold uppercase tracking-wider">Admin Girişi</a>
        @endauth
    </div>
</div>
    </nav>

    <header class="bg-gray-200 text-white py-20 px-6 text-center relative overflow-hidden">
        <div class="max-w-4xl mx-auto relative z-10">
            <span class="text-brandOrange tracking-widest text-xs uppercase font-extrabold mb-3 block">Özel Koleksiyon</span>
            <h1 class="text-4xl sm:text-6xl font-black mb-6 tracking-tight uppercase">Sezonun En İyileri</h1>
            <p class="text-gray-600 mb-10 text-sm sm:text-base max-w-xl mx-auto font-light leading-relaxed">Özenle seçilmiş trend ürünleri yüksek görsel kalitesi ve avantajlı fırsatlarla keşfedin.</p>
            
            <form action="{{ url('/') }}#urunler" method="GET" class="flex flex-row items-center gap-1.5 max-w-xl mx-auto w-full bg-white/5 p-1.5 sm:p-2 rounded-full backdrop-blur-md border border-white/10 shadow-lg">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Ürün ara..." class="w-full px-4 sm:px-6 py-2.5 sm:py-3 rounded-full text-gray-900 bg-white focus:outline-none text-xs sm:text-sm font-medium">
                <button type="submit" class="bg-brandOrange text-white px-5 sm:px-8 py-2.5 sm:py-3 rounded-full font-bold uppercase tracking-wider hover:bg-orange-600 transition text-[11px] sm:text-xs shrink-0 shadow-md">Keşfet</button>
            </form>
        </div>
    </header>

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 relative font-sans overflow-hidden" 
         x-data="{ activeIndex: 0, openModal: false, product: null }"
         x-init="setInterval(() => { activeIndex = (activeIndex + 1) % {{ count($bestSellers) }}; }, 5000)">
         
    <div class="flex items-center justify-between pb-6 border-b border-gray-200 mb-8">
        <div class="flex items-center space-x-4">
            <button class="p-1 hover:bg-gray-100 rounded">
                <svg class="w-6 h-6 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                </svg>
            </button>
            <h2 class="text-2xl font-black text-gray-900 uppercase tracking-widest">EN ÇOK SATANLAR</h2>
        </div>
        <div class="flex items-center space-x-3 text-xs font-mono text-gray-400">
            <svg class="w-5 h-5 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
            </svg>
        </div>
    </div>

    @if(isset($bestSellers) && count($bestSellers) > 0)
    <div class="relative bg-slate-900 rounded-none overflow-hidden shadow-2xl min-h-[500px] flex flex-col lg:flex-row items-stretch mb-12">
        
        <div class="absolute inset-0 z-0">
            @foreach($bestSellers as $index => $item)
                @if(isset($item->images) && count($item->images) > 0)
                    <div x-show="activeIndex === {{ $index }}" 
                         x-transition:enter="transition-opacity ease-out duration-700"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         class="absolute inset-0 w-full h-full">
                        <img src="{{ asset($item->images[0]) }}" 
                             alt="{{ $item->name }}" 
                             class="w-full h-full object-cover object-center opacity-85">
                    </div>
                @endif
            @endforeach
            <div class="absolute inset-0 bg-gradient-to-r from-slate-950/75 via-slate-900/30 to-transparent lg:w-3/4"></div>
        </div>

        <div class="relative z-30 lg:w-7/12 p-8 sm:p-12 lg:p-16 flex flex-col justify-center space-y-6">
            @foreach($bestSellers as $index => $item)
            <div x-show="activeIndex === {{ $index }}" 
                 x-transition:enter="transition-all ease-out duration-400"
                 x-transition:enter-start="opacity-0 translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="flex flex-col space-y-4" style="display: none;">
                
                <div>
                    <span class="inline-block bg-orange-500 text-white font-mono text-xs font-bold px-3 py-1 mb-3 rounded-none">
                        {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }} — ÖNE ÇIKAN
                    </span>
                    <h3 class="text-xs sm:text-sm font-black text-orange-400 uppercase tracking-widest">
                        {{ $item->short_description ?? 'YENİLİKÇİ KOLEKSİYON' }}
                    </h3>
                </div>

                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-white uppercase tracking-tighter leading-none italic">
                    {{ $item->name }}
                </h1>

                <div class="pt-4 flex items-center space-x-1">
                    <a href="{{ $item->affiliate_url ?? '#' }}" 
                       target="_blank" 
                       class="bg-orange-500 hover:bg-orange-600 text-white font-black text-xs uppercase tracking-widest px-8 py-4 transition-colors shadow-lg shadow-orange-500/30 flex items-center justify-center rounded-none">
                        ŞİMDİ İNCELE
                    </a>
                    <button class="bg-black/60 hover:bg-black text-white p-4 transition-colors border border-white/20 rounded-none backdrop-blur-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </button>
                </div>
            </div>
            @endforeach
        </div>

        <div class="relative z-20 lg:w-5/12 hidden lg:flex items-center justify-end p-8"></div>

    </div>
    @endif

    <div class="relative pt-4">
        <div class="flex items-center space-x-4 overflow-x-auto pb-4 scrollbar-hide">
            
            @foreach($bestSellers as $index => $item)
            <div @click="activeIndex = {{ $index }}" 
                 class="flex-shrink-0 w-36 sm:w-40 group cursor-pointer">
                <div class="relative bg-gray-100 p-2 border transition-all duration-300 rounded-none"
                     :class="activeIndex === {{ $index }} ? 'border-orange-500 ring-2 ring-orange-500/20 bg-orange-50/30' : 'border-gray-200 hover:border-orange-300'">
                    
                    <div class="flex items-center justify-between mb-1 px-1">
                        <span class="text-[10px] font-mono font-bold" :class="activeIndex === {{ $index }} ? 'text-orange-600' : 'text-gray-600'">
                            {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                        </span>
                    </div>

                    <div class="h-24 w-full relative z-10 overflow-hidden bg-white rounded-none">
                        @if(isset($item->images[0]))
                            <img src="{{ asset($item->images[0]) }}" alt="{{ $item->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-[10px] text-gray-400">Görsel</div>
                        @endif
                    </div>
                </div>

                <p class="mt-2 text-xs font-bold truncate transition-colors text-center"
                   :class="activeIndex === {{ $index }} ? 'text-orange-600' : 'text-gray-800 group-hover:text-orange-500'">
                    {{ $item->name }}
                </p>
            </div>
            @endforeach

        </div>
    </div>

</section>

<main x-data="{ openModal: false, product: null }" class="max-w-7xl mx-auto px-3 sm:px-8 py-12">
    @if(isset($discountedProducts) && $discountedProducts->count() > 0 && !request('search') && !request('category'))
    <section class="mb-16">
        <div class="flex justify-between items-end mb-8 border-b border-gray-100 pb-4">
            <div>
                <span class="text-xs uppercase font-bold text-red-500 tracking-widest flex items-center gap-1">
                    🔥 Sınırlı Süre Fırsatlar
                </span>
                <h2 class="text-2xl sm:text-3xl font-black tracking-tight text-gray-900 mt-1">İndirimli Ürünler</h2>
            </div>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-10">
            @foreach($discountedProducts as $product)
                <div class="group flex flex-col justify-between bg-white rounded-2xl p-4 shadow-sm border border-red-100 relative overflow-hidden">
                    @php
                        $discountPercent = round((($product->price - $product->discount_price) / $product->price) * 100);
                    @endphp
                    <span class="absolute top-3 right-3 bg-red-600 text-white text-[10px] font-extrabold px-2.5 py-1 rounded-full uppercase tracking-wider shadow-md z-20">
                        -%{{ $discountPercent }} İndirim
                    </span>

                    <div>
                        <div class="h-64 sm:h-80 bg-gray-100 relative overflow-hidden rounded-2xl mb-4 shadow-sm" x-data="{ active: 0, images: {{ json_encode($product->images ?? []) }} }">
                            @if($product->images && count($product->images) > 0)
                                <template x-for="(img, idx) in images" :key="idx">
                                    <div x-show="active === idx" class="absolute inset-0 w-full h-full transition-opacity duration-500">
                                        <img :src="'{{ asset('') }}' + img" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-700 ease-out">
                                    </div>
                                </template>
                            @else
                                <div class="flex items-center justify-center h-full text-gray-400 text-xs uppercase tracking-widest font-semibold">
                                    Görsel Yok
                                </div>
                            @endif
                        </div>

                        <div class="px-1">
                            <h3 class="font-bold text-gray-900 text-sm sm:text-base mb-1 group-hover:text-red-600 transition line-clamp-1">{{ $product->name }}</h3>
                        </div>
                    </div>

                    <div class="px-1 flex items-center justify-between pt-3 border-t border-gray-100 gap-2 mt-2">
                        <div>
                            <div class="flex flex-col sm:flex-row sm:items-baseline sm:gap-2">
                                <span class="text-sm sm:text-lg font-black text-red-600">{{ number_format($product->discount_price, 2) }} ₺</span>
                                <span class="text-[11px] sm:text-xs text-gray-400 line-through">{{ number_format($product->price, 2) }} ₺</span>
                            </div>
                        </div>
                        
                        <button @click="openModal = true; product = JSON.parse($el.getAttribute('data-product'))"
                                data-product="{{ json_encode([
                                    'name' => $product->name,
                                    'trendyol_url' => $product->trendyol_url,
                                    'hepsiburada_url' => $product->hepsiburada_url,
                                    'idefix_url' => $product->idefix_url,
                                    'amazon_url' => $product->amazon_url,
                                    'pazarama_url' => $product->pazarama_url
                                ]) }}"
                                class="bg-gray-900 text-white hover:bg-red-600 text-center px-3 sm:px-4 py-2 rounded-xl text-[11px] sm:text-xs font-bold uppercase tracking-wider transition shadow-sm cursor-pointer whitespace-nowrap">
                            İncele
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    @endif
    <div x-show="openModal" 
         x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm transition-opacity"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        
        <div @click.away="openModal = false" 
             class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl relative overflow-hidden transform transition-all"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95">
            
            <button @click="openModal = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 p-2 rounded-full hover:bg-gray-100 transition cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>

            <div class="mb-5 pr-8">
                <span class="text-[10px] uppercase font-bold tracking-widest text-brandOrange">Platform Seçimi</span>
                <h3 class="text-xl font-black text-gray-900 mt-0.5" x-text="product?.name"></h3>
                <p class="text-xs text-gray-500 mt-1">Alışverişinize devam etmek istediğiniz platformu seçin:</p>
            </div>

            <div class="space-y-2.5 max-h-[60vh] overflow-y-auto pr-1">
                <template x-if="product?.trendyol_url">
                    <a :href="product.trendyol_url" target="_blank" class="flex items-center justify-between p-3.5 rounded-2xl bg-orange-50 hover:bg-orange-100 border border-orange-200 text-orange-900 font-bold transition group">
                        <span class="flex items-center gap-2.5 text-sm">
                            <span class="w-2.5 h-2.5 rounded-full bg-orange-500"></span> Trendyol
                        </span>
                        <svg class="w-4 h-4 text-orange-500 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </template>

                <template x-if="product?.hepsiburada_url">
                    <a :href="product.hepsiburada_url" target="_blank" class="flex items-center justify-between p-3.5 rounded-2xl bg-amber-50 hover:bg-amber-100 border border-amber-200 text-amber-900 font-bold transition group">
                        <span class="flex items-center gap-2.5 text-sm">
                            <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span> Hepsiburada
                        </span>
                        <svg class="w-4 h-4 text-amber-500 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </template>

                <template x-if="product?.idefix_url">
                    <a :href="product.idefix_url" target="_blank" class="flex items-center justify-between p-3.5 rounded-2xl bg-blue-50 hover:bg-blue-100 border border-blue-200 text-blue-900 font-bold transition group">
                        <span class="flex items-center gap-2.5 text-sm">
                            <span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span> İdefix
                        </span>
                        <svg class="w-4 h-4 text-blue-500 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </template>

                <template x-if="product?.amazon_url">
                    <a :href="product.amazon_url" target="_blank" class="flex items-center justify-between p-3.5 rounded-2xl bg-yellow-50 hover:bg-yellow-100 border border-yellow-200 text-yellow-900 font-bold transition group">
                        <span class="flex items-center gap-2.5 text-sm">
                            <span class="w-2.5 h-2.5 rounded-full bg-yellow-500"></span> Amazon
                        </span>
                        <svg class="w-4 h-4 text-yellow-500 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </template>

                <template x-if="product?.pazarama_url">
                    <a :href="product.pazarama_url" target="_blank" class="flex items-center justify-between p-3.5 rounded-2xl bg-red-50 hover:bg-red-100 border border-red-200 text-red-900 font-bold transition group">
                        <span class="flex items-center gap-2.5 text-sm">
                            <span class="w-2.5 h-2.5 rounded-full bg-red-500"></span> Pazarama
                        </span>
                        <svg class="w-4 h-4 text-red-500 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </template>
            </div>

            <div class="mt-5 text-center border-t border-gray-100 pt-4">
                <span class="text-[11px] text-gray-400">Güvenli ve hızlı yönlendirme ile en avantajlı fiyatı yakalayın.</span>
            </div>
        </div>
    </div>
</main>

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 mt-6">
    <div id="categorySlider" class="flex gap-6 overflow-x-auto pb-4 pt-1 scrollbar-none snap-x snap-mandatory scroll-smooth focus:outline-none" style="scrollbar-width: none; -ms-overflow-style: none;">
        @forelse($categories as $category)
            <a href="{{ route('store.index', ['category' => $category->slug]) }}#urunler" class="group flex flex-col items-center text-center shrink-0 w-32 sm:w-40 snap-start">
                
                <div class="w-32 h-32 sm:w-40 sm:h-40 rounded-full overflow-hidden bg-slate-100 shadow-sm group-hover:shadow-md group-hover:scale-105 transition duration-300 relative border-2 sm:border-4 border-slate-100 group-hover:border-brandOrange">
                    @if($category->image)
                        <img src="{{ url('storage/' . $category->image) }}" alt="{{ $category->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-slate-400 font-bold text-xs">
                            Yok
                        </div>
                    @endif
                </div>

                <h3 class="mt-3 text-sm font-bold text-gray-900 group-hover:text-brandOrange transition truncate w-full px-1">
                    {{ $category->name }}
                </h3>

                <span class="text-xs text-slate-400 font-light mt-0.5">
                    {{ $category->products->count() }} Ürün
                </span>
            </a>
        @empty
            <div class="w-full py-12 text-center text-gray-400 text-sm">
                Henüz eklenmiş kategori bulunmuyor.
            </div>
        @endforelse
    </div>
</section>

<main x-data="{ openModal: false, product: null }" class="max-w-7xl mx-auto px-3 sm:px-8 py-16">
        <div id="urunler" class="scroll-mt-24">
            <span class="text-xs uppercase font-bold text-gray-400 tracking-widest">Koleksiyon</span>
            <h2 class="text-2xl sm:text-3xl font-black tracking-tight text-gray-900 mt-1">Ürünler</h2>
        </div>
    <div class="grid grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-10 mt-6">
        @forelse($products as $product)
            <div class="group flex flex-col justify-between bg-white rounded-2xl p-4 shadow-sm border border-slate-100">
                <div>
                    <div class="h-64 sm:h-96 bg-gray-100 relative overflow-hidden rounded-2xl mb-4 sm:mb-5 shadow-sm" x-data="{ active: 0, images: {{ json_encode($product->images ?? []) }} }">
                        @if($product->images && count($product->images) > 0)
                            <template x-for="(img, idx) in images" :key="idx">
                                <div x-show="active === idx" class="absolute inset-0 w-full h-full transition-opacity duration-500">
                                    <img :src="'{{ asset('') }}' + img" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-700 ease-out">
                                </div>
                            </template>

                            @if(count($product->images) > 1)
                                <button @click.prevent="active = (active === 0) ? images.length - 1 : active - 1" class="absolute left-2 top-1/2 -translate-y-1/2 bg-black/40 hover:bg-black/70 text-white p-1.5 sm:p-2.5 rounded-full opacity-0 group-hover:opacity-100 transition duration-300 backdrop-blur-sm z-10 focus:outline-none">
                                    <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                </button>
                                <button @click.prevent="active = (active === images.length - 1) ? 0 : active + 1" class="absolute right-2 top-1/2 -translate-y-1/2 bg-black/40 hover:bg-black/70 text-white p-1.5 sm:p-2.5 rounded-full opacity-0 group-hover:opacity-100 transition duration-300 backdrop-blur-sm z-10 focus:outline-none">
                                    <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </button>
                                <div class="absolute bottom-3 left-1/2 -translate-x-1/2 flex space-x-1 z-10 bg-black/30 backdrop-blur-md px-2 py-1 rounded-full">
                                    <template x-for="(img, idx) in images" :key="idx">
                                        <button @click.prevent="active = idx" :class="active === idx ? 'bg-white w-3' : 'bg-white/50 w-1'" class="h-1 rounded-full transition-all duration-300 focus:outline-none"></button>
                                    </template>
                                </div>
                            @endif
                        @else
                            <div class="flex items-center justify-center h-full text-gray-400 text-[10px] sm:text-xs uppercase tracking-widest font-semibold">
                                Görsel Yok
                            </div>
                        @endif

                        @if($product->category)
                            <span class="absolute top-3 left-3 bg-white/90 backdrop-blur-md text-gray-900 text-[9px] sm:text-[10px] font-bold uppercase tracking-widest px-2.5 py-1 rounded-full shadow-sm z-10">
                                {{ $product->category->name }}
                            </span>
                        @endif
                    </div>

                    <div class="px-1">
                        <h2 class="font-bold text-gray-900 text-sm sm:text-lg mb-1 group-hover:text-brandOrange transition line-clamp-1">{{ $product->name }}</h2>
                        <p class="text-gray-500 text-[11px] sm:text-xs line-clamp-2 mb-3 leading-relaxed font-light hidden sm:block">{{ $product->description ?? 'Özel tasarım ve yüksek kalite.' }}</p>
                    </div>
                </div>

                <div class="px-1 flex flex-col sm:flex-row sm:items-center justify-between pt-2 sm:pt-3 border-t border-gray-100 mt-2 gap-2">
                    <div>
                        @if($product->discount_price && $product->price > 0)
                            @php
                                $discountPercent = round((($product->price - $product->discount_price) / $product->price) * 100);
                            @endphp
                            <div class="flex items-baseline gap-2">
                                <span class="text-base sm:text-xl font-black text-gray-900">{{ number_format($product->discount_price, 2) }} ₺</span>
                                <span class="text-xs text-gray-400 line-through">{{ number_format($product->price, 2) }} ₺</span>
                            </div>
                            <div class="flex items-center gap-1 mt-0.5">
                                <span class="bg-red-500 text-white text-[9px] sm:text-[10px] font-bold px-1.5 py-0.2 rounded-full uppercase tracking-wider">
                                    -%{{ $discountPercent }}
                                </span>
                                <span class="text-[10px] text-gray-400 uppercase tracking-wider hidden sm:inline">| Stok: <span class="font-semibold text-gray-700">{{ $product->stock }}</span></span>
                            </div>
                        @else
                            <span class="text-base sm:text-xl font-black text-gray-900 block">{{ number_format($product->price, 2) }} ₺</span>
                            <span class="text-[10px] text-gray-400 uppercase tracking-wider hidden sm:block">Stok: <span class="font-semibold text-gray-700">{{ $product->stock }}</span></span>
                        @endif
                    </div>
                    
                    <button @click="openModal = true; product = JSON.parse($el.getAttribute('data-product'))"
                            data-product="{{ json_encode([
                                'name' => $product->name,
                                'trendyol_url' => $product->trendyol_url,
                                'hepsiburada_url' => $product->hepsiburada_url,
                                'idefix_url' => $product->idefix_url,
                                'amazon_url' => $product->amazon_url,
                                'pazarama_url' => $product->pazarama_url
                            ]) }}"
                            class="bg-gray-900 text-white hover:bg-red-600 text-center px-3 sm:px-4 py-2 rounded-xl text-[11px] sm:text-xs font-bold uppercase tracking-wider transition shadow-sm cursor-pointer whitespace-nowrap">
                        İncele
                    </button>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-24 text-gray-400">
                <p class="text-base font-medium">Bu kategoride henüz ürün sergilenmiyor.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-16">
        {{ $products->links() }}
    </div>

  <div x-show="openModal" 
     x-cloak
     class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm transition-opacity"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0">
    
    <div @click.away="openModal = false" 
         class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl relative overflow-hidden transform transition-all"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95">
        
        <button @click="openModal = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 p-2 rounded-full hover:bg-gray-100 transition cursor-pointer">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>

        <div class="mb-5 pr-8">
            <span class="text-[10px] uppercase font-bold tracking-widest text-brandOrange">Platform Seçimi</span>
            <h3 class="text-xl font-black text-gray-900 mt-0.5" x-text="product?.name"></h3>
            <p class="text-xs text-gray-500 mt-1">Alışverişinize devam etmek istediğiniz platformu seçin:</p>
        </div>

        <div class="space-y-2.5 max-h-[60vh] overflow-y-auto pr-1">
            <template x-if="product?.trendyol_url">
                <a :href="product.trendyol_url" target="_blank" class="flex items-center justify-between p-3.5 rounded-2xl bg-orange-50 hover:bg-orange-100 border border-orange-200 text-orange-900 font-bold transition group">
                    <span class="flex items-center gap-2.5 text-sm">
                        <span class="w-2.5 h-2.5 rounded-full bg-orange-500"></span> Trendyol
                    </span>
                    <svg class="w-4 h-4 text-orange-500 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </template>

            <template x-if="product?.hepsiburada_url">
                <a :href="product.hepsiburada_url" target="_blank" class="flex items-center justify-between p-3.5 rounded-2xl bg-amber-50 hover:bg-amber-100 border border-amber-200 text-amber-900 font-bold transition group">
                    <span class="flex items-center gap-2.5 text-sm">
                        <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span> Hepsiburada
                    </span>
                    <svg class="w-4 h-4 text-amber-500 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </template>

            <template x-if="product?.idefix_url">
                <a :href="product.idefix_url" target="_blank" class="flex items-center justify-between p-3.5 rounded-2xl bg-blue-50 hover:bg-blue-100 border border-blue-200 text-blue-900 font-bold transition group">
                    <span class="flex items-center gap-2.5 text-sm">
                        <span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span> İdefix
                    </span>
                    <svg class="w-4 h-4 text-blue-500 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </template>

            <template x-if="product?.amazon_url">
                <a :href="product.amazon_url" target="_blank" class="flex items-center justify-between p-3.5 rounded-2xl bg-yellow-50 hover:bg-yellow-100 border border-yellow-200 text-yellow-900 font-bold transition group">
                    <span class="flex items-center gap-2.5 text-sm">
                        <span class="w-2.5 h-2.5 rounded-full bg-yellow-500"></span> Amazon
                    </span>
                    <svg class="w-4 h-4 text-yellow-500 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </template>

            <template x-if="product?.pazarama_url">
                <a :href="product.pazarama_url" target="_blank" class="flex items-center justify-between p-3.5 rounded-2xl bg-red-50 hover:bg-red-100 border border-red-200 text-red-900 font-bold transition group">
                    <span class="flex items-center gap-2.5 text-sm">
                        <span class="w-2.5 h-2.5 rounded-full bg-red-500"></span> Pazarama
                    </span>
                    <svg class="w-4 h-4 text-red-500 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </template>
        </div>

        <div class="mt-5 text-center border-t border-gray-100 pt-4">
            <span class="text-[11px] text-gray-400">Güvenli ve hızlı yönlendirme ile en avantajlı fiyatı yakalayın.</span>
        </div>
    </div>
</div>
</main>

    <section class="max-w-7xl mx-auto px-4 sm:px-8 -mt-8 relative z-30">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <div class="group relative bg-white border border-gray-100 rounded-3xl p-8 shadow-xl shadow-gray-100/80 transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl hover:border-brandOrange/40 overflow-hidden">
                <div class="absolute -right-10 -bottom-10 w-32 h-32 bg-orange-50 rounded-full blur-2xl group-hover:bg-orange-100/80 transition duration-500 pointer-events-none"></div>
                <div class="relative z-10 flex items-center gap-5">
                    <div class="w-16 h-16 rounded-2xl bg-orange-50 group-hover:bg-brandOrange group-hover:text-white text-brandOrange flex items-center justify-center shrink-0 transition-all duration-500 shadow-sm">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    </div>
                    <div>
                        <span class="text-[10px] font-black uppercase tracking-widest text-brandOrange mb-1 block">Esnek Çözüm</span>
                        <h3 class="font-black text-base uppercase tracking-wider text-gray-900 group-hover:text-brandOrange transition-colors">Kolay İade</h3>
                        <p class="text-xs text-gray-500 font-light mt-1">14 Gün İçinde İade Hakkı</p>
                    </div>
                </div>
            </div>

            <div class="group relative bg-white border border-gray-100 rounded-3xl p-8 shadow-xl shadow-gray-100/80 transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl hover:border-brandOrange/40 overflow-hidden">
                <div class="absolute -right-10 -bottom-10 w-32 h-32 bg-orange-50 rounded-full blur-2xl group-hover:bg-orange-100/80 transition duration-500 pointer-events-none"></div>
                <div class="relative z-10 flex items-center gap-5">
                    <div class="w-16 h-16 rounded-2xl bg-orange-50 group-hover:bg-brandOrange group-hover:text-white text-brandOrange flex items-center justify-center shrink-0 transition-all duration-500 shadow-sm">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                    </div>
                    <div>
                        <span class="text-[10px] font-black uppercase tracking-widest text-brandOrange mb-1 block">7/24 Yanınızdayız</span>
                        <h3 class="font-black text-base uppercase tracking-wider text-gray-900 group-hover:text-brandOrange transition-colors">Destek Hattı</h3>
                        <p class="text-xs text-gray-500 font-light mt-1">Hızlı İletişim ve Çözüm</p>
                    </div>
                </div>
            </div>

            <div class="group relative bg-white border border-gray-100 rounded-3xl p-8 shadow-xl shadow-gray-100/80 transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl hover:border-brandOrange/40 overflow-hidden">
                <div class="absolute -right-10 -bottom-10 w-32 h-32 bg-orange-50 rounded-full blur-2xl group-hover:bg-orange-100/80 transition duration-500 pointer-events-none"></div>
                <div class="relative z-10 flex items-center gap-5">
                    <div class="w-16 h-16 rounded-2xl bg-orange-50 group-hover:bg-brandOrange group-hover:text-white text-brandOrange flex items-center justify-center shrink-0 transition-all duration-500 shadow-sm">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <div>
                        <span class="text-[10px] font-black uppercase tracking-widest text-brandOrange mb-1 block">%100 Güvenli</span>
                        <h3 class="font-black text-base uppercase tracking-wider text-gray-900 group-hover:text-brandOrange transition-colors">Kolay Ödeme</h3>
                        <p class="text-xs text-gray-500 font-light mt-1">Güvenli ve Kolay Ödeme</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 border-t border-slate-100 mt-12">
<script>
(function() {
    const style = document.createElement('style');
    style.innerHTML = `
        .ai-chat-container {
            position: fixed;
            bottom: 24px;
            right: 24px;
            z-index: 99999;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .ai-float-btn {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, #f97316, #ea580c);
            border: none;
            color: white;
            cursor: pointer;
            box-shadow: 0 10px 25px rgba(249, 115, 22, 0.4);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .ai-float-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 12px 30px rgba(249, 115, 22, 0.6);
        }
        .ai-float-btn svg {
            width: 28px;
            height: 28px;
            fill: currentColor;
            transition: transform 0.3s ease;
        }
        .ai-float-btn:hover svg {
            transform: rotate(12deg);
        }
        .ai-chat-box {
            display: none;
            width: 350px;
            height: 480px;
            background-color: #ffffff;
            border-radius: 20px;
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.2);
            flex-direction: column;
            overflow: hidden;
            position: absolute;
            bottom: 75px;
            right: 0;
            border: 1px solid #e2e8f0;
            animation: aiFadeIn 0.3s ease-in-out;
        }
        @keyframes aiFadeIn {
            from { opacity: 0; transform: translateY(10px) scale(0.95); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }
        .ai-chat-header {
            background: linear-gradient(135deg, #0f172a, #1e293b);
            color: white;
            padding: 16px;
            font-weight: bold;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #334155;
        }
        .ai-close-btn {
            background: none;
            border: none;
            color: #94a3b8;
            font-size: 22px;
            cursor: pointer;
            transition: color 0.2s;
        }
        .ai-close-btn:hover {
            color: white;
        }
        .ai-chat-body {
            flex: 1;
            padding: 16px;
            background-color: #f8fafc;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        .ai-quick-questions {
            display: flex;
            gap: 8px;
            overflow-x: auto;
            padding: 10px 14px;
            background-color: #ffffff;
            border-bottom: 1px solid #f1f5f9;
            -webkit-overflow-scrolling: touch;
            scroll-behavior: smooth;
        }
        .ai-quick-questions::-webkit-scrollbar {
            height: 4px;
        }
        .ai-quick-questions::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        .ai-quick-questions::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        .ai-chip-btn {
            flex-shrink: 0;
            white-space: nowrap;
            background-color: #fff7ed;
            color: #ea580c;
            border: 1px solid #ffedd5;
            padding: 6px 12px;
            border-radius: 14px;
            font-size: 11px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .ai-chip-btn:hover {
            background-color: #f97316;
            color: #ffffff;
            border-color: #f97316;
        }
        .ai-message {
            background-color: #e2e8f0;
            color: #1e293b;
            padding: 10px 14px;
            border-radius: 12px 12px 12px 0;
            font-size: 13px;
            max-width: 85%;
            word-break: break-word;
            margin: 0;
            line-height: 1.4;
        }
        .ai-message.user {
            background-color: #f97316;
            color: white;
            align-self: flex-end;
            border-radius: 12px 12px 0 12px;
        }
        .ai-chat-footer {
            display: flex;
            padding: 12px;
            background-color: #fff;
            border-top: 1px solid #e2e8f0;
        }
        .ai-chat-footer input {
            flex: 1;
            border: 1px solid #cbd5e1;
            padding: 9px 14px;
            border-radius: 20px;
            outline: none;
            font-size: 13px;
            color: #1e293b;
        }
        .ai-chat-footer input:focus {
            border-color: #f97316;
        }
        .ai-chat-footer button {
            background: #f97316;
            border: none;
            color: white;
            padding: 9px 16px;
            margin-left: 8px;
            border-radius: 20px;
            cursor: pointer;
            font-weight: bold;
            font-size: 13px;
            transition: background 0.2s;
        }
        .ai-chat-footer button:hover {
            background: #ea580c;
        }
    `;
    document.head.appendChild(style);

    const robotSvg = `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <rect x="3" y="11" width="18" height="10" rx="2"/>
        <circle cx="12" cy="5" r="2"/>
        <path d="M12 7v4"/>
        <line x1="8" y1="16" x2="8" y2="16.01"/>
        <line x1="16" y1="16" x2="16" y2="16.01"/>
        <path d="M9 19h6"/>
    </svg>`;

    const container = document.createElement('div');
    container.className = 'ai-chat-container';
    container.innerHTML = `
        <div class="ai-chat-box" id="aiChatBox">
            <div class="ai-chat-header">
                <span style="display: flex; align-items: center; gap: 8px; font-size: 14px;">
                    <span style="width: 20px; height: 20px; display: inline-flex; align-items: center;">${robotSvg}</span>
                    Alveral Asistan
                </span>
                <button class="ai-close-btn" id="aiCloseBtn">&times;</button>
            </div>
            
            <!-- Hazır Hızlı Soru Butonları (Kaydırılabilir & Esnek) -->
            <div class="ai-quick-questions">
                <button class="ai-chip-btn" onclick="sendQuickQuestion('En çok satan ürünler neler?')">🔥 En Çok Satanlar</button>
                <button class="ai-chip-btn" onclick="sendQuickQuestion('Ne önerirsin, en iyi ürün hangisi?')">⭐ Ne Önerirsin?</button>
                <button class="ai-chip-btn" onclick="sendQuickQuestion('Hangi kargo şirketiyle çalışıyorsunuz?')">🚚 Kargo & Sipariş</button>
                <button class="ai-chip-btn" onclick="sendQuickQuestion('Siz kimsiniz?')">🏬 Alveral Kimdir?</button>
                <button class="ai-chip-btn" onclick="sendQuickQuestion('Instagram adresiniz ne?')">📸 Instagram</button>
            </div>

            <div class="ai-chat-body" id="aiChatBody">
                <p class="ai-message">Merhaba! Ben Alveral Yapay Zeka Asistanıyım. Size en uygun ürünü bulmak veya sorularınızı yanıtlamak için buradayım! 🤖</p>
            </div>

            <div class="ai-chat-footer">
                <input type="text" placeholder="Ürün veya kategori sorun..." id="aiInput">
                <button id="aiSendBtn">Gönder</button>
            </div>
        </div>
        <button class="ai-float-btn" id="aiToggleBtn" title="AI Asistan">
            ${robotSvg}
        </button>
    `;
    document.body.appendChild(container);

    const toggleBtn = document.getElementById('aiToggleBtn');
    const chatBox = document.getElementById('aiChatBox');
    const closeBtn = document.getElementById('aiCloseBtn');
    const sendBtn = document.getElementById('aiSendBtn');
    const input = document.getElementById('aiInput');
    const chatBody = document.getElementById('aiChatBody');

    toggleBtn.addEventListener('click', () => {
        chatBox.style.display = chatBox.style.display === 'flex' ? 'none' : 'flex';
        if (chatBox.style.display === 'flex') {
            input.focus();
        }
    });

    closeBtn.addEventListener('click', () => {
        chatBox.style.display = 'none';
    });

    window.sendQuickQuestion = function(questionText) {
        input.value = questionText;
        sendMessage();
    };

    function getSmartReply(userText) {
        const text = userText.toLowerCase();
        
        if (text.includes('selamun aleyküm') || text.includes('s.a')) {
            return "Aleykümselam! Hoş geldiniz, safalar getirdiniz. Buyurun, ne arzu etmiştiniz? 🌸";
        } 
        else if (text.includes('hello') || text.includes('hi') || text.includes('merhaba') || text.includes('selam')) {
            return "Hellooo! Welcome to Alveral! Size nasıl yardımcı olabilirim? 🤖✨";
        } 
        else if (text.includes('müslüman mısın') || text.includes('dinin ne')) {
            return "Ben neticede kodlardan oluşan bir yapay zeka robotuyum 🤖 ama kanlı canlı insan olsaydım Elhamdülillah ben de sizden olurdum! 😄";
        } 
        else if (text.includes('nerelisin') || text.includes('kaç yaşındasın')) {
            return "Ruhum dijital, köküm Burdur Çavdır! 30 yıllık ticaret kültürünün içine doğmuş yeni nesil bir yapay zekayım. Yaşım yok ama enerjim hep 18! ⚡";
        }
        else if (text.includes('gerçek misin') || text.includes('insan mısın')) {
            return "Şu an karşında yapay zeka var ama arkamda 30 yıllık esnaf tecrübesi var! Yani emniyettesin, robot elimle çay ikram edemem ama en iyi ürünü bulurum ☕🤖";
        }
        else if (text.includes('ne önerirsin') || text.includes('en iyi ürün') || text.includes('tavsiye') || text.includes('ne almalıyım')) {
            return "Alveral vitrinindeki her ürün kendi kategorisinin yıldızıdır! 🔥 Ancak en çok tercih edilen popüler parçaları görmek için 'En Çok Satanlar' bölümümüze göz atabilir ya da aradığınız ürün türünü söylerseniz size en iyisini hemen seçerim! 🛍️✨";
        }
        else if (text.includes('en çok satan') || text.includes('popüler') || text.includes('best seller')) {
            return "En popüler ürünlerimizi doğrudan sayfamızdaki **'En Çok Satanlar'** bölümünden inceleyebilirsiniz! 🚀";
        } 
        else if (text.includes('kargo') || text.includes('teslimat') || text.includes('sipariş')) {
            return "Ürünlerimiz ulusal satış platformlarına (Trendyol, Amazon, Hepsiburada vb.) yönlendirilmektedir. Dilediğiniz güvenli platform üzerinden siparişinizi gönül rahatlığıyla oluşturabilirsiniz! 🚚✨";
        }
        else if (text.includes('indirim yap') || text.includes('pazarlık')) {
            return "Canın sağ olsun! Pazar yerlerindeki en cömert kampanyaları yakalaman için buradayım, sepeti doldur indirimler seni bekliyor 😉🔥";
        }
        else if (text.includes('fiyat') || text.includes('ücret') || text.includes('kaç para')) {
            return "Güncel fiyatları vitrinimizden inceleyebilir; dilediğiniz e-ticaret platformundan alışveriş yaparak o uygulamaya özel kupon ve fiyat avantajlarından yararlanabilirsiniz! 🏷️💳";
        } 
        else if (text.includes('kimsiniz') || text.includes('alveral kim') || text.includes('güvenilir misiniz')) {
            return "Burdur Çavdır'da 30 yılı aşkın köklü esnaflık ve ticaret birikimine sahip bir aile şirketiyiz! Yılların getirdiği güveni Alveral markasıyla dijital dünyaya taşıyoruz. 🏢✨";
        }
        else if (text.includes('ismi nereden') || text.includes('ne demek')) {
            return "Alveral; dürüst ticaretin en tatlı ritmi olan 'Al - Ver - Al' döngüsünden geliyor! Hem bereketli bir alışverişi hem de alanın da satanın da yüzünü güldüren bir köprüyü simgeliyor. 😉🛍️";
        }
        else if (text.includes('instagram') || text.includes('sosyal medya')) {
            return "Özel sürprizler, yeni koleksiyonlar ve güncel paylaşımlar için bizi Instagram'da **@alveral.tr** hesabımızdan takip edebilirsiniz! 📸";
        }
        else if (text.includes('iade') || text.includes('değişim')) {
            return "Siparişinizi hangi pazar yerinden oluşturduysanız, o platformun kolay iade ve değişim koşulları geçerlidir. Hiçbir sorun yaşamadan işlemlerinizi gerçekleştirebilirsiniz! 🔄";
        }
        else if (text.includes('naber') || text.includes('nasılsın')) {
            return "İyilik, güzellik! Sunucularım tıkır tıkır çalışıyor, size hizmet etmek için enerjim %100! Siz nasılsınız? 😊";
        }
        else if (text.includes('teşekkür') || text.includes('sağol')) {
            return "Rica ederim! Keyifli alışverişler dilerim, başka bir sorunuz olursa ben hep buradayım ✨";
        } 
        else {
            return "Harika bir soru! Aradığınız ürünün adını veya kategorisini yazarsanız size en uygun seçenekleri hemen önerebilirim 🛍️";
        }
    }

    function sendMessage() {
        const text = input.value.trim();
        if (!text) return;

        const userMsg = document.createElement('p');
        userMsg.className = 'ai-message user';
        userMsg.textContent = text;
        chatBody.appendChild(userMsg);
        input.value = '';
        chatBody.scrollTop = chatBody.scrollHeight;

        setTimeout(() => {
            const aiMsg = document.createElement('p');
            aiMsg.className = 'ai-message';
            aiMsg.textContent = getSmartReply(text);
            chatBody.appendChild(aiMsg);
            chatBody.scrollTop = chatBody.scrollHeight;
        }, 600);
    }

    sendBtn.addEventListener('click', sendMessage);
    input.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') sendMessage();
    });
})();
</script>
<div class="flex flex-wrap justify-center items-center gap-4 sm:gap-8">
    
    <div class="bg-white border border-slate-100 px-4 sm:px-6 py-3 sm:py-4 rounded-2xl shadow-sm hover:shadow-lg hover:scale-105 transition duration-300 w-[calc(50%-8px)] sm:w-52 h-24 sm:h-32 flex items-center justify-center">
        <img src="{{ asset('img/reference/trendyol.png') }}" alt="Trendyol Mağazamız" class="max-h-12 sm:max-h-16 object-contain">
    </div>

    
    <div class="bg-white border border-slate-100 px-4 sm:px-6 py-3 sm:py-4 rounded-2xl shadow-sm hover:shadow-lg hover:scale-105 transition duration-300 w-[calc(50%-8px)] sm:w-52 h-24 sm:h-32 flex items-center justify-center">
        <img src="{{ asset('img/reference/hepsiburada.png') }}" alt="Hepsiburada Mağazamız" class="max-h-12 sm:max-h-16 object-contain">
    </div>

    
    <div class="bg-white border border-slate-100 px-4 sm:px-6 py-3 sm:py-4 rounded-2xl shadow-sm hover:shadow-lg hover:scale-105 transition duration-300 w-[calc(50%-8px)] sm:w-52 h-24 sm:h-32 flex items-center justify-center">
        <img src="{{ asset('img/reference/idefix.png') }}" alt="idefix Mağazamız" class="max-h-12 sm:max-h-16 object-contain">
    </div>

   
    <div class="bg-white border border-slate-100 px-4 sm:px-6 py-3 sm:py-4 rounded-2xl shadow-sm hover:shadow-lg hover:scale-105 transition duration-300 w-[calc(50%-8px)] sm:w-52 h-24 sm:h-32 flex items-center justify-center">
        <img src="{{ asset('img/reference/amazon.png') }}" alt="Amazon Mağazamız" class="max-h-12 sm:max-h-16 object-contain">
    </div>

    
    <div class="bg-white border border-slate-100 px-4 sm:px-6 py-3 sm:py-4 rounded-2xl shadow-sm hover:shadow-lg hover:scale-105 transition duration-300 w-[calc(50%-8px)] sm:w-52 h-24 sm:h-32 flex items-center justify-center">
        <img src="{{ asset('img/reference/pazarama.png') }}" alt="pazarama Mağazamız" class="max-h-12 sm:max-h-16 object-contain">
    </div>
</div>
</section>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        const slider = document.getElementById('categorySlider');
        if (!slider) return;

        let autoScroll = setInterval(() => {
            if (slider.scrollWidth <= slider.clientWidth) return;

            if (slider.scrollLeft + slider.clientWidth >= slider.scrollWidth - 5) {
                slider.scrollTo({ left: 0, behavior: 'smooth' });
            } else {
                slider.scrollBy({ left: 160, behavior: 'smooth' });
            }
        }, 3000);

        slider.addEventListener('mouseenter', () => clearInterval(autoScroll));
        slider.addEventListener('mouseleave', () => {
            clearInterval(autoScroll);
            autoScroll = setInterval(() => {
                if (slider.scrollWidth <= slider.clientWidth) return;
                if (slider.scrollLeft + slider.clientWidth >= slider.scrollWidth - 5) {
                    slider.scrollTo({ left: 0, behavior: 'smooth' });
                } else {
                    slider.scrollBy({ left: 160, behavior: 'smooth' });
                }
            }, 3000);
        });
    });
</script>



<footer id="iletisim" class="bg-gray-900 text-white py-16 px-6 mt-24">
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-10 text-sm">
        
        <div>
            <img src="{{ asset('img/logo/logo.png') }}" alt="Alveral" class="h-12 w-auto mb-4 brightness-120">
            <p class="text-gray-400 font-light leading-relaxed">
                30 yılı aşkın tecrübemizle özenle seçilmiş ürünleri ve en avantajlı fırsatları modern vitrin konseptiyle buluşturuyoruz.
            </p>
        </div>

        <div>
            <h3 class="font-bold text-xs uppercase tracking-widest mb-4 text-white">Keşfet</h3>
            <ul class="space-y-2.5 text-gray-400 font-light">
                <li>
                    <a href="{{ url('/') }}" class="hover:text-white transition">Anasayfa</a>
                </li>
                <li>
                    <a href="{{ route('contact') }}" class="hover:text-white transition">İletişim</a>
                </li>

                @auth('admin')
                    <li class="pt-2 border-t border-gray-800">
                        <a href="{{ route('admin.dashboard') }}" class="text-brandOrange hover:text-orange-400 font-bold transition flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span>Yönetim Paneli</span>
                        </a>
                    </li>
                @endauth
            </ul>
        </div>

        <div>
            <h3 class="font-bold text-xs uppercase tracking-widest mb-4 text-white">Sosyal Medya Hesaplarımız</h3>
                <li>
                    <a href="https://www.instagram.com/alveral.tr/" target="_blank" class="hover:text-white transition flex items-center gap-2 group">
                        <svg class="w-4 h-4 text-brandOrange group-hover:scale-110 transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <rect width="20" height="20" x="2" y="2" rx="5" ry="5"/>
                            <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/>
                            <line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/>
                        </svg>
                        <span>Instagram (@alveral.tr)</span>
                    </a>
                </li>
        </div>

    </div>


    <div class="border-t border-gray-800 mt-12 pt-8 flex flex-col items-center justify-center text-center text-sm text-gray-400 font-light">
        <p>© {{ date('Y') }} Alveral. Tüm hakları saklıdır.</p>
        <a href="https://edaoncel.github.io/edaoncell/project.html" target="_blank" rel="noopener noreferrer" class="mt-4 hover:text-white transition duration-300 flex items-center gap-2 group">
            <span class="text-gray-300">Alveral Tasarım & Geliştirme:</span>
            <span class="font-bold text-white underline underline-offset-4 decoration-brandOrange group-hover:text-brandOrange transition tracking-wider">Eda Öncel</span>
        </a>
    </div>
</footer>

</body>
</html>