<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DanhGia;
use App\Models\GiaoVien;
use App\Models\HocSinh;
use Illuminate\Http\Request;

class DanhGiaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // We'll show one row per student on index (like điểm danh layout).
        $thang = $request->input('thang');
        $nam = $request->input('nam');

        // Eager load danhgia entries for each student; if filters provided, limit to those
        $hocsinhQuery = HocSinh::with(['lophoc']);

        $hocsinhQuery->with(['danhgia' => function ($q) use ($thang, $nam) {
            if ($nam) {
                $q->where('nam', $nam);
            }
            if ($thang) {
                $q->where('thang', $thang);
            }
            // order so first() will be the most recent
            $q->orderBy('nam', 'desc')->orderBy('thang', 'desc')->orderBy('id', 'desc');
        }]);

        // Paginate students (index shows students list; each row uses the latest matching evaluation)
        $hocsinhList = $hocsinhQuery->paginate(10);

        return view('admin.danhgia.index', compact('hocsinhList', 'thang', 'nam'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $hocsinh = HocSinh::all();
        $giaovien = GiaoVien::all();

        return view('admin.danhgia.create', compact('hocsinh', 'giaovien'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'mahocsinh' => 'nullable|exists:hocsinh,id',
            'magiaovien' => 'nullable|exists:giaovien,id',
            'nam'   => 'nullable|integer|min:2000|max:2100',
            'thang' => 'nullable|integer|min:1|max:12',
            'thechat' => 'nullable|integer|min:1|max:5',
            'ngonngu' => 'nullable|integer|min:1|max:5',
            'nhanthuc' => 'nullable|integer|min:1|max:5',
            'camxucxahoi' => 'nullable|integer|min:1|max:5',
            'nghethuat' => 'nullable|integer|min:1|max:5',
            'nhanxetchung' => 'nullable|string',
        ]);
        DanhGia::create($request->all());

        return redirect()->route('admin.danhgia.index')->with('success', 'Thêm đánh giá thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $danhgia = DanhGia::with(['hocsinh', 'giaovien'])->findOrFail($id);

        // Lấy tất cả đánh giá của học sinh này trong cùng tháng/năm
        $allEvaluations = DanhGia::with(['hocsinh', 'giaovien'])
            ->where('mahocsinh', $danhgia->mahocsinh)
            ->where('thang', $danhgia->thang)
            ->where('nam', $danhgia->nam)
            ->orderBy('id', 'DESC')
            ->get();

        return view('admin.danhgia.show', compact('danhgia', 'allEvaluations'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $danhgia = DanhGia::findOrFail($id);
        $hocsinh = HocSinh::all();
        $giaovien = GiaoVien::all();

        return view('admin.danhgia.edit', compact('danhgia', 'hocsinh', 'giaovien'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'mahocsinh' => 'nullable|exists:hocsinh,id',
            'magiaovien' => 'nullable|exists:giaovien,id',
            'nam' => 'nullable|integer|min:2000|max:2100',
            'thang' => 'nullable|integer|min:1|max:12',
            'thechat' => 'nullable|integer|min:1|max:5',
            'ngonngu' => 'nullable|integer|min:1|max:5',
            'nhanthuc' => 'nullable|integer|min:1|max:5',
            'camxucxahoi' => 'nullable|integer|min:1|max:5',
            'nghethuat' => 'nullable|integer|min:1|max:5',
            'nhanxetchung' => 'nullable|string',
        ]);

        $danhgia = DanhGia::findOrFail($id);
        $danhgia->update($request->all());

        return redirect()->route('admin.danhgia.index')->with('success', 'Cập nhật đánh giá thành công!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $danhgia = DanhGia::findOrFail($id);
        $danhgia->delete();

        return redirect()->route('admin.danhgia.index')->with('success', 'Xóa đánh giá thành công!');
    }
}
