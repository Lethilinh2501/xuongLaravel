<!-- Sidebar -->
<div class="sidebar border-end p-3" style="width: 250px;">
    <h4>Admin</h4>
    <ul class="nav flex-column">
        <li class="nav-item"><a class="nav-link active" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Quản lý người dùng</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('admin.products.listProduct') }}">Quản lý sản phẩm</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('admin.categories.listCategory') }}">Quản lý danh mục</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('admin.brands.listBrand') }}">Quản lý thương hiệu</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('admin.posts.listPost') }}">Quản lý bài viết</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Báo cáo</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Thống kê</a></li>
    </ul>
</div>