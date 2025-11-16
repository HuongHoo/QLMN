<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LopHoc;
use Illuminate\Http\Request;

class LopHocController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lophoc = LopHoc::paginate(10); // Lấy tất cả dữ liệu từ bảng lophoc
        return view('admin.lophoc.index', compact('lophoc')); // Trả về
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.lophoc.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tenlop' => 'required|string|max:100',
            'nhomtuoi' => 'required|string|max:50',
            'siso' => 'required|numeric|min:1',
        ]);

        LopHoc::create($request->all());

        return redirect()
            ->route('admin.lophoc.index')
            ->with('success', 'Lớp học đã được thêm thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $lophoc = LopHoc::findOrFail($id);
        return view('admin.lophoc.edit', compact('lophoc'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'tenlop' => 'required|string|max:100',
            'nhomtuoi' => 'required|string|max:50',
            'siso' => 'required|numeric|min:1',
        ]);

        $lophoc = LopHoc::findOrFail($id);
        $lophoc->update($request->all());

        return redirect()
            ->route('admin.lophoc.index')
            ->with('success', 'Lớp học đã được cập nhật thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $lophoc = LopHoc::findOrFail($id);
        $lophoc->delete();

        return redirect()
            ->route('admin.lophoc.index')
            ->with('success', 'Lớp học đã được xóa thành công!');
    }
}
