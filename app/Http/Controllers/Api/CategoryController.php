<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Lấy danh sách
    public function index()
    {
        $categories = Category::select('id', 'name')->get();
        return response()->json([
            'message' => 'success',
            'data' => $categories
        ], 200);
    }

    // Lấy 1 category theo ID
    public function show($id)
    {
        $category = Category::select('id', 'name')->find($id);
        if (!$category) {
            return response()->json([
                'message' => 'Category not found',
            ], 404);
        }
        return response()->json([
            'message' => 'success',
            'data' => $category
        ], 200);
    }

    // Tạo mới category
    public function store(Request $req)
    {
        $validated = $req->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = Category::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Category created successfully!',
            'data' => $category
        ], 201);
    }

    // Cập nhật category
    public function update(Request $req, $id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Category not found'
            ], 404);
        }

        $validated = $req->validate([
            'name' => 'required|string|max:255',
        ]);

        $category->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Category updated successfully!',
            'data' => $category
        ]);
    }

    // Xoá category
    public function destroy($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Category not found'
            ], 404);
        }

        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Category deleted successfully!'
        ]);
    }
}
