<?php

namespace App\Observers;

use App\Models\ContactMessage;
use App\Models\User;
use App\Notifications\SystemAlert;
use Illuminate\Support\Facades\Notification;

class ContactMessageObserver
{
    /**
     * Handle the ContactMessage "created" event.
     */
    public function created(ContactMessage $contactMessage): void
    {
        $admins = User::where('role', 'admin')->get();
        
        $data = [
            'type' => 'message',
            'icon' => 'mail',
            'color' => 'bg-purple-100 text-purple-600',
            'title' => 'New Message',
            'description' => "From {$contactMessage->name}: " . \Illuminate\Support\Str::limit($contactMessage->subject, 20),
            'url' => route('admin.messages.show', $contactMessage->id),
        ];

        Notification::send($admins, new SystemAlert($data));
    }
}
