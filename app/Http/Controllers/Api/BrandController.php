<?php

namespace App\Http\Controllers\Api;

use App\Models\Brand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::select('id', 'name', 'logo')->get();
        return response()->json([
            'message' => 'success',
            'data' => $brands
        ], 200);
    }

    public function show($id)
    {
        $brand = Brand::select('id', 'name', 'logo')->find($id);
        if (!$brand) {
            return response()->json([
                'message' => 'Brand not found',
            ], 404);
        }

        return response()->json([
            'message' => 'success',
            'data' => $brand
        ], 200);
    }

    public function store(Request $req)
    {
        $validated = $req->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $logoPath = null;
        if ($req->hasFile('logo')) {
            $logo = $req->file('logo');
            $logoName = time() . '_' . $logo->getClientOriginalName();
            $logoPath = $logo->storeAs('uploads/brands', $logoName, 'public');
        }

        $brand = Brand::create([
            'name' => $validated['name'],
            'logo' => $logoPath,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Brand created successfully!',
            'data' => $brand
        ], 201);
    }

    public function update(Request $req, $id)
    {
        $brand = Brand::find($id);
        if (!$brand) {
            return response()->json([
                'success' => false,
                'message' => 'Brand not found'
            ], 404);
        }

        $validated = $req->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $logoPath = $brand->logo;
        if ($req->hasFile('logo')) {
            if ($logoPath && Storage::disk('public')->exists($logoPath)) {
                Storage::disk('public')->delete($logoPath);
            }

            $logo = $req->file('logo');
            $logoName = time() . '_' . $logo->getClientOriginalName();
            $logoPath = $logo->storeAs('uploads/brands', $logoName, 'public');
        }

        $brand->update([
            'name' => $validated['name'],
            'logo' => $logoPath,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Brand updated successfully!',
            'data' => $brand
        ]);
    }

    public function destroy($id)
    {
        $brand = Brand::find($id);
        if (!$brand) {
            return response()->json([
                'success' => false,
                'message' => 'Brand not found'
            ], 404);
        }

        if ($brand->logo && Storage::disk('public')->exists($brand->logo)) {
            Storage::disk('public')->delete($brand->logo);
        }

        $brand->delete();

        return response()->json([
            'success' => true,
            'message' => 'Brand deleted successfully!'
        ]);
    }
}
