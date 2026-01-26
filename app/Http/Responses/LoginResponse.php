<?php

namespace App\Http\Responses;

use Illuminate\Http\Request;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        $user = $request->user();
        
        // Check if there's a redirect parameter (e.g., from checkout)
        if ($request->has('redirect')) {
            return redirect($request->get('redirect'));
        }
        
        // Redirect clients to frontend dashboard, admins to admin dashboard
        if ($user->hasRole('client')) {
            return redirect()->route('frontend.dashboard.index');
        } elseif ($user->hasAnyRole(['admin', 'super-admin'])) {
            return redirect()->route('dashboard');
        }
        
        // Default redirect to frontend dashboard
        return redirect()->route('frontend.dashboard.index');
    }
}
