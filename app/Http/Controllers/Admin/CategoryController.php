<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Symfony\Contracts\Service\Attribute\Required;

class CategoryController extends Controller
{
    public function listCategory()
    {
        $listCategory = Category::paginate(7);
        return view('admin.categories.list-category')
            ->with(['listCategory' => $listCategory]);
    }

    public function detailCategory($idCategory)
    {
        $category = Category::where('id', $idCategory)->first();
        return view('admin.categories.detail-category')
            ->with(['category' => $category]);
    }

    public function addCategory()
    {
        return view('admin.categories.add-category');
    }

    public function addPostCategory(Request $req)
    {

        $req->validate([
            'name' => 'required|string|max:255',
        ]);

        Category::create([
            'name' => $req->nameSP,
            'parent_id' => $req->parent_id ?? null,
        ]);

        return redirect()->route('admin.categories.listCategory')
            ->with('message', 'Thêm danh mục thành công!');
    }
    public function deleteCategory(Request $req)
    {
        $category = Category::where('id', $req->idCategory)->first();

        if (!$category) {
            return redirect()->route('admin.categories.listCategory')->with([
                'error' => 'Không tìm thấy thương hiệu cần xóa'
            ]);
        }

        $category->delete();

        return redirect()->route('admin.categories.listCategory')->with([
            'message' => 'Xóa thành công'
        ]);
    }

    public function updateCategory($idCategory)
    {
        $category = Category::where('id', $idCategory)->first();
        return view('admin.categories.update-category')
            ->with(['category' => $category]);
    }

    public function updatePatchCategory($idCategory, Request $req)
    {

        $category = Category::where('id', $idCategory)->first();

        $data = [
            'name' => $req->nameSP,
            'parent_id' => $req->parent_id ?? null,

        ];
        Category::where('id', $idCategory)->update($data);
        return redirect()->route('admin.categories.listCategory')->with([
            'message' => 'Sửa thành công'
        ]);
    }
}
