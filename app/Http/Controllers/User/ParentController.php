<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\HocSinh;
use App\Models\DiemDanh;
use App\Models\HocPhi;
use App\Models\DanhGia;
use App\Models\SucKhoe;
use App\Models\LopHoc;
use App\Models\HoatDong;
use App\Models\HoatDongHangNgay;
use App\Models\AnhHoatDong;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ParentController extends Controller
{
    private function getParentChildren()
    {
        $user = Auth::user();
        $phuHuynh = $user->phuHuynh;

        if (!$phuHuynh) {
            return collect();
        }

        return HocSinh::where('maphuhuynh', $phuHuynh->id)
            ->with(['lophoc', 'diemdanh', 'suckhoe', 'danhgia'])
            ->get();
    }

    public function index()
    {
        $user = Auth::user();
        $phuHuynh = $user->phuHuynh;
        $children = $this->getParentChildren();

        // Lấy hoạt động hàng ngày của các con
        $hoatDongHangNgays = collect();
        $anhHoatDongs = collect();

        if ($children->isNotEmpty()) {
            $childIds = $children->pluck('id');
            $lopIds = $children->pluck('malop')->unique();

            // Hoạt động hàng ngày hôm nay hoặc mới nhất
            $hoatDongHangNgays = HoatDongHangNgay::whereIn('hocsinh_id', $childIds)
                ->orWhereIn('lophoc_id', $lopIds)
                ->whereNull('hocsinh_id')
                ->with(['anhHoatDongs', 'giaovien', 'hocsinh', 'lophoc'])
                ->orderBy('ngay', 'desc')
                ->orderBy('giobatdau', 'asc')
                ->take(10)
                ->get();

            // Ảnh hoạt động gần đây
            $hoatDongIds = $hoatDongHangNgays->pluck('id');
            $anhHoatDongs = AnhHoatDong::whereIn('hoatdong_hangngay_id', $hoatDongIds)
                ->orderBy('created_at', 'desc')
                ->take(8)
                ->get();
        }

        return view('parent.dashboard', compact('user', 'phuHuynh', 'children', 'hoatDongHangNgays', 'anhHoatDongs'));
    }

    // Trang thông tin bé
    public function thongtinBe()
    {
        $user = Auth::user();
        $phuHuynh = $user->phuHuynh;
        $children = $this->getParentChildren();

        if ($children->isEmpty()) {
            return redirect()->route('parent.home');
        }

        $childrenStats = [];
        $thisMonth = Carbon::now()->month;
        $thisYear = Carbon::now()->year;

        foreach ($children as $child) {
            $childDiemDanh = DiemDanh::where('mahocsinh', $child->id)
                ->whereMonth('ngaydiemdanh', $thisMonth)
                ->whereYear('ngaydiemdanh', $thisYear)
                ->get();

            // Tính học phí còn nợ = tổng tiền - số tiền đã thanh toán
            $hocPhiList = HocPhi::where('mahocsinh', $child->id)->get();
            $tongTien = $hocPhiList->sum('tongtien');
            $daDong = $hocPhiList->sum('dathanhtoan');
            $conNo = $tongTien - $daDong;

            $childrenStats[$child->id] = [
                'coMat' => $childDiemDanh->where('trangthai', 'like', '%có mặt%')->count(),
                'vang' => $childDiemDanh->where('trangthai', 'like', '%vắng%')->count(),
                'hocPhiChuaDong' => $conNo > 0 ? $conNo : 0,
                'latestDanhGia' => DanhGia::where('mahocsinh', $child->id)->orderBy('created_at', 'desc')->first(),
                'latestSucKhoe' => SucKhoe::where('mahocsinh', $child->id)->orderBy('created_at', 'desc')->first(),
            ];
        }

        return view('parent.thongtinbe', compact('user', 'phuHuynh', 'children', 'childrenStats'));
    }

    // Chi tiết từng bé
    public function chiTietBe($id)
    {
        $user = Auth::user();
        $phuHuynh = $user->phuHuynh;
        $children = $this->getParentChildren();

        $child = $children->firstWhere('id', $id);
        if (!$child) {
            return redirect()->route('parent.thongtinbe')->with('error', 'Không tìm thấy thông tin bé');
        }

        $thisMonth = Carbon::now()->month;
        $thisYear = Carbon::now()->year;

        // Điểm danh tháng này
        $diemDanhThang = DiemDanh::where('mahocsinh', $child->id)
            ->whereMonth('ngaydiemdanh', $thisMonth)
            ->whereYear('ngaydiemdanh', $thisYear)
            ->orderBy('ngaydiemdanh', 'desc')
            ->get();

        // Học phí
        $hocPhis = HocPhi::where('mahocsinh', $child->id)->orderBy('created_at', 'desc')->get();

        // Đánh giá
        $danhGias = DanhGia::where('mahocsinh', $child->id)->orderBy('created_at', 'desc')->take(10)->get();

        // Sức khỏe
        $sucKhoes = SucKhoe::where('mahocsinh', $child->id)->orderBy('created_at', 'desc')->take(5)->get();

        return view('parent.chitietbe', compact('user', 'phuHuynh', 'children', 'child', 'diemDanhThang', 'hocPhis', 'danhGias', 'sucKhoes'));
    }

    // Trang điểm danh
    public function diemDanh()
    {
        $user = Auth::user();
        $phuHuynh = $user->phuHuynh;
        $children = $this->getParentChildren();

        if ($children->isEmpty()) {
            return redirect()->route('parent.home');
        }

        $childIds = $children->pluck('id');
        $thisMonth = Carbon::now()->month;
        $thisYear = Carbon::now()->year;

        // Điểm danh hôm nay
        $diemDanhHomNay = DiemDanh::whereDate('ngaydiemdanh', Carbon::today())
            ->whereIn('mahocsinh', $childIds)
            ->get();

        // Điểm danh tháng này
        $diemDanhThang = DiemDanh::whereMonth('ngaydiemdanh', $thisMonth)
            ->whereYear('ngaydiemdanh', $thisYear)
            ->whereIn('mahocsinh', $childIds)
            ->orderBy('ngaydiemdanh', 'desc')
            ->get();

        // Thống kê
        $soNgayCoMat = $diemDanhThang->filter(function ($dd) {
            return str_contains(strtolower($dd->trangthai ?? ''), 'có mặt');
        })->count();
        $soNgayVang = $diemDanhThang->filter(function ($dd) {
            return str_contains(strtolower($dd->trangthai ?? ''), 'vắng');
        })->count();

        return view('parent.diemdanh', compact('user', 'phuHuynh', 'children', 'diemDanhHomNay', 'diemDanhThang', 'soNgayCoMat', 'soNgayVang'));
    }

    // Trang học phí
    public function hocPhi()
    {
        $user = Auth::user();
        $phuHuynh = $user->phuHuynh;
        $children = $this->getParentChildren();

        if ($children->isEmpty()) {
            return redirect()->route('parent.home');
        }

        $childIds = $children->pluck('id');

        $hocPhis = HocPhi::whereIn('mahocsinh', $childIds)
            ->orderBy('created_at', 'desc')
            ->get();

        // dathanhtoan là số tiền đã đóng, không phải boolean
        $tongDaDong = $hocPhis->sum('dathanhtoan');
        $tongTien = $hocPhis->sum('tongtien');
        $tongChuaDong = $tongTien - $tongDaDong;

        return view('parent.hocphi', compact('user', 'phuHuynh', 'children', 'hocPhis', 'tongChuaDong', 'tongDaDong'));
    }

    // Trang đánh giá
    public function danhGia()
    {
        $user = Auth::user();
        $phuHuynh = $user->phuHuynh;
        $children = $this->getParentChildren();

        if ($children->isEmpty()) {
            return redirect()->route('parent.home');
        }

        $childIds = $children->pluck('id');

        // Sắp xếp theo năm tăng dần, sau đó theo tháng tăng dần
        // để phụ huynh thấy được sự phát triển của con theo thời gian
        $danhGias = DanhGia::whereIn('mahocsinh', $childIds)
            ->with('giaovien')
            ->orderBy('nam', 'asc')
            ->orderBy('thang', 'asc')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('parent.danhgia', compact('user', 'phuHuynh', 'children', 'danhGias'));
    }

    // Trang sức khỏe
    public function sucKhoe()
    {
        $user = Auth::user();
        $phuHuynh = $user->phuHuynh;
        $children = $this->getParentChildren();

        if ($children->isEmpty()) {
            return redirect()->route('parent.home');
        }

        $childIds = $children->pluck('id');

        $sucKhoes = SucKhoe::whereIn('mahocsinh', $childIds)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('parent.suckhoe', compact('user', 'phuHuynh', 'children', 'sucKhoes'));
    }

    // Trang public home (cho khách chưa đăng nhập)
    public function home()
    {
        // Lấy danh sách lớp học kèm giáo viên chủ nhiệm (eager load để tránh N+1 query)
        $lopHocs = LopHoc::with('giaovien')->get();

        // Lấy hoạt động để hiển thị gallery
        $hoatDongs = HoatDong::hienThi()
            ->orderBy('thutu', 'asc')
            ->orderBy('ngay', 'desc')
            ->take(9)
            ->get();

        return view('parent.home', compact('lopHocs', 'hoatDongs'));
    }
}
