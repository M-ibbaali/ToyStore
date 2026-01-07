<?php

namespace App\View\Composers;

use Illuminate\View\View;

class AdminNotificationComposer
{
    public function compose(View $view)
    {
        // Fetch real database notifications for the logged-in admin
        // We only get unread ones for the badge/dropdown initially, or maybe latest 10?
        // User asked for "badge must always reflect real unread notifications count".
        
        $user = auth()->user();
        
        if (!$user) {
            $view->with('adminNotifications', collect());
            return;
        }

        // Get unread notifications for badge count and dropdown display
        // We format them to match the view's expected structure
        $dbNotifications = $user->unreadNotifications()->latest()->take(10)->get();
        
        $notifications = $dbNotifications->map(function ($note) {
            return [
                'id' => $note->id,
                'type' => $note->data['type'] ?? 'info',
                'icon' => $note->data['icon'] ?? 'bell',
                'color' => $note->data['color'] ?? 'bg-gray-100 text-gray-600',
                'title' => $note->data['title'] ?? 'Notification',
                'description' => $note->data['description'] ?? '',
                'time' => $note->created_at,
                'url' => route('admin.notifications.index'), // Link to full list or specific action? User might prefer list to mark read. 
                // Actually, let's link to the action IF provided, but maybe passing through a "mark read" route?
                // For now, link to action URL directly.
                'action_url' => $note->data['url'] ?? '#',
            ];
        });

        // Pass the COLLECTION of formatted notifications
        // We also need the count of ALL unread, not just the taken 10
        $unreadCount = $user->unreadNotifications()->count();

        $view->with('adminNotifications', $notifications);
        $view->with('adminUnreadCount', $unreadCount);
    }
}
