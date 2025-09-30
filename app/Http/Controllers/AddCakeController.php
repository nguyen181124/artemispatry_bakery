<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cake;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AddCakeController extends Controller
{
    public function index()
    {
        $cakes = Cake::orderBy('id', 'desc')->get();
        return view('addcake', compact('cakes'));
    }

    public function storeOrUpdate(Request $request)
    {
        try {
            $validated = $request->validate([
                'id' => 'nullable|integer|exists:cake,id',
                'name' => 'required|string|max:255',
                'img' => 'required|url',
                'price' => 'required|integer',
                'info' => 'required|string',
                'category' => 'required|integer|in:1,2,3,4',
            ]);

            $isUpdate = !empty($request->id);

            $cake = Cake::updateOrCreate(
                ['id' => $request->id],
                $request->only(['name', 'img', 'price', 'info', 'category'])
            );

            return response()->json([
                'success' => true,
                'message' => $isUpdate ? 'Cập nhật sản phẩm công!' : 'Thêm sản phẩm công!',
                'cake' => $cake,
                'isUpdate' => $isUpdate,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi: ' . $e->getMessage(),
            ], 400);
        }
    }

    public function destroy($id)
    {
        try {
            $cake = Cake::findOrFail($id);
            $cake->delete();

            return response()->json([
                'success' => true,
                'message' => 'Đã xóa sản phẩm công!',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi: ' . $e->getMessage(),
            ], 400);
        }
    }
}