@extends('admin.layout.default')

@push('style')
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
                @if (session('message'))
                    <div class="alert alert-primary" role="alert">
                        {{ session('message') }}
                    </div>
                @endif
                <h2 class="mb-4 text-center">Danh Sách Bình Luận Bài Viết</h2>
                <div class="card p-4">
                    <table class="table table-bordered table-striped">
                        <thead class="table-dark text-center">
                            <tr>
                                <th>STT</th>
                                <th>Tài khoản</th>
                                <th>Bài viết</th>
                                <th>Bình luận</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($listPostComment as $key => $value)
                                <tr>
                                    <td class="text-center">{{ $key + 1 }}</td>
                                    <td>{{ $value->user ? $value->user->name : 'Chưa xác định' }}</td>
                                    <td>{{ $value->post ? Str::limit($value->post->title, 30, '...') : 'Chưa xác định' }}</td>
                                    <td title="{{ $value->comment }}">
                                        {{ Str::limit($value->comment, 50, '...') }}
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.postcomments.detailPostComment', $value->id) }}"
                                            class="btn btn-primary btn-sm">Chi tiết</a>
                                        <form id="delete-postcomment-form-{{ $value->id }}"
                                            action="{{ route('admin.postcomments.deletePostComment', ['idPostComment' => $value->id]) }}"
                                            method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm"
                                                onclick="confirmDelete({{ $value->id }})">Xóa</button>
                                        </form>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $listPostComment->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </main>
    @endsection

    @push('scripts')
        <script>
            function confirmDelete(postcommentId) {
                if (confirm("Bạn có chắc chắn muốn xóa thương hiệu này?")) {
                    document.getElementById('delete-postcomment-form-' + postcommentId).submit();
                }
            }
        </script>
    @endpush
