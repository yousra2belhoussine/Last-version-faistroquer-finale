<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $notifications = $user->notifications()->paginate(20);

        return view('notifications.index', [
            'notifications' => $notifications
        ]);
    }

    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'message_notifications' => 'boolean',
            'proposition_notifications' => 'boolean',
            'admin_notifications' => 'boolean'
        ]);

        $user = auth()->user();
        $user->notification_preferences = $validated;
        $user->save();

        return back()->with('success', 'Préférences de notification mises à jour avec succès');
    }

    public function markAsRead(Request $request)
    {
        $user = auth()->user();
        
        if ($request->has('notification_id')) {
            $user->notifications()->findOrFail($request->notification_id)->markAsRead();
        } else {
            $user->unreadNotifications->markAsRead();
        }

        return response()->json(['success' => true]);
    }
} 