<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-6 py-3 bg-red-500 border border-transparent rounded-2xl font-black text-xs text-white uppercase tracking-widest hover:bg-red-600 active:scale-95 focus:outline-none focus:ring-4 focus:ring-red-500/20 transition-all duration-300 shadow-lg shadow-red-500/20']) }}>

{{ $slot }}
</button>
