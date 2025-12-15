<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\DanhGia;
use App\Models\HocSinh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DanhGiaController extends Controller
{
    /**
     * Hiển thị danh sách đánh giá của lớp chủ nhiệm
     */
    public function index(Request $request)
    {
        $teacher = Auth::user()->giaoVien;
        $lophoc = $teacher->lophoc;

        if (!$lophoc) {
            return redirect()->route('teacher.teacher')->with('error', 'Bạn chưa được phân công lớp chủ nhiệm!');
        }

        $thang = $request->input('thang');
        $nam = $request->input('nam');

        // Lấy danh sách học sinh trong lớp với đánh giá
        $hocsinhQuery = HocSinh::where('malop', $lophoc->id)->with(['lophoc']);

        $hocsinhQuery->with(['danhgia' => function ($q) use ($thang, $nam, $teacher) {
            // Chỉ lấy đánh giá do giáo viên này tạo
            $q->where('magiaovien', $teacher->id);

            if ($nam) {
                $q->where('nam', $nam);
            }
            if ($thang) {
                $q->where('thang', $thang);
            }
            $q->orderBy('nam', 'desc')->orderBy('thang', 'desc')->orderBy('id', 'desc');
        }]);

        $hocsinhList = $hocsinhQuery->paginate(15);

        return view('teacher.danhgia.index', compact('hocsinhList', 'thang', 'nam', 'lophoc', 'teacher'));
    }

    /**
     * Hiển thị form tạo đánh giá mới
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

        return view('teacher.danhgia.create', compact('hocsinh', 'lophoc', 'teacher'));
    }

    /**
     * Lưu đánh giá mới
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
            'nam'   => 'required|integer|min:2000|max:2100',
            'thang' => 'required|integer|min:1|max:12',
            'thechat' => 'nullable|integer|min:1|max:5',
            'ngonngu' => 'nullable|integer|min:1|max:5',
            'nhanthuc' => 'nullable|integer|min:1|max:5',
            'camxucxahoi' => 'nullable|integer|min:1|max:5',
            'nghethuat' => 'nullable|integer|min:1|max:5',
            'nhanxetchung' => 'nullable|string',
        ]);

        // Kiểm tra học sinh có thuộc lớp chủ nhiệm không
        $hocsinh = HocSinh::where('id', $data['mahocsinh'])
            ->where('malop', $lophoc->id)
            ->first();

        if (!$hocsinh) {
            return back()->with('error', 'Học sinh không thuộc lớp chủ nhiệm của bạn!')->withInput();
        }

        // Tự động gán mã giáo viên
        $data['magiaovien'] = $teacher->id;

        DanhGia::create($data);

        return redirect()->route('teacher.danhgia.index')->with('success', 'Thêm đánh giá thành công!');
    }

    /**
     * Hiển thị chi tiết đánh giá
     */
    public function show($id)
    {
        $teacher = Auth::user()->giaoVien;
        $lophoc = $teacher->lophoc;

        if (!$lophoc) {
            return redirect()->route('teacher.teacher')->with('error', 'Bạn chưa được phân công lớp chủ nhiệm!');
        }

        $danhgia = DanhGia::with(['hocsinh', 'giaovien'])->findOrFail($id);

        // Kiểm tra đánh giá có do giáo viên này tạo và học sinh thuộc lớp chủ nhiệm không
        if ($danhgia->magiaovien != $teacher->id || $danhgia->hocsinh->malop != $lophoc->id) {
            return abort(403, 'Bạn không có quyền xem đánh giá này!');
        }

        // Lấy tất cả đánh giá của học sinh này trong cùng tháng/năm do giáo viên này tạo
        $allEvaluations = DanhGia::with(['hocsinh', 'giaovien'])
            ->where('mahocsinh', $danhgia->mahocsinh)
            ->where('magiaovien', $teacher->id)
            ->where('thang', $danhgia->thang)
            ->where('nam', $danhgia->nam)
            ->orderBy('id', 'DESC')
            ->get();

        return view('teacher.danhgia.show', compact('danhgia', 'allEvaluations', 'lophoc', 'teacher'));
    }

    /**
     * Hiển thị form chỉnh sửa đánh giá
     */
    public function edit($id)
    {
        $teacher = Auth::user()->giaoVien;
        $lophoc = $teacher->lophoc;

        if (!$lophoc) {
            return redirect()->route('teacher.teacher')->with('error', 'Bạn chưa được phân công lớp chủ nhiệm!');
        }

        $danhgia = DanhGia::with(['hocsinh'])->findOrFail($id);

        // Kiểm tra đánh giá có do giáo viên này tạo và học sinh thuộc lớp chủ nhiệm không
        if ($danhgia->magiaovien != $teacher->id || $danhgia->hocsinh->malop != $lophoc->id) {
            return abort(403, 'Bạn không có quyền sửa đánh giá này!');
        }

        $hocsinh = HocSinh::where('malop', $lophoc->id)->get();

        return view('teacher.danhgia.edit', compact('danhgia', 'hocsinh', 'lophoc', 'teacher'));
    }

    /**
     * Cập nhật đánh giá
     */
    public function update(Request $request, $id)
    {
        $teacher = Auth::user()->giaoVien;
        $lophoc = $teacher->lophoc;

        if (!$lophoc) {
            return redirect()->route('teacher.teacher')->with('error', 'Bạn chưa được phân công lớp chủ nhiệm!');
        }

        $danhgia = DanhGia::with(['hocsinh'])->findOrFail($id);

        // Kiểm tra đánh giá có do giáo viên này tạo và học sinh thuộc lớp chủ nhiệm không
        if ($danhgia->magiaovien != $teacher->id || $danhgia->hocsinh->malop != $lophoc->id) {
            return abort(403, 'Bạn không có quyền sửa đánh giá này!');
        }

        $data = $request->validate([
            'mahocsinh' => 'required|exists:hocsinh,id',
            'nam' => 'required|integer|min:2000|max:2100',
            'thang' => 'required|integer|min:1|max:12',
            'thechat' => 'nullable|integer|min:1|max:5',
            'ngonngu' => 'nullable|integer|min:1|max:5',
            'nhanthuc' => 'nullable|integer|min:1|max:5',
            'camxucxahoi' => 'nullable|integer|min:1|max:5',
            'nghethuat' => 'nullable|integer|min:1|max:5',
            'nhanxetchung' => 'nullable|string',
        ]);

        // Giữ nguyên giáo viên đã tạo
        $data['magiaovien'] = $teacher->id;

        $danhgia->update($data);

        return redirect()->route('teacher.danhgia.index')->with('success', 'Cập nhật đánh giá thành công!');
    }

    /**
     * Xóa đánh giá
     */
    public function destroy($id)
    {
        $teacher = Auth::user()->giaoVien;
        $lophoc = $teacher->lophoc;

        if (!$lophoc) {
            return redirect()->route('teacher.teacher')->with('error', 'Bạn chưa được phân công lớp chủ nhiệm!');
        }

        $danhgia = DanhGia::with(['hocsinh'])->findOrFail($id);

        // Kiểm tra đánh giá có do giáo viên này tạo và học sinh thuộc lớp chủ nhiệm không
        if ($danhgia->magiaovien != $teacher->id || $danhgia->hocsinh->malop != $lophoc->id) {
            return abort(403, 'Bạn không có quyền xóa đánh giá này!');
        }

        $danhgia->delete();

        return redirect()->route('teacher.danhgia.index')->with('success', 'Xóa đánh giá thành công!');
    }
}
