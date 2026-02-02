<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    /**
     * Get notifications for the authenticated user.
     */
    public function index(Request $request)
    {
        $query = Notification::where(function($q) {
            $q->where('notifiable_type', 'App\Models\User')
              ->where('notifiable_id', auth()->id())
              ->orWhere(function($q2) {
                  // System-wide notifications (notifiable_type = 'system')
                  $q2->where('notifiable_type', 'system')
                     ->whereNull('notifiable_id');
              });
        });

        // Filter by read/unread
        if ($request->has('unread_only') && $request->unread_only) {
            $query->whereNull('read_at');
        }

        $notifications = $query->latest()
            ->limit($request->get('limit', 10))
            ->get();

        $unreadCount = Notification::where(function($q) {
            $q->where('notifiable_type', 'App\Models\User')
              ->where('notifiable_id', auth()->id())
              ->orWhere(function($q2) {
                  $q2->where('notifiable_type', 'system')
                     ->whereNull('notifiable_id');
              });
        })->whereNull('read_at')->count();

        return response()->json([
            'notifications' => $notifications->map(function($notification) {
                return [
                    'id' => $notification->id,
                    'type' => $notification->type,
                    'title' => $notification->title,
                    'message' => $notification->message,
                    'icon' => $notification->icon ?? 'info',
                    'color' => $notification->color,
                    'data' => $notification->data,
                    'read_at' => $notification->read_at,
                    'time_ago' => $notification->time_ago,
                    'created_at' => $notification->created_at->toIso8601String(),
                ];
            }),
            'unread_count' => $unreadCount,
        ]);
    }

    /**
     * Mark notification as read.
     */
    public function markAsRead(Notification $notification)
    {
        // Check if user owns this notification or it's a system notification
        if (($notification->notifiable_type === 'App\Models\User' && $notification->notifiable_id == auth()->id()) ||
            ($notification->notifiable_type === 'system')) {
            $notification->markAsRead();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead()
    {
        Notification::where(function($q) {
            $q->where(function($q1) {
                $q1->where('notifiable_type', 'App\Models\User')
                   ->where('notifiable_id', auth()->id());
            })->orWhere(function($q2) {
                $q2->where('notifiable_type', 'system')
                   ->whereNull('notifiable_id');
            });
        })->whereNull('read_at')->update(['read_at' => now()]);

        return response()->json(['success' => true]);
    }
}
