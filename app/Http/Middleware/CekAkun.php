<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CekAkun
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::getUser()->email != 'admin@finbites.com') {
            // return response()->json('Opps! You do not have permission to access.');                
            // return redirect()->route('back');                
            return abort(404);;                
        } 
        return $next($request);
    }
}
