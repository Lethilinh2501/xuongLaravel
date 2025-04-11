<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $product = Product::select('name', 'price')->get();
        return response()->json([
            'message' => 'success',
            'data' => $product
        ], 200);
    }
    public function show($id)
    {
        $product = Product::select('name', 'price')->where('id', $id)->first();
        return response()->json([
            'message' => 'success',
            'data' => $product
        ], 200);
    }
    public function store(Request $req)
    {
        // Bước 1: Validate
        $validatedData = $req->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'brand_id' => 'nullable|exists:brands,id',
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' // validate file ảnh
        ]);

        try {
            if ($req->hasFile('image')) {
                $image = $req->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->storeAs('uploads/products', $imageName, 'public');
                $validatedData['image'] =  $imageName;
            }

            // Bước 3: Lưu vào DB
            $product = Product::create($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'Product created successfully!',
                'data' => $product
            ], 201);
        } catch (\Exception $e) {
            $product = Product::create($validatedData);
            return response()->json([
                'success' => false,
                'message' => 'Product created successfully!',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $req, $id)
    {
        $validatedData = $req->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'brand_id' => 'nullable|exists:brands,id',
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }

        try {
            // Nếu có ảnh mới => xử lý cập nhật
            if ($req->hasFile('image')) {
                // Xoá ảnh cũ nếu có
                if ($product->image && Storage::disk('public')->exists($product->image)) {
                    Storage::disk('public')->delete($product->image);
                }

                $image = $req->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $imagePath = $image->storeAs('uploads/products', $imageName, 'public');
                $validatedData['image'] = $imagePath;
            }

            $product->update($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'Product updated successfully!',
                'data' => $product
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update product',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }

        try {
            // Xoá ảnh nếu có
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            $product->delete();

            return response()->json([
                'success' => true,
                'message' => 'Product deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete product',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
