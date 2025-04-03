<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class Register2Middleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Kiểm tra nếu email chưa được xác thực
        if (Auth::check() && !Auth::user()->email_verified_at) {
            return redirect()->route('verification.notice')->with('message', 'Vui lòng xác nhận email trước khi tiếp tục!');
        }

        return $next($request);
    }
}
