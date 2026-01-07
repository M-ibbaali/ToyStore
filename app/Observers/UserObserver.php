<?php

namespace App\Observers;

use App\Models\User;
use App\Notifications\SystemAlert;
use Illuminate\Support\Facades\Notification;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        // Don't notify if the user is an admin created via seeder/manually
        if ($user->role === 'admin') return;

        $admins = User::where('role', 'admin')->get();
        
        $data = [
            'type' => 'user',
            'icon' => 'user-add',
            'color' => 'bg-green-100 text-green-600',
            'title' => 'New Customer',
            'description' => "{$user->name} joined the store.",
            'url' => route('admin.users.index'),
        ];

        Notification::send($admins, new SystemAlert($data));
    }
}
