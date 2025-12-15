<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Hocsinh;
use App\Models\PhuHuynh;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class QuanlyhocsinhController extends Controller
{
    public function index()
    {
        $teacher = Auth::user()->giaoVien;
        $lophoc = $teacher->lophoc;
        $hocsinhs = Hocsinh::where('malop', $lophoc->id)->get();
        return view("teacher.hocsinh.index", compact('hocsinhs', 'lophoc', 'teacher'));
    }

    public function show($id)
    {
        $teacher = Auth::user()->giaoVien;
        $lophoc = $teacher->lophoc;

        // Chỉ cho phép xem học sinh trong lớp mình chủ nhiệm
        $hocsinh = Hocsinh::where('malop', $lophoc->id)->findOrFail($id);

        return view("teacher.hocsinh.show", compact('hocsinh', 'lophoc', 'teacher'));
    }

    public function edit($id)
    {
        $teacher = Auth::user()->giaoVien;
        $lophoc = $teacher->lophoc;

        // Chỉ cho phép sửa học sinh trong lớp mình chủ nhiệm
        $hocsinh = Hocsinh::where('malop', $lophoc->id)->findOrFail($id);
        $phuhuynh = PhuHuynh::all();

        return view("teacher.hocsinh.edit", compact('hocsinh', 'lophoc', 'teacher', 'phuhuynh'));
    }

    public function update(Request $request, $id)
    {
        $teacher = Auth::user()->giaoVien;
        $lophoc = $teacher->lophoc;

        // Chỉ cho phép cập nhật học sinh trong lớp mình chủ nhiệm
        $hocsinh = Hocsinh::where('malop', $lophoc->id)->findOrFail($id);

        $data = $request->validate([
            'tenhocsinh' => 'required|string|max:255',
            'ngaysinh' => 'nullable|date',
            'gioitinh' => 'nullable|in:Nam,Nữ',
            'diachithuongtru' => 'nullable|string',
            'diachitamtru' => 'nullable|string',
            'maphuhuynh' => 'nullable|exists:phuhuynh,id',
            'ghichusuckhoe' => 'nullable|string',
        ]);

        // Xử lý upload ảnh nếu có
        if ($request->hasFile('anh')) {
            $file = $request->file('anh');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/hocsinh'), $filename);
            $data['anh'] = 'uploads/hocsinh/' . $filename;
        }

        $hocsinh->update($data);

        return redirect()->route('teacher.hocsinh.index')
            ->with('success', 'Cập nhật thông tin học sinh thành công!');
    }
}
