<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminSessionTimeout
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
       $timeout = 604800;
        
        $lastActivity = session('admin_last_activity');

        if ($lastActivity && (time() - $lastActivity > $timeout)) {
            // Log out the filament user
            filament()->auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->to(filament()->getLoginUrl());
        }

        session(['admin_last_activity' => time()]);

        return $next($request);
    }
}
