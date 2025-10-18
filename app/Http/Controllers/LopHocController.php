<?php

namespace App\Http\Controllers;

use App\Models\LopHoc;
use Illuminate\Http\Request;

class LopHocController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lophoc = LopHoc::paginate(10); // Lấy tất cả dữ liệu từ bảng lophoc
        return view('lophoc.index', compact('lophoc')); // Trả về
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('lophoc.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Add validation and store logic
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $lophoc = LopHoc::findOrFail($id);
        return view('lophoc.edit', compact('lophoc'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Add validation and update logic
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Add delete logic
    }
}
