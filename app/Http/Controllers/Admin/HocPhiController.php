<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\HocPhi;
use App\Models\HocSinh;
use App\Models\GiaoVien;
use Illuminate\Http\Request;

class HocPhiController extends Controller
{
    /**
     * Hiển thị danh sách học phí
     */
    public function index()
    {
        $hocphis = HocPhi::with(['hocsinh', 'giaovien'])->get();

        foreach ($hocphis as $hp) {
            $hp->tongtien = ($hp->hocphi ?? 0)
                + ($hp->tienansang ?? 0)
                + ($hp->tienantrua ?? 0)
                + ($hp->tienxebus ?? 0)
                + ($hp->phikhac ?? 0);

            $hp->con_no = $hp->tongtien - ($hp->dathanhtoan ?? 0);
        }

        return view('admin.hocphi.index', compact('hocphis'));
    }

    /**
     * Hiển thị form tạo học phí mới
     */
    public function create()
    {
        $hocsinh = HocSinh::all();
        $giaovien = GiaoVien::all();
        return view('admin.hocphi.create', compact('hocsinh', 'giaovien'));
    }

    /**
     * Lưu học phí mới
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'mahocsinh' => 'nullable|exists:hocsinh,id',
            'thoigiandong' => 'nullable|date',
            'hocphi' => 'nullable|numeric',
            'tienansang' => 'nullable|numeric',
            'tienantrua' => 'nullable|numeric',
            'tienxebus' => 'nullable|numeric',
            'phikhac' => 'nullable|numeric',
            'ngaythanhtoan' => 'nullable|date',
            'dathanhtoan' => 'nullable|numeric',
            'magiaovien' => 'nullable|exists:giaovien,id',
            'ghichu' => 'nullable|string',
        ]);

        // Nếu không nhập thời gian đóng, mặc định ngày 01 tháng hiện tại
        if (empty($data['thoigiandong'])) {
            $data['thoigiandong'] = now()->startOfMonth()->toDateString(); // YYYY-MM-01
        }

        // Tính tổng tiền
        $data['tongtien'] = ($data['hocphi'] ?? 0)
            + ($data['tienansang'] ?? 0)
            + ($data['tienantrua'] ?? 0)
            + ($data['tienxebus'] ?? 0)
            + ($data['phikhac'] ?? 0);

        HocPhi::create($data);

        return redirect()->route('admin.hocphi.index')->with('success', 'Thêm học phí thành công!');
    }

    /**
     * Hiển thị chi tiết học phí
     */
    public function show(HocPhi $hocphi)
    {
        $hocphi->tongtien = ($hocphi->hocphi ?? 0)
            + ($hocphi->tienansang ?? 0)
            + ($hocphi->tienantrua ?? 0)
            + ($hocphi->tienxebus ?? 0)
            + ($hocphi->phikhac ?? 0);

        $hocphi->con_no = $hocphi->tongtien - ($hocphi->dathanhtoan ?? 0);

        return view('admin.hocphi.show', compact('hocphi'));
    }

    /**
     * Hiển thị form chỉnh sửa học phí
     */
    public function edit(HocPhi $hocphi)
    {
        $hocsinh = HocSinh::all();
        $giaovien = GiaoVien::all();
        return view('admin.hocphi.edit', compact('hocphi', 'hocsinh', 'giaovien'));
    }

    /**
     * Cập nhật học phí
     */
    public function update(Request $request, HocPhi $hocphi)
    {
        $data = $request->validate([
            'mahocsinh' => 'nullable|exists:hocsinh,id',
            'thoigiandong' => 'nullable|date',
            'hocphi' => 'nullable|numeric',
            'tienansang' => 'nullable|numeric',
            'tienantrua' => 'nullable|numeric',
            'tienxebus' => 'nullable|numeric',
            'phikhac' => 'nullable|numeric',
            'ngaythanhtoan' => 'nullable|date',
            'dathanhtoan' => 'nullable|numeric',
            'magiaovien' => 'nullable|exists:giaovien,id',
            'ghichu' => 'nullable|string',
        ]);

        // Tính tổng tiền
        $data['tongtien'] = ($data['hocphi'] ?? 0)
            + ($data['tienansang'] ?? 0)
            + ($data['tienantrua'] ?? 0)
            + ($data['tienxebus'] ?? 0)
            + ($data['phikhac'] ?? 0);

        $hocphi->update($data);

        return redirect()->route('admin.hocphi.index')->with('success', 'Cập nhật học phí thành công!');
    }

    /**
     * Xóa học phí
     */
    public function destroy(HocPhi $hocphi)
    {
        $hocphi->delete();
        return redirect()->route('admin.hocphi.index')->with('success', 'Xóa học phí thành công!');
    }
}
