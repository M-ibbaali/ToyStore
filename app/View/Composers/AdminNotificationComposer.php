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

        // Get latest actionable notifications (stock alerts and new orders)
        // We format them to match the view's expected structure
        $dbNotifications = $user->notifications()
            ->whereIn('data->type', ['stock', 'order'])
            ->latest()
            ->take(10)
            ->get();
        
        $notifications = $dbNotifications->map(function ($note) {
            return [
                'id' => $note->id,
                'type' => $note->data['type'] ?? 'info',
                'icon' => $note->data['icon'] ?? 'bell',
                'color' => $note->data['color'] ?? 'bg-gray-100 text-gray-600',
                'title' => $note->data['title'] ?? 'Notification',
                'description' => $note->data['description'] ?? '',
                'time' => $note->created_at,
                'read_at' => $note->read_at, // Include read_at timestamp
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
