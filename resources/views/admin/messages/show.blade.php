@extends('layouts.admin')

@section('title', 'View Message')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <a href="{{ route('admin.messages.index') }}" class="flex items-center text-gray-500 hover:text-gray-900 font-medium transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Back to Messages
        </a>
        
        <form action="{{ route('admin.messages.destroy', $message->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this message?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-white text-red-600 hover:bg-red-50 border border-red-200 px-4 py-2 rounded-lg font-bold text-sm transition-colors flex items-center shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                Delete Message
            </button>
        </form>
    </div>

    <!-- Message Content Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <!-- Message Header -->
        <div class="p-8 border-b border-gray-100 bg-gray-50/50">
            <div class="flex flex-col md:flex-row justify-between md:items-start gap-6">
                <div class="flex gap-4">
                    <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-black text-lg uppercase shadow-inner">
                        {{ substr($message->name, 0, 2) }}
                    </div>
                    <div>
                        <h2 class="text-xl font-black text-gray-900">{{ $message->subject ?? 'No Subject' }}</h2>
                        <div class="flex items-center gap-2 mt-2">
                            <span class="font-bold text-gray-700 text-sm">{{ $message->name }}</span>
                            <span class="text-blue-500 text-xs font-medium bg-blue-50 px-2 py-0.5 rounded-full border border-blue-100">&lt;{{ $message->email }}&gt;</span>
                        </div>
                        @if($message->phone)
                        <div class="text-xs text-gray-500 font-medium mt-1">
                            Phone: <span class="text-gray-700">{{ $message->phone }}</span>
                        </div>
                        @endif
                    </div>
                </div>
                
                <div class="text-right">
                    <div class="text-sm font-bold text-gray-900">{{ $message->created_at->format('M d, Y') }}</div>
                    <div class="text-xs text-gray-500 font-medium mt-1">{{ $message->created_at->format('h:i A') }}</div>
                    <div class="text-[10px] text-gray-400 mt-1 uppercase tracking-wider font-bold">{{ $message->created_at->diffForHumans() }}</div>
                </div>
            </div>
        </div>

        <!-- Message Body -->
        <div class="p-8">
            <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-4">Message Content</label>
            <div class="prose prose-sm max-w-none text-gray-700 leading-relaxed whitespace-pre-line">
                {{ $message->message }}
            </div>
        </div>
        
        <!-- Reply Section (Placeholder for future) -->
        <div class="p-8 bg-gray-50 border-t border-gray-100">
             <div class="flex gap-3">
                 <a href="mailto:{{ $message->email }}?subject=Re: {{ $message->subject }}" class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 text-white font-bold rounded-xl text-sm hover:bg-blue-700 transition-all shadow-lg shadow-blue-500/30">
                     <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                     Reply via Email
                 </a>
             </div>
        </div>
    </div>
</div>
@endsection
