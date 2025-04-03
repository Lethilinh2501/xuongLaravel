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
        return view('client.login');
    }
    public function postLogin(Request $req)
    {
        $dataUserLogin = [
            'email' => $req->email,
            'password' => $req->password,
        ];

        $remember = $req->has('remember');

        if (Auth::attempt($dataUserLogin, $remember)) {
            //logout hết các tài khoản khác
            Session::where('user_id', Auth::id())->delete();
            // Tạo phiên đăng nhập mới
            session()->put('user_id', Auth::id());

            // Đăng nhập thành công
            // dd('Đăng nhập thành công', Auth::user());
            if (Auth::attempt(['email' => $req->email, 'password' => $req->password])) {
                return redirect()->route('admin.products.listProduct')->with([
                    'message' => 'Đăng nhập thành công'
                ]);
            } else {
                // Đăng nhập vào user
                echo 'Đăng nhập  vào user';
            }
        } else {
            // Đăng nhập thất bại
            // dd('Đăng nhập thất bại', $dataUserLogin);
            return redirect()->back()->with([
                'message' => 'email hoặc mật khẩu không đúng'
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
        return view('client.register');
    }

    public function postRegister(Request $req)
    {
        $check = User::where('email', $req->email)->exists();
        if ($check) {
            return redirect()->back()->with([
                'message' => 'tài khoản đã tồn tại'
            ]);
        } else {
            $data = [
                'name' => $req->name,
                'email' => $req->email,
                'password' => Hash::make($req->password),
                'role_id' => 1,
            ];
            $newUser = User::create($data);
            Auth::login($newUser); // tự động cho user này
            // return dashboard (trang chủ)

            return redirect()->route('login')->with([
                'message' => 'Đăng kí thành công. vui lòng đăng nhập.'
            ]);
            // đki sau đó quay trl trang đn
            //     'message' => 'Đăng kí thành công. vui lòng đăng nhập.'
            // ]);
        }
    }
}
