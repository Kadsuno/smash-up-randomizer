<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Sentry\State\Scope;
use Symfony\Component\HttpFoundation\Response;

use function Sentry\configureScope;

class SentryUserContext
{
    /**
     * Set authenticated user context on the Sentry scope.
     * Only non-PII data (numeric ID + role) is sent; send_default_pii remains false.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            configureScope(function (Scope $scope) use ($user): void {
                $scope->setUser([
                    'id' => $user->getAuthIdentifier(),
                    'role' => $user->is_admin ?? false ? 'admin' : 'user',
                ]);
            });
        }

        return $next($request);
    }
}
