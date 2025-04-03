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
            <h2 class="mb-4">Chi Tiết Thương Hiệu</h2>
            <div class="card p-4">
                <form action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="nameSP" class="form-label">Tên thương hiệu</label>
                        <input type="text" class="form-control" id="nameSP" name="nameSP"
                            placeholder="Nhập tên sản phẩm" value="{{ $brand->name }}">
                    </div>
                    <div class="mb-3">
                        <label for="imageSP" class="form-label">Hình ảnh</label><br>
                        <img src="{{ asset($brand->logo) }}" alt="" class="img-thumbnail rounded mx-auto d-block" width="300">
                    </div>
                    <a href="{{ route('admin.brands.listBrand') }}" class="btn btn-primary">Quay lại</a>
                </form>
            </div>
        </div>
    </main>
@endsection
