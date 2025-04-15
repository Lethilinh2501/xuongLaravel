<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->paginate(10);
        return response()->json($users);
    }

    public function show($id)
    {
        $user = User::with('roles')->find($id);

        if (!$user) {
            return response()->json(['error' => 'Không tìm thấy người dùng'], 404);
        }

        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'Không tìm thấy người dùng'], 404);
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'role_id' => 'required|exists:roles,id',
            'status' => 'required|boolean',
        ]);

        $user->update($data);

        return response()->json([
            'message' => 'Cập nhật người dùng thành công',
            'user' => $user,
        ]);
    }

    // PATCH /api/users/{id}/toggle-status
    public function toggleStatus($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'Không tìm thấy người dùng'], 404);
        }

        $user->status = !$user->status;
        $user->save();

        return response()->json([
            'message' => 'Đã thay đổi trạng thái người dùng',
            'status' => $user->status,
        ]);
    }
}
