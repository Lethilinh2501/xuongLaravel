<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function listRole()
    {
        $listRole = Role::paginate(7);
        return view('admin.roles.list-role')
            ->with(['listRole' => $listRole]);
    }

    public function addRole()
    {
        return view('admin.roles.add-role');
    }

    public function addPostRole(Request $req)
    {

        $req->validate([
            'name' => 'required|string|max:255',
        ]);

        Role::create([
            'name' => $req->nameSP,
        ]);

        return redirect()->route('admin.roles.listRole')
            ->with('message', 'Thêm thành công!');
    }
}
