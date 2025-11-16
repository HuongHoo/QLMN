<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SucKhoe;
use App\Models\HocSinh;
use Illuminate\Http\Request;

class SucKhoeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hocsinhList = SucKhoe::with('hocsinh')->paginate(10);
            $hocsinhList = HocSinh::with(['suckhoe', 'lophoc'])->paginate(10);
            return view('admin.suckhoe.index', compact('hocsinhList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $hocsinh = HocSinh::all();
        return view('admin.suckhoe.create', compact('hocsinh'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'mahocsinh' => 'nullable|integer',
            'ngaykham' => 'nullable|date',
            'chieucao' => 'nullable|numeric',
            'cannang' => 'nullable|numeric',
            'tinhtrang' => 'nullable|string|max:255',
            'ghichu' => 'nullable|string',
        ]);

        SucKhoe::create($request->all());

        return redirect()->route('admin.suckhoe.index')
            ->with('success', 'Đã thêm bản ghi sức khỏe!');
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
    public function edit(string $id)
    {
        $suckhoe = SucKhoe::findOrFail($id);
        $hocsinh = HocSinh::all();
        return view('admin.suckhoe.edit', compact('suckhoe', 'hocsinh'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'mahocsinh' => 'nullable|integer',
            'ngaykham' => 'nullable|date',
            'chieucao' => 'nullable|numeric',
            'cannang' => 'nullable|numeric',
            'tinhtrang' => 'nullable|string|max:255',
            'ghichu' => 'nullable|string',
        ]);

        $sk = SucKhoe::findOrFail($id);
        $sk->update($request->all());

        return redirect()->route('admin.suckhoe.index')
            ->with('success', 'Đã cập nhật bản ghi sức khỏe!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        SucKhoe::findOrFail($id)->delete();

        return redirect()->route('admin.suckhoe.index')
            ->with('success', 'Đã xóa bản ghi!');
    }
}
