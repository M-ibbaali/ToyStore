<?php

namespace App\View\Composers;

use Illuminate\View\View;

class AdminNotificationComposer
{
    public function compose(View $view)
    {
        $user = auth()->user();
        
        if (!$user) {
            $view->with('adminNotifications', collect());
            $view->with('adminUnreadCount', 0);
            return;
        }

        // Get recent notifications (read and unread) for history
        $dbNotifications = $user->notifications()->latest()->take(10)->get();
        
        $notifications = $dbNotifications->map(function ($note) {
            return [
                'id' => $note->id,
                'read_at' => $note->read_at,
                'type' => $note->data['type'] ?? 'info',
                'icon' => $note->data['icon'] ?? 'bell',
                'color' => $note->data['color'] ?? 'bg-gray-100 text-gray-600',
                'title' => $note->data['title'] ?? 'Notification',
                'description' => $note->data['description'] ?? '',
                'time' => $note->created_at,
                'action_url' => $note->data['url'] ?? '#',
            ];
        });

        // Global unread count for badge
        $unreadCount = $user->unreadNotifications()->count();

        $view->with('adminNotifications', $notifications);
        $view->with('adminUnreadCount', $unreadCount);
    }
}
