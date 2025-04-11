<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;

class PostController extends Controller
{
    public function listPost()
    {
        $listPost = Post::with(['user'])->paginate(7);
        return view('admin.posts.list-post')
            ->with(['listPost' => $listPost]);
    }
    public function addPost()
    {
        $listUser = User::all();
        return view('admin.posts.add-post')
            ->with('listUser', $listUser);
    }

    public function detailPost($idPost)
    {
        $post = Post::with(['user'])->find($idPost);
        return view('admin.posts.detail-post')
            ->with(['post' => $post]);
    }
}
