<?php

namespace App\Http\Middleware;

use App\Services\SecurityLogService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityMonitoringMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $ipAddress = $request->ip();

        // Check if IP is blocked
        if (SecurityLogService::isIpBlocked($ipAddress)) {
            SecurityLogService::log('unauthorized_access', 'high', $request, "Blocked IP attempt: {$ipAddress}");
            abort(403, 'Your IP address has been blocked due to suspicious activity.');
        }

        // Detect SQL injection
        SecurityLogService::detectSqlInjection($request);

        // Detect XSS
        SecurityLogService::detectXss($request);

        $response = $next($request);

        // Log suspicious patterns in response
        if ($response->getStatusCode() >= 400 && $response->getStatusCode() < 500) {
            SecurityLogService::log(
                'suspicious_activity',
                'medium',
                $request,
                "HTTP {$response->getStatusCode()} response"
            );
        }

        return $response;
    }
}
