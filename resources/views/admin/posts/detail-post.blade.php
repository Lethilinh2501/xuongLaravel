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
            <h2 class="mb-4">Chi Tiết Bài Viết</h2>
            <div class="card p-4">
                <table class="table table-bordered">
                    <tr>
                        <th>Tên tài khoản</th>
                        <td>{{ $post->user->name }}</td>
                    </tr>
                    <tr>
                        <th>Tiêu đề</th>
                        <td>{{ $post->title }}</td>
                    </tr>
                    <tr>
                        <th>Nội dung</th>
                        <td>{{ $post->content }}</td>
                    </tr>

                    <tr>
                        <th>Ngày đăng</th>
                        <td>{{ $post->created_at }}</td>
                    </tr>
                    <tr>
                        <th>ngày sửa</th>
                        <td>{{ $post->update_at }}</td>
                    </tr>
                </table>
                <a href="{{ route('admin.posts.listPost') }}" class="btn btn-primary mt-3">Quay lại</a>
            </div>
        </div>
    </main>
@endsection
