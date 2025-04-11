<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Session;

class AuthenticationController extends Controller
{
    public function login()
    {
        return view('login');
    }
    public function postLogin(Request $req)
    {
        $credentials = [
            'email' => $req->email,
            'password' => $req->password,
        ];

        $remember = $req->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            Session::where('user_id', Auth::id())->delete();
            session()->put('user_id', Auth::id());

            $user = Auth::user();

            if ($user->role_id == 2) {
                return redirect()->route('admin.products.listProduct')->with([
                    'message' => 'Đăng nhập thành công'
                ]);
            } else {
                Auth::logout(); // Logout vì không đủ quyền
                return redirect()->route('login')->with([
                    'message' => 'Bạn không có quyền truy cập trang admin. Vui lòng liên hệ quản trị viên.'
                ]);
            }
        } else {
            return redirect()->back()->with([
                'message' => 'Email hoặc mật khẩu không đúng'
            ]);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with([
            'message' => 'Đăng xuất thành công'

        ]);
    }

    public function register()
    {
        return view('register');
    }

    public function postRegister(Request $req)
    {
        $check = User::where('email', $req->email)->exists();

        if ($check) {
            return redirect()->back()->with([
                'message' => 'Tài khoản đã tồn tại'
            ]);
        }

        $data = [
            'name' => $req->name,
            'email' => $req->email,
            'password' => Hash::make($req->password),
            'role_id' => 1,
        ];

        // dd($data); // Xem thử dữ liệu đúng chưa

        $newUser = User::create($data);
        Auth::login($newUser);

        return redirect()->route('login')->with([
            'message' => 'Đăng kí thành công. Vui lòng đăng nhập.'
        ]);
    }
}
