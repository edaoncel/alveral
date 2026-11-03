@extends('layouts.admin')
@section('title', 'Alveral - Pazaryeri Yönetimi & API Entegrasyonu')
<!-- Bootstrap 5 CSS ve FontAwesome İkonlarını Sayfaya Dahil Et -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

@section('content')
<div class="container-fluid px-4 py-4" style="background-color: #f8fafc; min-height: 100vh;">
    
    <!-- SAYFA BAŞLIĞI VE SİSTEM DURUMU -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 pb-3 border-bottom gap-3">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge bg-primary bg-opacity-10 text-primary fw-semibold px-2.5 py-1.5 rounded">v2.4 Entegrasyon</span>
                <span class="text-muted small">•</span>
                <span class="text-muted small">Son Güncelleme: Bugün</span>
            </div>
            <h1 class="h3 fw-bold text-dark mb-0">
                <i class="fa-solid fa-network-wired text-primary me-2"></i>Pazaryeri Yönetimi & API Entegrasyonu
            </h1>
            <p class="text-muted small mb-0 mt-1">Trendyol, Hepsiburada ve Amazon API ayarlarını yapılandırın, fiyat kâr oranlarını yönetin ve XML senkronizasyonunu gerçekleştirin.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <div class="bg-white p-2 px-3 rounded-4 shadow-sm border d-flex align-items-center gap-3">
                <div class="position-relative">
                    <span class="spinner-grow spinner-grow-sm text-success" role="status"></span>
                    <span class="position-absolute top-0 start-0 spinner-grow spinner-grow-sm text-success opacity-50"></span>
                </div>
                <div>
                    <div class="small fw-bold text-dark lh-1">Sistem Aktif</div>
                    <div class="text-muted opacity-75" style="font-size: 11px;">API Bağlantıları Canlı</div>
                </div>
            </div>
        </div>
    </div>

    <!-- BİLDİRİMLER -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4 d-flex align-items-center" role="alert">
            <div class="bg-success text-white rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                <i class="fa-solid fa-check"></i>
            </div>
            <div>{!! session('success') !!}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4 d-flex align-items-center" role="alert">
            <div class="bg-danger text-white rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                <i class="fa-solid fa-exclamation"></i>
            </div>
            <div>{{ session('error') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- HIZLI ÖZET İSTATİSTİKLERİ -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-3">
                <div class="d-flex align-items-center">
                    <div class="rounded-4 p-3 bg-primary bg-opacity-10 text-primary me-3">
                        <i class="fa-solid fa-boxes-stacked fa-xl"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-semibold">Toplam Senkronize Ürün</div>
                        <h4 class="fw-bold mb-0 text-dark">{{ isset($urunler) ? count($urunler) : 0 }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-3">
                <div class="d-flex align-items-center">
                    <div class="rounded-4 p-3 bg-success bg-opacity-10 text-success me-3">
                        <i class="fa-solid fa-store fa-xl"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-semibold">Aktif Mağaza Sayısı</div>
                        <h4 class="fw-bold mb-0 text-dark">
                            {{ (session('mp_trendyol_aktif', true) ? 1 : 0) + (session('mp_hepsiburada_aktif', false) ? 1 : 0) + (session('mp_amazon_aktif', false) ? 1 : 0) }} / 3
                        </h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-3">
                <div class="d-flex align-items-center">
                    <div class="rounded-4 p-3 bg-warning bg-opacity-10 text-warning me-3">
                        <i class="fa-solid fa-arrows-rotate fa-xl"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-semibold">XML Senkronizasyonu</div>
                        <h4 class="fw-bold mb-0 text-dark">Otomatik (24s)</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- PAZARYERİ KUTULARI (Trendyol, Hepsiburada, Amazon) -->
    <div class="row g-4 mb-4">
        
        <!-- 1. Trendyol Kutusu -->
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white overflow-hidden transition-all">
                <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="rounded-3 p-2.5 me-3 fw-bold text-white shadow-sm d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background: linear-gradient(135deg, #f97316, #ea580c);">
                                <i class="fa-solid fa-bag-shopping fa-lg"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold text-dark mb-0">Trendyol</h5>
                                <span class="text-muted small">Marketplace API</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('admin.marketplaces.alveral.kar') }}" method="POST">
                        @csrf
                        <input type="hidden" name="pazaryeri" value="trendyol">
                        
                        <!-- Aktif/Pasif Switch -->
                        <div class="mb-3 form-check form-switch ps-0 d-flex justify-content-between align-items-center bg-light p-2.5 rounded-3">
                            <label class="form-check-label small fw-bold text-dark ms-2" for="trendyolAktif">Mağaza Durumu</label>
                            <input class="form-check-input style-switch me-0" type="checkbox" role="switch" id="trendyolAktif" name="aktif" value="1" {{ session('mp_trendyol_aktif', true) ? 'checked' : '' }}>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-secondary">Kâr Oranı (%)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0 text-muted"><i class="fa-solid fa-percent"></i></span>
                                <input type="number" step="0.01" name="varsayilan_kar" class="form-control bg-light border-0 fw-bold text-dark" value="{{ session('mp_trendyol_kar', 26.00) }}" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-secondary">Tedarikçi (Supplier) ID</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0 text-muted"><i class="fa-solid fa-id-card"></i></span>
                                <input type="text" name="merchant_id" class="form-control bg-light border-0" placeholder="Örn: 123456" value="{{ session('mp_trendyol_merchant') }}">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label small fw-semibold text-secondary">API Secret</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0 text-muted"><i class="fa-solid fa-key"></i></span>
                                <input type="password" name="api_secret" class="form-control bg-light border-0" placeholder="••••••••••••••••" value="{{ session('mp_trendyol_secret') }}">
                            </div>
                        </div>

                        <button type="submit" class="btn w-100 fw-semibold text-white py-2.5 rounded-3 shadow-sm d-flex align-items-center justify-content-center gap-2" style="background-color: #f97316; border: none;">
                            <i class="fa-solid fa-floppy-disk"></i> Trendyol Ayarlarını Kaydet
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- 2. Hepsiburada Kutusu -->
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white overflow-hidden">
                <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="rounded-3 p-2.5 me-3 fw-bold text-white shadow-sm d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background: linear-gradient(135deg, #ff6000, #d45000);">
                                <i class="fa-solid fa-store fa-lg"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold text-dark mb-0">Hepsiburada</h5>
                                <span class="text-muted small">Merchant API</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('admin.marketplaces.alveral.kar') }}" method="POST">
                        @csrf
                        <input type="hidden" name="pazaryeri" value="hepsiburada">

                        <!-- Aktif/Pasif Switch -->
                        <div class="mb-3 form-check form-switch ps-0 d-flex justify-content-between align-items-center bg-light p-2.5 rounded-3">
                            <label class="form-check-label small fw-bold text-dark ms-2" for="hbAktif">Mağaza Durumu</label>
                            <input class="form-check-input style-switch me-0" type="checkbox" role="switch" id="hbAktif" name="aktif" value="1" {{ session('mp_hepsiburada_aktif', false) ? 'checked' : '' }}>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-secondary">Kâr Oranı (%)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0 text-muted"><i class="fa-solid fa-percent"></i></span>
                                <input type="number" step="0.01" name="varsayilan_kar" class="form-control bg-light border-0 fw-bold text-dark" value="{{ session('mp_hepsiburada_kar', 28.00) }}" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-secondary">Merchant Username</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0 text-muted"><i class="fa-solid fa-user"></i></span>
                                <input type="text" name="merchant_id" class="form-control bg-light border-0" placeholder="HB Mağaza Kullanıcı Adı" value="{{ session('mp_hepsiburada_merchant') }}">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label small fw-semibold text-secondary">API Şifresi / Token</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0 text-muted"><i class="fa-solid fa-lock"></i></span>
                                <input type="password" name="api_secret" class="form-control bg-light border-0" placeholder="••••••••••••••••" value="{{ session('mp_hepsiburada_secret') }}">
                            </div>
                        </div>

                        <button type="submit" class="btn w-100 fw-semibold text-white py-2.5 rounded-3 shadow-sm d-flex align-items-center justify-content-center gap-2" style="background-color: #ff6000; border: none;">
                            <i class="fa-solid fa-floppy-disk"></i> Hepsiburada Ayarlarını Kaydet
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- 3. Amazon Kutusu -->
        <div class="col-xl-4 col-md-12">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white overflow-hidden">
                <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="rounded-3 p-2.5 me-3 fw-bold text-dark shadow-sm d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background: linear-gradient(135deg, #ff9900, #e68a00);">
                                <i class="fa-brands fa-amazon fa-xl"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold text-dark mb-0">Amazon</h5>
                                <span class="text-muted small">SP-API Entegrasyonu</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('admin.marketplaces.alveral.kar') }}" method="POST">
                        @csrf
                        <input type="hidden" name="pazaryeri" value="amazon">

                        <!-- Aktif/Pasif Switch -->
                        <div class="mb-3 form-check form-switch ps-0 d-flex justify-content-between align-items-center bg-light p-2.5 rounded-3">
                            <label class="form-check-label small fw-bold text-dark ms-2" for="amzAktif">Mağaza Durumu</label>
                            <input class="form-check-input style-switch me-0" type="checkbox" role="switch" id="amzAktif" name="aktif" value="1" {{ session('mp_amazon_aktif', false) ? 'checked' : '' }}>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-secondary">Kâr Oranı (%)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0 text-muted"><i class="fa-solid fa-percent"></i></span>
                                <input type="number" step="0.01" name="varsayilan_kar" class="form-control bg-light border-0 fw-bold text-dark" value="{{ session('mp_amazon_kar', 30.00) }}" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-secondary">Seller ID</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0 text-muted"><i class="fa-solid fa-store"></i></span>
                                <input type="text" name="merchant_id" class="form-control bg-light border-0" placeholder="Amazon Satıcı ID" value="{{ session('mp_amazon_merchant') }}">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label small fw-semibold text-secondary">SP-API Refresh Token</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0 text-muted"><i class="fa-solid fa-shield-halved"></i></span>
                                <input type="password" name="api_secret" class="form-control bg-light border-0" placeholder="••••••••••••••••" value="{{ session('mp_amazon_secret') }}">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-dark w-100 fw-semibold py-2.5 rounded-3 shadow-sm d-flex align-items-center justify-content-center gap-2">
                            <i class="fa-solid fa-floppy-disk"></i> Amazon Ayarlarını Kaydet
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <!-- XML YÜKLEME VE URL SENRONİZASYON KUTUSU -->
<div class="card border-0 shadow-sm rounded-4 mb-4 bg-white border-top border-dark border-4">
    <div class="card-body p-4">
        <div class="d-flex align-items-center mb-3">
            <div class="bg-dark bg-opacity-10 text-dark rounded-3 p-3 me-3 shadow-sm" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                <i class="fa-solid fa-cloud-arrow-up fa-lg"></i>
            </div>
            <div>
                <h5 class="fw-bold text-dark mb-0">Tedarikçi XML Senkronizasyonu</h5>
                <span class="text-muted small">İster bilgisayardan XML dosyası yükleyin, ister tedarikçinin XML linkini girerek otomatik eşitleyin.</span>
            </div>
        </div>

        <form action="{{ route('admin.marketplaces.alveral.sync') }}" method="POST" enctype="multipart/form-data" class="row g-3 align-items-center mt-2">
            @csrf
            
            <!-- URL Giriş Alanı -->
            <div class="col-lg-5">
                <label class="form-label small fw-bold text-secondary">XML Canlı URL Adresi</label>
                <input type="url" name="xml_url" class="form-control bg-light border-0 py-2.5" placeholder="https://tedarikci.com/ornek.xml" value="{{ \App\Models\Setting::where('key', 'saved_xml_url')->value('value') }}">
            </div>

            <!-- Veya Dosya Yükleme Alanı -->
            <div class="col-lg-4">
                <label class="form-label small fw-bold text-secondary">Veya Bilgisayardan Dosya Seç</label>
                <input class="form-control bg-light border-0 py-2.5" type="file" name="xml_dosyasi" accept=".xml">
            </div>

            <div class="col-lg-3 d-flex align-items-end">
                <button type="submit" class="btn w-100 py-2.5 fw-semibold text-white shadow-sm mt-auto" style="background-color: #f97316; border-color: #f97316;">
                    <i class="fa-solid fa-rotate me-1"></i> Senkronize Et
                </button>
            </div>
        </form>
    </div>
</div>

    <!-- ÜRÜN LİSTESİ TABLOSU -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
    <div class="card-header bg-white py-3 px-4 border-bottom border-light d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div class="d-flex align-items-center gap-2">
            <i class="fa-solid fa-boxes-stacked text-primary"></i>
            <h5 class="mb-0 fw-bold text-dark">Senkronize Ürün Listesi</h5>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-light text-dark border px-3 py-2 rounded-pill small fw-semibold me-2">
                Toplam: {{ isset($urunler) ? count($urunler) : 0 }} Ürün
            </span>
            
            <!-- DARALT / GENİŞLET BUTONLARI -->
            <button class="btn btn-sm btn-outline-danger px-3 py-2 rounded-pill fw-semibold" type="button" id="btnDaralt" style="display: none;">
                <i class="fa-solid fa-chevron-up me-1"></i> Daralt
            </button>
            <button class="btn btn-sm btn-outline-success px-3 py-2 rounded-pill fw-semibold" type="button" id="btnGenişlet">
                <i class="fa-solid fa-chevron-down me-1"></i> Genişlet
            </button>
        </div>
    </div>

    <!-- Başlangıçta gizli (kapalı) gelmesi için style="display: none;" eklendi -->
    <div id="urunlerTablosuContent" style="display: none;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-nowrap">
                    <thead class="bg-light text-uppercase fs-7 text-muted border-bottom">
                        <tr>
                            <th class="ps-4 py-3">SKU / Stok Kodu</th>
                            <th class="py-3">Ürün Adı</th>
                            <th class="py-3">Satış Fiyatı</th>
                            <th class="py-3">Stok Durumu</th>
                            <th class="pe-4 py-3 text-end">Son Güncelleme</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($urunler) && count($urunler) > 0)
                            @foreach($urunler as $row)
                                <tr>
                                    <td class="ps-4">
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary border font-monospace px-2.5 py-1.5 rounded">
                                            {{ $row->sku ?? 'SKU-YOK' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="fw-semibold text-dark">{{ $row->name }}</div>
                                    </td>
                                    <td>
                                        <span class="text-success fw-bold">
                                            {{ number_format($row->price, 2) }} ₺
                                        </span>
                                    </td>
                                    <td>
                                        @if($row->stock > 10)
                                            <span class="badge bg-success bg-opacity-10 text-success fw-bold px-3 py-1.5 rounded-pill">
                                                <i class="fa-solid fa-check me-1"></i> {{ $row->stock }} Adet
                                            </span>
                                        @elseif($row->stock > 0)
                                            <span class="badge bg-warning bg-opacity-10 text-warning fw-bold px-3 py-1.5 rounded-pill">
                                                <i class="fa-solid fa-triangle-exclamation me-1"></i> {{ $row->stock }} Adet (Kritik)
                                            </span>
                                        @else
                                            <span class="badge bg-danger bg-opacity-10 text-danger fw-bold px-3 py-1.5 rounded-pill">
                                                <i class="fa-solid fa-xmark me-1"></i> Stok Tükendi
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-muted small pe-4 text-end">
                                        <i class="fa-regular fa-clock me-1"></i>
                                        {{ $row->updated_at ? $row->updated_at->format('d.m.Y H:i') : '-' }}
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <div class="py-4">
                                        <div class="rounded-circle bg-light d-inline-flex p-4 mb-3">
                                            <i class="fa-solid fa-box-open fa-3x text-muted opacity-50"></i>
                                        </div>
                                        <h6 class="fw-bold text-dark mb-1">Henüz Aktarılmış Ürün Bulunmuyor</h6>
                                        <p class="small text-muted mb-0">Yukarıdaki XML senkronizasyon alanını kullanarak ürünlerinizi yönetebilirsiniz.</p>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Butonların çalışmasını sağlayan ufak JavaScript kod parçacığı -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const content = document.getElementById('urunlerTablosuContent');
        const btnDaralt = document.getElementById('btnDaralt');
        const btnGenişlet = document.getElementById('btnGenişlet');

        btnGenişlet.addEventListener('click', function () {
            content.style.display = 'block';
            btnGenişlet.style.display = 'none';
            btnDaralt.style.display = 'inline-block';
        });

        btnDaralt.addEventListener('click', function () {
            content.style.display = 'none';
            btnDaralt.style.display = 'none';
            btnGenişlet.style.display = 'inline-block';
        });
    });
</script>

</div>

<!-- ÖZEL STİLLER -->
<style>
    .border-dashed {
        border-style: dashed !important;
    }
    .style-dropzone {
        border: 2px dashed #cbd5e1;
        transition: all 0.2s ease-in-out;
    }
    .style-dropzone:hover {
        border-color: #0d6efd;
        background-color: #f1f5f9 !important;
    }
    .style-switch {
        width: 2.75em !important;
        height: 1.4em !important;
        cursor: pointer;
    }
    .transition-all {
        transition: transform 0.2s ease, shadow 0.2s ease;
    }
    .transition-all:hover {
        transform: translateY(-2px);
    }
</style>

<!-- Saf JavaScript Kontrol Scriptleri -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // 1. Aktif/Pasif switch butonlarına tıklandığında formu otomatik kaydetme
        const switches = document.querySelectorAll('input[name="aktif"]');
        switches.forEach(function (sw) {
            sw.addEventListener('change', function () {
                this.closest('form').submit();
            });
        });

        // 2. Daralt ve Genişlet butonları için çakışmasız özel kontrol
        const tabloContent = document.getElementById('urunlerTablosuContent');

        document.getElementById('btnDaralt').addEventListener('click', function () {
            tabloContent.style.display = 'none';
        });

        document.getElementById('btnGenişlet').addEventListener('click', function () {
            tabloContent.style.display = 'block';
        });
    });
</script>
@endsection