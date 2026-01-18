<?php

namespace App\Http\Controllers;

use App\Models\SecurityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SecurityController extends Controller
{
    /**
     * Display a listing of security logs.
     */
    public function index(Request $request)
    {
        $query = SecurityLog::with('user')->latest();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('ip_address', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('route', 'like', "%{$search}%");
            });
        }

        // Filter by event type
        if ($request->filled('event_type')) {
            $query->where('event_type', $request->event_type);
        }

        // Filter by severity
        if ($request->filled('severity')) {
            $query->where('severity', $request->severity);
        }

        // Filter by blocked
        if ($request->has('blocked')) {
            $query->where('blocked', $request->blocked);
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $logs = $query->paginate(20)->withQueryString();

        // Get stats for all logs (not just paginated)
        $allLogsQuery = SecurityLog::query();
        if ($request->filled('search')) {
            $search = $request->search;
            $allLogsQuery->where(function($q) use ($search) {
                $q->where('ip_address', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        if ($request->filled('event_type')) {
            $allLogsQuery->where('event_type', $request->event_type);
        }
        if ($request->filled('severity')) {
            $allLogsQuery->where('severity', $request->severity);
        }
        $allLogs = $allLogsQuery->get();

        $stats = [
            'total' => $allLogs->count(),
            'critical' => $allLogs->where('severity', 'critical')->count(),
            'high' => $allLogs->where('severity', 'high')->count(),
            'blocked' => $allLogs->where('blocked', true)->count(),
            'today' => SecurityLog::whereDate('created_at', today())->count(),
        ];

        // Get event types for filter
        $eventTypes = SecurityLog::distinct()->pluck('event_type')->sort();

        return view('backend.security.index', compact('logs', 'stats', 'eventTypes'));
    }

    /**
     * Display the specified security log.
     */
    public function show(SecurityLog $securityLog)
    {
        $securityLog->load('user');
        return view('backend.security.show', compact('securityLog'));
    }

    /**
     * Block an IP address
     */
    public function blockIp(Request $request, $ipAddress)
    {
        SecurityLog::where('ip_address', $ipAddress)
            ->update([
                'blocked' => true,
                'blocked_at' => now(),
            ]);

        return redirect()->back()
            ->with('success', "IP address {$ipAddress} has been blocked.");
    }

    /**
     * Unblock an IP address
     */
    public function unblockIp($ipAddress)
    {
        SecurityLog::where('ip_address', $ipAddress)
            ->update([
                'blocked' => false,
                'blocked_at' => null,
            ]);

        return redirect()->back()
            ->with('success', "IP address {$ipAddress} has been unblocked.");
    }

    /**
     * Export security logs to CSV
     */
    public function export(Request $request)
    {
        $query = SecurityLog::with('user');

        // Apply same filters as index
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('ip_address', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('event_type')) {
            $query->where('event_type', $request->event_type);
        }

        if ($request->filled('severity')) {
            $query->where('severity', $request->severity);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $logs = $query->latest()->get();

        $filename = 'security_logs_export_' . now()->format('Y-m-d_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($logs) {
            $file = fopen('php://output', 'w');
            
            fputcsv($file, ['Event Type', 'Severity', 'IP Address', 'User', 'Email', 'Route', 'Description', 'Blocked', 'Created At']);
            
            foreach ($logs as $log) {
                fputcsv($file, [
                    $log->event_type_label,
                    ucfirst($log->severity),
                    $log->ip_address,
                    $log->user ? $log->user->name : 'N/A',
                    $log->email ?? 'N/A',
                    $log->route ?? 'N/A',
                    $log->description ?? 'N/A',
                    $log->blocked ? 'Yes' : 'No',
                    $log->created_at->format('Y-m-d H:i:s'),
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Get security statistics for dashboard
     */
    public function statistics()
    {
        $stats = [
            'today' => SecurityLog::whereDate('created_at', today())->count(),
            'this_week' => SecurityLog::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'this_month' => SecurityLog::whereMonth('created_at', now()->month)->count(),
            'critical_today' => SecurityLog::whereDate('created_at', today())->where('severity', 'critical')->count(),
            'blocked_ips' => SecurityLog::where('blocked', true)->distinct('ip_address')->count('ip_address'),
            'top_attack_types' => SecurityLog::select('event_type', DB::raw('count(*) as count'))
                ->groupBy('event_type')
                ->orderByDesc('count')
                ->limit(5)
                ->get(),
            'top_attacker_ips' => SecurityLog::select('ip_address', DB::raw('count(*) as count'))
                ->groupBy('ip_address')
                ->orderByDesc('count')
                ->limit(10)
                ->get(),
        ];

        return response()->json($stats);
    }
}
