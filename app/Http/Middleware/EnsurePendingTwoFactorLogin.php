<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePendingTwoFactorLogin
{
    /**
     * Ensure the session has a pending MFA login (user id) before accessing the challenge routes.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->session()->has('two_factor.login.id')) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
