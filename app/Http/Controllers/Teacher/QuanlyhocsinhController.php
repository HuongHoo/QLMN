<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Hocsinh;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class QuanlyhocsinhController extends Controller
{
    public function index()
    {
        $teacher = Auth::user()->giaoVien;
        $lophoc = $teacher->lophoc;
        $hocsinhs = Hocsinh::where('malop', $lophoc->id)->get();
        return view("teacher.hocsinh.index", compact('hocsinhs', 'lophoc', 'teacher'));
    }
}
