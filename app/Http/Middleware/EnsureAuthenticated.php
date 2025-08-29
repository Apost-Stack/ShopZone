<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Enums\RoleEnum;

class EnsureAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * Usage examples:
     *  ->middleware('ensure.auth')               // juste auth
     *  ->middleware('ensure.auth:admin')         // auth + role admin
     *  ->middleware('ensure.auth:admin,employee')// auth + role admin OR employee
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @param  string|null  $roles  Comma-separated list of allowed roles (optional)
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, $guard = null, $roles = null): Response
    {
        if (!Auth::guard($guard)->check()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }

            return redirect()->route('errors.401');
        }

        $user = Auth::guard($guard)->user();

        if (!is_null($roles)) {
            $allowed = array_map('trim', explode(',', $roles));

            if (!in_array($user->role, $allowed, true)) {
                if ($request->expectsJson()) {
                    return response()->json(['message' => 'Forbidden.'], 403);
                }

                $route = $this->roleHomeRoute($user->role);
                return redirect()->route($route);
            }
        }

        return $next($request);
    }

    /**
     * Retourne le nom de route où rediriger selon le rôle.
     * Adapte ces noms de route à tes routes réelles.
     */
    private function roleHomeRoute(string $role): string
    {
        return match ($role) {
            RoleEnum::ADMIN->value    => 'admin.home',
            RoleEnum::EMPLOYEE->value => 'employee.home',
            RoleEnum::CUSTOMER->value => 'customer.home',
            default                   => 'home',
        };
    }
}
