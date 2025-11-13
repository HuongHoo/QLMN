<?php

namespace App\Http\Controllers;

use App\Models\DiemDanh;
use App\Models\GiaoVien;
use App\Models\HocSinh;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class DiemDanhController extends Controller
{
    /**
     * Hiển thị danh sách điểm danh (dạng bảng nhiều ngày / nhiều học sinh)
     */
    public function index(Request $request)
    {
        // Lấy start/end từ query nếu có, nếu không thì mặc định là tuần hiện tại
        $start = $request->start
            ? \Carbon\Carbon::parse($request->start)
            : \Carbon\Carbon::now()->startOfWeek(); // bắt đầu tuần hiện tại (thứ 2)

        $end = $start->copy()->addDays(6); // 7 ngày liên tiếp

        $ngayList = collect();
        for ($i = 0; $i < 7; $i++) {
            $ngayList->push($start->copy()->addDays($i));
        }

        $hocsinhList = HocSinh::with('lophoc', 'diemdanh')->paginate(20);

        return view('admin.diemdanh.index', compact('hocsinhList', 'ngayList', 'start', 'end'));
    }

    /**
     * Form thêm mới
     */
    public function create()
    {
        $hocsinh = HocSinh::with('lophoc')->get();
        $giaovien = GiaoVien::all();

        return view('admin.diemdanh.create', compact('hocsinh', 'giaovien'));
    }

    /**
     * Lưu dữ liệu điểm danh
     */
    public function store(Request $request)
    {
        $request->validate([
            'mahocsinh' => 'required|exists:hocsinh,id',
            'magiaovien' => 'required|exists:giaovien,id',
            'ngaydiemdanh' => 'required|date',
            'trangthai' => 'required|in:có mặt,vắng mặt,nghỉ phép,trễ',
            'gioden' => 'nullable|date_format:H:i',
            'giove' => 'nullable|date_format:H:i|after_or_equal:gioden',
            'lydo' => 'nullable|max:255',
            'tepdinhkem' => 'nullable|max:255',
            'nhietdo' => 'nullable|numeric|min:35|max:42',
            'ghichu' => 'nullable|max:500',
        ]);

        $hocsinh = HocSinh::with('lophoc')->findOrFail($request->mahocsinh);
        $giobatdau = $hocsinh->lophoc ? Carbon::parse($hocsinh->lophoc->giobatdau) : null;
        $gioden = $request->gioden ? Carbon::parse($request->gioden) : null;

        $sophuttre = 0;
        $trangthai = $request->trangthai;

        if ($giobatdau && $gioden && $gioden->gt($giobatdau)) {
            $sophuttre = $giobatdau->diffInMinutes($gioden);
            $trangthai = 'trễ';
        }

        DiemDanh::create([
            'mahocsinh' => $request->mahocsinh,
            'magiaovien' => $request->magiaovien,
            'ngaydiemdanh' => $request->ngaydiemdanh,
            'gioden' => $gioden ? $gioden->format('H:i') : null,
            'giove' => $request->giove ? Carbon::parse($request->giove)->format('H:i') : null,
            'lydo' => $request->lydo,
            'sophuttre' => $sophuttre,
            'trangthai' => $trangthai,
            'tepdinhkem' => $request->tepdinhkem,
            'nhietdo' => $request->nhietdo,
            'ghichu' => $request->ghichu,
        ]);

        return redirect()->route('admin.diemdanh.index')->with('success', 'Thêm điểm danh thành công!');
    }
    public function show(string $id)
    {
        $hocsinh = HocSinh::with('lophoc', 'diemdanh')->findOrFail($id);

        return view('admin.diemdanh.show', compact('hocsinh'));
    }
    /**
     * Form sửa điểm danh
     */
    public function edit(string $id)
    {
        $diemdanh = DiemDanh::findOrFail($id);
        $hocsinh = HocSinh::with('lophoc')->get();
        $giaovien = GiaoVien::all();

        return view('admin.diemdanh.edit', compact('diemdanh', 'hocsinh', 'giaovien'));
    }

    /**
     * Cập nhật điểm danh
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'mahocsinh' => 'required|exists:hocsinh,id',
            'magiaovien' => 'required|exists:giaovien,id',
            'ngaydiemdanh' => 'required|date',
            'trangthai' => 'required|in:có mặt,vắng mặt,nghỉ phép,trễ',
            'gioden' => 'nullable|date_format:H:i',
            'giove' => 'nullable|date_format:H:i|after_or_equal:gioden',
            'lydo' => 'nullable|max:255',
            'tepdinhkem' => 'nullable|max:255',
            'nhietdo' => 'nullable|numeric|min:35|max:42',
            'ghichu' => 'nullable|max:500',
        ]);

        $diemdanh = DiemDanh::findOrFail($id);
        $hocsinh = HocSinh::with('lophoc')->findOrFail($request->mahocsinh);
        $giobatdau = $hocsinh->lophoc ? Carbon::parse($hocsinh->lophoc->giobatdau) : null;
        $gioden = $request->gioden ? Carbon::parse($request->gioden) : null;

        $sophuttre = 0;
        $trangthai = $request->trangthai;

        if ($giobatdau && $gioden && $gioden->gt($giobatdau)) {
            $sophuttre = $giobatdau->diffInMinutes($gioden);
            $trangthai = 'trễ';
        }

        $diemdanh->update([
            'mahocsinh' => $request->mahocsinh,
            'magiaovien' => $request->magiaovien,
            'ngaydiemdanh' => $request->ngaydiemdanh,
            'gioden' => $gioden ? $gioden->format('H:i') : null,
            'giove' => $request->giove ? Carbon::parse($request->giove)->format('H:i') : null,
            'lydo' => $request->lydo,
            'sophuttre' => $sophuttre,
            'trangthai' => $trangthai,
            'tepdinhkem' => $request->tepdinhkem,
            'nhietdo' => $request->nhietdo,
            'ghichu' => $request->ghichu,
        ]);

        return redirect()->route('admin.diemdanh.index')->with('success', 'Cập nhật điểm danh thành công!');
    }

    /**
     * Xóa điểm danh
     */
    public function destroy(string $id)
    {
        $diemdanh = DiemDanh::findOrFail($id);
        $diemdanh->delete();

        return redirect()->route('admin.diemdanh.index')->with('success', 'Xóa điểm danh thành công!');
    }
}
