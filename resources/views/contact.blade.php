@extends('layouts.store')

@section('title', 'Alveral - Hakkımızda ve İletişim')

@section('content')
    
<header class="bg-slate-200 text-white py-20 px-6 text-center relative overflow-hidden">
    <div class="max-w-4xl mx-auto relative z-10">
        <span class="text-brandOrange tracking-widest text-xs uppercase font-extrabold mb-3 block">30 Yıllık Güven ve Dijital Vizyon</span>
        <h1 class="text-4xl sm:text-5xl font-black mb-4 tracking-tight uppercase">İletişim</h1>
        <p class="text-slate-400 text-sm sm:text-base max-w-xl mx-auto font-light leading-relaxed">Geçmişten gelen güçlü esnaflık mirasımızı, modern e-ticaretin dinamikleriyle birleştirerek sizlere kesintisiz bir alışveriş deneyimi sunuyoruz.</p>
    </div>
</header>

<div class="max-w-6xl mx-auto px-4 sm:px-8 py-16 w-full">
    
    <div class="bg-white border border-slate-200 rounded-3xl p-8 sm:p-12 shadow-sm mb-16 leading-relaxed text-slate-600 space-y-6">
        <p class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">
            Ticaretin kalbinde doğan, kaliteyi ve güveni standart haline getiren bir e-ticaret platformuyuz.
        </p>
        <p class="text-sm sm:text-base font-light leading-relaxed">
            <strong class="text-slate-900 font-bold">Alveral</strong>, 30 yılı aşkın süredir ticaretin içinde pişmiş, müşteri memnuniyetini ve dürüstlüğü her şeyin üzerinde tutan köklü bir ekibin vizyonuyla hayata geçirildi. Yıllar boyunca yerelde edindiğimiz güçlü ticari ilişkileri, birinci sınıf ürün seçki anlayışını ve esnaflık kültürünü; bugünün dijital dünyasına taşıyarak sınırları ortadan kaldırıyoruz.
        </p>
        <p class="text-sm sm:text-base font-light leading-relaxed">
            İsmini ve dinamizmini ticaretin en saf halinden alan Alveral; binlerce ürünü en avantajlı fiyatlar ve güvenilir tedarik ağlarıyla buluşturan yeni nesil bir alışveriş platformudur. Sadece bir satış noktası değil; aynı zamanda müşterilerinin her an yanında olan, şeffaf, hızlı ve müşteri odaklı bir dijital çözüm ortağıyız.
        </p>
        <p class="text-sm sm:text-base font-light leading-relaxed">
            Bugün, genişleyen kategori yapımız, güçlü pazar yeri entegrasyonlarımız ve işimize duyduğumuz ilk günkü heyecanla büyümeye devam ediyoruz. Alveral çatısı altında sunduğumuz her üründe kaliteyi ön planda tutuyor, alışverişinizi keyifli, güvenli ve kolay kılmak için çalışıyoruz.
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
        
        <div class="lg:col-span-5 space-y-8">
            <div class="bg-white border border-slate-200 p-8 rounded-3xl shadow-sm">
                <h3 class="font-black text-xl text-slate-900 mb-2">Sosyal Medya Dünyamız</h3>
                <p class="text-xs text-slate-400 mb-6 font-light">En yeni koleksiyonlarımızdan, sürpriz kampanyalardan ve güncel fırsatlardan anında haberdar olmak için bizi takip edin:</p>
                
                <div class="space-y-3">
                    <a href="https://www.instagram.com/alveral.tr/" target="_blank" class="flex items-center gap-3.5 p-4 bg-slate-50 hover:bg-orange-50 hover:text-brandOrange rounded-2xl font-bold text-xs transition border border-slate-100 group">
                        <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-amber-500 via-rose-500 to-purple-600 flex items-center justify-center text-white shrink-0 shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <rect width="20" height="20" x="2" y="2" rx="5" ry="5"/>
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/>
                                <line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/>
                            </svg>
                        </div>
                        <div>
                            <span class="block text-slate-900 group-hover:text-brandOrange font-extrabold text-sm">@alveral.tr</span>
                            <span class="text-[11px] text-slate-400 font-normal">Resmi Instagram Hesabımız</span>
                        </div>
                    </a>
                    <a href="https://www.facebook.com/share/19GHvLb4DJ/" target="_blank" class="flex items-center gap-3.5 p-4 bg-slate-50 hover:bg-orange-50 hover:text-brandOrange rounded-2xl font-bold text-xs transition border border-slate-100 group">
                    <div class="w-9 h-9 rounded-xl bg-blue-600 flex items-center justify-center text-white shrink-0 shadow-sm">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </div>
                    <div>
                        <span class="block text-slate-900 group-hover:text-brandOrange font-extrabold text-sm">Alveral</span>
                        <span class="text-[11px] text-slate-400 font-normal">Resmi Facebook Hesabımız</span>
                    </div>
                </a>

                <!-- 3. TIKTOK KARTI -->
                <a href="https://www.tiktok.com/@alveral.tr" target="_blank" class="flex items-center gap-3.5 p-4 bg-slate-50 hover:bg-orange-50 hover:text-brandOrange rounded-2xl font-bold text-xs transition border border-slate-100 group">
                    <div class="w-9 h-9 rounded-xl bg-black flex items-center justify-center text-white shrink-0 shadow-sm">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.13z"/>
                        </svg>
                    </div>
                    <div>
                        <span class="block text-slate-900 group-hover:text-brandOrange font-extrabold text-sm">@alveral.tr</span>
                        <span class="text-[11px] text-slate-400 font-normal">Resmi TikTok Hesabımız</span>
                    </div>
                </a>
                </div>
            </div>

            <div class="bg-slate-100 text-white p-8 rounded-3xl shadow-sm space-y-3">
                <h4 class="font-bold text-sm uppercase tracking-wider text-brandOrange">Alveral Güvencesi</h4>
                <p class="text-xs text-slate-900 font-light leading-relaxed">
                    Yüzlerce mutlu müşterimizin tercihi olan platformumuzda, güvenli ödeme alternatifleri ve özenli kargo süreçleriyle her alışverişinizde yanınızdayız.
                </p>
            </div>
        </div>

<div id="bize-ulasin" class="lg:col-span-7 bg-white border border-slate-200 p-8 sm:p-10 rounded-3xl shadow-sm scroll-mt-6">
    <h3 class="font-black text-2xl text-slate-900 mb-1">Bizimle İletişime Geçin</h3>
    <p class="text-xs text-slate-400 mb-8 font-light">Görüş, öneri, soru ve kurumsal iş birliği talepleriniz için aşağıdaki formu doldurarak bize ulaşabilirsiniz.</p>

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-bold rounded-2xl shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('contact.store') }}" method="POST" class="space-y-5">
        @csrf
        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Adınız Soyadınız</label>
            <input type="text" name="name" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3.5 text-sm text-slate-800 focus:outline-none focus:border-brandOrange focus:ring-1 focus:ring-brandOrange transition">
        </div>
        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">E-Posta Adresiniz</label>
            <input type="email" name="email" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3.5 text-sm text-slate-800 focus:outline-none focus:border-brandOrange focus:ring-1 focus:ring-brandOrange transition">
        </div>
        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Konu</label>
            <input type="text" name="subject" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3.5 text-sm text-slate-800 focus:outline-none focus:border-brandOrange focus:ring-1 focus:ring-brandOrange transition">
        </div>
        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Mesajınız</label>
            <textarea name="message" rows="4" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3.5 text-sm text-slate-800 focus:outline-none focus:border-brandOrange focus:ring-1 focus:ring-brandOrange transition"></textarea>
        </div>

        <!-- KVKK Onay Kutusu -->
        <div class="flex items-start gap-3 pt-2">
            <input type="checkbox" name="kvkk" id="kvkk" required class="mt-0.5 rounded border-slate-300 text-brandOrange focus:ring-brandOrange cursor-pointer">
            <label for="kvkk" class="text-xs text-slate-600 leading-relaxed cursor-pointer select-none">
                <a href="{{ route('kvkk.terms') }}" target="_blank" class="text-brandOrange underline hover:opacity-80 font-semibold">KVKK Aydınlatma Metni</a>'ni okudum, kişisel verilerimin işlenmesini kabul ediyorum.
            </label>
        </div>

        <button type="submit" class="w-full bg-slate-300 hover:bg-brandOrange text-white font-bold py-4 rounded-2xl text-xs uppercase tracking-wider transition shadow-sm cursor-pointer">
            Mesaj Gönder
        </button>
    </form>
</div>

    </div>
</div>

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
        <button class="ai-chip-btn" onclick="sendQuickQuestion('Instagram adresiniz ne?')">📸 Instagram (@alveral.tr)</button>
        <button class="ai-chip-btn" onclick="sendQuickQuestion('Facebook sayfanız var mı?')">📘 Facebook (Alveral)</button>
        <button class="ai-chip-btn" onclick="sendQuickQuestion('TikTok hesabınız var mı?')">🎵 TikTok (@alveral.tr)</button>
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
            return "Ürünlerimiz ulusal satış platformlarına (Trendyol, Hepsiburada vb.) yönlendirilmektedir. Dilediğiniz güvenli platform üzerinden siparişinizi gönül rahatlığıyla oluşturabilirsiniz! 🚚✨";
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
        else if (text.includes('facebook') || text.includes('sosyal medya')) {
            return "Özel sürprizler, yeni koleksiyonlar ve güncel paylaşımlar için bizi facebook'da **@alveral** hesabımızdan takip edebilirsiniz! 📸";
        }
        else if (text.includes('tiktok') || text.includes('sosyal medya')) {
            return "Özel sürprizler, yeni koleksiyonlar ve güncel paylaşımlar için bizi tiktok'da **@alveral.tr** hesabımızdan takip edebilirsiniz! 📸";
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
@endsection