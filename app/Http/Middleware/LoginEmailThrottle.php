<?php

namespace App\Http\Middleware;

use Illuminate\Routing\Middleware\ThrottleRequests;

class LoginEmailThrottle extends ThrottleRequests
{
    protected function resolveRequestSignature($request)
    {
        return sha1($request->email);
    }

    protected function getHeaders($maxAttempts, $remainingAttempts, $retryAfter = null)
    {
        $headers = [
            'Email-RateLimit-Limit' => $maxAttempts,
            'Email-RateLimit-Remaining' => $remainingAttempts,
        ];

        if (!is_null($retryAfter)) {
            $headers['Retry-After'] = $retryAfter;
            $headers['X-RateLimit-Reset'] = $this->availableAt($retryAfter);
        }

        return $headers;
    }
}
