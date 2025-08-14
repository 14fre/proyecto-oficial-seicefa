<?php

namespace Modules\SIBAF\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\SIBAF\Entities\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::with(['user', 'responsibleAllocation'])
            ->where('user_id', Auth::id()) // <-- AGREGADO
            ->where('created_at', '>=', Carbon::now()->subDays(2))
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return response()->json($notifications);
    }

    public function markAsRead($id)
    {
        $notification = Notification::where('id', $id)
            ->where('user_id', Auth::id()) // <-- AGREGADO
            ->firstOrFail();
        $notification->statusNotification = 'seen';
        $notification->save();
        
        return response()->json(['success' => true]);
    }

    public function markAllAsRead()
    {
        Notification::where('user_id', Auth::id()) // <-- AGREGADO
            ->where('statusNotification', 'pending')
            ->where('created_at', '>=', Carbon::now()->subDays(2))
            ->update(['statusNotification' => 'seen']);

        return response()->json(['success' => true]);
    }

    public function getUnreadCount()
    {
        $count = Notification::where('user_id', Auth::id()) // <-- AGREGADO
            ->where('statusNotification', 'pending')
            ->where('created_at', '>=', Carbon::now()->subDays(2))
            ->count();

        return response()->json(['count' => $count]);
    }

    public function getRecent()
    {
        $notifications = Notification::with(['user', 'responsibleAllocation'])
            ->where('user_id', Auth::id()) // <-- AGREGADO
            ->where('created_at', '>=', Carbon::now()->subDays(2))
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return response()->json($notifications);
    }

    public function destroy($id)
    {
        $notification = Notification::where('id', $id)
            ->where('user_id', Auth::id()) // <-- AGREGADO
            ->firstOrFail();
        $notification->delete();

        return response()->json(['success' => true]);
    }

    public function destroyAllRead()
    {
        Notification::where('user_id', Auth::id()) // <-- AGREGADO
            ->where('statusNotification', 'seen')
            ->where('created_at', '>=', Carbon::now()->subDays(2))
            ->delete();

        return response()->json(['success' => true]);
    }
}