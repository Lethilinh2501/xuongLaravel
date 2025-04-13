<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PostComment;
use Illuminate\Http\Request;

class PostCommentController extends Controller
{
    public function listPostComment()
    {
        $listPostComment = PostComment::with(['user', 'post'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('admin.postcomments.list-postcomment', compact('listPostComment'));
    }

    public function detailPostComment($idPostComment)
    {
        $postcomment = PostComment::with(['user', 'post'])->find($idPostComment);
        return view('admin.postcomments.detail-postcomment')
            ->with(['postcomment' => $postcomment]);
    }

    public function deletePostComment(Request $req)
    {
        $postcomment = PostComment::find($req->idPostComment);

        if (!$postcomment) {
            return redirect()->route('admin.postcomments.listPostComment')->with([
                'error' => 'Không tìm thấy sản phẩm cần xóa'
            ]);
        }

        $postcomment->delete();

        return redirect()->route('admin.postcomments.listPostComment')->with([
            'message' => 'Xóa thành công'
        ]);
    }
}
