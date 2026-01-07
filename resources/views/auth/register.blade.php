<x-guest-layout>
    <div class="mb-8">
        <h2 class="mt-6 text-4xl font-black text-toys-text tracking-tight">
            Join the Fun! <span class="text-primary">✨</span>
        </h2>
        <p class="mt-2 text-base font-bold text-gray-500">
            Create an account to start your collection!
        </p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Full Name')" class="text-toys-text font-black uppercase text-xs tracking-widest ml-1 mb-1" />
            <x-text-input id="name" class="block mt-1 w-full rounded-2xl border-2 border-gray-100 bg-gray-50 focus:border-secondary focus:ring-0 focus:bg-white transition-all py-3 px-4 font-bold" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Super Kid Name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email Address')" class="text-toys-text font-black uppercase text-xs tracking-widest ml-1 mb-1" />
            <x-text-input id="email" class="block mt-1 w-full rounded-2xl border-2 border-gray-100 bg-gray-50 focus:border-secondary focus:ring-0 focus:bg-white transition-all py-3 px-4 font-bold" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="fun@toystore.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" class="text-toys-text font-black uppercase text-xs tracking-widest ml-1 mb-1" />
            <x-text-input id="password" class="block mt-1 w-full rounded-2xl border-2 border-gray-100 bg-gray-50 focus:border-secondary focus:ring-0 focus:bg-white transition-all py-3 px-4 font-bold"
                            type="password"
                            name="password"
                            required autocomplete="new-password"
                            placeholder="Min. 8 characters" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-toys-text font-black uppercase text-xs tracking-widest ml-1 mb-1" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full rounded-2xl border-2 border-gray-100 bg-gray-50 focus:border-secondary focus:ring-0 focus:bg-white transition-all py-3 px-4 font-bold"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" placeholder="Re-enter your secret code" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full flex justify-center py-4 px-4 border-none rounded-2xl shadow-lg shadow-primary/20 text-lg font-black text-white bg-primary hover:bg-secondary focus:outline-none transition-all transform hover:-translate-y-1 active:scale-95 uppercase tracking-widest">
                {{ __('Join the Club') }}
            </button>
        </div>
    </form>

    <div class="mt-8 border-t-2 border-dashed border-gray-100 pt-6 text-center">
        <p class="text-sm font-bold text-gray-500">
            Already a member? 
            <a href="{{ route('login') }}" class="ml-1 font-black text-secondary hover:text-primary transition border-b-2 border-secondary hover:border-primary pb-0.5">
                Sign In
            </a>
        </p>
    </div>
</x-guest-layout>
