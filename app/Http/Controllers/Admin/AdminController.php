<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HocSinh;
use App\Models\GiaoVien;
use App\Models\LopHoc;
use App\Models\PhuHuynh;
use App\Models\HocPhi;
use App\Models\DiemDanh;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // Thống kê tổng quan
        $tongHocSinh = HocSinh::count();
        $tongGiaoVien = GiaoVien::count();
        $tongLopHoc = LopHoc::count();
        $tongPhuHuynh = PhuHuynh::count();

        // Thống kê học sinh theo giới tính
        $hocSinhNam = HocSinh::where('gioitinh', 'Nam')->count();
        $hocSinhNu = HocSinh::where('gioitinh', 'Nữ')->count();

        // Thống kê giáo viên theo trạng thái
        $giaoVienDangLam = GiaoVien::where('trangthai', 'Đang công tác')->count();
        $giaoVienNghiViec = GiaoVien::where('trangthai', 'Nghỉ việc')->count();

        // Thống kê học phí (cột: tongtien, dathanhtoan)
        $hocPhiDaThu = HocPhi::where('dathanhtoan', 1)->sum('tongtien');
        $hocPhiChuaThu = HocPhi::where('dathanhtoan', 0)->sum('tongtien');

        // Thống kê học sinh theo lớp
        $lopHocStats = LopHoc::withCount('hocsinh')->get();

        // Điểm danh hôm nay (cột: ngaydiemdanh)
        $today = Carbon::today();
        $diemDanhHomNay = DiemDanh::whereDate('ngaydiemdanh', $today)->count();
        $coMatHomNay = DiemDanh::whereDate('ngaydiemdanh', $today)->where('trangthai', 'like', '%có mặt%')->count();
        $vangHomNay = DiemDanh::whereDate('ngaydiemdanh', $today)->where('trangthai', 'like', '%vắng%')->count();

        return view("admin.dashboard", compact(
            'tongHocSinh',
            'tongGiaoVien',
            'tongLopHoc',
            'tongPhuHuynh',
            'hocSinhNam',
            'hocSinhNu',
            'giaoVienDangLam',
            'giaoVienNghiViec',
            'hocPhiDaThu',
            'hocPhiChuaThu',
            'lopHocStats',
            'diemDanhHomNay',
            'coMatHomNay',
            'vangHomNay'
        ));
    }
}
