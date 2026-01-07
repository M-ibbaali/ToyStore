@extends('layouts.frontend')

@section('title', 'Profile Settings - ToyStore')

@section('content')
<x-dashboard-layout>
    <!-- Header -->
    <div class="mb-12">
        <h1 class="text-4xl font-black text-toys-text tracking-tight mb-2 uppercase">Profile Settings</h1>
        <p class="text-gray-500 font-bold uppercase text-xs tracking-widest">Manage your information and account security.</p>
    </div>

    <div class="space-y-16">
        <!-- Personal Information -->
        <section class="relative">
            <h2 class="text-xl font-black text-toys-text tracking-tight mb-8 uppercase border-l-4 border-primary pl-4">Personal Information</h2>
            <div class="max-w-2xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </section>

        <!-- Security -->
        <section class="relative">
            <h2 class="text-xl font-black text-toys-text tracking-tight mb-8 uppercase border-l-4 border-secondary pl-4">Security & Password</h2>
            <div class="max-w-2xl">
                @include('profile.partials.update-password-form')
            </div>
        </section>

        <!-- Danger Zone -->
        <section class="pt-16 border-t border-gray-100">
            <h2 class="text-xl font-black text-red-500 tracking-tight mb-8 uppercase border-l-4 border-red-500 pl-4">Danger Zone</h2>
            <div class="max-w-2xl">
                @include('profile.partials.delete-user-form')
            </div>
        </section>
    </div>
</x-dashboard-layout>
@endsection
