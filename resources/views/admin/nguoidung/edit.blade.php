@extends('admin.welcome')

@section('content')
    <div class="container-fluid" id="container-wrapper">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Cập nhật thông tin người dùng</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.nguoidung.index') }}">Người dùng</a></li>
                <li class="breadcrumb-item active" aria-current="page">Chỉnh sửa</li>
            </ol>
        </div>

        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Chỉnh sửa thông tin</h6>
                        <a href="{{ route('admin.nguoidung.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                    </div>

                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('admin.nguoidung.update', $nguoidung->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="name">Họ và tên</label>
                                <input type="text" name="name" id="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $nguoidung->name) }}">
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email', $nguoidung->email) }}">
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password">Mật khẩu mới (nếu muốn đổi)</label>
                                <input type="password" name="password" id="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Để trống nếu không muốn đổi mật khẩu">
                                @error('password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="vaitro">Vai trò</label>
                                <select name="vaitro" id="vaitro"
                                    class="form-control @error('vaitro') is-invalid @enderror">
                                    <option value="admin"
                                        {{ old('vaitro', $nguoidung->vaitro) == 'admin' ? 'selected' : '' }}>Quản trị viên
                                    </option>
                                    <option value="teacher"
                                        {{ old('vaitro', $nguoidung->vaitro) == 'teacher' ? 'selected' : '' }}>Giáo viên
                                    </option>
                                    <option value="parent"
                                        {{ old('vaitro', $nguoidung->vaitro) == 'parent' ? 'selected' : '' }}>Phụ huynh
                                    </option>
                                </select>
                                @error('vaitro')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="trangthai">Trạng thái</label>
                                <select name="trangthai" id="trangthai"
                                    class="form-control @error('trangthai') is-invalid @enderror">
                                    <option value="hoatdong"
                                        {{ old('trangthai', $nguoidung->trangthai) == 'hoatdong' ? 'selected' : '' }}>Hoạt
                                        động
                                    </option>
                                    <option value="khoa"
                                        {{ old('trangthai', $nguoidung->trangthai) == 'khoa' ? 'selected' : '' }}>Khóa
                                    </option>
                                </select>
                                @error('trangthai')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-success px-4">
                                    <i class="fas fa-save"></i> Cập nhật
                                </button>
                                <a href="{{ route('admin.nguoidung.index') }}" class="btn btn-secondary px-4">
                                    Hủy
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
