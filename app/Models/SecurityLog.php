<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SecurityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_type',
        'severity',
        'ip_address',
        'user_agent',
        'user_id',
        'email',
        'route',
        'method',
        'description',
        'request_data',
        'country',
        'city',
        'blocked',
        'blocked_at',
    ];

    protected $casts = [
        'request_data' => 'array',
        'blocked' => 'boolean',
        'blocked_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get severity color for display
     */
    public function getSeverityColorAttribute(): string
    {
        return match($this->severity) {
            'low' => 'blue',
            'medium' => 'yellow',
            'high' => 'orange',
            'critical' => 'red',
            default => 'gray',
        };
    }

    /**
     * Get event type label
     */
    public function getEventTypeLabelAttribute(): string
    {
        return match($this->event_type) {
            'login_attempt' => 'Login Attempt',
            'failed_login' => 'Failed Login',
            'suspicious_activity' => 'Suspicious Activity',
            'brute_force' => 'Brute Force Attack',
            'sql_injection' => 'SQL Injection Attempt',
            'xss_attempt' => 'XSS Attempt',
            'csrf_failure' => 'CSRF Token Mismatch',
            'unauthorized_access' => 'Unauthorized Access',
            'rate_limit_exceeded' => 'Rate Limit Exceeded',
            'file_upload_attempt' => 'Malicious File Upload',
            default => ucfirst(str_replace('_', ' ', $this->event_type)),
        };
    }
}

