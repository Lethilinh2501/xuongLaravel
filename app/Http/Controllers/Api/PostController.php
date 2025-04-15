<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        return response()->json(Post::with('user')->get());
    }

    public function show($id)
    {
        $post = Post::with('user')->find($id);
        if (!$post) {
            return response()->json(['error' => 'Không tìm thấy bài viết'], 404);
        }
        return response()->json($post);
    }

    public function store(Request $req)
    {
        $data = $req->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'user_id' => 'required|exists:users,id',
        ]);

        $post = Post::create($data);

        return response()->json(['message' => 'Tạo bài viết thành công', 'post' => $post], 201);
    }

    public function update(Request $req, $id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->json(['error' => 'Không tìm thấy bài viết'], 404);
        }

        $data = $req->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $post->update($data);

        return response()->json(['message' => 'Cập nhật thành công', 'post' => $post]);
    }

    public function destroy($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->json(['error' => 'Không tìm thấy bài viết'], 404);
        }

        $post->delete();
        return response()->json(['message' => 'Xóa thành công']);
    }
}
