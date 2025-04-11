<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenController extends Controller
{
    public function postLogin(Request $req)
    {
        if (Auth::attempt([
            'email' => $req->email,
            'password' => $req->password,
        ])) {
            if (Auth::user()->role_id == '2') {
                $token = User::find(Auth::id())->createToken('token')->plainTextToken;
                return response()->json([
                    'token' => $token,
                    'message' => 'Đăng nhập thành công',
                    'status_code' => '200'
                ], 200);
            }
        }
        return response()->json([
            'massage' => 'Đăng nhập thất bại',
            'status_code' => '200'
        ], 200);
    }

    public function postRegister(Request $req)
    {
        $validated = $req->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role_id' => 1, // mặc định client
        ]);

        return response()->json([
            'message' => 'Đăng ký thành công!',
            'user' => $user
        ], 201);
    }

    public function logout(Request $req)
    {
        $req->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Đăng xuất thành công!'
        ]);
    }
}
