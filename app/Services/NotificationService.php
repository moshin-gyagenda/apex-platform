<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\Product;
use App\Models\Order;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;

class NotificationService
{
    /**
     * Create a notification.
     */
    public static function create(string $type, string $title, string $message, $notifiable = null, array $data = [], string $icon = null, string $color = 'primary')
    {
        // Determine icon based on type if not provided
        if (!$icon) {
            $icon = self::getIconForType($type);
        }

        // Determine color based on type if not provided
        if ($color === 'primary') {
            $color = self::getColorForType($type);
        }

        return Notification::create([
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'icon' => $icon,
            'color' => $color,
            'notifiable_type' => $notifiable ? get_class($notifiable) : 'system',
            'notifiable_id' => $notifiable ? $notifiable->id : null,
            'data' => $data,
        ]);
    }

    /**
     * Check for low stock products and create notifications.
     */
    public static function checkLowStock()
    {
        $lowStockProducts = Product::where('status', 'active')
            ->whereColumn('quantity', '<=', 'reorder_level')
            ->where('quantity', '>=', 0)
            ->get();

        if ($lowStockProducts->count() > 0) {
            // Create a single notification for multiple low stock items
            $productNames = $lowStockProducts->take(3)->pluck('name')->toArray();
            $message = $lowStockProducts->count() . ' product' . ($lowStockProducts->count() > 1 ? 's' : '') . ' running low';
            if (count($productNames) > 0) {
                $message .= ': ' . implode(', ', $productNames);
                if ($lowStockProducts->count() > 3) {
                    $message .= ' and ' . ($lowStockProducts->count() - 3) . ' more';
                }
            }

            // Check if notification already exists (within last hour)
            $existingNotification = Notification::where('type', 'low_stock')
                ->where('created_at', '>', now()->subHour())
                ->first();

            if (!$existingNotification) {
                self::create(
                    'low_stock',
                    'Low Stock Alert',
                    $message,
                    null, // System notification
                    [
                        'product_count' => $lowStockProducts->count(),
                        'product_ids' => $lowStockProducts->pluck('id')->toArray(),
                    ],
                    'package',
                    'yellow'
                );
            }
        }
    }

    /**
     * Create notification for new order.
     */
    public static function notifyNewOrder(Order $order)
    {
        self::create(
            'new_order',
            'New Order Received',
            'Order #' . $order->order_number . ' has been placed',
            null, // System notification (or could be $order->user)
            [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'total_amount' => $order->total_amount,
            ],
            'shopping-cart',
            'green'
        );
    }

    /**
     * Create notification for new sale (POS).
     */
    public static function notifyNewSale(Sale $sale)
    {
        self::create(
            'new_sale',
            'New Sale Completed',
            'Sale #' . $sale->id . ' completed - ' . number_format($sale->final_amount, 0) . ' UGX',
            null, // System notification
            [
                'sale_id' => $sale->id,
                'final_amount' => $sale->final_amount,
                'payment_method' => $sale->payment_method,
            ],
            'check-circle',
            'green'
        );
    }

    /**
     * Get icon for notification type.
     */
    private static function getIconForType(string $type): string
    {
        return match($type) {
            'low_stock' => 'package',
            'new_order' => 'shopping-cart',
            'new_sale' => 'check-circle',
            'system_update' => 'alert-triangle',
            default => 'info',
        };
    }

    /**
     * Get color for notification type.
     */
    private static function getColorForType(string $type): string
    {
        return match($type) {
            'low_stock' => 'yellow',
            'new_order' => 'green',
            'new_sale' => 'green',
            'system_update' => 'purple',
            default => 'primary',
        };
    }
}
