<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Hocsinh;
use App\Models\DiemDanh;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index()
    {
        $teacher = Auth::user()->giaoVien;

        if (!$teacher) {
            return abort(404, 'Không tìm thấy thông tin giáo viên');
        }

        $lop = $teacher->lophoc;

        // Thống kê học sinh trong lớp
        $tongHocSinh = $lop ? Hocsinh::where('malop', $lop->id)->count() : 0;
        $hocSinhNam = $lop ? Hocsinh::where('malop', $lop->id)->where('gioitinh', 'Nam')->count() : 0;
        $hocSinhNu = $lop ? Hocsinh::where('malop', $lop->id)->where('gioitinh', 'Nữ')->count() : 0;

        // Điểm danh hôm nay
        $today = Carbon::today();
        $danhSachHocSinh = $lop ? Hocsinh::where('malop', $lop->id)->pluck('id') : collect();

        $diemDanhHomNay = DiemDanh::whereDate('ngaydiemdanh', $today)
            ->whereIn('mahocsinh', $danhSachHocSinh)
            ->count();
        $coMatHomNay = DiemDanh::whereDate('ngaydiemdanh', $today)
            ->whereIn('mahocsinh', $danhSachHocSinh)
            ->where('trangthai', 'like', '%có mặt%')
            ->count();
        $vangHomNay = DiemDanh::whereDate('ngaydiemdanh', $today)
            ->whereIn('mahocsinh', $danhSachHocSinh)
            ->where('trangthai', 'like', '%vắng%')
            ->count();

        // Thống kê điểm danh tuần này
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
        $diemDanhTuan = DiemDanh::whereBetween('ngaydiemdanh', [$startOfWeek, $endOfWeek])
            ->whereIn('mahocsinh', $danhSachHocSinh)
            ->count();

        // Danh sách học sinh trong lớp
        $hocsinhs = $lop ? Hocsinh::where('malop', $lop->id)->take(5)->get() : collect();

        return view("teacher.dashboard", compact(
            'teacher',
            'lop',
            'tongHocSinh',
            'hocSinhNam',
            'hocSinhNu',
            'diemDanhHomNay',
            'coMatHomNay',
            'vangHomNay',
            'diemDanhTuan',
            'hocsinhs'
        ));
    }
}
