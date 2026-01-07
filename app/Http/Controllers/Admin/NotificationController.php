<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()->notifications()->paginate(20);
        auth()->user()->unreadNotifications->markAsRead();
        
        return view('admin.notifications.index', compact('notifications'));
    }

    public function destroy($id)
    {
        auth()->user()->notifications()->where('id', $id)->delete();
        return back()->with('success', 'Notification deleted.');
    }

    public function clearAll()
    {
        auth()->user()->notifications()->delete();
        return back()->with('success', 'All notifications cleared.');
    }
}
