<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\ThongBao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ThongBaoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $giaovien = Auth::user()->giaovien;

        if (!$giaovien) {
            return abort(404, 'Không tìm thấy thông tin giáo viên.');
        }

        // Lấy danh sách thông báo của giáo viên
        $thongbaos = ThongBao::where('magiaovien', $giaovien->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('teacher.thongbao.index', compact('thongbaos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $giaovien = Auth::user()->giaovien;

        if (!$giaovien) {
            return abort(404, 'Không tìm thấy thông tin giáo viên.');
        }

        $lophoc = $giaovien->lophoc;

        return view('teacher.thongbao.create', compact('lophoc'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $giaovien = Auth::user()->giaovien;

        if (!$giaovien) {
            return redirect()->back()->with('error', 'Không tìm thấy thông tin giáo viên.');
        }

        $request->validate([
            'tieude' => 'required|string|max:255',
            'noidung' => 'required|string',
            'loaithongbao' => 'required|in:chung,khẩn cấp,sự kiện,nghỉ lễ',
            'phamvi' => 'required|in:lop,truong',
            'tepdinhkem' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['tieude', 'noidung', 'loaithongbao']);
        $data['magiaovien'] = $giaovien->id;

        // Xử lý phạm vi gửi
        if ($request->phamvi === 'lop') {
            $data['malop'] = $giaovien->lophoc->id ?? null;
        } else {
            // Nếu gửi toàn trường, không set malop (null = toàn trường)
            $data['malop'] = null;
        }

        $data['ngaytao'] = now();
        $data['trangthai'] = 'chờ duyệt'; // Trạng thái mặc định

        // Xử lý file đính kèm
        if ($request->hasFile('tepdinhkem')) {
            $file = $request->file('tepdinhkem');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('thongbao', $filename, 'public');
            $data['tepdinhkem'] = $path;
        }

        ThongBao::create($data);

        return redirect()->route('teacher.thongbao.index')
            ->with('success', 'Thông báo đã được tạo và đang chờ duyệt!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $thongbao = ThongBao::findOrFail($id);

        // Kiểm tra quyền xem
        $giaovien = Auth::user()->giaovien;
        if ($thongbao->magiaovien != $giaovien->id) {
            return abort(403, 'Bạn không có quyền xem thông báo này.');
        }

        return view('teacher.thongbao.show', compact('thongbao'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $thongbao = ThongBao::findOrFail($id);

        // Kiểm tra quyền sửa
        $giaovien = Auth::user()->giaovien;
        if ($thongbao->magiaovien != $giaovien->id) {
            return abort(403, 'Bạn không có quyền sửa thông báo này.');
        }

        // Chỉ cho sửa nếu đang chờ duyệt hoặc bị từ chối
        if (!in_array($thongbao->trangthai, ['chờ duyệt', 'từ chối'])) {
            return redirect()->back()->with('error', 'Chỉ có thể sửa thông báo đang chờ duyệt hoặc bị từ chối.');
        }

        $lophoc = $giaovien->lophoc;

        return view('teacher.thongbao.edit', compact('thongbao', 'lophoc'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $thongbao = ThongBao::findOrFail($id);

        // Kiểm tra quyền sửa
        $giaovien = Auth::user()->giaovien;
        if ($thongbao->magiaovien != $giaovien->id) {
            return abort(403, 'Bạn không có quyền sửa thông báo này.');
        }

        // Chỉ cho sửa nếu đang chờ duyệt hoặc bị từ chối
        if (!in_array($thongbao->trangthai, ['chờ duyệt', 'từ chối'])) {
            return redirect()->back()->with('error', 'Chỉ có thể sửa thông báo đang chờ duyệt hoặc bị từ chối.');
        }

        $request->validate([
            'tieude' => 'required|string|max:255',
            'noidung' => 'required|string',
            'loaithongbao' => 'required|in:chung,khẩn cấp,sự kiện,nghỉ lễ',
            'tepdinhkem' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['tieude', 'noidung', 'loaithongbao']);
        $data['trangthai'] = 'chờ duyệt'; // Reset về chờ duyệt khi sửa
        $data['lydotuchoi'] = null; // Xóa lý do từ chối cũ

        // Xử lý file đính kèm
        if ($request->hasFile('tepdinhkem')) {
            // Xóa file cũ nếu có
            if ($thongbao->tepdinhkem) {
                Storage::disk('public')->delete($thongbao->tepdinhkem);
            }

            $file = $request->file('tepdinhkem');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('thongbao', $filename, 'public');
            $data['tepdinhkem'] = $path;
        }

        $thongbao->update($data);

        return redirect()->route('teacher.thongbao.index')
            ->with('success', 'Thông báo đã được cập nhật!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $thongbao = ThongBao::findOrFail($id);

        // Kiểm tra quyền xóa
        $giaovien = Auth::user()->giaovien;
        if ($thongbao->magiaovien != $giaovien->id) {
            return abort(403, 'Bạn không có quyền xóa thông báo này.');
        }

        // Xóa file đính kèm nếu có
        if ($thongbao->tepdinhkem) {
            Storage::disk('public')->delete($thongbao->tepdinhkem);
        }

        $thongbao->delete();

        return redirect()->route('teacher.thongbao.index')
            ->with('success', 'Thông báo đã được xóa!');
    }
}
