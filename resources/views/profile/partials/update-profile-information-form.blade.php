<section>
    <form method="post" action="{{ route('profile.update') }}" class="space-y-8" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <!-- Avatar Selection -->
        <div class="flex flex-col sm:flex-row items-center gap-8 p-6 bg-gray-50 rounded-[2rem] border border-dashed border-gray-200" x-data="{ 
            hasAvatar: {{ $user->avatar ? 'true' : 'false' }},
            removeAvatar: false,
            previewUrl: '{{ $user->avatar_url }}',
            originalUrl: '{{ $user->avatar_url }}'
        }">
            <div class="relative group">
                <div class="w-32 h-32 rounded-3xl overflow-hidden shadow-xl ring-4 ring-white relative">
                    <img id="avatar-preview" :src="previewUrl" alt="{{ $user->name }}" class="w-full h-full object-cover">
                    <div x-show="removeAvatar" class="absolute inset-0 bg-red-500/20 backdrop-blur-[2px] flex items-center justify-center">
                        <span class="bg-red-500 text-white text-[10px] font-black px-2 py-1 rounded-lg shadow-lg uppercase tracking-widest">Removing</span>
                    </div>
                </div>
                <label for="avatar" class="absolute -bottom-2 -right-2 w-10 h-10 bg-primary text-white rounded-xl flex items-center justify-center cursor-pointer shadow-lg hover:bg-secondary transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </label>
                <input type="file" name="avatar" id="avatar" class="hidden" accept="image/*" 
                       @change="
                        removeAvatar = false;
                        previewUrl = URL.createObjectURL($event.target.files[0]);
                       ">
                <input type="hidden" name="remove_avatar" :value="removeAvatar ? '1' : '0'">
            </div>
            <div>
                <h4 class="text-sm font-black text-toys-text uppercase tracking-tight mb-1">Profile Picture</h4>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest leading-relaxed mb-4">
                    JPG, GIF or PNG. Max size of 2MB.<br>
                    Recommended: Square image for best fit.
                </p>
                <div class="flex flex-wrap gap-2">
                    <button type="button" @click="document.getElementById('avatar').click()" class="text-[10px] font-black uppercase tracking-widest text-primary hover:text-secondary transition-colors underline decoration-dotted decoration-2 underline-offset-4">Change Photo</button>
                    <template x-if="hasAvatar">
                        <button type="button" @click="removeAvatar = !removeAvatar; if(removeAvatar) previewUrl = originalUrl" class="text-[10px] font-black uppercase tracking-widest text-red-500 hover:text-red-600 transition-colors underline decoration-dotted decoration-2 underline-offset-4" x-text="removeAvatar ? 'Keep Photo' : 'Remove Photo'"></button>
                    </template>
                </div>
                <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Name -->
            <div class="space-y-2">
                <x-input-label for="name" :value="__('Name')" class="text-xs font-black uppercase tracking-widest text-gray-400 ml-1" />
                <x-text-input id="name" name="name" type="text" class="block w-full !rounded-2xl border-gray-100 focus:border-primary focus:ring-primary/5 transition-all" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <!-- Email -->
            <div class="space-y-2">
                <x-input-label for="email" :value="__('Email Address')" class="text-xs font-black uppercase tracking-widest text-gray-400 ml-1" />
                <x-text-input id="email" name="email" type="email" class="block w-full !rounded-2xl border-gray-100 focus:border-primary focus:ring-primary/5 transition-all text-gray-500 bg-gray-50/30" :value="old('email', $user->email)" required autocomplete="username" />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />
            </div>

            <!-- Phone -->
            <div class="space-y-2">
                <x-input-label for="phone" :value="__('Phone Number')" class="text-xs font-black uppercase tracking-widest text-gray-400 ml-1" />
                <x-text-input id="phone" name="phone" type="tel" class="block w-full !rounded-2xl border-gray-100 focus:border-primary focus:ring-primary/5 transition-all" :value="old('phone', $user->phone)" autocomplete="tel" />
                <x-input-error class="mt-2" :messages="$errors->get('phone')" />
            </div>

            <!-- City -->
            <div class="space-y-2">
                <x-input-label for="city" :value="__('City')" class="text-xs font-black uppercase tracking-widest text-gray-400 ml-1" />
                <x-text-input id="city" name="city" type="text" class="block w-full !rounded-2xl border-gray-100 focus:border-primary focus:ring-primary/5 transition-all" :value="old('city', $user->city)" autocomplete="address-level2" />
                <x-input-error class="mt-2" :messages="$errors->get('city')" />
            </div>
        </div>

        <!-- Address -->
        <div class="space-y-2">
            <x-input-label for="address" :value="__('Detailed Address')" class="text-xs font-black uppercase tracking-widest text-gray-400 ml-1" />
            <x-textarea-input id="address" name="address" class="block w-full !rounded-3xl border-gray-100 focus:border-primary focus:ring-primary/5 transition-all" :value="old('address', $user->address)" autocomplete="street-address" rows="3" />
            <x-input-error class="mt-2" :messages="$errors->get('address')" />
        </div>

        <div class="flex items-center gap-6 pt-4">
            <button type="submit" class="px-10 py-4 bg-primary text-white rounded-2xl font-black text-xs uppercase tracking-[0.2em] shadow-xl shadow-primary/20 hover:bg-secondary transition-all hover:-translate-y-0.5 active:scale-95">
                Update Profile
            </button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 3000)"
                    class="text-[10px] font-black uppercase tracking-widest text-green-500"
                >Profile information saved successfully!</p>
            @endif
        </div>
    </form>
</section>
