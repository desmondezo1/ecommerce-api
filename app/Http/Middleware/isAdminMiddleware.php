<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class isAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = User::find(Auth::id());

        // Pre-Middleware Action
        if (!auth()->check() ){
            abort(403,'Must be LoggedIn as Admins !');
        }

        if( $user->role == 4 or $user->role == 2 ){
            $response = $next($request);
            // Post-Middleware Action
            return $response;
        }


        abort(403,'Must be LoggedIn as Admins !');
    }
}
