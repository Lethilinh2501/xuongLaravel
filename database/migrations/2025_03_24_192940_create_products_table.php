<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // Khóa chính tự động tăng
            $table->string('name'); // Tên sản phẩm
            $table->text('description')->nullable(); // Mô tả sản phẩm, có thể để trống
            $table->decimal('price', 10, 2); // Giá sản phẩm
            $table->decimal('discount', 10, 2)->default(0); // Giảm giá, mặc định là 0
            $table->integer('stock')->default(0); // Số lượng tồn kho, mặc định là 0
            $table->foreignId('brand_id')->nullable()->constrained('brands')->onDelete('set null'); // Thương hiệu
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null'); // Danh mục
            $table->string('image')->nullable(); // Ảnh sản phẩm, có thể để trống
            $table->timestamps(); // Tự động tạo created_at và updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
