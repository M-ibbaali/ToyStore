@extends('layouts.frontend')

@push('styles')
<style>
    .story-img-secondary {
        transform: translate(10%, 20%);
    }
    @media (min-width: 1024px) {
        .story-img-secondary {
            transform: translate(25%, 40%);
        }
    }
    .value-card {
        transition: all 0.3s ease;
    }
    .value-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px -15px rgba(0,0,0,0.05);
    }
    .team-img-wrapper {
        transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .team-card:hover .team-img-wrapper {
        transform: scale(1.02);
    }
</style>
@endpush

@section('title', 'About Our ToyStore Journey')

@section('content')
<div class="bg-white overflow-hidden">
    <!-- Section 1: Our Story -->
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4 lg:pt-8 pb-16 lg:pb-24">
        <h1 class="text-5xl font-black text-toys-text mb-8 leading-[1.1] text-center">
            Crafting Joy, <br> One Toy at a Time
        </h1>  
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">
            <div class="relative pb-32 lg:pb-0">
                
                <!-- Large Foreground Image -->
                <div class="rounded-none overflow-hidden shadow-2xl z-10 relative">
                    <img src="https://t4.ftcdn.net/jpg/06/46/80/67/360_F_646806797_QdvRzf1tIt9J6wmMR0hZ4KbI08aVq0g3.jpg" alt="ToyStore Showroom" class="w-full h-[550px] object-cover">
                </div>
                <!-- Small Overlapping Image -->
                <div class="absolute bottom-0 right-0 w-2/3 h-[320px] rounded-none overflow-hidden shadow-2xl z-20 story-img-secondary border-[12px] border-white">
                    <img src="https://t4.ftcdn.net/jpg/06/38/36/99/360_F_638369937_0Jz6J9VvtygJG0YLC3MbRiMVIucP0elT.jpg" alt="Handcrafted Details" class="w-full h-full object-cover">
                </div>
            </div>
            
            <div class="lg:pl-10">
                <span class="text-[11px] font-black uppercase tracking-[0.4em] text-primary block mb-6 px-1 border-l-4 border-primary">Our Legacy</span>
                
                <p class="text-gray-500 font-bold mb-8 leading-relaxed max-w-xl">
                    Founded in a small family workshop, ToyStore began with a simple vision: to bring back the magic of tactile, imaginative play. We believe that in a digital world, the warmth of a wooden block or the comfort of a plush friend is more important than ever.
                </p>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-12">
                    <div class="flex items-center gap-4 group">
                        <div class="w-10 h-10 bg-gray-50 rounded-lg flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <span class="text-sm font-black text-toys-text">Safety Certified</span>
                    </div>
                    <div class="flex items-center gap-4 group">
                        <div class="w-10 h-10 bg-gray-50 rounded-lg flex items-center justify-center text-secondary group-hover:bg-secondary group-hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 3v1m0 16v1m9-9h-1M4 9H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        </div>
                        <span class="text-sm font-black text-toys-text">Eco-Friendly Tools</span>
                    </div>
                    <div class="flex items-center gap-4 group">
                        <div class="w-10 h-10 bg-gray-50 rounded-lg flex items-center justify-center text-green-500 group-hover:bg-green-500 group-hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                        </div>
                        <span class="text-sm font-black text-toys-text">Global Imagination</span>
                    </div>
                    <div class="flex items-center gap-4 group">
                        <div class="w-10 h-10 bg-gray-50 rounded-lg flex items-center justify-center text-orange-500 group-hover:bg-orange-500 group-hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <span class="text-sm font-black text-toys-text">Lifetime Stories</span>
                    </div>
                </div>


            </div>
        </div>
    </div>

    <!-- Section 2: Our Philosophy -->
    <div class="bg-gray-50/50 py-32">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-black text-toys-text mb-20 uppercase tracking-tight">Our Core Philosophy</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <!-- Value 1 -->
                <div class="value-card bg-white p-12 border border-gray-100 group">
                    <h3 class="text-xl font-black text-toys-text mb-4 uppercase group-hover:text-primary transition-colors">Quality First</h3>
                    <p class="text-sm text-gray-500 font-bold leading-relaxed">We source only the finest sustainable materials, ensuring every toy can be passed down through generations.</p>
                </div>
                <!-- Value 2 -->
                <div class="value-card bg-white p-12 border border-gray-100 group">
                    <h3 class="text-xl font-black text-toys-text mb-4 uppercase group-hover:text-primary transition-colors">Inspired Learning</h3>
                    <p class="text-sm text-gray-500 font-bold leading-relaxed">Our developmental specialists curate every product to spark curiosity and cognitive growth in early childhood.</p>
                </div>
                <!-- Value 3 -->
                <div class="value-card bg-white p-12 border border-gray-100 group">
                    <h3 class="text-xl font-black text-toys-text mb-4 uppercase group-hover:text-primary transition-colors">Community Heart</h3>
                    <p class="text-sm text-gray-500 font-bold leading-relaxed">ToyStore is more than a shop; it's a hub for parents and educators to share the joy of conscious parenting.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Section 3: Meet The Team -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32">
        <div class="text-center mb-20">
            <span class="text-[11px] font-black uppercase tracking-[0.4em] text-gray-400 block mb-4">Behind the Scenes</span>
            <h2 class="text-3xl font-black text-toys-text uppercase tracking-tight">The Team Behind the Toys</h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
            <!-- Team Member 1 -->
            <div class="team-card group">
                <div class="team-img-wrapper rounded-none overflow-hidden aspect-[4/5] mb-8 shadow-xl">
                    <img src="/brain/e529c155-b6a2-4916-aa6a-a3ccb0a97671/expert_1_1767607984864.png" alt="Thomas Qlark" class="w-full h-full object-cover">
                </div>
                <h4 class="text-xl font-black text-toys-text uppercase mb-2">Thomas Qlark</h4>
                <p class="text-[10px] font-black uppercase tracking-widest text-primary mb-4">Master Craftsman</p>
                <p class="text-xs text-gray-400 font-bold leading-relaxed">With 20 years of experience, Thomas ensures every wooden piece is polished to perfection.</p>
            </div>

            <!-- Team Member 2 -->
            <div class="team-card group">
                <div class="team-img-wrapper rounded-none overflow-hidden aspect-[4/5] mb-8 shadow-xl">
                    <img src="/brain/e529c155-b6a2-4916-aa6a-a3ccb0a97671/expert_2_1767607997759.png" alt="Gessica Romin" class="w-full h-full object-cover">
                </div>
                <h4 class="text-xl font-black text-toys-text uppercase mb-2">Gessica Romin</h4>
                <p class="text-[10px] font-black uppercase tracking-widest text-primary mb-4">Creative Director</p>
                <p class="text-xs text-gray-400 font-bold leading-relaxed">Gessica leads our design lab, turning whimsical ideas into safe, playable realities.</p>
            </div>

            <!-- Team Member 3 -->
            <div class="team-card group">
                <div class="team-img-wrapper rounded-none overflow-hidden aspect-[4/5] mb-8 shadow-xl">
                    <img src="/brain/e529c155-b6a2-4916-aa6a-a3ccb0a97671/expert_3_1767608015831.png" alt="Gopinnk Goli" class="w-full h-full object-cover">
                </div>
                <h4 class="text-xl font-black text-toys-text uppercase mb-2">Gopinnk Goli</h4>
                <p class="text-[10px] font-black uppercase tracking-widest text-primary mb-4">Logistics Lead</p>
                <p class="text-xs text-gray-400 font-bold leading-relaxed">Expertly managing our global supply chain to bring fun to your doorstep, anywhere in the world.</p>
            </div>
        </div>
    </div>

   
</div>
@endsection
