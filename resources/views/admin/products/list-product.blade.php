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
                <h2 class="mb-4">Danh Sách Sản Phẩm</h2>
                <a href="{{ route('admin.products.addProduct') }}" class="btn btn-primary mb-4">Thêm mới</a>
                <div class="card p-4">
                    <table class="table table-bordered table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>STT</th>
                                <th>Tên sản phẩm</th>
                                <th>Giá</th>
                                <th>Danh mục</th>
                                <th>Thương hiệu</th>
                                <th>Hình ảnh</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($listProduct as $key => $value)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $value->name }}</td>
                                    <td>{{ $value->price }}</td>
                                    <td>{{ $value->category ? $value->category->name : 'Không có danh mục' }}</td>
                                    <td>{{ $value->brand ? $value->brand->name : 'Không có thương hiệu' }}</td>
                                    <td><img src="{{ asset($value->image) }}" alt="" width="120"></td>
                                    <td>
                                        <a href="{{ route('admin.products.detailProduct', $value->id) }}"
                                            class="btn btn-primary btn-sm">Chi tiết</a>
                                        <a href="{{ route('admin.products.updateProduct', $value->id) }}"
                                            class="btn btn-warning btn-sm">Sửa</a>
                                        <form id="delete-product-form-{{ $value->id }}"
                                            action="{{ route('admin.products.deleteProduct', ['idProduct' => $value->id]) }}"
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
                    {{ $listProduct->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </main>
    @endsection

    @push('scripts')
        <script>
            function confirmDelete(productId) {
                if (confirm("Bạn có chắc chắn muốn xóa thương hiệu này?")) {
                    document.getElementById('delete-product-form-' + productId).submit();
                }
            }
        </script>
    @endpush
