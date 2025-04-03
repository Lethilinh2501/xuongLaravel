<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class RegisterMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Kiểm tra nếu người dùng đã đăng ký hay chưa
        if (Auth::check() && !Auth::user()->is_registered == false) {
            return redirect()->route('register')->with('message', 'Bạn cần hoàn tất đăng ký!');
        }

        return $next($request);
    }
}
