<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class CustomAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // if (Auth::check() && Auth::user()->role_id == 1) {
        //     return $next($request);
        // }
        // else {
        //     return redirect()->route('');
        // }

        // if ($request->user()->role == '1') {
        //     // // echo $request->email;
        //     // // dd($request->email);
        //     // $userRole = Auth::user()->role->pluck('name')->toArray();
        //     // dd($userRole);

        //     // $userRole = Auth::user()->role->pluck('name')->toArray();
        //     // $userRole = $request->user()->role;
        //     // dd(Auth::user());

        //     // $user = $request->user();

        //     $role = User::with('hasRole');
        //     echo 'Admin';
        // } else {
        //     echo 'Customer';
        // }

        return $next($request);
    }
}
