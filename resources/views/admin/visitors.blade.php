@extends('layouts.admin')

@section('title', 'Alveral - Ziyaretçi ve Tarayıcı Logları')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-black text-gray-900">Ziyaretçi ve Tarayıcı Logları</h1>
            <p class="text-xs text-slate-500 mt-1">Sitenize giriş yapan tüm kullanıcıların tarayıcı ve IP hareketleri.</p>
        </div>
    </div>
    <div>
        <form action="{{ route('admin.visitors.clear') }}" method="POST" onsubmit="return confirm('Tüm ziyaretçi loglarını silmek istediğinize emin misiniz? Bu işlem geri alınamaz!');">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-rose-50 text-rose-600 hover:bg-rose-100 text-xs font-bold px-4 py-2.5 rounded-xl transition shadow-sm">
                Tüm Logları Temizle
            </button>
        </form>
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[700px]">
                <thead>
                    <tr class="border-b border-slate-200 text-xs text-slate-400 uppercase tracking-wider bg-slate-50">
                        <th class="p-4">IP Adresi</th>
                        <th class="p-4">Cihaz</th>
                        <th class="p-4">Tarayıcı</th>
                        <th class="p-4">Sayfa Gezme</th>
                        <th class="p-4">Son Görülme</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($visitors as $visitor)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="p-4 font-bold text-gray-900 font-mono text-xs">{{ $visitor->ip_address }}</td>
                            <td class="p-4 text-gray-600">
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $visitor->device == 'Mobil' ? 'bg-purple-50 text-purple-600' : 'bg-blue-50 text-blue-600' }}">
                                    {{ $visitor->device }}
                                </span>
                            </td>
                            <td class="p-4 text-gray-700 font-medium text-xs">{{ $visitor->browser }}</td>
                            <td class="p-4 text-gray-500 font-semibold">{{ $visitor->visit_count }} İstek</td>
                            <td class="p-4 text-gray-400 text-xs">{{ $visitor->last_seen_at->diffForHumans() }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-6 text-center text-slate-400 text-sm">Henüz kayıtlı ziyaretçi bulunmuyor.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-4 border-t border-slate-100 bg-slate-50">
            {{ $visitors->links() }}
        </div>
    </div>
</div>
@endsection