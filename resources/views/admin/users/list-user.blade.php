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
        <main class="container-fluid flex-grow-1 text-center">
            <div class="container mt-4">
                @if (session('message'))
                    <div class="alert alert-primary" role="alert">
                        {{ session('message') }}
                    </div>
                @endif
                <h2 class="mb-4">Danh Sách Người Dùng</h2>
                <div class="card p-4">
                    <table class="table table-bordered table-striped text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>STT</th>
                                <th>Tên</th>
                                <th>Email</th>
                                <th>Vai trò</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($listUser as $key => $value)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $value->name }}</td>
                                    <td>{{ $value->email }}</td>
                                    <td>{{ $value->roles ? $value->roles->name : 'Chưa xác định' }}</td>
                                    <td>
                                        <a href="{{ route('admin.users.detailUser', $value->id) }}"
                                            class="btn btn-primary btn-sm">Chi tiết</a>
                                        <a href="{{ route('admin.users.updateUser', $value->id) }}"
                                            class="btn btn-warning btn-sm">Sửa</a>
                                        <form id="toggle-status-form-{{ $value->id }}"
                                            action="{{ route('admin.users.toggleStatus', ['idUser' => $value->id]) }}"
                                            method="POST" style="display:inline;">
                                            @csrf
                                            @method('PATCH')
                                            @if ($value->status)
                                                <button type="button" class="btn btn-danger btn-sm"
                                                    onclick="confirmToggle({{ $value->id }}, 'ẩn')">Ẩn</button>
                                            @else
                                                <button type="button" class="btn btn-success btn-sm"
                                                    onclick="confirmToggle({{ $value->id }}, 'hiện')">Hiện</button>
                                            @endif
                                        </form>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $listUser->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </main>
    @endsection

    @push('scripts')
        <script>
            function confirmToggle(userId, actionText) {
                if (confirm(`Bạn có chắc chắn muốn ${actionText} người dùng này?`)) {
                    document.getElementById('toggle-status-form-' + userId).submit();
                }
            }
        </script>
    @endpush
