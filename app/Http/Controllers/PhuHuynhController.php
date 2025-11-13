<?php

namespace App\Http\Controllers;

use App\Models\PhuHuynh;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;


class PhuHuynhController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $phuhuynh = PhuHuynh::with('user')->paginate(10);
        return view('admin.phuhuynh.index', compact('phuhuynh'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $phuhuynh = new PhuHuynh();
        return view('admin.phuhuynh.create', compact('phuhuynh'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'hoten' => 'required|string|max:100',
            'quanhe' => 'required|in:bố,mẹ,ông,bà,người giám hộ',
            'sdt' => 'nullable|string|max:20',
            'email' => 'required|email|unique:users,email',
            'diachithuongtru' => 'nullable|string|max:300',
            'diachitamtru' => 'nullable|string|max:300',
            'nghenghiep' => 'nullable|string|max:100',
        ]);

        //1️⃣ Tạo user cho phụ huynh
        $user = User::create([
            'name' => $request->hoten,
            'email' => $request->email,
            'password' => Hash::make('12345678'), // mật khẩu mặc định
            'vaitro' => 'parent', // vai trò mặc định
        ]);

        // 2️⃣ Tạo phụ huynh
        PhuHuynh::create([
            'hoten' => $request->hoten,
            'quanhe' => $request->quanhe,
            'sdt' => $request->sdt,
            'email' => $request->email,
            'diachithuongtru' => $request->diachithuongtru,
            'diachitamtru' => $request->diachitamtru,
            'nghenghiep' => $request->nghenghiep,
            'user_id' => $user->id,
        ]);

        return redirect()->route('admin.phuhuynh.index')->with('success', 'Thêm phụ huynh thành công.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PhuHuynh $phuHuynh)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $phuhuynh = PhuHuynh::findOrFail($id);
        return view('admin.phuhuynh.edit', compact('phuhuynh'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $phuhuynh = PhuHuynh::findOrFail($id);
        $user = $phuhuynh->user;

        // Xác thực dữ liệu
        $request->validate([
            'hoten' => 'required|string|max:100',
            'quanhe' => 'required|in:bố,mẹ,ông,bà,người giám hộ',
            'sdt' => 'nullable|string|max:20',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($user?->id),
                Rule::unique('phuhuynh', 'email')->ignore($phuhuynh->id),
            ],
            'diachithuongtru' => 'nullable|string|max:300',
            'diachitamtru' => 'nullable|string|max:300',
            'nghenghiep' => 'nullable|string|max:100',
        ]);

        // Cập nhật hoặc tạo user
        if ($user) {
            $user->update([
                'name' => $request->hoten,
                'email' => $request->email,
            ]);
        } else {
            // nếu chưa có user thì tạo mới
            if (User::where('email', $request->email)->exists()) {
                return back()->withErrors(['email' => 'Email đã tồn tại trong hệ thống'])->withInput();
            }

            $user = User::create([
                'name' => $request->hoten,
                'email' => $request->email,
                'password' => Hash::make('12345678'),
                'vaitro' => 'parent',
            ]);

            $phuhuynh->user_id = $user->id;
        }

        // Cập nhật bảng phuhuynh
        $phuhuynh->update([
            'hoten' => $request->hoten,
            'quanhe' => $request->quanhe,
            'sdt' => $request->sdt,
            'email' => $request->email,
            'diachithuongtru' => $request->diachithuongtru,
            'diachitamtru' => $request->diachitamtru,
            'nghenghiep' => $request->nghenghiep,
        ]);

        $phuhuynh->save();

        return redirect()->route('admin.phuhuynh.index')->with('success', 'Cập nhật phụ huynh thành công.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $phuhuynh = PhuHuynh::findOrFail($id);
        $user = $phuhuynh->user;

        // Xóa phụ huynh
        $phuhuynh->delete();

        // Xóa user nếu có
        if ($user) {
            $user->delete();
        }

        return redirect()->route('admin.phuhuynh.index')->with('success', 'Xóa phụ huynh thành công.');
    }
}
