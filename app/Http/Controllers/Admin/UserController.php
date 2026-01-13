<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::paginate(10);
        return view('admin.nguoidung.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.nguoidung.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'vaitro' => 'required|string|in:admin,teacher,parent',
            'trangthai' => 'required|string|in:hoatdong,khoa',
        ]);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'vaitro' => $request->input('vaitro'),
            'trangthai' => $request->input('trangthai'),
        ]);

        return redirect()->route('admin.nguoidung.index')->with('Thành công', 'Thêm người dùng thành công.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // $user = User::findOrFail($id);
        // return view('admin.nguoidung.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $nguoidung = User::findOrFail($id);
        return view('admin.nguoidung.edit', compact('nguoidung'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'vaitro' => 'required|string|in:admin,teacher,parent',
            'trangthai' => 'required|string|in:hoatdong,khoa',
        ]);
        $user = User::findOrFail($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->vaitro = $request->input('vaitro');
        $user->trangthai = $request->input('trangthai');
        $user->save();
        return redirect()->route('admin.nguoidung.index')->with('success', 'Cập nhật người dùng thành công.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.nguoidung.index')->with('Thành công', 'Xóa người dùng thành công.');
    }

    /**
     * Lock user account
     */
    public function lock(string $id)
    {
        $user = User::findOrFail($id);
        $user->is_locked = true;
        $user->save();

        return redirect()->route('admin.nguoidung.index')->with('success', 'Đã khóa tài khoản người dùng.');
    }

    /**
     * Unlock user account
     */
    public function unlock(string $id)
    {
        $user = User::findOrFail($id);
        $user->is_locked = false;
        $user->save();

        return redirect()->route('admin.nguoidung.index')->with('success', 'Đã mở khóa tài khoản người dùng.');
    }
}
