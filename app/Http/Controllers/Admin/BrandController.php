<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Support\Facades\File;

class BrandController extends Controller
{
    public function listBrand()
    {
        $listBrand = Brand::paginate(7);
        return view('admin.brands.list-brand')
            ->with(['listBrand' => $listBrand]);
    }
    public function addBrand()
    {
        return view('admin.brands.add-brand');
    }
    public function addPostBrand(Request $req)
    {
        $linkImage = "";
        if ($req->hasFile('imageSP')) {
            $image = $req->file('imageSP');
            $newName = time() . "_" . $image->getClientOriginalName();
            $linkStogate = 'uploads/brands/';
            $image->move(public_path($linkStogate), $newName);

            $linkImage = $linkStogate . $newName;
        }

        $data = [
            'name' => $req->nameSP,
            'logo' => $linkImage,
        ];
        Brand::create($data);
        return redirect()->route('admin.brands.listBrand')->with([
            'message' => 'Thêm mới thành công'
        ]);
    }

    public function deleteBrand(Request $req)
    {
        $brand = Brand::where('id', $req->idBrand)->first();

        // Kiểm tra nếu không tìm thấy brand
        if (!$brand) {
            return redirect()->route('admin.brands.listBrand')->with([
                'error' => 'Không tìm thấy thương hiệu cần xóa'
            ]);
        }

        // Xóa file logo nếu có
        if (!empty($brand->logo)) {
            File::delete(public_path($brand->logo));
        }

        // Xóa bản ghi trong database
        $brand->delete();

        return redirect()->route('admin.brands.listBrand')->with([
            'message' => 'Xóa thành công'
        ]);
    }

    public function detailBrand($idBrand)
    {
        $brand = Brand::where('id', $idBrand)->first();
        return view('admin.brands.detail-brand')
            ->with(['brand' => $brand]);
    }

    public function updateBrand($idBrand)
    {
        $brand = Brand::where('id', $idBrand)->first();
        return view('admin.brands.update-brand')
            ->with(['brand' => $brand]);
    }
    
    public function updatePatchBrand($idBrand, Request $req)
    {
        
        $brand = Brand::where('id', $idBrand)->first();
        $linkImage = $brand->logo;

        if ($req->hasFile('imageSP')) {
            File::delete(public_path($brand->logo)); // xóa file cũ

            $image = $req->file('imageSP');
            $newName = time() . "_" . $image->getClientOriginalName();
            $linkStogate = 'uploads/brands/';
            $image->move(public_path($linkStogate), $newName);
            $linkImage = $linkStogate . $newName;
        }

        $data = [
            'name' => $req->nameSP,
            'logo' => $linkImage,
        ];
        Brand::where('id', $idBrand)->update($data);
        return redirect()->route('admin.brands.listBrand')->with([
            'message' => 'Sửa thành công'
        ]);
    }
}
