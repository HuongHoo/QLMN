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

    public function store(Request $request)
    {
        $request->validate([
            'ngay' => 'required|date',
            'mahocsinh' => 'required|array',
            'gioden' => 'required|array',
            'ghichu' => 'nullable|array',
        ]);

        // Lấy thông tin giáo viên đang đăng nhập
        $giaovien = Auth::user()->giaovien;

        if (!$giaovien) {
            return redirect()->back()->with('error', 'Không tìm thấy thông tin giáo viên.');
        }

        // Lấy giờ bắt đầu của lớp
        $lophoc = $giaovien->lophoc;
        $gioBatDau = $lophoc->giobatdau ?? '07:00'; // Giờ bắt đầu lớp

        $mahocsinhArr = $request->mahocsinh;
        $giodenArr = $request->gioden;
        $ghichuArr = $request->ghichu ?? [];

        foreach ($mahocsinhArr as $index => $id) {
            $gioDen = $giodenArr[$index];

            // Tính số phút trễ: giờ đến - giờ bắt đầu
            $sophuttre = 0;
            if ($gioDen) {
                // Chuyển giờ bắt đầu và giờ đến sang phút
                list($h1, $m1) = explode(':', $gioBatDau);
                list($h2, $m2) = explode(':', $gioDen);

                $phutBatDau = ($h1 * 60) + $m1;
                $phutDen = ($h2 * 60) + $m2;

                // Chỉ tính trễ nếu đến muộn hơn giờ quy định
                $sophuttre = max(0, $phutDen - $phutBatDau);
            }

            // Lấy trạng thái từ checkbox (có thể tick nhiều)
            $trangthaiCheckboxName = 'trangthai_' . $id;
            $trangthaiArr = $request->input($trangthaiCheckboxName, []);
            $trangthaiStr = count($trangthaiArr) > 0 ? implode(', ', $trangthaiArr) : 'vắng mặt';

            DiemDanh::updateOrCreate(
                [
                    'mahocsinh' => $id,
                    'ngaydiemdanh' => $request->ngay,
                ],
                [
                    'trangthai' => $trangthaiStr,
                    'gioden' => $gioDen,
                    'sophuttre' => $sophuttre, // Tính toán từ backend
                    'ghichu' => $ghichuArr[$index] ?? null,
                    'magiaovien' => $giaovien->id,  // Lưu mã giáo viên điểm danh
                ]
            );
        }

        return redirect()->back()->with('success', 'Lưu điểm danh thành công!');
    }
}
