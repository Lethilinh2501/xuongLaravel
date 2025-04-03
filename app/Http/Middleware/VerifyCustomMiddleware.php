<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class VerifyCustomMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Kiểm tra nếu người dùng chưa đăng nhập
        if (Auth::check()) {
            return redirect()->route('login')->with('message', 'Bạn cần đăng nhập trước!');
        }

        return $next($request);
    }
}
