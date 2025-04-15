<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PostComment;

class PostCommentController extends Controller
{
    public function index()
    {
        $comments = PostComment::with(['user', 'post'])->orderBy('created_at', 'desc')->get();
        return response()->json($comments);
    }

    public function show($id)
    {
        $comment = PostComment::with(['user', 'post'])->find($id);
        if (!$comment) {
            return response()->json(['error' => 'Không tìm thấy bình luận'], 404);
        }
        return response()->json($comment);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'content' => 'required|string',
            'post_id' => 'required|exists:posts,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $comment = PostComment::create($data);

        return response()->json([
            'message' => 'Tạo bình luận thành công',
            'comment' => $comment
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $comment = PostComment::find($id);
        if (!$comment) {
            return response()->json(['error' => 'Không tìm thấy bình luận'], 404);
        }

        $data = $request->validate([
            'content' => 'required|string',
        ]);

        $comment->update($data);

        return response()->json([
            'message' => 'Cập nhật thành công',
            'comment' => $comment
        ]);
    }

    public function destroy($id)
    {
        $comment = PostComment::find($id);
        if (!$comment) {
            return response()->json(['error' => 'Không tìm thấy bình luận'], 404);
        }

        $comment->delete();

        return response()->json(['message' => 'Xóa bình luận thành công']);
    }
}
