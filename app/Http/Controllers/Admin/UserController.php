<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function listUser()
    {
        $listUser = User::with('roles')
            // ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('admin.users.list-user', compact('listUser'));
    }
    public function detailUser($idUser)
    {
        $user = User::with('roles')->find($idUser);
        return view('admin.users.detail-user')
            ->with(['user' => $user]);
    }
    public function updateUser($idUser)
    {
        $user = User::find($idUser);
        $listRole = Role::all();

        if (!$user) {
            return redirect()->route('admin.users.listUser')->with('error', 'Không tìm thấy sản phẩm');
        }

        return view('admin.users.update-user', [
            'user' => $user,
            'listRole' => $listRole,
        ]);
    }

    public function updatePatchUser($idUser, Request $req)
    {
        $user = User::find($idUser);

        if (!$user) {
            return redirect()->route('admin.users.listUser')->with('error', 'Không tìm thấy người dùng');
        }

        $validated = $req->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'role_id' => 'required|exists:roles,id',
            'status' => 'required|boolean',
        ]);

        $user->update($validated);

        return redirect()->route('admin.users.listUser')->with('message', 'Cập nhật người dùng thành công');
    }

    public function toggleStatus($idUser)
    {
        $user = User::find($idUser);
        if (!$user) {
            return redirect()->route('admin.users.listUser')->with('error', 'Không tìm thấy người dùng');
        }

        $user->status = !$user->status; // Đảo ngược trạng thái
        $user->save();

        return redirect()->route('admin.users.listUser')->with('message', 'Cập nhật trạng thái thành công');
    }
}
