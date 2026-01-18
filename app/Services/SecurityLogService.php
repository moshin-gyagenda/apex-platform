<?php

namespace App\Services;

use App\Models\SecurityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SecurityLogService
{
    /**
     * Log a security event
     */
    public static function log(string $eventType, string $severity, Request $request, ?string $description = null, ?int $userId = null): SecurityLog
    {
        $ipAddress = $request->ip();
        $geoData = self::getGeoLocation($ipAddress);

        $log = SecurityLog::create([
            'event_type' => $eventType,
            'severity' => $severity,
            'ip_address' => $ipAddress,
            'user_agent' => $request->userAgent(),
            'user_id' => $userId ?? auth()->id(),
            'email' => $request->input('email') ?? (auth()->user()?->email),
            'route' => $request->route()?->getName() ?? $request->path(),
            'method' => $request->method(),
            'description' => $description ?? self::getDefaultDescription($eventType),
            'request_data' => self::sanitizeRequestData($request),
            'country' => $geoData['country'] ?? null,
            'city' => $geoData['city'] ?? null,
        ]);

        // Check for brute force patterns
        self::checkBruteForce($log);

        return $log;
    }

    /**
     * Check for SQL injection patterns
     */
    public static function detectSqlInjection(Request $request): bool
    {
        $patterns = [
            '/\b(union|select|insert|update|delete|drop|create|alter|exec|execute)\b/i',
            '/\b(or|and)\s+\d+\s*=\s*\d+/i',
            '/\'\s*(or|and)\s+\'\d+\'=\'\d+/i',
            '/\b(\'|\"|;|--|\/\*|\*\/)/i',
        ];

        $input = json_encode($request->all());
        
        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $input)) {
                self::log('sql_injection', 'critical', $request, 'SQL injection attempt detected');
                return true;
            }
        }

        return false;
    }

    /**
     * Check for XSS patterns
     */
    public static function detectXss(Request $request): bool
    {
        $patterns = [
            '/<script[^>]*>.*?<\/script>/is',
            '/<iframe[^>]*>.*?<\/iframe>/is',
            '/javascript:/i',
            '/on\w+\s*=/i',
            '/<img[^>]+src[^>]*=.*javascript:/i',
        ];

        $input = json_encode($request->all());
        
        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $input)) {
                self::log('xss_attempt', 'high', $request, 'XSS attempt detected');
                return true;
            }
        }

        return false;
    }

    /**
     * Check for brute force attempts
     */
    protected static function checkBruteForce(SecurityLog $log): void
    {
        if (!in_array($log->event_type, ['failed_login', 'login_attempt'])) {
            return;
        }

        // Check failed login attempts in last 15 minutes from same IP
        $recentFailedAttempts = SecurityLog::where('ip_address', $log->ip_address)
            ->where('event_type', 'failed_login')
            ->where('created_at', '>=', now()->subMinutes(15))
            ->count();

        if ($recentFailedAttempts >= 5) {
            $log->update([
                'severity' => 'critical',
                'event_type' => 'brute_force',
                'blocked' => true,
                'blocked_at' => now(),
            ]);

            // Block the IP
            SecurityLog::where('ip_address', $log->ip_address)
                ->update([
                    'blocked' => true,
                    'blocked_at' => now(),
                ]);
        }
    }

    /**
     * Get geo location for IP address
     */
    protected static function getGeoLocation(string $ipAddress): array
    {
        if (filter_var($ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
            try {
                // Using ip-api.com (free tier: 45 requests/minute)
                $response = Http::timeout(2)->get("http://ip-api.com/json/{$ipAddress}");
                if ($response->successful()) {
                    $data = $response->json();
                    return [
                        'country' => $data['country'] ?? null,
                        'city' => $data['city'] ?? null,
                    ];
                }
            } catch (\Exception $e) {
                // Silently fail
            }
        }

        return [];
    }

    /**
     * Sanitize request data for logging (remove sensitive info)
     */
    protected static function sanitizeRequestData(Request $request): array
    {
        $data = $request->except(['password', 'password_confirmation', '_token', '_method']);
        
        // Limit array depth
        $sanitized = [];
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $sanitized[$key] = array_slice($value, 0, 10); // Limit to 10 items
            } else {
                $sanitized[$key] = is_string($value) ? substr($value, 0, 500) : $value;
            }
        }

        return $sanitized;
    }

    /**
     * Get default description for event type
     */
    protected static function getDefaultDescription(string $eventType): string
    {
        return match($eventType) {
            'failed_login' => 'Failed login attempt',
            'login_attempt' => 'Login attempt',
            'brute_force' => 'Brute force attack detected',
            'sql_injection' => 'SQL injection attempt',
            'xss_attempt' => 'XSS attack attempt',
            'csrf_failure' => 'CSRF token validation failed',
            'unauthorized_access' => 'Unauthorized access attempt',
            'rate_limit_exceeded' => 'Rate limit exceeded',
            default => 'Security event detected',
        };
    }

    /**
     * Check if IP is blocked
     */
    public static function isIpBlocked(string $ipAddress): bool
    {
        return SecurityLog::where('ip_address', $ipAddress)
            ->where('blocked', true)
            ->exists();
    }
}

