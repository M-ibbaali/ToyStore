{{-- Why Choose ToyStore Section - Reusable Component --}}
<section class="bg-gradient-to-br from-toys-bg to-white py-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        {{-- Header --}}
        <div class="text-center mb-12">
            <h2 class="text-4xl md:text-5xl font-black text-toys-text mb-4">
                Why Choose <span class="text-primary">ToyStore</span>
            </h2>
            <p class="text-base md:text-lg text-gray-600 font-medium max-w-2xl mx-auto">
                Your trusted partner for quality toys, exceptional service, and endless smiles. 
                We're committed to bringing joy to every family.
            </p>
        </div>

        {{-- Feature Cards Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            
            {{-- Card 1: Premium Quality --}}
            <div class="bg-white rounded-2xl p-6 shadow-md hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border-2 border-transparent hover:border-primary group">
                <div class="w-16 h-16 bg-primary/10 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-primary transition-colors duration-300">
                    <svg class="w-8 h-8 text-primary group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-black text-toys-text mb-2 group-hover:text-primary transition-colors">
                    Premium Quality
                </h3>
                <p class="text-sm text-gray-600 leading-relaxed">
                    Carefully selected toys that meet the highest safety standards and quality checks.
                </p>
            </div>

            {{-- Card 2: Fast Shipping --}}
            <div class="bg-white rounded-2xl p-6 shadow-md hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border-2 border-transparent hover:border-secondary group">
                <div class="w-16 h-16 bg-secondary/10 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-secondary transition-colors duration-300">
                    <svg class="w-8 h-8 text-secondary group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <h3 class="text-xl font-black text-toys-text mb-2 group-hover:text-secondary transition-colors">
                    Fast Shipping
                </h3>
                <p class="text-sm text-gray-600 leading-relaxed">
                    Quick and reliable delivery to get your toys to you as fast as possible.
                </p>
            </div>

            {{-- Card 3: Secure Payment --}}
            <div class="bg-white rounded-2xl p-6 shadow-md hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border-2 border-transparent hover:border-primary group">
                <div class="w-16 h-16 bg-primary/10 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-primary transition-colors duration-300">
                    <svg class="w-8 h-8 text-primary group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <h3 class="text-xl font-black text-toys-text mb-2 group-hover:text-primary transition-colors">
                    Secure Payment
                </h3>
                <p class="text-sm text-gray-600 leading-relaxed">
                    Shop with confidence using our encrypted and secure payment gateway.
                </p>
            </div>

            {{-- Card 4: 24/7 Support --}}
            <div class="bg-white rounded-2xl p-6 shadow-md hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border-2 border-transparent hover:border-secondary group">
                <div class="w-16 h-16 bg-secondary/10 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-secondary transition-colors duration-300">
                    <svg class="w-8 h-8 text-secondary group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-black text-toys-text mb-2 group-hover:text-secondary transition-colors">
                    24/7 Support
                </h3>
                <p class="text-sm text-gray-600 leading-relaxed">
                    Our friendly team is always here to help with any questions or concerns.
                </p>
            </div>

        </div>

        {{-- Call to Action Button --}}
        <div class="text-center">
            <a href="{{ route('about') }}" 
               class="inline-flex items-center gap-3 bg-secondary text-white px-8 py-4 rounded-full font-black text-lg uppercase tracking-wide shadow-lg hover:shadow-2xl hover:bg-primary transition-all duration-300 transform hover:scale-105 group">
                <span>About Us</span>
                <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>
    </div>
</section>
