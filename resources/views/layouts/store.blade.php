<!DOCTYPE html>
<html lang="tr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Alveral')</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo/link_logo.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
   
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>[x-cloak] { display: none !important; }</style>
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
<body class="bg-white min-h-screen text-gray-900 antialiased flex flex-col justify-between" x-data="{ mobileMenu: false, mobileCatOpen: false }">
<nav class="bg-white/95 backdrop-blur-md border-b border-gray-100 sticky top-0 z-50 shadow-sm"
     x-data="{ mobileMenu: false, mobileCatOpen: false, catOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-8 h-20 flex justify-between items-center">
        
        <a href="{{ url('/') }}" class="flex items-center">
            <img src="{{ asset('img/logo/logo.png') }}" alt="Alveral" class="h-12 sm:h-12 w-auto object-contain">
        </a>

        <!-- Güvenli Veri Çekme (Controller'dan bağımsız her sayfada çalışır) -->
        @php
            $navCategories = \App\Models\Category::all();
            $menuCategories = \App\Models\Category::where('show_in_menu', true)->get();
        @endphp

        <div class="hidden md:flex items-center space-x-10 text-sm font-medium tracking-wide text-gray-700">
            <!-- 1. ANASAYFA -->
            <a href="{{ url('/') }}" class="text-brandOrange font-semibold transition">ANASAYFA</a>
            
            <!-- 2. KATEGORİLER (Dropdown) -->
            <div class="relative" @click.away="catOpen = false">
                <button @click="catOpen = !catOpen" type="button" class="flex items-center gap-1.5 hover:text-brandOrange transition focus:outline-none">
                    KATEGORİLER
                    <svg class="w-4 h-4 transition-transform duration-200" :class="catOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                
                <div x-show="catOpen" x-cloak 
                    x-transition:enter="transition ease-out duration-200" 
                    x-transition:enter-start="opacity-0 translate-y-2" 
                    x-transition:enter-end="opacity-100 translate-y-0" 
                    class="absolute left-0 mt-4 w-60 bg-white border border-gray-100 rounded-2xl shadow-2xl py-3 z-50">
                    <a href="{{ url('/#urunler') }}" class="block px-5 py-2.5 text-xs uppercase tracking-wider font-bold text-gray-800 hover:bg-gray-50 hover:text-brandOrange transition">Tüm Ürünler</a>
                    
                    @foreach($navCategories as $cat)
                        <a href="{{ url('/?category=' . $cat->slug . '#urunler') }}" class="block px-5 py-2.5 text-xs font-medium text-gray-600 hover:bg-gray-50 hover:text-brandOrange transition">
                            {{ $cat->name }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- 3. MENÜ KATEGORİLERİ (Doğrudan Akışta) -->
            @foreach($menuCategories as $menuCat)
                <a href="{{ url('/?category=' . $menuCat->slug . '#urunler') }}" 
                class="transition relative px-3 py-1.5 rounded-xl text-sm font-semibold bg-gradient-to-r from-brandOrange to-amber-500 text-white shadow-md shadow-brandOrange/20 animate-pulse hover:animate-none hover:scale-105">
                    {{ $menuCat->name }}
                    <span class="absolute -top-1 -right-1 flex h-3 w-3">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-300 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-amber-400"></span>
                    </span>
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

    <!-- MOBİL MENÜ -->
    <div x-show="mobileMenu" x-cloak class="md:hidden bg-white border-b border-gray-100 px-6 py-5 space-y-4 shadow-xl">
        <a href="{{ url('/') }}" class="block text-sm font-bold text-brandOrange">ANASAYFA</a>
        
        <!-- Kategoriler Mobil -->
        <div>
            <button @click="mobileCatOpen = !mobileCatOpen" type="button" class="w-full flex justify-between items-center text-xs font-extrabold text-gray-400 uppercase tracking-widest pt-2 focus:outline-none">
                <span>KATEGORİLER</span>
                <svg class="w-4 h-4 transition-transform duration-200" :class="mobileCatOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>
            
            <div x-show="mobileCatOpen" x-cloak class="pl-3 mt-3 space-y-2.5 border-l-2 border-orange-100 max-h-48 overflow-y-auto">
                <a href="{{ url('/#urunler') }}" class="block text-xs font-semibold text-gray-800">Tüm Ürünler</a>
                @foreach($navCategories as $cat)
                    <a href="{{ url('/?category=' . $cat->slug . '#urunler') }}" class="block text-xs text-gray-600 hover:text-brandOrange transition">{{ $cat->name }}</a>
                @endforeach
            </div>
        </div>
        
        <!-- Öne Çıkan Menü Kategorileri Mobil -->
        <div class="space-y-2 pt-1">
            @foreach($menuCategories as $menuCat)
                <a href="{{ url('/?category=' . $menuCat->slug . '#urunler') }}" 
                   class="block text-sm font-medium transition rounded-xl px-3 py-2 bg-brandOrange text-white font-bold shadow-sm shadow-brandOrange/30 flex items-center justify-between">
                    <span>{{ $menuCat->name }}</span>
                    <span class="flex h-2 w-2 relative">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-white"></span>
                    </span>
                </a>
            @endforeach
        </div>

        <div class="pt-2">
            <a href="{{ route('contact') }}" class="block text-sm font-bold text-brandOrange">İLETİŞİM</a>
        </div>
        
        <div class="pt-2">
            @auth('admin')
                <a href="{{ route('admin.dashboard') }}" class="block text-center bg-gray-900 text-white py-3 rounded-full text-xs font-bold uppercase tracking-wider">Panel</a>
            @else
                <a href="{{ route('admin.login') }}" class="block text-center bg-gray-900 text-white py-3 rounded-full text-xs font-bold uppercase tracking-wider">Admin Girişi</a>
            @endauth
        </div>
    </div>
</nav>
    <main class="flex-1">
        @yield('content')
    </main>

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
                <ul>
                <!-- 1. INSTAGRAM -->
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

                <!-- 2. FACEBOOK -->
                <li class="mt-2">
                    <a href="https://www.facebook.com/share/19GHvLb4DJ/" target="_blank" class="hover:text-white transition flex items-center gap-2 group">
                        <svg class="w-4 h-4 text-brandOrange group-hover:scale-110 transition" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                        <span>Facebook (Alveral)</span>
                    </a>
                </li>

                <!-- 3. TIKTOK -->
                <li class="mt-2">
                    <a href="https://www.tiktok.com/@alveral.tr" target="_blank" class="hover:text-white transition flex items-center gap-2 group">
                        <svg class="w-4 h-4 text-brandOrange group-hover:scale-110 transition" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.13z"/>
                        </svg>
                        <span>TikTok (@alveral.tr)</span>
                    </a>
                </li>
            </ul>
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