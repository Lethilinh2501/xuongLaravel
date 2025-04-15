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
    <!-- Main Section -->
    <main class="container-fluid flex-grow-1">
        <div class="container mt-4">
            <h2 class="mb-4">Thêm Bài Viết</h2>
            <div class="card p-4">
                <form action="{{ route('admin.posts.addPostPost') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Tiêu đề</label>
                        <input type="text" class="form-control" id="title" name="title"
                            placeholder="Nhập tiêu đề bài viết">
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">Nội dung</label>
                        <textarea class="form-control" id="content" name="content" rows="5" placeholder="Nhập nội dung bài viết..."></textarea>
                    </div>

                    <!-- Ẩn trường 'user_id' và tự động gán giá trị cho người đăng nhập -->
                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

                    <button type="submit" class="btn btn-primary">Thêm bài viết</button>
                </form>
            </div>
        </div>
    </main>
@endsection
