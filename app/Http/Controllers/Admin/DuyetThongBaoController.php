<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ThongBao;
use App\Models\UserThongBao;
use App\Models\HocSinh;
use App\Models\PhuHuynh;
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

        // Tạo thông báo cho phụ huynh
        $this->createUserNotifications($thongbao);

        return redirect()->back()->with('success', 'Đã phê duyệt thông báo và gửi đến phụ huynh!');
    }

    /**
     * Tạo thông báo cho các phụ huynh tương ứng
     */
    private function createUserNotifications($thongbao)
    {
        $userIds = [];

        if ($thongbao->malop) {
            // Thông báo cho 1 lớp cụ thể
            // Lấy danh sách học sinh trong lớp
            $hocsinhs = HocSinh::where('malop', $thongbao->malop)->get();

            // Lấy danh sách phụ huynh của các học sinh
            foreach ($hocsinhs as $hocsinh) {
                if ($hocsinh->phuhuynh && $hocsinh->phuhuynh->user_id) {
                    $userIds[] = $hocsinh->phuhuynh->user_id;
                }
            }
        } else {
            // Thông báo cho toàn trường
            // Lấy tất cả phụ huynh có user_id
            $phuhuynhs = PhuHuynh::whereNotNull('user_id')->get();
            $userIds = $phuhuynhs->pluck('user_id')->toArray();
        }

        // Loại bỏ trùng lặp
        $userIds = array_unique($userIds);

        // Tạo bản ghi trong user_thongbao cho mỗi phụ huynh
        foreach ($userIds as $userId) {
            UserThongBao::create([
                'user_id' => $userId,
                'thongbao_id' => $thongbao->id,
                'is_read' => false,
            ]);
        }
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
