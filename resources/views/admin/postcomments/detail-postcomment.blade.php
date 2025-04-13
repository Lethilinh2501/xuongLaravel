@extends('admin.layout.default')

@push('style')
    <style>
        body {
            background-color: #f8f9fa;
        }

        .sidebar {
            background-color: #2c3e50;
            color: white;
            padding-top: 20px;
        }

        .sidebar a {
            color: #ecf0f1;
            text-decoration: none;
            display: block;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background 0.3s, color 0.3s;
        }

        .sidebar a:hover {
            background-color: #2980b9;
            color: white;
        }

        .header {
            background-color: #3498db;
            color: white;
            padding: 10px 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .footer {
            background-color: #3498db;
            color: white;
            text-align: center;
            padding: 10px 0;
            font-size: 14px;
        }
    </style>
@endpush

@section('content')
    <main class="container-fluid flex-grow-1">
        <div class="container mt-4">
            <h2 class="mb-4">Chi Tiết Bình Luận Bài Viết</h2>
            <div class="card p-4">
                <table class="table table-bordered">
                    <tr>
                        <th>Người bình luận</th>
                        <td>{{ $postcomment->user ? $postcomment->user->name : 'Chưa xác định' }}</td>
                    </tr>
                    <tr>
                        <th>Bài viết</th>
                        <td>{{ $postcomment->post ? $postcomment->post->title : 'Chưa xác định' }}</td>
                    </tr>
                    <tr>
                        <th>Nội dung bình luận</th>
                        <td>{{ $postcomment->comment }}</td>
                    </tr>
                    <tr>
                        <th>Trạng thái</th>
                        <td>
                            @if($postcomment->status)
                                <span class="badge bg-success">Hiển thị</span>
                            @else
                                <span class="badge bg-danger">Đã ẩn</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Ngày tạo</th>
                        <td>{{ $postcomment->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Ngày cập nhật</th>
                        <td>{{ $postcomment->updated_at->format('d/m/Y H:i') }}</td>
                    </tr>
                </table>
                <a href="{{ route('admin.postcomments.listPostComment') }}" class="btn btn-primary mt-3">Quay lại</a>
            </div>
        </div>
    </main>
@endsection
