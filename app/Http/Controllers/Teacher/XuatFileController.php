<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\HocSinh;
use App\Models\HocPhi;
use App\Models\DanhGia;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class XuatFileController extends Controller
{
    /**
     * Trang danh sách xuất file
     */
    public function index()
    {
        $teacher = Auth::user()->giaoVien;
        if (!$teacher) {
            return abort(404, 'Không tìm thấy thông tin giáo viên');
        }

        $lop = $teacher->lophoc;
        if (!$lop) {
            return redirect()->route('teacher.dashboard')->with('error', 'Bạn chưa được phân công lớp');
        }

        $hocsinhs = HocSinh::where('malop', $lop->id)->with(['hocphi', 'danhgia'])->get();

        return view('teacher.xuatfile.index', compact('teacher', 'lop', 'hocsinhs'));
    }

    /**
     * Xuất PDF học phí của 1 học sinh
     */
    public function xuatHocPhiHocSinh($id)
    {
        $teacher = Auth::user()->giaoVien;
        $lop = $teacher->lophoc;

        $hocsinh = HocSinh::where('malop', $lop->id)->findOrFail($id);
        $hocphis = HocPhi::where('mahocsinh', $id)->orderBy('created_at', 'desc')->get();

        $tongTien = $hocphis->sum('tongtien');
        $daDong = $hocphis->sum('dathanhtoan');
        $conNo = $tongTien - $daDong;

        $data = [
            'hocsinh' => $hocsinh,
            'hocphis' => $hocphis,
            'lop' => $lop,
            'teacher' => $teacher,
            'tongTien' => $tongTien,
            'daDong' => $daDong,
            'conNo' => $conNo,
            'ngayXuat' => Carbon::now()->format('d/m/Y H:i'),
        ];

        $pdf = Pdf::loadView('teacher.xuatfile.hocphi-pdf', $data);
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download('hocphi_' . $hocsinh->hoten . '_' . date('Y-m-d') . '.pdf');
    }

    /**
     * Xuất PDF học phí cả lớp
     */
    public function xuatHocPhiLop()
    {
        $teacher = Auth::user()->giaoVien;
        $lop = $teacher->lophoc;

        $hocsinhs = HocSinh::where('malop', $lop->id)->with('hocphi')->get();

        $danhSachHocPhi = [];
        $tongTienLop = 0;
        $tongDaDongLop = 0;

        foreach ($hocsinhs as $hs) {
            $tongTien = $hs->hocphi->sum('tongtien');
            $daDong = $hs->hocphi->sum('dathanhtoan');
            $conNo = $tongTien - $daDong;

            $danhSachHocPhi[] = [
                'hocsinh' => $hs,
                'tongTien' => $tongTien,
                'daDong' => $daDong,
                'conNo' => $conNo,
            ];

            $tongTienLop += $tongTien;
            $tongDaDongLop += $daDong;
        }

        $data = [
            'danhSachHocPhi' => $danhSachHocPhi,
            'lop' => $lop,
            'teacher' => $teacher,
            'tongTienLop' => $tongTienLop,
            'tongDaDongLop' => $tongDaDongLop,
            'tongConNoLop' => $tongTienLop - $tongDaDongLop,
            'ngayXuat' => Carbon::now()->format('d/m/Y H:i'),
        ];

        $pdf = Pdf::loadView('teacher.xuatfile.hocphi-lop-pdf', $data);
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('hocphi_lop_' . $lop->tenlop . '_' . date('Y-m-d') . '.pdf');
    }

    /**
     * Xuất PDF đánh giá của 1 học sinh
     */
    public function xuatDanhGiaHocSinh($id, Request $request)
    {
        $teacher = Auth::user()->giaoVien;
        $lop = $teacher->lophoc;

        $hocsinh = HocSinh::where('malop', $lop->id)->findOrFail($id);

        // Lọc theo năm nếu có
        $nam = $request->get('nam', date('Y'));
        $thang = $request->get('thang');

        $query = DanhGia::where('mahocsinh', $id)->where('nam', $nam);
        if ($thang) {
            $query->where('thang', $thang);
        }
        $danhgias = $query->orderBy('thang', 'asc')->get();

        $data = [
            'hocsinh' => $hocsinh,
            'danhgias' => $danhgias,
            'lop' => $lop,
            'teacher' => $teacher,
            'nam' => $nam,
            'thang' => $thang,
            'ngayXuat' => Carbon::now()->format('d/m/Y H:i'),
        ];

        $pdf = Pdf::loadView('teacher.xuatfile.danhgia-pdf', $data);
        $pdf->setPaper('A4', 'portrait');

        $filename = 'danhgia_' . $hocsinh->hoten . '_' . $nam;
        if ($thang) {
            $filename .= '_thang' . $thang;
        }
        $filename .= '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Xuất PDF đánh giá cả lớp theo tháng
     */
    public function xuatDanhGiaLop(Request $request)
    {
        $teacher = Auth::user()->giaoVien;
        $lop = $teacher->lophoc;

        $nam = $request->get('nam', date('Y'));
        $thang = $request->get('thang', date('m'));

        $hocsinhs = HocSinh::where('malop', $lop->id)->get();

        $danhSachDanhGia = [];
        foreach ($hocsinhs as $hs) {
            $danhgia = DanhGia::where('mahocsinh', $hs->id)
                ->where('nam', $nam)
                ->where('thang', $thang)
                ->first();

            $danhSachDanhGia[] = [
                'hocsinh' => $hs,
                'danhgia' => $danhgia,
            ];
        }

        $data = [
            'danhSachDanhGia' => $danhSachDanhGia,
            'lop' => $lop,
            'teacher' => $teacher,
            'nam' => $nam,
            'thang' => $thang,
            'ngayXuat' => Carbon::now()->format('d/m/Y H:i'),
        ];

        $pdf = Pdf::loadView('teacher.xuatfile.danhgia-lop-pdf', $data);
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('danhgia_lop_' . $lop->tenlop . '_thang' . $thang . '_' . $nam . '.pdf');
    }

    /**
     * Xem trước PDF học phí (trong browser)
     */
    public function xemTruocHocPhi($id)
    {
        $teacher = Auth::user()->giaoVien;
        $lop = $teacher->lophoc;

        $hocsinh = HocSinh::where('malop', $lop->id)->findOrFail($id);
        $hocphis = HocPhi::where('mahocsinh', $id)->orderBy('created_at', 'desc')->get();

        $tongTien = $hocphis->sum('tongtien');
        $daDong = $hocphis->sum('dathanhtoan');
        $conNo = $tongTien - $daDong;

        $data = [
            'hocsinh' => $hocsinh,
            'hocphis' => $hocphis,
            'lop' => $lop,
            'teacher' => $teacher,
            'tongTien' => $tongTien,
            'daDong' => $daDong,
            'conNo' => $conNo,
            'ngayXuat' => Carbon::now()->format('d/m/Y H:i'),
        ];

        $pdf = Pdf::loadView('teacher.xuatfile.hocphi-pdf', $data);
        return $pdf->stream();
    }

    /**
     * Xem trước PDF đánh giá (trong browser)
     */
    public function xemTruocDanhGia($id, Request $request)
    {
        $teacher = Auth::user()->giaoVien;
        $lop = $teacher->lophoc;

        $hocsinh = HocSinh::where('malop', $lop->id)->findOrFail($id);

        $nam = $request->get('nam', date('Y'));
        $thang = $request->get('thang');

        $query = DanhGia::where('mahocsinh', $id)->where('nam', $nam);
        if ($thang) {
            $query->where('thang', $thang);
        }
        $danhgias = $query->orderBy('thang', 'asc')->get();

        $data = [
            'hocsinh' => $hocsinh,
            'danhgias' => $danhgias,
            'lop' => $lop,
            'teacher' => $teacher,
            'nam' => $nam,
            'thang' => $thang,
            'ngayXuat' => Carbon::now()->format('d/m/Y H:i'),
        ];

        $pdf = Pdf::loadView('teacher.xuatfile.danhgia-pdf', $data);
        return $pdf->stream();
    }
}
