@extends('layouts.admin')

@section('title', 'Sinem - Mesajlar Paneli')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex justify-between items-center mb-8 pb-4 border-b border-slate-200">
        <div>
            <h1 class="text-2xl font-black text-gray-900">Gelen Müşteri Mesajları</h1>
            <p class="text-xs text-gray-500 mt-1">İletişim formundan kullanıcıların gönderdiği tüm mesajlar burada listelenir.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/30 text-emerald-600 text-sm rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-[600px]">
            <thead>
                <tr class="border-b border-slate-200 text-xs text-slate-400 uppercase tracking-wider bg-slate-50">
                    <th class="p-4">Gönderen</th>
                    <th class="p-4">E-Posta</th>
                    <th class="p-4">Konu</th>
                    <th class="p-4">Mesaj</th>
                    <th class="p-4">Tarih</th>
                    <th class="p-4 text-right">İşlemler</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm">
                @forelse($messages as $msg)
                    {{-- Yeni gelen veya okunmuş olmasına göre satır arka planı değişir --}}
                    <tr class="transition {{ isset($msg->is_read) && !$msg->is_read ? 'bg-orange-50/60 hover:bg-orange-50' : 'hover:bg-slate-50' }}">
                        <td class="p-4 font-bold text-gray-900 flex items-center gap-2 whitespace-nowrap">
                            {{ $msg->name }}
                            @if(isset($msg->is_read) && !$msg->is_read)
                                <span class="bg-brandOrange text-white text-[9px] font-black px-2 py-0.5 rounded uppercase tracking-wider">Yeni</span>
                            @endif
                        </td>
                        <td class="p-4 text-gray-600 whitespace-nowrap">{{ $msg->email }}</td>
                        <td class="p-4 text-gray-700 font-semibold whitespace-nowrap">{{ $msg->subject ?? 'Konu Belirtilmemiş' }}</td>
                        <td class="p-4 text-gray-600 max-w-xs truncate">{{ $msg->message }}</td>
                        <td class="p-4 text-gray-400 text-xs whitespace-nowrap">{{ $msg->created_at->format('d.m.Y H:i') }}</td>
                        <td class="p-4 text-right flex items-center justify-end gap-2 whitespace-nowrap">
                            
                            <a href="mailto:{{ $msg->email }}?subject=Yanıt: {{ urlencode($msg->subject ?? 'Sinem Destek') }}" 
                               class="text-xs bg-slate-900 hover:bg-brandOrange text-white px-3 py-1.5 rounded-lg font-bold transition">
                                Yanıtla
                            </a>

                           
                            <form action="{{ route('admin.messages.destroy', $msg->id) }}" method="POST" onsubmit="return confirm('Bu mesajı silmek istediğinize emin misiniz?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs bg-red-50 hover:bg-red-600 text-red-600 hover:text-white px-3 py-1.5 rounded-lg font-bold transition">Sil</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-gray-400 text-sm">Henüz gelen bir mesaj bulunmuyor.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection