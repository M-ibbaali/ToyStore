@extends('layouts.frontend')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<style>
    #contact-map {
        height: 350px;
        width: 100%;
        z-index: 10;
        border-radius: 1.5rem; /* rounded-3xl */
    }
    @media (min-width: 1024px) {
        #contact-map {
            height: 450px;
        }
    }
    .leaflet-popup-content-wrapper {
        border-radius: 1rem;
        padding: 5px;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }
    .leaflet-popup-tip {
        display: none;
    }
</style>
@endpush

@section('title', 'Get In Touch')

@section('content')
<div class="bg-white py-10 lg:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        @if(session('success'))
        <div class="mb-8 p-4 bg-green-100 border border-green-200 text-green-700 rounded-xl font-bold flex items-center gap-3">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start mb-20">
            <!-- Left: Contact Form -->
            <div class="lg:col-span-8">
                <h1 class="text-4xl font-black text-toys-text tracking-tight mb-2 uppercase">Get In Touch</h1>
                <p class="text-gray-500 text-sm font-bold mb-10">submit your inquiry below and we'll be in touch within 48 hours.</p>

                <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[11px] font-black uppercase tracking-wider text-gray-400 mb-2">Name</label>
                            <input type="text" name="name" value="{{ old('name', auth()->user()->name ?? '') }}" required
                                class="w-full px-4 py-4 bg-white border border-gray-200 rounded-lg focus:border-primary focus:ring-1 focus:ring-primary transition outline-none text-sm font-bold placeholder-gray-300" 
                                placeholder="Your Name">
                            @error('name') <p class="mt-1 text-xs text-red-500 font-bold">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-[11px] font-black uppercase tracking-wider text-gray-400 mb-2">Email</label>
                            <input type="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}" required
                                class="w-full px-4 py-4 bg-white border border-gray-200 rounded-lg focus:border-primary focus:ring-1 focus:ring-primary transition outline-none text-sm font-bold placeholder-gray-300"
                                placeholder="Your Email">
                            @error('email') <p class="mt-1 text-xs text-red-500 font-bold">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[11px] font-black uppercase tracking-wider text-gray-400 mb-2">Phone No</label>
                            <input type="text" name="phone" value="{{ old('phone', auth()->user()->phone ?? '') }}"
                                class="w-full px-4 py-4 bg-white border border-gray-200 rounded-lg focus:border-primary focus:ring-1 focus:ring-primary transition outline-none text-sm font-bold placeholder-gray-300"
                                placeholder="Your Phone Number">
                            @error('phone') <p class="mt-1 text-xs text-red-500 font-bold">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-[11px] font-black uppercase tracking-wider text-gray-400 mb-2">Subject</label>
                            <select name="subject" required
                                class="w-full px-4 py-4 bg-white border border-gray-200 rounded-lg focus:border-primary focus:ring-1 focus:ring-primary transition outline-none text-sm font-bold appearance-none cursor-pointer"
                                style="background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2224%22%20height%3D%2224%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%22currentColor%22%20stroke-width%3D%222%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%20class%3D%22feather%20feather-chevron-down%22%3E%3Cpolyline%20points%3D%226%209%2012%2015%2018%209%22%3E%3C%2Fpolyline%3E%3C%2Fsvg%3E'); background-repeat: no-repeat; background-position: right 1rem center; background-size: 1.25em;">
                                <option value="" disabled {{ old('subject') ? '' : 'selected' }}>Select a Subject</option>
                                <option value="General Inquiry" {{ old('subject') == 'General Inquiry' ? 'selected' : '' }}>General Inquiry</option>
                                <option value="Product Question" {{ old('subject') == 'Product Question' ? 'selected' : '' }}>Product Question</option>
                                <option value="Shipping Issue" {{ old('subject') == 'Shipping Issue' ? 'selected' : '' }}>Shipping Issue</option>
                                <option value="Other" {{ old('subject') == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('subject') <p class="mt-1 text-xs text-red-500 font-bold">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-[11px] font-black uppercase tracking-wider text-gray-400 mb-2">Message</label>
                        <textarea name="message" rows="6" required
                            class="w-full px-4 py-4 bg-white border border-gray-200 rounded-lg focus:border-primary focus:ring-1 focus:ring-primary transition outline-none text-sm font-bold placeholder-gray-300"
                            placeholder="Write your message here...">{{ old('message') }}</textarea>
                        @error('message') <p class="mt-1 text-xs text-red-500 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit" class="bg-secondary text-white px-10 py-4 rounded-full text-xs font-black uppercase tracking-widest hover:bg-toys-text transition-all transform hover:-translate-y-1 shadow-lg shadow-secondary/20 active:scale-95">
                        Submit Now
                    </button>
                </form>
            </div>

            <!-- Right: Contact Information -->
            <div class="lg:col-span-4 lg:sticky lg:top-28">
                <div class="bg-secondary p-10 rounded-none text-white">
                    <h2 class="text-xl font-black mb-8 border-b border-white/20 pb-4">Contact Information</h2>
                    
                    <div class="space-y-8">
                        <div class="flex gap-4">
                            <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center flex-shrink-0 text-secondary">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold leading-relaxed">Avenue Mohamed VI, Marrakech Store,<br>Morocco</p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center flex-shrink-0 text-secondary">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1c-8.284 0-15-6.716-15-15V5z"/></svg>
                            </div>
                            <div>
                                <p class="text-xs font-black tracking-wide">+92 (8800) 48720</p>
                                <p class="text-[10px] font-bold text-white/70">Mon - Sat: 8 am - 5 pm</p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center flex-shrink-0 text-secondary">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <div>
                                <p class="text-xs font-black tracking-wide">needhelp@company.com</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-12 pt-8 border-t border-white/20">
                        <h3 class="text-sm font-black uppercase tracking-widest mb-6">Follow Us</h3>
                        <div class="flex gap-4">
                            <a href="#" class="w-10 h-10 border-2 border-white rounded-full flex items-center justify-center hover:bg-white hover:text-secondary transition-all">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>
                            </a>
                            <a href="#" class="w-10 h-10 border-2 border-white rounded-full flex items-center justify-center hover:bg-white hover:text-secondary transition-all">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"/></svg>
                            </a>
                            <a href="#" class="w-10 h-10 border-2 border-white rounded-full flex items-center justify-center hover:bg-white hover:text-secondary transition-all">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Functional Map Section -->
        <div class="mb-24 rounded-3xl overflow-hidden shadow-2xl shadow-gray-200 border border-gray-100">
            <div id="contact-map"></div>
        </div>

        <!-- FAQs Section -->
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-black text-toys-text inline-block border-b-4 border-secondary pb-2 uppercase tracking-tight">FAQS</h2>
                <p class="text-gray-500 font-bold mt-4">Have a quick question? Check our FAQs for a quick answer</p>
            </div>

            <div class="space-y-4" id="faq-accordion">
                <!-- FAQ 1 -->
                <div class="border-b border-gray-100 group">
                    <button class="w-full py-6 flex items-center justify-between text-left focus:outline-none faq-btn" data-target="faq-1">
                        <span class="text-base font-black text-secondary group-hover:text-primary transition-colors">How do I start understanding fashion?</span>
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-primary transition-transform faq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div id="faq-1" class="hidden pb-6 text-sm text-gray-500 font-bold leading-relaxed">
                        Just about three quarters of Gen Z and Millennials say they usually shop at mass merchant retailers, coming in first above online, specialty, and discount retailers, as well as department stores and sporting goods.
                    </div>
                </div>

                <!-- FAQ 2 -->
                <div class="border-b border-gray-100 group">
                    <button class="w-full py-6 flex items-center justify-between text-left focus:outline-none faq-btn" data-target="faq-2">
                        <span class="text-base font-black text-toys-text group-hover:text-primary transition-colors">What is your fashion advice?</span>
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-primary transition-transform faq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"/></svg>
                    </button>
                    <div id="faq-2" class="hidden pb-6 text-sm text-gray-500 font-bold leading-relaxed">
                        Our best advice is to focus on quality over quantity. Choose timeless pieces that can be easily mixed and matched, and don't be afraid to express your personality through accessories.
                    </div>
                </div>

                <!-- FAQ 3 -->
                <div class="border-b border-gray-100 group">
                    <button class="w-full py-6 flex items-center justify-between text-left focus:outline-none faq-btn" data-target="faq-3">
                        <span class="text-base font-black text-toys-text group-hover:text-primary transition-colors">What are some questions about fashion?</span>
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-primary transition-transform faq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"/></svg>
                    </button>
                    <div id="faq-3" class="hidden pb-6 text-sm text-gray-500 font-bold leading-relaxed">
                        Common questions include: How to build a capsule wardrobe? What colors suit my skin tone? How to dress for specific body types? and How to stay trendy while being sustainable?
                    </div>
                </div>

                <!-- FAQ 4 -->
                <div class="border-b border-gray-100 group">
                    <button class="w-full py-6 flex items-center justify-between text-left focus:outline-none faq-btn" data-target="faq-4">
                        <span class="text-base font-black text-toys-text group-hover:text-primary transition-colors">Is fashion important in life?</span>
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-primary transition-transform faq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"/></svg>
                    </button>
                    <div id="faq-4" class="hidden pb-6 text-sm text-gray-500 font-bold leading-relaxed">
                        Fashion is more than just clothing; it's a form of self-expression and identification. It can boost confidence and help you present your best self to the world.
                    </div>
                </div>

                <!-- FAQ 5 -->
                <div class="border-b border-gray-100 group">
                    <button class="w-full py-6 flex items-center justify-between text-left focus:outline-none faq-btn" data-target="faq-5">
                        <span class="text-base font-black text-toys-text group-hover:text-primary transition-colors">What influences fashion trends?</span>
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-primary transition-transform faq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"/></svg>
                    </button>
                    <div id="faq-5" class="hidden pb-6 text-sm text-gray-500 font-bold leading-relaxed">
                        Trends are influenced by many factors including culture, movies, music, social media, historical events, and the work of innovative designers.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Map
        // Coordinates for Marrakech location
        const lat = 31.6460889;
        const lng = -8.0035767;
        
        const map = L.map('contact-map', {
            scrollWheelZoom: false // Disable zoom on scroll to prevent accidental zooming while scrolling page
        }).setView([lat, lng], 18); // Zoom level 18 as per provided 133m view

        // Add OpenStreetMap Tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Custom Marker Style (Optional - using default for now but could use a beautiful SVG)
        const marker = L.marker([lat, lng]).addTo(map);
        
        // Popup Content
        const popupContent = `
            <div class="p-2">
                <h3 class="font-black text-toys-text uppercase text-sm mb-1">Marrakech Store</h3>
                <p class="text-xs text-gray-500 font-bold">Avenue Mohamed VI, Marrakech,<br>Morocco</p>
                <div class="mt-2 text-secondary text-[10px] font-black uppercase tracking-widest">Open Now</div>
            </div>
        `;
        
        marker.bindPopup(popupContent).openPopup();

        // Enable zoom on click
        map.on('click', function() {
            if (!map.scrollWheelZoom.enabled()) {
                map.scrollWheelZoom.enable();
            }
        });

        // Defensive: Invalidate size after a delay to ensure correct rendering in complex layouts
        setTimeout(() => {
            map.invalidateSize();
        }, 500);
    });

    // Existing FAQ logic
    document.querySelectorAll('.faq-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const targetId = btn.getAttribute('data-target');
            const target = document.getElementById(targetId);
            const icon = btn.querySelector('.faq-icon');
            
            // Toggle visibility
            target.classList.toggle('hidden');
            
            // Rotate icon or toggle state if needed
            if (!target.classList.contains('hidden')) {
                icon.style.transform = 'rotate(180deg)';
                // Change color of text to secondary when open?
                btn.querySelector('span').classList.remove('text-toys-text');
                btn.querySelector('span').classList.add('text-secondary');
            } else {
                icon.style.transform = 'rotate(0deg)';
                btn.querySelector('span').classList.remove('text-secondary');
                btn.querySelector('span').classList.add('text-toys-text');
            }
        });
    });

    // Open first FAQ by default to match image
    document.querySelector('.faq-btn').click();
</script>
@endpush
@endsection
