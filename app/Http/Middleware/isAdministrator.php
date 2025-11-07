<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class isAdministrator
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $user = auth()->user()->loadMissing('roles');
            $allowed = $user->roles->contains(function ($role) {
                // Case-insensitive compare and allow when pivot status is 1 or pivot not present
                return strcasecmp($role->nama_role ?? '', 'Administrator') === 0
                    && (!isset($role->pivot) || !isset($role->pivot->status) || (int) $role->pivot->status === 1);
            });

            if ($allowed) {
                return $next($request);
            }
        }

        Log::warning('Access denied by middleware', [
            'middleware' => __CLASS__,
            'user_id' => auth()->id(),
            'path' => $request->path(),
        ]);
        return redirect()->route('login')->with('error', 'Anda tidak memiliki akses.');
    }
}
