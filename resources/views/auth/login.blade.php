<x-guest-layout>
    <div class="mb-8">
        <h2 class="mt-6 text-4xl font-black text-toys-text tracking-tight">
            Welcome Back! <span class="text-primary">👋</span>
        </h2>
        <p class="mt-2 text-base font-bold text-gray-500">
            Sign in to start your toy adventure!
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email Address')" class="text-toys-text font-black uppercase text-xs tracking-widest ml-1 mb-1" />
            <x-text-input id="email" class="block mt-1 w-full rounded-2xl border-2 border-gray-100 bg-gray-50 focus:border-secondary focus:ring-0 focus:bg-white transition-all py-3 px-4 font-bold" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="fun@toystore.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between mb-1">
                <x-input-label for="password" :value="__('Password')" class="text-toys-text font-black uppercase text-xs tracking-widest ml-1" />
                @if (Route::has('password.request'))
                    <a class="text-xs font-black text-secondary hover:text-primary transition uppercase tracking-wider" href="{{ route('password.request') }}">
                        {{ __('Forgot?') }}
                    </a>
                @endif
            </div>

            <x-text-input id="password" class="block mt-1 w-full rounded-2xl border-2 border-gray-100 bg-gray-50 focus:border-secondary focus:ring-0 focus:bg-white transition-all py-3 px-4 font-bold"
                            type="password"
                            name="password"
                            required autocomplete="current-password" 
                            placeholder="Your secret code" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center ml-1">
            <input id="remember_me" type="checkbox" class="h-5 w-5 text-secondary focus:ring-secondary border-2 border-gray-200 rounded-lg" name="remember">
            <label for="remember_me" class="ml-3 block text-sm font-bold text-gray-600">
                {{ __('Stay Signed In') }}
            </label>
        </div>

        <div>
            <button type="submit" class="w-full flex justify-center py-4 px-4 border-none rounded-2xl shadow-lg shadow-primary/20 text-lg font-black text-white bg-primary hover:bg-secondary focus:outline-none transition-all transform hover:-translate-y-1 active:scale-95 uppercase tracking-widest">
                {{ __('Let\'s Play!') }}
            </button>
        </div>
    </form>

    <div class="mt-10 border-t-2 border-dashed border-gray-100 pt-8 text-center">
        <p class="text-sm font-bold text-gray-500">
            New to our toy box? 
            <a href="{{ route('register') }}" class="ml-1 font-black text-secondary hover:text-primary transition border-b-2 border-secondary hover:border-primary pb-0.5">
                Join the Fun!
            </a>
        </p>
    </div>
</x-guest-layout>
