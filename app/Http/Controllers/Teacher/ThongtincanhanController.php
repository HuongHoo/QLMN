<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class ThongtincanhanController extends Controller
{
    public function index()
    {
        $teacher = Auth::user()->giaoVien()->with('lophoc')->first();

        if (!$teacher) {
            return abort(404, 'Không tìm thấy thông tin giáo viên');
        }

        return view("teacher.thongtincanhan.index", compact('teacher'));
    }
}
