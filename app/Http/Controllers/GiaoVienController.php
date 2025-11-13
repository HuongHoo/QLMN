<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GiaoVien;
use App\Models\LopHoc;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class GiaoVienController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $giaovien = GiaoVien::with('lophoc')->paginate(10);
        return view('admin.giaovien.index', compact('giaovien'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $giaovien = new GiaoVien();
        $lophoc = LopHoc::all();
        return view('admin.giaovien.create', compact('giaovien', 'lophoc'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'sothe',
            'tengiaovien',
            'ngaysinh' => 'required|date',
            'gioitinh' => 'required|in:nam,nữ,khác',
            'diachithuongtru',
            'diachitamtru',
            'sdt',
            'email' => 'required|email|unique:users,email',
            'chucvu' => 'required|in:giáo viên,hiệu trưởng,hiệu phó',
            'trangthai',
            'anh' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);

        // Tạo user
        $user = User::create([
            'name' => $request->tengiaovien,
            'vaitro' => 'teacher',
            'email' => $request->email,
            'password' => Hash::make('12345678'),
        ]);

        // Xử lý ảnh nếu có
        $fileName = null;
        if ($request->hasFile('anh')) {
            $fileName = $request->file('anh')->store('giaovien', 'public');
        }

        // Tạo giáo viên
        GiaoVien::create([
            'sothe' => $request->sothe,
            'tengiaovien' => $request->tengiaovien,
            'ngaysinh' => $request->ngaysinh,
            'gioitinh' => $request->gioitinh,
            'diachithuongtru' => $request->diachithuongtru,
            'diachitamtru' => $request->diachitamtru,
            'sdt' => $request->sdt,
            'email' => $request->email,
            'chucvu' => $request->chucvu,
            'trangthai' => $request->trangthai,
            'malopchunhiem' => $request->malopchunhiem,
            'cccd' => $request->cccd,
            'ngayvaolam' => $request->ngayvaolam,
            'anh' => $fileName,
            'user_id' => $user->id,
        ]);

        return redirect()->route('admin.giaovien.index')->with('success', 'Thêm giáo viên thành công.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $giaovien = GiaoVien::findOrFail($id);
        $lophoc = LopHoc::all();
        return view('admin.giaovien.edit', compact('giaovien', 'lophoc'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $giaoVien = GiaoVien::findOrFail($id);
        $user = $giaoVien->user;

        // Validate dữ liệu
        $request->validate([
            'sothe',
            'tengiaovien',
            'ngaysinh' => 'required|date',
            'gioitinh' => 'required|in:nam,nữ,khác',
            'diachithuongtru',
            'diachitamtru',
            'sdt',
            'email' => [

                'email',
                Rule::unique('users', 'email')->ignore($user->id),
                Rule::unique('giaovien', 'email')->ignore($giaoVien->id),
            ],
            'chucvu' => 'required|in:giáo viên,hiệu trưởng,hiệu phó',
            'trangthai',
            'anh' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);

        // Cập nhật hoặc tạo user liên kết
        if ($user) {
            $user->update([
                'name' => $request->tengiaovien,
                'email' => $request->email,
            ]);
        } else {
            // kiểm tra email tồn tại trước khi tạo
            if (User::where('email', $request->email)->exists()) {
                return back()->withErrors(['email' => 'Email này đã tồn tại trong hệ thống'])->withInput();
            }

            $user = User::create([
                'name' => $request->tengiaovien,
                'email' => $request->email,
                'password' => Hash::make('12345678'),
            ]);
            $giaoVien->user_id = $user->id;
        }

        // Xử lý ảnh
        $fileName = $giaoVien->anh;
        if ($request->hasFile('anh')) {
            if ($fileName && Storage::disk('public')->exists($fileName)) {
                Storage::disk('public')->delete($fileName);
            }
            $fileName = $request->file('anh')->store('giaovien', 'public');
        }

        // Cập nhật giáo viên
        $giaoVien->update([
            'sothe' => $request->sothe,
            'tengiaovien' => $request->tengiaovien,
            'ngaysinh' => $request->ngaysinh,
            'gioitinh' => $request->gioitinh,
            'diachithuongtru' => $request->diachithuongtru,
            'diachitamtru' => $request->diachitamtru,
            'sdt' => $request->sdt,
            'email' => $request->email,
            'chucvu' => $request->chucvu,
            'trangthai' => $request->trangthai,
            'malopchunhiem' => $request->malopchunhiem,
            'cccd' => $request->cccd,
            'ngayvaolam' => $request->ngayvaolam,
            'anh' => $fileName,
        ]);

        $giaoVien->save(); // lưu user_id nếu mới tạo

        return redirect()->route('admin.giaovien.index')->with('success', 'Cập nhật giáo viên thành công.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $giaoVien = GiaoVien::findOrFail($id);

        // Xóa ảnh nếu có
        if ($giaoVien->anh && Storage::disk('public')->exists($giaoVien->anh)) {
            Storage::disk('public')->delete($giaoVien->anh);
        }

        // Xóa user liên kết nếu muốn
        if ($giaoVien->user) {
            $giaoVien->user->delete();
        }

        $giaoVien->delete();

        return redirect()->route('admin.giaovien.index')->with('success', 'Xóa giáo viên thành công.');
    }
}
