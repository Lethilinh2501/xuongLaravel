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
            <h2 class="mb-4 text-center">Thông Tin Người Dùng</h2>
            <div class="card p-4">
                <table class="table table-bordered">
                    <tr>
                        <th>Tên</th>
                        <td>{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <th>Số điện thoại</th>
                        <td>{{ $user->phone }}</td>
                    </tr>
                    <tr>
                        <th>Địa chỉ</th>
                        <td>{{ $user->address }}</td>
                    </tr>
                    <tr>
                        <th>Vai trò</th>
                        <td>{{ $user->roles ? $user->roles->name : 'Chưa xác định' }}</td>
                    </tr>
                    <tr>
                        <th>Trạng thái</th>
                        <td>{{ $user->status == 1 ? 'Kích hoạt' : 'Không kích hoạt' }}</td>
                    </tr>
                </table>
                <a href="{{ route('admin.users.listUser') }}" class="btn btn-primary mt-3">Quay lại</a>
            </div>
        </div>
    </main>
@endsection
