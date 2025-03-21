<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::orderBy('id', 'desc')->get();
        return view('admin.employees', compact('employees'));
    }

    public function storeOrUpdate(Request $request)
    {
        try {
            $validated = $request->validate([
                'id' => 'nullable|integer|exists:employees,id',
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:employees,email,' . $request->id,
                'phone' => 'nullable|string|max:20',
                'date_of_birth' => 'nullable|date',
                'address' => 'nullable|string',
                'position' => 'nullable|string|max:100',
                'salary' => 'nullable|numeric|min:0',
            ]);

            $isUpdate = !empty($request->id);

            $employee = Employee::updateOrCreate(
                ['id' => $request->id],
                $request->only(['name', 'email', 'phone', 'date_of_birth', 'address', 'position', 'salary'])
            );

            return response()->json([
                'success' => true,
                'message' => $isUpdate ? 'Cập nhật nhân viên thành công!' : 'Thêm nhân viên thành công!',
                'employee' => $employee,
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
            $employee = Employee::findOrFail($id);
            $employee->delete();

            return response()->json([
                'success' => true,
                'message' => 'Đã xóa nhân viên thành công!',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi: ' . $e->getMessage(),
            ], 400);
        }
    }
}
