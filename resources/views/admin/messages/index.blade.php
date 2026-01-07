@extends('layouts.admin')

@section('title', 'Contact Messages')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-black text-gray-900 tracking-tight">Contact Messages</h1>
            <p class="text-sm font-medium text-gray-500 mt-1">Manage and read inquiries from customers.</p>
        </div>
    </div>

    <!-- Messages Table Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100 text-xs uppercase tracking-wider text-gray-500 font-bold">
                        <th class="p-6">Sender</th>
                        <th class="p-6">Subject</th>
                        <th class="p-6">Message Preview</th>
                        <th class="p-6">Date</th>
                        <th class="p-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($messages as $message)
                    <tr class="hover:bg-gray-50 transition-colors group">
                        <td class="p-6 font-medium text-gray-900">
                            <div>{{ $message->name }}</div>
                            <div class="text-xs text-gray-400 font-normal mt-1">{{ $message->email }}</div>
                        </td>
                        <td class="p-6">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $message->subject ?? 'No Subject' }}
                            </span>
                        </td>
                        <td class="p-6 text-gray-500 max-w-xs truncate">
                            {{ Str::limit($message->message, 50) }}
                        </td>
                        <td class="p-6 text-gray-500 font-medium">
                            {{ $message->created_at->format('M d, Y') }}
                            <div class="text-xs text-gray-400 mt-0.5">{{ $message->created_at->format('h:i A') }}</div>
                        </td>
                        <td class="p-6 text-right font-medium">
                            <div class="flex items-center justify-end gap-3 opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('admin.messages.show', $message->id) }}" 
                                   class="text-blue-600 hover:text-blue-900 hover:bg-blue-50 p-2 rounded-lg transition-colors"
                                   title="View Message">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                                
                                <form action="{{ route('admin.messages.destroy', $message->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this message?');" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 hover:bg-red-50 p-2 rounded-lg transition-colors" title="Delete Message">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-12 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-500">
                                <svg class="w-12 h-12 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                <p class="text-base font-medium">No messages found.</p>
                                <p class="text-xs mt-1">New contact form submissions will appear here.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($messages->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
            {{ $messages->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
