<?php

namespace Modules\SIBAF\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\SIBAF\Entities\Notification;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::with(['user', 'responsibleAllocation'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('sibaf::notifications', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->markAsRead();

        return response()->json(['success' => true]);
    }

    public function markAllAsRead()
    {
        Notification::where('statusNotification', 'pending')->update(['statusNotification' => 'seen']);

        return response()->json(['success' => true]);
    }

    public function getUnreadCount()
    {
        $count = Notification::where('statusNotification', 'pending')->count();

        return response()->json(['count' => $count]);
    }

    public function getRecent()
    {
        $notifications = Notification::with(['user', 'responsibleAllocation'])
            ->where('statusNotification', 'pending')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return response()->json($notifications);
    }

    public function destroy($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->delete();

        return response()->json(['success' => true]);
    }

    public function destroyAllRead()
    {
        Notification::where('statusNotification', 'seen')->delete();

        return response()->json(['success' => true]);
    }
} 