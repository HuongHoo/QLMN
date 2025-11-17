<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ThongBao;
use Illuminate\Http\Request;

class DuyetThongBaoController extends Controller
{
    /**
     * Hiển thị danh sách thông báo chờ duyệt
     */
    public function index()
    {
        $thongbaos = ThongBao::where('trangthai', 'chờ duyệt')
            ->with(['giaovien', 'lophoc'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.thongbao.index', compact('thongbaos'));
    }

    /**
     * Hiển thị lịch sử phê duyệt (đã duyệt hoặc từ chối)
     */
    public function history()
    {
        $thongbaos = ThongBao::whereIn('trangthai', ['đã duyệt', 'từ chối'])
            ->with(['giaovien', 'lophoc'])
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('admin.thongbao.history', compact('thongbaos'));
    }

    /**
     * Phê duyệt thông báo
     */
    public function approve($id)
    {
        $thongbao = ThongBao::findOrFail($id);

        if ($thongbao->trangthai !== 'chờ duyệt') {
            return redirect()->back()->with('error', 'Thông báo này đã được xử lý.');
        }

        $thongbao->update([
            'trangthai' => 'đã duyệt',
            'ngaygui' => now(),
            'lydotuchoi' => null,
        ]);

        return redirect()->back()->with('success', 'Đã phê duyệt thông báo!');
    }

    /**
     * Từ chối thông báo
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'lydotuchoi' => 'required|string|max:500',
        ]);

        $thongbao = ThongBao::findOrFail($id);

        if ($thongbao->trangthai !== 'chờ duyệt') {
            return redirect()->back()->with('error', 'Thông báo này đã được xử lý.');
        }

        $thongbao->update([
            'trangthai' => 'từ chối',
            'lydotuchoi' => $request->lydotuchoi,
        ]);

        return redirect()->back()->with('success', 'Đã từ chối thông báo!');
    }

    /**
     * Xem chi tiết thông báo
     */
    public function show($id)
    {
        $thongbao = ThongBao::with(['giaovien', 'lophoc'])->findOrFail($id);

        return view('admin.thongbao.show', compact('thongbao'));
    }
}
