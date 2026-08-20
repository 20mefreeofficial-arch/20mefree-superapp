<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePermission
{
    /**
     * Batasi route berdasarkan permission modul.fungsi.aksi milik user.
     *
     * Contoh pemakaian: ->middleware('permission:user-rbac.users.view')
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        $user = $request->user();

        [$moduleSlug, $functionSlug, $action] = array_pad(explode('.', $permission), 3, null);

        if (! $user || ! $user->hasPermission($moduleSlug, $functionSlug, $action)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
