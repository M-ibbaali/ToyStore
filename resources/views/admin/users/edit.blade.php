@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.users.index') }}" class="text-secondary hover:text-primary transition flex items-center gap-2 mb-4 font-bold">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Back to Users
    </a>
    <h1 class="text-3xl font-bold text-toys-text">Edit User: {{ $user->name }}</h1>
</div>

<div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
    <form action="{{ route('admin.users.update', $user) }}" method="POST" class="p-8">
        @csrf
        @method('PATCH')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                       class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-secondary focus:ring-secondary transition-all">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                       class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-secondary focus:ring-secondary transition-all">
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Role -->
            <div>
                <label for="role" class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">Role</label>
                <select name="role" id="role" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-secondary focus:ring-secondary transition-all">
                    <option value="client" {{ old('role', $user->role) == 'client' ? 'selected' : '' }}>Client</option>
                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                @error('role') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">Status</label>
                <select name="status" id="status" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-secondary focus:ring-secondary transition-all">
                    <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status', $user->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Phone -->
            <div>
                <label for="phone" class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">Phone</label>
                <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}"
                       class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-secondary focus:ring-secondary transition-all">
                @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- City -->
            <div>
                <label for="city" class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">City</label>
                <input type="text" name="city" id="city" value="{{ old('city', $user->city) }}"
                       class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-secondary focus:ring-secondary transition-all">
                @error('city') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            
            <div class="md:col-span-2">
                <label for="address" class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">Address</label>
                <textarea name="address" id="address" rows="3"
                          class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-secondary focus:ring-secondary transition-all">{{ old('address', $user->address) }}</textarea>
                @error('address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="md:col-span-2 bg-gray-50 p-6 rounded-2xl border-2 border-dashed border-gray-200">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Change Password</h3>
                <p class="text-sm text-gray-500 mb-6">Leave blank if you don't want to change the password.</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">New Password</label>
                        <input type="password" name="password" id="password"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-secondary focus:ring-secondary transition-all bg-white">
                        @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">Confirm New Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-secondary focus:ring-secondary transition-all bg-white">
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end pt-6 border-t border-gray-100">
            <button type="submit" class="px-8 py-4 bg-toys-btn text-white rounded-2xl hover:bg-secondary transition-all transform hover:-translate-y-0.5 shadow-lg shadow-toys-btn/25 font-black uppercase tracking-widest text-sm">
                Update User ✨
            </button>
        </div>
    </form>
</div>
@endsection
