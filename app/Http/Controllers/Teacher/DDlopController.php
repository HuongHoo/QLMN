<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Hocsinh;
use App\Models\DiemDanh;
use App\Models\LopHoc;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DDlopController extends Controller
{
    public function index()
    {
        $giaovien = Auth::user()->giaovien;  // giáo viên đăng nhập (fix: giaoVien not giaovien)

        if (!$giaovien) {
            return abort(404, 'Không tìm thấy thông tin giáo viên. Vui lòng liên hệ admin.');
        }

        $lophoc = $giaovien->lophoc;  // lớp chủ nhiệm

        if (!$lophoc) {
            return abort(404, 'Giáo viên chưa được phân công lớp chủ nhiệm.');
        }

        $gioVaoHoc = $lophoc->giobatdau ?? '07:00';  // giờ vào học lớp
        // danh sách học sinh
        $hocsinh = $lophoc->hocsinh()->orderBy('tenhocsinh')->get();
        return view('teacher.diemdanh.index', compact('hocsinh', 'gioVaoHoc'));
    }
    public function history()
    {
        $giaovien = Auth::user()->giaovien;
        if (!$giaovien) {
            return abort(404, 'Không tìm thấy thông tin giáo viên.');
        }

        $lophoc = $giaovien->lophoc;  // lớp chủ nhiệm
        if (!$lophoc) {
            return abort(404, 'Giáo viên chưa được phân công lớp chủ nhiệm.');
        }

        // Lấy tổng số học sinh trong lớp
        $tongHocSinh = $lophoc->hocsinh()->count();

        // Lấy lịch sử điểm danh của lớp với thống kê
        $danhSachNgay = DiemDanh::where('magiaovien', $giaovien->id)
            ->select('ngaydiemdanh')
            ->distinct()
            ->orderBy('ngaydiemdanh', 'desc')
            ->get();

        // Thêm thống kê cho từng ngày
        $diemdanh = $danhSachNgay->map(function ($item) use ($giaovien) {
            $ngay = $item->ngaydiemdanh;
            $records = DiemDanh::where('magiaovien', $giaovien->id)
                ->where('ngaydiemdanh', $ngay)
                ->get();

            return (object)[
                'ngaydiemdanh' => $ngay,
                'coMat' => $records->where('trangthai', 'có mặt')->count(),
                'vangMat' => $records->where('trangthai', 'vắng mặt')->count(),
                'nghiPhep' => $records->where('trangthai', 'nghỉ phép')->count(),
                'tre' => $records->where('trangthai', 'trễ')->count(),
                'tongSo' => $records->count(),
            ];
        });

        return view('teacher.diemdanh.history', compact('diemdanh', 'lophoc', 'tongHocSinh'));
    }

    public function history_detail($date)
    {
        $giaovien = Auth::user()->giaovien;
        if (!$giaovien) {
            return abort(404, 'Không tìm thấy thông tin giáo viên.');
        }

        $lophoc = $giaovien->lophoc;  // lớp chủ nhiệm
        if (!$lophoc) {
            return abort(404, 'Giáo viên chưa được phân công lớp chủ nhiệm.');
        }


        // Lấy lịch sử điểm danh của lớp
        $diemdanh = DiemDanh::where('magiaovien', $giaovien->id)
            ->where('ngaydiemdanh', $date)
            ->orderBy('id', 'desc')
            ->get();

        return view('teacher.diemdanh.history-detail', compact('diemdanh', 'lophoc'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'ngaydiemdanh' => 'required|date',
            'mahocsinh' => 'required|array',
            'ghichu' => 'nullable|array',
        ]);

        // Lấy thông tin giáo viên đang đăng nhập
        $giaovien = Auth::user()->giaovien;

        if (!$giaovien) {
            return redirect()->back()->with('error', 'Không tìm thấy thông tin giáo viên.');
        }

        $mahocsinhArr = $request->mahocsinh;
        $trangthaiArr = $request->trangthai;
        $ghichuArr = $request->ghichu ?? [];

        foreach ($mahocsinhArr as $index => $id) {

            // Lấy trạng thái từ checkbox (có thể tick nhiều)
            $trangthaiCheckboxName = 'trangthai_' . $id;
            $trangthaiArr = $request->input($trangthaiCheckboxName, []);
            $trangthaiStr = count($trangthaiArr) > 0 ? implode(', ', $trangthaiArr) : 'vắng mặt';

            DiemDanh::updateOrCreate(
                [
                    'mahocsinh' => $id,
                    'ngaydiemdanh' => $request->ngaydiemdanh,
                ],
                [
                    'trangthai' => $trangthaiStr,
                    'ghichu' => $ghichuArr[$index] ?? null,
                    'magiaovien' => $giaovien->id,  // Lưu mã giáo viên điểm danh
                ]
            );
        }

        return redirect()->back()->with('success', 'Lưu điểm danh thành công!');
    }

    public function edit($date)
    {
        $giaovien = Auth::user()->giaovien;
        if (!$giaovien) {
            return abort(404, 'Không tìm thấy thông tin giáo viên.');
        }

        $lophoc = $giaovien->lophoc;
        if (!$lophoc) {
            return abort(404, 'Giáo viên chưa được phân công lớp chủ nhiệm.');
        }

        $gioVaoHoc = $lophoc->giobatdau ?? '07:00';

        // Lấy danh sách điểm danh của ngày này
        $diemdanhRecords = DiemDanh::where('magiaovien', $giaovien->id)
            ->where('ngaydiemdanh', $date)
            ->get()
            ->keyBy('mahocsinh'); // key by mahocsinh để dễ lookup

        // Lấy tất cả học sinh trong lớp
        $hocsinh = $lophoc->hocsinh()->orderBy('tenhocsinh')->get();

        return view('teacher.diemdanh.edit', compact('hocsinh', 'gioVaoHoc', 'diemdanhRecords', 'date'));
    }

    public function update(Request $request, $date)
    {
        $request->validate([
            'mahocsinh' => 'required|array',
            'ghichu' => 'nullable|array',
        ]);

        $giaovien = Auth::user()->giaovien;
        if (!$giaovien) {
            return redirect()->back()->with('error', 'Không tìm thấy thông tin giáo viên.');
        }

        $mahocsinhArr = $request->mahocsinh;
        $ghichuArr = $request->ghichu ?? [];

        foreach ($mahocsinhArr as $index => $id) {
            $trangthaiCheckboxName = 'trangthai_' . $id;
            $trangthaiArr = $request->input($trangthaiCheckboxName, []);
            $trangthaiStr = count($trangthaiArr) > 0 ? implode(', ', $trangthaiArr) : 'vắng mặt';

            DiemDanh::updateOrCreate(
                [
                    'mahocsinh' => $id,
                    'ngaydiemdanh' => $date,
                ],
                [
                    'trangthai' => $trangthaiStr,
                    'ghichu' => $ghichuArr[$index] ?? null,
                    'magiaovien' => $giaovien->id,
                ]
            );
        }

        return redirect()->route('teacher.diemdanh.history')->with('success', 'Cập nhật điểm danh thành công!');
    }
}
