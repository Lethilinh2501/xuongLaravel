<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function listProduct()
    {
        $listProduct = Product::with(['brand', 'category'])->paginate(7);
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

        $linkImage = "";
        if ($req->hasFile('imageSP')) {
            $image = $req->file('imageSP');
            $newName = time() . "_" . $image->getClientOriginalName();
            $linkStogate = 'uploads/products/';
            $image->move(public_path($linkStogate), $newName);
            $linkImage = $linkStogate . $newName;
        }

        $data = [
            'name' => $req->nameSP,
            'price' => $req->priceSP,
            'stock' => $req->soluongSP,
            'category_id' => $req->dmSP,
            'brand_id' => $req->brandSP,
            'description' => $req->motaSP,
            'image' => $linkImage,
        ];
        Product::create($data);
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
        $product = Product::where('id', $req->idProduct)->first();

        // Kiểm tra nếu không tìm thấy product
        if (!$product) {
            return redirect()->route('admin.products.listProduct')->with([
                'error' => 'Không tìm thấy sản phẩm cần xóa'
            ]);
        }

        if (!empty($product->image)) {
            File::delete(public_path($product->image));  // Xóa file ảnh nếu có
        }

        $product->delete();  // Xóa bản ghi trong database

        return redirect()->route('admin.products.listProduct')->with([
            'message' => 'Xóa mới thành công'
        ]);
    }

    public function updateProduct($idProduct)
    {
        $product = Product::where('id', $idProduct)->first();
        $listCategory = Category::all();
        $listBrand = Brand::all();
        return view('admin.products.update-product')
            ->with([
                'product' => $product,
                'listCategory' => $listCategory,
                'listBrand' => $listBrand
            ]);
    }

    public function updatePatchProduct($idProduct, Request $req)
    {
        $product = Product::where('id', $idProduct)->first();
        $linkImage = $product->image;

        if ($req->hasFile('imageSP')) {
            File::delete(public_path($product->image)); // xóa file cũ

            $image = $req->file('imageSP');
            $newName = time() . "_" . $image->getClientOriginalName();
            $linkStogate = 'uploads/products/';
            $image->move(public_path($linkStogate), $newName);
            $linkImage = $linkStogate . $newName;
        }
        $data = [
            'name' => $req->nameSP,
            'price' => $req->priceSP,
            'stock' => $req->soluongSP,
            'category_id' => $req->dmSP,
            'brand_id' => $req->brandSP,
            'description' => $req->motaSP,
            'image' => $linkImage,
        ];
        Product::where('id', $idProduct)->update($data);
        return redirect()->route('admin.products.listProduct')->with([
            'message' => 'Xóa mới thành công'
        ]);
    }
}
