<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-6 py-3 bg-white border-2 border-gray-100 rounded-2xl font-black text-xs text-secondary uppercase tracking-widest shadow-sm hover:border-secondary hover:bg-secondary hover:text-white focus:outline-none focus:ring-4 focus:ring-secondary/10 disabled:opacity-25 transition-all duration-300 active:scale-95']) }}>
    {{ $slot }}
</button>
