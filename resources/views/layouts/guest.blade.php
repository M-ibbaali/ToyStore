<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'ToyStore') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            body { font-family: 'Nunito', sans-serif; }
        </style>
    </head>
    <body class="font-sans text-toys-text antialiased">
        <div class="min-h-screen flex bg-toy-bg">
            <!-- Left Side: Visual -->
            <div class="hidden lg:flex lg:w-1/2 relative bg-secondary overflow-hidden">
                <img src="{{ asset('images/auth_banner.png') }}" 
                     alt="ToyStore" 
                     class="absolute inset-0 w-full h-full object-cover opacity-80">
                <div class="absolute inset-0 bg-gradient-to-br from-secondary/40 via-primary/20 to-secondary/60"></div>
                
                <div class="relative z-10 flex flex-col justify-between w-full h-full p-12 text-white">
                    <div>
                         <a href="/" class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center mb-8 shadow-xl border-4 border-primary hover:scale-110 transition-transform duration-300">
                            <svg class="w-10 h-10 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                            </svg>
                         </a>
                         <h1 class="text-6xl font-black mb-6 leading-tight drop-shadow-lg">Where Every <br/><span class="text-primary">Toy</span> Sparkles!</h1>
                         <p class="text-xl text-white max-w-md font-bold leading-relaxed drop-shadow-md">Join our family and discover the most magical collection of toys for your little ones.</p>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="flex items-center space-x-3 bg-white/20 backdrop-blur-md p-4 rounded-2xl w-fit border border-white/30">
                             <div class="flex -space-x-2 overflow-hidden">
                                 <div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center border-2 border-white text-white font-bold">😊</div>
                                 <div class="w-10 h-10 rounded-full bg-secondary flex items-center justify-center border-2 border-white text-white font-bold">🤖</div>
                                 <div class="w-10 h-10 rounded-full bg-yellow-400 flex items-center justify-center border-2 border-white text-white font-bold">🧸</div>
                             </div>
                             <span class="text-sm font-black uppercase tracking-wider">Over 10,000 Happy Families!</span>
                        </div>
                        <p class="text-xs font-bold text-white/80 uppercase tracking-widest">© {{ date('Y') }} ToyStore. Made with ❤️ for kids.</p>
                    </div>
                </div>
            </div>

            <!-- Right Side: Form -->
            <div class="flex-1 flex flex-col justify-center py-12 px-4 sm:px-6 lg:flex-none lg:w-1/2 xl:px-24 bg-white relative rounded-l-[3rem] shadow-[-20px_0_40px_rgba(0,0,0,0.05)]">
                 <!-- Mobile Logo (Visible only on small screens) -->
                 <div class="lg:hidden absolute top-8 left-8">
                     <a href="/" class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-primary rounded-xl flex items-center justify-center text-white shadow-lg shadow-primary/30">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
                        </div>
                        <span class="font-black text-2xl text-toys-text tracking-tighter">ToyStore</span>
                     </a>
                 </div>

                <div class="mx-auto w-full max-w-sm lg:w-96">
                     {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
