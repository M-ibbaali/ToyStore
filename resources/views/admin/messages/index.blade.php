@extends('layouts.admin')

@section('title', 'Contact Messages')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-10">
    <div>
        <h1 class="text-3xl font-black text-gray-900 tracking-tight">Messages</h1>
        <p class="text-xs text-gray-400 font-bold mt-2 uppercase tracking-widest opacity-70">Customer Inquiries</p>
    </div>
</div>

@if(session('success'))
    <div class="bg-green-50 border border-green-100 text-green-700 px-6 py-4 rounded-2xl mb-8 flex items-center gap-3">
        <div class="w-8 h-8 bg-green-500 text-white rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg shadow-green-500/20">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
        </div>
        <p class="text-sm font-bold">{{ session('success') }}</p>
    </div>
@endif

<div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto custom-scrollbar">
        <table class="min-w-full divide-y divide-gray-50">
            <thead class="bg-gray-50/50">
                <tr>
                    <th class="px-8 py-5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Sender</th>
                    <th class="px-8 py-5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest hidden md:table-cell">Subject</th>
                    <th class="px-8 py-5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Preview</th>
                    <th class="px-8 py-5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Date</th>
                    <th class="px-8 py-5 text-right text-[10px] font-black text-gray-400 uppercase tracking-widest">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($messages as $message)
                <tr class="hover:bg-gray-50/50 transition-colors group relative {{ $message->read_at ? '' : 'bg-blue-50/20' }}">
                    <td class="px-8 py-5 whitespace-nowrap">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-gray-100 text-gray-400 flex items-center justify-center text-xs font-black uppercase">
                                {{ substr($message->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-sm font-black text-gray-900 flex items-center gap-2">
                                    {{ $message->name }}
                                    @if(!$message->read_at)
                                        <span class="w-1.5 h-1.5 bg-blue-600 rounded-full"></span>
                                    @endif
                                </p>
                                <p class="text-[10px] text-gray-400 font-bold mt-0.5 truncate max-w-[150px]">{{ $message->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap hidden md:table-cell">
                        <span class="text-[10px] font-black {{ $message->subject ? 'text-gray-900 bg-gray-50' : 'text-gray-300' }} px-3 py-1 rounded-lg uppercase tracking-widest">{{ $message->subject ?? 'No Subject' }}</span>
                    </td>
                    <td class="px-8 py-5">
                        <p class="text-[11px] text-gray-500 font-medium leading-relaxed max-w-[200px] sm:max-w-xs truncate">
                            {{ $message->message }}
                        </p>
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap">
                        <p class="text-[11px] font-black text-gray-600 tracking-tight">{{ $message->created_at->format('M d, Y') }}</p>
                        <p class="text-[9px] text-gray-300 font-bold mt-0.5">{{ $message->created_at->format('H:i') }}</p>
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.messages.show', $message->id) }}" class="p-2.5 bg-gray-50 text-gray-400 hover:text-blue-600 hover:bg-blue-50 border border-transparent rounded-xl transition-all active:scale-95 group/btn" title="Read Message">
                                <svg class="w-5 h-5 group-hover/btn:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </a>
                            <form action="{{ route('admin.messages.destroy', $message->id) }}" method="POST" onsubmit="return confirm('Careful! Delete this customer message permanently?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2.5 bg-gray-50 text-gray-400 hover:text-red-600 hover:bg-red-50 border border-transparent rounded-xl transition-all active:scale-95 group/btn" title="Delete Message">
                                    <svg class="w-5 h-5 group-hover/btn:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-8 py-20 text-center">
                        <div class="w-20 h-20 bg-gray-50 rounded-[2rem] flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                        </div>
                        <p class="text-sm font-black text-gray-900">Inbox is empty</p>
                        <p class="text-xs text-gray-400 mt-2 font-medium">Customer inquiries will appear here.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-10">
    {{ $messages->links() }}
</div>
@endsection
