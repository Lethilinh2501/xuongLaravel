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

    public function addPostPost(Request $req)
    {
        $req->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'user_id' => 'required|exists:users,id',
        ]);

        Post::create([
            'title' => $req->title,
            'content' => $req->content,
            'user_id' => $req->user_id,
        ]);

        return redirect()->route('admin.posts.listPost')->with('message', 'Thêm bài viết thành công!');
    }

    public function detailPost($idPost)
    {
        $post = Post::with(['user'])->find($idPost);
        return view('admin.posts.detail-post')
            ->with(['post' => $post]);
    }

    public function deletePost(Request $req)
    {
        $post = Post::find($req->idPost);

        if (!$post) {
            return redirect()->route('admin.posts.listPost')->with([
                'error' => 'Không tìm thấy sản phẩm cần xóa'
            ]);
        }

        $post->delete();

        return redirect()->route('admin.posts.listPost')->with([
            'message' => 'Xóa thành công'
        ]);
    }

    public function updatePost($idPost)
    {
        $post = Post::find($idPost);
        if (!$post) {
            return redirect()->route('admin.posts.listPost')->with('error', 'Không tìm thấy bài viết');
        }

        return view('admin.posts.update-post', ['post' => $post]);
    }

    public function updatePatchPost(Request $req, $idPost)
    {
        $req->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $post = Post::find($idPost);

        if (!$post) {
            return redirect()->route('admin.posts.listPost')->with('error', 'Không tìm thấy bài viết để cập nhật');
        }

        $post->title = $req->title;
        $post->content = $req->content;
        $post->save();

        return redirect()->route('admin.posts.listPost')->with('message', 'Cập nhật bài viết thành công!');
    }
}
