<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role): Response
    {
        // Kiểm tra nếu người dùng chưa đăng nhập
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Kiểm tra quyền người dùng
        if (Auth::user()->role_id !== $role) {
            abort(403, 'Bạn không có quyền truy cập trang này!');
        }

        return $next($request);
    }
}
