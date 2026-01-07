<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-6 py-3 bg-primary border border-transparent rounded-2xl font-black text-xs text-white uppercase tracking-widest hover:bg-secondary focus:outline-none focus:ring-4 focus:ring-secondary/20 active:scale-95 transition-all duration-300 shadow-lg shadow-primary/20']) }}>
    {{ $slot }}
</button>
