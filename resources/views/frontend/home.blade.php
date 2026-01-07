@extends('layouts.frontend')

@section('title', 'ToyStore - Fun for Everyone!')

@section('content')
<!-- Hero Banner -->
<div class="relative w-full h-[60vh] sm:h-[70vh] md:h-[80vh] lg:h-screen min-h-[500px] lg:min-h-[800px] overflow-hidden shadow-lg group">
    <img src="{{ asset('images/hero.png') }}" alt="ToyStore Hero" class="w-full h-full object-cover">
    
    <!-- Overlay Content -->
    <div class="absolute inset-0 bg-black/10 flex flex-col items-center justify-center text-center text-toys-text px-4 sm:px-6 lg:px-8">
        <div class="bg-white/90 backdrop-blur-sm p-8 rounded-3xl shadow-xl animate-fade-in-up border-4 border-primary transform hover:scale-105 transition duration-500">
            <p class="text-lg sm:text-xl md:text-2xl font-bold tracking-wide mb-2 text-secondary font-sans animate-bounce">Welcome to ToyStore</p>
            <h1 class="text-4xl sm:text-5xl md:text-7xl font-black mb-4 sm:mb-6 leading-tight text-toys-text drop-shadow-md font-sans">
                Fun For <br class="hidden sm:block"> <span class="text-primary">Everyone!</span>
            </h1>
            <a href="{{ route('shop.index') }}" class="group inline-flex items-center gap-3 text-sm sm:text-base font-bold uppercase tracking-widest bg-secondary text-white px-8 py-3 rounded-full hover:bg-primary hover:text-white transition shadow-lg">
                Start Playing
                <svg class="w-5 h-5 transform group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>
    </div>
</div>

<div class="bg-toy-bg min-h-screen">
    <!-- Main Container -->
    <div class="max-w-7xl mx-auto px-2 sm:px-4 lg:px-8 py-6">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 relative">

    <!-- ================= LEFT SIDEBAR ================= -->
    <aside class="hidden lg:block lg:col-span-3">
        <div class="sticky top-24 space-y-6 h-fit">

            <!-- Banner 1 -->
            <div class="relative rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition duration-300 group border-2 border-white hover:border-primary">
                <img src="{{ asset('images/lego.png') }}" class="w-full object-cover group-hover:scale-105 transition duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent p-6 flex flex-col justify-end">
                    <p class="text-yellow-300 text-xs font-bold uppercase mb-1">Build Your World</p>
                    <h3 class="text-white text-2xl font-black mb-4">New Lego Sets</h3>
                    <a href="{{ route('shop.index') }}" class="bg-primary text-white text-xs font-bold px-5 py-2 rounded-full w-fit hover:bg-white hover:text-primary transition">
                        Explore
                    </a>
                </div>
            </div>

            <!-- Banner 2 -->
            <div class="relative rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition duration-300 group border-2 border-white hover:border-secondary">
                <img src="{{ asset('images/plush.png') }}" class="w-full object-cover group-hover:scale-105 transition duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent p-6 flex flex-col justify-end">
                    <p class="text-pink-300 text-xs font-bold uppercase mb-1">Soft & Cuddly</p>
                    <h3 class="text-white text-2xl font-black mb-4">Plush Friends</h3>
                    <a href="{{ route('shop.index') }}" class="bg-secondary text-white text-xs font-bold px-5 py-2 rounded-full w-fit hover:bg-white hover:text-secondary transition">
                        Shop Now
                    </a>
                </div>
            </div>

            <!-- Banner 3 -->
            <div class="relative rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition duration-300 group border-2 border-white hover:border-primary">
                <img src="{{ asset('images/games.png') }}" class="w-full object-cover group-hover:scale-105 transition duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent p-6 flex flex-col justify-end">
                    <p class="text-green-300 text-xs font-bold uppercase mb-1">Family Fun</p>
                    <h3 class="text-white text-2xl font-black mb-4">Game Night</h3>
                    <a href="{{ route('shop.index') }}" class="bg-white text-black text-xs font-bold px-5 py-2 rounded-full w-fit hover:bg-primary hover:text-white transition">
                        Play
                    </a>
                </div>
            </div>

        </div>
    </aside>

    <!-- ================= MAIN CONTENT ================= -->
    <main class="col-span-1 lg:col-span-9 space-y-16">

        @foreach($categories as $category)
            @if($category->products->count() > 0)

            <section>
                <!-- Header -->
                <div class="flex justify-between items-end mb-6 border-b-2 border-primary/20 pb-2">
                    <h2 class="text-3xl font-black">{{ $category->name }}</h2>

                    <a href="{{ route('shop.index', ['category' => $category->id]) }}"
                       class="text-sm font-bold text-secondary bg-white px-3 py-1 rounded-full shadow-sm hover:text-primary transition">
                        View All →
                    </a>
                </div>

                <!-- Products : 3 only -->
                <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                    @foreach($category->products->take(3) as $product)
                        <div class="bg-white rounded-3xl shadow-sm hover:shadow-xl transition group overflow-hidden flex flex-col">

                            <!-- Image -->
                            <div class="relative aspect-[4/5] bg-gray-50 overflow-hidden">
                                <a href="{{ route('product.show', $product->slug) }}">
                                    <img src="{{ $product->image_url }}"
                                         class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                                </a>

                                <!-- Discount Badge -->
                                @if($product->original_price > $product->price)
                                    <span class="absolute top-2 left-2 bg-red-500 text-white text-[10px] font-black px-2 py-1 rounded-lg z-10 uppercase tracking-widest">
                                        -{{ round((($product->original_price - $product->price) / $product->original_price) * 100) }}%
                                    </span>
                                @endif

                                <!-- Favorite Button -->
                                <button type="button" onclick="toggleFavorite({{ $product->id }})" 
                                        class="absolute top-2 right-2 p-2 rounded-full bg-white/90 backdrop-blur-sm shadow-md transition-all hover:scale-110 z-20 group/fav"
                                        title="Add to Favorites">
                                    <svg class="fav-icon-{{ $product->id }} w-5 h-5 transition-all duration-300 {{ auth()->check() && auth()->user()->favorites->contains($product->id) ? 'text-red-500' : 'text-gray-400' }}" 
                                         fill="{{ auth()->check() && auth()->user()->favorites->contains($product->id) ? 'currentColor' : 'none' }}" 
                                         stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                </button>
                            </div>

                            <!-- Details -->
                            <div class="p-4 flex flex-col flex-grow">
                                <span class="text-xs font-bold uppercase text-secondary mb-1">
                                    {{ $category->name }}
                                </span>

                                <h3 class="font-bold text-sm mb-2 line-clamp-2 hover:text-primary transition">
                                    <a href="{{ route('product.show', $product->slug) }}">
                                        {{ $product->name }}
                                    </a>
                                </h3>

                                <div class="mt-auto flex justify-between items-center">
                                    <div>
                                        @if($product->original_price > $product->price)
                                            <span class="text-xs line-through text-gray-400 font-bold">
                                                {{ formatPrice($product->original_price) }}
                                            </span>
                                        @endif
                                        <div class="text-lg font-black text-primary">
                                            {{ formatPrice($product->price) }}
                                        </div>
                                    </div>

                                    <button onclick="addToCart({{ $product->id }})"
                                            class="border-2 border-primary text-primary px-3 py-1 rounded-full text-xs font-bold hover:bg-primary hover:text-white transition">
                                        Add
                                    </button>
                                </div>
                            </div>

                        </div>
                    @endforeach

                </div>
            </section>

            @endif
        @endforeach

    </main>
</div>


        <!-- Promotional Banners Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 my-12">
            <!-- Banner 1: Science -->
            <div class="relative h-[300px] md:h-[350px] rounded-3xl overflow-hidden group shadow-lg hover:shadow-2xl transition duration-300 border-4 border-white">
                <img src="{{ asset('images/science.png') }}" alt="Science Kits" class="w-full h-full object-cover transition duration-700 group-hover:scale-105">
                <div class="absolute inset-0 bg-black/20 flex flex-col justify-center px-8 md:px-12">
                    <span class="text-xs font-black tracking-widest text-white uppercase mb-2 bg-primary px-2 py-1 w-fit rounded">Learn & Play</span>
                    <h3 class="text-3xl md:text-4xl font-black text-white mb-4 leading-tight drop-shadow-lg">Spark <br> Curiosity</h3>
                    <div>
                        <a href="{{ route('shop.index') }}" class="inline-block px-6 py-2.5 bg-white border-2 border-white text-primary text-sm font-bold rounded-full hover:bg-primary hover:text-white transition duration-300 shadow-md">
                            Discover Science
                        </a>
                    </div>
                </div>
            </div>

            <!-- Banner 2: Sale -->
            <div class="relative h-[300px] md:h-[350px] rounded-3xl overflow-hidden group shadow-lg hover:shadow-2xl transition duration-300 border-4 border-white">
                <img src="{{ asset('images/games.png') }}" alt="Big Sale" class="w-full h-full object-cover transition duration-700 group-hover:scale-105 filter brightness-75">
                <div class="absolute inset-0 flex flex-col justify-center px-8 md:px-12">
                    <h3 class="text-4xl md:text-5xl font-black text-yellow-300 mb-2 drop-shadow-lg stroke-black">25% OFF <br> ALL GAMES</h3>
                    <p class="text-white font-bold mb-6 text-lg drop-shadow-md">Board games, cards, and puzzles for the whole family.</p>
                    <div>
                        <a href="{{ route('shop.index') }}" class="inline-block px-6 py-2.5 bg-secondary border-2 border-secondary text-white text-sm font-bold rounded-full hover:bg-white hover:text-secondary transition duration-300 shadow-md">
                            Shop Sale
                        </a>
                    </div>
                </div>
            </div>
        </div>

       
    </div>
</div>

<!-- Quick View Modal Overlay -->
<div id="quickViewModal" class="fixed inset-0 z-[60] hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeQuickView()"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <!-- Modal Panel -->
        <div class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full relative border-4 border-primary">
            <button onclick="closeQuickView()" class="absolute top-4 right-4 text-gray-400 hover:text-primary z-10">
                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start gap-8" id="quickViewContent">
                    <!-- Loading State -->
                    <div class="w-full flex justify-center py-20">
                        <svg class="animate-spin h-10 w-10 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Why Choose ToyStore Section --}}
@include('components.why-choose-section')

@endsection

@push('scripts')
<script>
// Quick View Logic
function openQuickView(productId) {
    const modal = document.getElementById('quickViewModal');
    const content = document.getElementById('quickViewContent');
    
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden'; // Prevent scrolling
    
    // Show Loading
    content.innerHTML = `
        <div class="w-full flex justify-center py-20">
            <svg class="animate-spin h-10 w-10 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>
    `;

    const product = productsData.find(p => p.id === productId);
    
    if(product) {
        populateQuickView(product);
    } else {
        content.innerHTML = '<p class="text-center text-red-500 py-10">Product not found.</p>';
    }
}

function closeQuickView() {
    const modal = document.getElementById('quickViewModal');
    modal.classList.add('hidden');
    document.body.style.overflow = '';
}

function populateQuickView(product) {
    const content = document.getElementById('quickViewContent');
    
    let mainImage = null;
    if(product.images && product.images.length > 0) {
        let firstImg = product.images[0].image;
        mainImage = firstImg.startsWith('http') ? firstImg : '/storage/' + firstImg;
    }
    
    content.innerHTML = `
        <div class="w-full md:w-1/2 mb-6 md:mb-0">
             <div class="aspect-square bg-gray-50 rounded-lg overflow-hidden relative border-2 border-dashed border-gray-200">
                 ${mainImage ? `<img src="${mainImage}" class="w-full h-full object-cover">` : `<div class="w-full h-full flex items-center justify-center text-gray-300"><svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>`}
             </div>
        </div>
        <div class="w-full md:w-1/2 md:pl-8 flex flex-col">
            <h2 class="text-3xl font-black text-toys-text mb-2">${product.name}</h2>
            <div class="mb-4">
                <span class="text-3xl font-black text-primary">DH${parseFloat(product.price).toFixed(2)}</span>
                ${(product.original_price && product.original_price > product.price) ? `<span class="ml-2 text-lg text-gray-400 line-through font-bold">DH${parseFloat(product.original_price).toFixed(2)}</span>` : ''}
            </div>
            <p class="text-gray-600 mb-6 text-base leading-relaxed font-medium">${product.description || 'No description available.'}</p>
            
            <div class="mt-auto">
                <form action="/cart/add" method="POST">
                    <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').content}">
                    <input type="hidden" name="product_id" value="${product.id}">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="flex items-center border-2 border-gray-200 rounded-full overflow-hidden">
                            <button type="button" onclick="this.nextElementSibling.stepDown()" class="px-4 py-2 text-gray-600 hover:bg-gray-100 font-bold">-</button>
                            <input type="number" name="quantity" value="1" min="1" max="${product.stock}" class="w-12 text-center border-none focus:ring-0 font-bold">
                            <button type="button" onclick="this.previousElementSibling.stepUp()" class="px-4 py-2 text-gray-600 hover:bg-gray-100 font-bold">+</button>
                        </div>
                        <span class="text-sm text-gray-500 font-bold">${product.stock > 0 ? `${product.stock} in stock` : 'Out of stock'}</span>
                    </div>
                    <button type="submit" 
                            class="w-full bg-primary text-white py-4 px-6 rounded-full hover:bg-secondary transition disabled:opacity-50 disabled:cursor-not-allowed font-black text-lg shadow-lg hover:shadow-xl transform hover:-translate-y-1"
                            ${product.stock == 0 ? 'disabled' : ''}>
                        ${product.stock > 0 ? 'ADD TO CART' : 'OUT OF STOCK'}
                    </button>
                </form>
            </div>
        </div>
    `;
}

// Pass PHP data to JS
const productsData = @json($featuredProducts);
</script>
@endpush
