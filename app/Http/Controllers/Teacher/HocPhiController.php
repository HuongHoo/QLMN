<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\HocPhi;
use App\Models\HocSinh;
use App\Models\DiemDanh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HocPhiController extends Controller
{
    /**
     * Hiển thị danh sách học phí của lớp chủ nhiệm
     */
    public function index(Request $request)
    {
        $teacher = Auth::user()->giaoVien;
        $lophoc = $teacher->lophoc;

        if (!$lophoc) {
            return redirect()->route('teacher.teacher')->with('error', 'Bạn chưa được phân công lớp chủ nhiệm!');
        }

        // Lấy danh sách học sinh trong lớp
        $hocsinhIds = HocSinh::where('malop', $lophoc->id)->pluck('id');

        // Lấy học phí của các học sinh trong lớp
        $hocphisQuery = HocPhi::with(['hocsinh', 'giaovien'])
            ->whereIn('mahocsinh', $hocsinhIds);

        // Lọc theo tháng/năm nếu có
        if ($request->filled('thang')) {
            $hocphisQuery->whereMonth('thoigiandong', $request->thang);
        }
        if ($request->filled('nam')) {
            $hocphisQuery->whereYear('thoigiandong', $request->nam);
        }

        $hocphis = $hocphisQuery->orderBy('thoigiandong', 'desc')->paginate(20);

        // Tính toán các giá trị tổng
        foreach ($hocphis as $hp) {
            $hp->tongtien = ($hp->hocphi ?? 0)
                + ($hp->tienansang ?? 0)
                + ($hp->tienantrua ?? 0)
                + ($hp->tienxebus ?? 0)
                + ($hp->phikhac ?? 0);

            $hp->con_no = $hp->tongtien - ($hp->dathanhtoan ?? 0);
        }

        return view('teacher.hocphi.index', compact('hocphis', 'lophoc', 'teacher'));
    }

    /**
     * Hiển thị form tạo học phí mới
     */
    public function create()
    {
        $teacher = Auth::user()->giaoVien;
        $lophoc = $teacher->lophoc;

        if (!$lophoc) {
            return redirect()->route('teacher.teacher')->with('error', 'Bạn chưa được phân công lớp chủ nhiệm!');
        }

        // Chỉ lấy học sinh trong lớp chủ nhiệm
        $hocsinh = HocSinh::where('malop', $lophoc->id)->get();

        // Lấy mức phí mặc định từ bản ghi học phí gần nhất của lớp (do admin tạo)
        $mucPhiMacDinh = HocPhi::whereHas('hocsinh', function ($query) use ($lophoc) {
            $query->where('malop', $lophoc->id);
        })->latest()->first();

        return view('teacher.hocphi.create', compact('hocsinh', 'lophoc', 'teacher', 'mucPhiMacDinh'));
    }

    /**
     * Lưu học phí mới
     */
    public function store(Request $request)
    {
        $teacher = Auth::user()->giaoVien;
        $lophoc = $teacher->lophoc;

        if (!$lophoc) {
            return redirect()->route('teacher.teacher')->with('error', 'Bạn chưa được phân công lớp chủ nhiệm!');
        }

        $data = $request->validate([
            'mahocsinh' => 'required|exists:hocsinh,id',
            'thoigiandong' => 'required|date',
            'tu_ngay' => 'nullable|date',
            'den_ngay' => 'nullable|date',
            'gia_tien_an_ngay' => 'nullable|numeric',
            'so_ngay_di_hoc' => 'nullable|integer',
            'tienantrua_auto' => 'nullable|numeric',
            'ngaythanhtoan' => 'required|date',
            'dathanhtoan' => 'required|numeric|min:0',
            'ghichu' => 'nullable|string',
        ]);

        // Kiểm tra học sinh có thuộc lớp chủ nhiệm không
        $hocsinh = HocSinh::where('id', $data['mahocsinh'])
            ->where('malop', $lophoc->id)
            ->first();

        if (!$hocsinh) {
            return back()->with('error', 'Học sinh không thuộc lớp chủ nhiệm của bạn!')->withInput();
        }

        // Lấy mức phí từ cấu hình admin (bản ghi gần nhất của lớp)
        $mucPhiMacDinh = HocPhi::whereHas('hocsinh', function ($query) use ($lophoc) {
            $query->where('malop', $lophoc->id);
        })->latest()->first();

        // Nếu không có mức phí mặc định, sử dụng giá trị 0
        $data['hocphi'] = $mucPhiMacDinh->hocphi ?? 0;
        $data['tienansang'] = $mucPhiMacDinh->tienansang ?? 0;
        $data['tienxebus'] = $mucPhiMacDinh->tienxebus ?? 0;
        $data['phikhac'] = $mucPhiMacDinh->phikhac ?? 0;

        // Tính tiền ăn trưa tự động nếu có đủ thông tin
        if (!empty($data['tu_ngay']) && !empty($data['den_ngay']) && !empty($data['gia_tien_an_ngay'])) {
            $soNgayDiHoc = DiemDanh::where('mahocsinh', $data['mahocsinh'])
                ->whereBetween('ngaydiemdanh', [$data['tu_ngay'], $data['den_ngay']])
                ->where(function($query) {
                    $query->where('trangthai', 'like', '%có mặt%')
                          ->orWhere('trangthai', 'like', '%đi muộn%');
                })
                ->count();
            
            $data['so_ngay_di_hoc'] = $soNgayDiHoc;
            $data['tienantrua'] = $soNgayDiHoc * $data['gia_tien_an_ngay'];
        } else {
            // Nếu không tính tự động, lấy từ mức phí mặc định
            $data['tienantrua'] = $mucPhiMacDinh->tienantrua ?? 0;
        }

        // Tính tổng tiền
        $data['tongtien'] = ($data['hocphi'] ?? 0)
            + ($data['tienansang'] ?? 0)
            + ($data['tienantrua'] ?? 0)
            + ($data['tienxebus'] ?? 0)
            + ($data['phikhac'] ?? 0);

        // Tự động gán mã giáo viên
        $data['magiaovien'] = $teacher->id;

        // Xóa trường tienantrua_auto vì không có trong database
        unset($data['tienantrua_auto']);

        HocPhi::create($data);

        return redirect()->route('teacher.hocphi.index')->with('success', 'Thêm thông tin thanh toán học phí thành công!');
    }

    /**
     * Hiển thị chi tiết học phí
     */
    public function show($id)
    {
        $teacher = Auth::user()->giaoVien;
        $lophoc = $teacher->lophoc;

        if (!$lophoc) {
            return redirect()->route('teacher.teacher')->with('error', 'Bạn chưa được phân công lớp chủ nhiệm!');
        }

        $hocphi = HocPhi::with(['hocsinh', 'giaovien'])->findOrFail($id);

        // Kiểm tra học sinh có thuộc lớp chủ nhiệm không
        if ($hocphi->hocsinh->malop != $lophoc->id) {
            return abort(403, 'Bạn không có quyền xem học phí này!');
        }

        $hocphi->tongtien = ($hocphi->hocphi ?? 0)
            + ($hocphi->tienansang ?? 0)
            + ($hocphi->tienantrua ?? 0)
            + ($hocphi->tienxebus ?? 0)
            + ($hocphi->phikhac ?? 0);

        $hocphi->con_no = $hocphi->tongtien - ($hocphi->dathanhtoan ?? 0);

        return view('teacher.hocphi.show', compact('hocphi', 'lophoc', 'teacher'));
    }

    /**
     * Hiển thị form chỉnh sửa học phí
     */
    public function edit($id)
    {
        $teacher = Auth::user()->giaoVien;
        $lophoc = $teacher->lophoc;

        if (!$lophoc) {
            return redirect()->route('teacher.teacher')->with('error', 'Bạn chưa được phân công lớp chủ nhiệm!');
        }

        $hocphi = HocPhi::with(['hocsinh'])->findOrFail($id);

        // Kiểm tra học sinh có thuộc lớp chủ nhiệm không
        if ($hocphi->hocsinh->malop != $lophoc->id) {
            return abort(403, 'Bạn không có quyền sửa học phí này!');
        }

        $hocsinh = HocSinh::where('malop', $lophoc->id)->get();

        return view('teacher.hocphi.edit', compact('hocphi', 'hocsinh', 'lophoc', 'teacher'));
    }

    /**
     * Cập nhật học phí
     */
    public function update(Request $request, $id)
    {
        $teacher = Auth::user()->giaoVien;
        $lophoc = $teacher->lophoc;

        if (!$lophoc) {
            return redirect()->route('teacher.teacher')->with('error', 'Bạn chưa được phân công lớp chủ nhiệm!');
        }

        $hocphi = HocPhi::with(['hocsinh'])->findOrFail($id);

        // Kiểm tra học sinh có thuộc lớp chủ nhiệm không
        if ($hocphi->hocsinh->malop != $lophoc->id) {
            return abort(403, 'Bạn không có quyền sửa học phí này!');
        }

        $data = $request->validate([
            'mahocsinh' => 'required|exists:hocsinh,id',
            'thoigiandong' => 'nullable|date',
            'hocphi' => 'nullable|numeric|min:0',
            'tienansang' => 'nullable|numeric|min:0',
            'tienantrua' => 'nullable|numeric|min:0',
            'tienxebus' => 'nullable|numeric|min:0',
            'phikhac' => 'nullable|numeric|min:0',
            'ngaythanhtoan' => 'nullable|date',
            'dathanhtoan' => 'nullable|numeric|min:0',
            'ghichu' => 'nullable|string',
        ]);

        // Tính tổng tiền
        $data['tongtien'] = ($data['hocphi'] ?? 0)
            + ($data['tienansang'] ?? 0)
            + ($data['tienantrua'] ?? 0)
            + ($data['tienxebus'] ?? 0)
            + ($data['phikhac'] ?? 0);

        // Giữ nguyên giáo viên đã tạo
        $data['magiaovien'] = $teacher->id;

        $hocphi->update($data);

        return redirect()->route('teacher.hocphi.index')->with('success', 'Cập nhật học phí thành công!');
    }

    /**
     * Xóa học phí
     */
    public function destroy($id)
    {
        $teacher = Auth::user()->giaoVien;
        $lophoc = $teacher->lophoc;

        if (!$lophoc) {
            return redirect()->route('teacher.teacher')->with('error', 'Bạn chưa được phân công lớp chủ nhiệm!');
        }

        $hocphi = HocPhi::with(['hocsinh'])->findOrFail($id);

        // Kiểm tra học sinh có thuộc lớp chủ nhiệm không
        if ($hocphi->hocsinh->malop != $lophoc->id) {
            return abort(403, 'Bạn không có quyền xóa học phí này!');
        }

        $hocphi->delete();

        return redirect()->route('teacher.hocphi.index')->with('success', 'Xóa học phí thành công!');
    }

    /**
     * API: Lấy số ngày đi học từ điểm danh
     */
    public function getSoNgayDiHoc(Request $request)
    {
        $mahocsinh = $request->mahocsinh;
        $tuNgay = $request->tu_ngay;
        $denNgay = $request->den_ngay;

        if (!$mahocsinh || !$tuNgay || !$denNgay) {
            return response()->json(['so_ngay_di_hoc' => 0]);
        }

        $soNgayDiHoc = DiemDanh::where('mahocsinh', $mahocsinh)
            ->whereBetween('ngaydiemdanh', [$tuNgay, $denNgay])
            ->where(function($query) {
                $query->where('trangthai', 'like', '%có mặt%')
                      ->orWhere('trangthai', 'like', '%đi muộn%');
            })
            ->count();

        return response()->json(['so_ngay_di_hoc' => $soNgayDiHoc]);
    }
}
