<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
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
        // Kiểm tra nếu user đã đăng nhập và có quyền admin
        if (Auth::check() && Auth::user()->email === 'admin@gmail.com') {
            return $next($request);
        }

        // Nếu không phải admin thì chuyển hướng về trang chủ hoặc trang lỗi
        return redirect('/');
    }
}
