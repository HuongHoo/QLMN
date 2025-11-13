<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\HocSinh;
use App\Models\LopHoc;
use App\Models\PhuHuynh;



class HocSinhController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hocsinh = HocSinh::with(['lophoc', 'phuhuynh'])->paginate(10);

        return view('admin.hocsinh.index', compact('hocsinh'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $lophoc = LopHoc::all();
        $phuhuynh = PhuHuynh::all();

        return view('admin.hocsinh.create', compact('lophoc', 'phuhuynh'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'mathe' => 'required|unique:hocsinh,mathe|max:20',
            'tenhocsinh' => 'required|max:100',
            'ngaysinh' => 'required|date',
            'gioitinh' => 'required|in:nam,nữ',
            'malop' => 'nullable|exists:lophoc,id',
            'maphuhuynh' => 'nullable|exists:phuhuynh,id',
        ]);

        $data = $request->all();

        // Xử lý ảnh nếu có upload
        if ($request->hasFile('anh')) {
            $file = $request->file('anh');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/anh_hocsinh'), $fileName);
            $data['anh'] = 'uploads/anh_hocsinh/' . $fileName;
        }

        HocSinh::create($data);

        return redirect()->route('admin.hocsinh.index')->with('success', 'Thêm học sinh thành công!');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $hocsinh = HocSinh::where('tenhocsinh', 'like', '%' . $query . '%')->get();

        return view('admin.hocsinh.index', compact('hocsinh'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $hocsinh = HocSinh::findOrFail($id);
        $lophoc = LopHoc::all();
        $phuhuynh = PhuHuynh::all();

        return view('admin.hocsinh.edit', compact('hocsinh', 'lophoc', 'phuhuynh'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $hocsinh = HocSinh::findOrFail($id);

        $request->validate([
            'mathe' => 'required|max:20|unique:hocsinh,mathe,' . $id,
            'tenhocsinh' => 'required|max:100',
            'ngaysinh' => 'required|date',
            'gioitinh' => 'required|in:nam,nữ',
            'diachithuongtru' => 'nullable|max:255',
            'diachitamtru' => 'nullable|max:255',
            'malop' => 'nullable|exists:lophoc,id',
            'maphuhuynh' => 'nullable|exists:phuhuynh,id',
            'anh' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'ghichusuckhoe' => 'nullable|max:255',
        ]);

        $data = $request->all();

        // Cập nhật ảnh nếu có
        if ($request->hasFile('anh')) {
            $file = $request->file('anh');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/anh_hocsinh'), $fileName);
            $data['anh'] = 'uploads/anh_hocsinh/' . $fileName;
        }

        $hocsinh->update($data);

        return redirect()->route('admin.hocsinh.index')->with('success', 'Cập nhật học sinh thành công!');
    }

    public function destroy(string $id)
    {
        $hocsinh = HocSinh::findOrFail($id);
        $hocsinh->delete();

        return redirect()->route('admin.hocsinh.index')->with('success', 'Xóa học sinh thành công!');
    }
}
