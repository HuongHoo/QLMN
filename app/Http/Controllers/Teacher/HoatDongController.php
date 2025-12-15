<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\HoatDongHangNgay;
use App\Models\AnhHoatDong;
use App\Models\HocSinh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class HoatDongController extends Controller
{
    /**
     * Hiển thị danh sách hoạt động đã đăng
     */
    public function index(Request $request)
    {
        $teacher = Auth::user()->giaoVien;
        if (!$teacher) {
            return abort(404, 'Không tìm thấy thông tin giáo viên');
        }

        $lop = $teacher->lophoc;
        if (!$lop) {
            return redirect()->route('teacher.dashboard')->with('error', 'Bạn chưa được phân công lớp');
        }

        // Lọc theo ngày
        $ngay = $request->get('ngay', Carbon::today()->format('Y-m-d'));

        $hoatDongs = HoatDongHangNgay::where('lophoc_id', $lop->id)
            ->whereDate('ngay', $ngay)
            ->with(['anhHoatDongs', 'hocsinh', 'giaovien'])
            ->orderBy('giobatdau', 'asc')
            ->get();

        // Danh sách học sinh trong lớp
        $hocsinhs = HocSinh::where('malop', $lop->id)->get();

        return view('teacher.hoatdong.index', compact('teacher', 'lop', 'hoatDongs', 'hocsinhs', 'ngay'));
    }

    /**
     * Form tạo hoạt động mới
     */
    public function create()
    {
        $teacher = Auth::user()->giaoVien;
        if (!$teacher) {
            return abort(404, 'Không tìm thấy thông tin giáo viên');
        }

        $lop = $teacher->lophoc;
        if (!$lop) {
            return redirect()->route('teacher.dashboard')->with('error', 'Bạn chưa được phân công lớp');
        }

        $hocsinhs = HocSinh::where('malop', $lop->id)->get();

        return view('teacher.hoatdong.create', compact('teacher', 'lop', 'hocsinhs'));
    }

    /**
     * Lưu hoạt động mới
     */
    public function store(Request $request)
    {
        $request->validate([
            'tieude' => 'required|string|max:255',
            'mota' => 'nullable|string',
            'loai' => 'required|in:gioian,hoctap,ngoaitroi,nghingoi,khac',
            'giobatdau' => 'required',
            'gioketthuc' => 'required',
            'ngay' => 'required|date',
            'hocsinh_ids' => 'nullable|array',
            'hocsinh_ids.*' => 'exists:hocsinh,id',
            'anh.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $teacher = Auth::user()->giaoVien;
        $lop = $teacher->lophoc;

        // Nếu chọn tất cả học sinh hoặc không chọn ai cụ thể -> hoạt động cho cả lớp
        $hocsinhIds = $request->hocsinh_ids ?? [];

        if (empty($hocsinhIds) || $request->has('tat_ca_lop')) {
            // Tạo 1 hoạt động cho cả lớp (không gắn với học sinh cụ thể)
            $hoatDong = HoatDongHangNgay::create([
                'lophoc_id' => $lop->id,
                'giaovien_id' => $teacher->id,
                'hocsinh_id' => null, // Null = cả lớp
                'tieude' => $request->tieude,
                'mota' => $request->mota,
                'loai' => $request->loai,
                'giobatdau' => $request->giobatdau,
                'gioketthuc' => $request->gioketthuc,
                'ngay' => $request->ngay,
            ]);

            // Upload ảnh
            if ($request->hasFile('anh')) {
                foreach ($request->file('anh') as $file) {
                    $path = $file->store('hoatdong/' . Carbon::parse($request->ngay)->format('Y-m-d'), 'public');
                    AnhHoatDong::create([
                        'hoatdong_hangngay_id' => $hoatDong->id,
                        'anh' => $path,
                        'mota' => $request->tieude,
                    ]);
                }
            }
        } else {
            // Tạo hoạt động cho từng học sinh được chọn
            foreach ($hocsinhIds as $hocsinhId) {
                $hoatDong = HoatDongHangNgay::create([
                    'lophoc_id' => $lop->id,
                    'giaovien_id' => $teacher->id,
                    'hocsinh_id' => $hocsinhId,
                    'tieude' => $request->tieude,
                    'mota' => $request->mota,
                    'loai' => $request->loai,
                    'giobatdau' => $request->giobatdau,
                    'gioketthuc' => $request->gioketthuc,
                    'ngay' => $request->ngay,
                ]);

                // Upload ảnh cho mỗi hoạt động
                if ($request->hasFile('anh')) {
                    foreach ($request->file('anh') as $file) {
                        $path = $file->store('hoatdong/' . Carbon::parse($request->ngay)->format('Y-m-d'), 'public');
                        AnhHoatDong::create([
                            'hoatdong_hangngay_id' => $hoatDong->id,
                            'anh' => $path,
                            'mota' => $request->tieude,
                        ]);
                    }
                }
            }
        }

        return redirect()->route('teacher.hoatdong.index')
            ->with('success', 'Đã đăng hoạt động thành công! Phụ huynh sẽ thấy được ảnh này.');
    }

    /**
     * Xem chi tiết hoạt động
     */
    public function show($id)
    {
        $teacher = Auth::user()->giaoVien;
        $hoatDong = HoatDongHangNgay::with(['anhHoatDongs', 'hocsinh', 'lophoc', 'giaovien'])
            ->where('giaovien_id', $teacher->id)
            ->findOrFail($id);

        return view('teacher.hoatdong.show', compact('hoatDong', 'teacher'));
    }

    /**
     * Xóa hoạt động
     */
    public function destroy($id)
    {
        $teacher = Auth::user()->giaoVien;
        $hoatDong = HoatDongHangNgay::where('giaovien_id', $teacher->id)->findOrFail($id);

        // Xóa ảnh
        foreach ($hoatDong->anhHoatDongs as $anh) {
            Storage::disk('public')->delete($anh->anh);
            $anh->delete();
        }

        $hoatDong->delete();

        return redirect()->route('teacher.hoatdong.index')
            ->with('success', 'Đã xóa hoạt động thành công!');
    }

    /**
     * Đăng nhanh ảnh (AJAX)
     */
    public function dangNhanhAnh(Request $request)
    {
        $request->validate([
            'anh' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
            'mota' => 'nullable|string|max:255',
            'loai' => 'required|in:gioian,hoctap,ngoaitroi,nghingoi,khac',
        ]);

        $teacher = Auth::user()->giaoVien;
        $lop = $teacher->lophoc;

        if (!$lop) {
            return response()->json(['error' => 'Bạn chưa được phân công lớp'], 400);
        }

        // Tạo hoạt động
        $hoatDong = HoatDongHangNgay::create([
            'lophoc_id' => $lop->id,
            'giaovien_id' => $teacher->id,
            'hocsinh_id' => null,
            'tieude' => $request->mota ?? 'Hoạt động ' . Carbon::now()->format('H:i'),
            'mota' => $request->mota,
            'loai' => $request->loai,
            'giobatdau' => Carbon::now()->format('H:i'),
            'gioketthuc' => Carbon::now()->addHour()->format('H:i'),
            'ngay' => Carbon::today(),
        ]);

        // Upload ảnh
        $path = $request->file('anh')->store('hoatdong/' . Carbon::today()->format('Y-m-d'), 'public');
        $anhHoatDong = AnhHoatDong::create([
            'hoatdong_hangngay_id' => $hoatDong->id,
            'anh' => $path,
            'mota' => $request->mota,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Đã đăng ảnh thành công!',
            'anh_url' => asset('storage/' . $path),
        ]);
    }
}
