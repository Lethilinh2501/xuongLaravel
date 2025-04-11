<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;


class ProductController extends Controller
{
    public function listProduct()
    {
        $listProduct = Product::with(['brand', 'category'])
            ->orderBy('created_at', 'desc')
            ->paginate(7);
        return view('admin.products.list-product')
            ->with(['listProduct' => $listProduct]);
    }

    public function addProduct()
    {
        $listCategory = Category::all();
        $listBrand = Brand::all();
        return view('admin.products.add-product')
            ->with('listCategory', $listCategory)
            ->with('listBrand', $listBrand);
    }

    public function addPostProduct(Request $req)
    {
        $validatedData = $req->validate([
            'nameSP' => 'required|string|max:255',
            'priceSP' => 'required|numeric|min:0',
            'soluongSP' => 'nullable|integer|min:0',
            'dmSP' => 'nullable|exists:categories,id',
            'brandSP' => 'nullable|exists:brands,id',
            'motaSP' => 'nullable|string',
            'imageSP' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $linkImage = null;
        if ($req->hasFile('imageSP')) {
            $image = $req->file('imageSP');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $linkImage = $image->storeAs('uploads/products', $imageName, 'public');
        }

        Product::create([
            'name' => $validatedData['nameSP'],
            'price' => $validatedData['priceSP'],
            'stock' => $validatedData['soluongSP'] ?? 0,
            'category_id' => $validatedData['dmSP'],
            'brand_id' => $validatedData['brandSP'],
            'description' => $validatedData['motaSP'],
            'image' => $linkImage,
        ]);

        return redirect()->route('admin.products.listProduct')->with([
            'message' => 'Thêm mới thành công'
        ]);
    }
    public function detailProduct($idProduct)
    {
        // Lấy sản phẩm theo ID cùng với danh mục & thương hiệu
        $product = Product::with(['category', 'brand'])->find($idProduct);
        return view('admin.products.detail-product')
            ->with(['product' => $product]);
    }

    public function deleteProduct(Request $req)
    {
        $product = Product::find($req->idProduct);

        if (!$product) {
            return redirect()->route('admin.products.listProduct')->with([
                'error' => 'Không tìm thấy sản phẩm cần xóa'
            ]);
        }

        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('admin.products.listProduct')->with([
            'message' => 'Xóa thành công'
        ]);
    }

    public function updateProduct($idProduct)
    {
        $product = Product::find($idProduct);
        $listCategory = Category::all();
        $listBrand = Brand::all();

        if (!$product) {
            return redirect()->route('admin.products.listProduct')->with('error', 'Không tìm thấy sản phẩm');
        }

        return view('admin.products.update-product', [
            'product' => $product,
            'listCategory' => $listCategory,
            'listBrand' => $listBrand,
        ]);
    }

    public function updatePatchProduct($idProduct, Request $req)
    {
        $product = Product::find($idProduct);

        if (!$product) {
            return redirect()->route('admin.products.listProduct')->with('error', 'Không tìm thấy sản phẩm');
        }

        $validatedData = $req->validate([
            'nameSP' => 'required|string|max:255',
            'priceSP' => 'required|numeric|min:0',
            'soluongSP' => 'nullable|integer|min:0',
            'dmSP' => 'nullable|exists:categories,id',
            'brandSP' => 'nullable|exists:brands,id',
            'motaSP' => 'nullable|string',
            'imageSP' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $linkImage = $product->image;

        if ($req->hasFile('imageSP')) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            $image = $req->file('imageSP');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $linkImage = $image->storeAs('uploads/products', $imageName, 'public');
        }

        $product->update([
            'name' => $validatedData['nameSP'],
            'price' => $validatedData['priceSP'],
            'stock' => $validatedData['soluongSP'] ?? 0,
            'category_id' => $validatedData['dmSP'],
            'brand_id' => $validatedData['brandSP'],
            'description' => $validatedData['motaSP'],
            'image' => $linkImage,
        ]);

        return redirect()->route('admin.products.listProduct')->with([
            'message' => 'Cập nhật thành công'
        ]);
    }
}
