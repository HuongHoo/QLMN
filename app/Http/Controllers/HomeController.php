<?php

namespace App\Http\Controllers;

use App\Models\ThongBao;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = auth()->user();

        // Redirect theo role của user
        if ($user->role === 'admin') {
            return redirect()->route('admin.welcome');
        } elseif ($user->role === 'teacher') {
            return redirect()->route('teacher.teacher');
        } else {
            return redirect()->route('parent.home');
        }
    }

    public function thongbao_detail(int $id)
    {
        $thongbao = ThongBao::findOrFail($id);

        if (!$thongbao->is_read) {
            $thongbao->is_read = true;
            $thongbao->save();
        }

        return response()->json([
            'title' => $thongbao->tieude,
            'content' => $thongbao->noidung,
            'created_at' => $thongbao->created_at->toDateTimeString(),
        ]);
    }
}
