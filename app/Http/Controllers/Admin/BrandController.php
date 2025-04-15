<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    public function listBrand()
    {
        $listBrand = Brand::paginate(7);
        return view('admin.brands.list-brand', compact('listBrand'));
    }

    public function addBrand()
    {
        return view('admin.brands.add-brand');
    }

    public function addPostBrand(Request $req)
    {
        $validatedData = $req->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;

        if ($req->hasFile('logo')) {
            $image = $req->file('logo');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = $image->storeAs('uploads/brands', $imageName, 'public');
        }

        Brand::create([
            'name' => $validatedData['name'],
            'logo' => $imagePath,
        ]);

        return redirect()->route('admin.brands.listBrand')
            ->with('message', 'Thêm mới thành công');
    }


    public function deleteBrand(Request $req)
    {
        $brand = Brand::find($req->idBrand);

        if (!$brand) {
            return redirect()->route('admin.brands.listBrand')
                ->with('message', 'Không tìm thấy thương hiệu cần xóa');
        }

        if ($brand->logo && Storage::disk('public')->exists($brand->logo)) {
            Storage::disk('public')->delete($brand->logo);
        }

        $brand->delete();

        return redirect()->route('admin.brands.listBrand')
            ->with('message', 'Xóa thành công');
    }

    public function detailBrand($idBrand)
    {
        $brand = Brand::find($idBrand);
        return view('admin.brands.detail-brand', compact('brand'));
    }

    public function updateBrand($idBrand)
    {
        $brand = Brand::find($idBrand);

        if (!$brand) {
            return redirect()->route('admin.brands.listBrand')
                ->with('message', 'Không tìm thấy thương hiệu');
        }

        return view('admin.brands.update-brand', compact('brand'));
    }

    public function updatePatchBrand($idBrand, Request $req)
    {
        $brand = Brand::find($idBrand);

        if (!$brand) {
            return redirect()->route('admin.brands.listBrand')
                ->with('message', 'Không tìm thấy thương hiệu');
        }

        $validatedData = $req->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = $brand->logo;

        if ($req->hasFile('logo')) {
            // Xoá logo cũ
            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }

            $image = $req->file('logo');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = $image->storeAs('uploads/brands', $imageName, 'public');
        }

        $brand->update([
            'name' => $validatedData['name'],
            'logo' => $imagePath,
        ]);

        return redirect()->route('admin.brands.listBrand')
            ->with('message', 'Sửa thành công');
    }
}
