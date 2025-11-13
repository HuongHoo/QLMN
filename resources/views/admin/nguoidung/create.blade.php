@extends('admin.welcome')

@section('content')
    <div class="container-fluid" id="container-wrapper">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Thêm người dùng mới</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.nguoidung.index') }}">Người dùng</a></li>
                <li class="breadcrumb-item active" aria-current="page">Thêm mới</li>
            </ol>
        </div>

        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Thông tin người dùng</h6>
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

                        <form action="{{ route('admin.nguoidung.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">Họ và tên</label>
                                <input type="text" name="name" id="name"
                                    class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                    placeholder="Nhập họ và tên người dùng">
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email"
                                    class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                                    placeholder="Nhập email người dùng">
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password">Mật khẩu</label>
                                <input type="password" name="password" id="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Nhập mật khẩu">
                                @error('password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation">Xác nhận mật khẩu</label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="form-control" placeholder="Nhập lại mật khẩu">
                            </div>
                            <div class="form-group">
                                <label for="vaitro">Vai trò</label>
                                <select name="vaitro" id="vaitro"
                                    class="form-control @error('vaitro') is-invalid @enderror">
                                    <option value="">-- Chọn vai trò --</option>
                                    <option value="admin" {{ old('vaitro') == 'admin' ? 'selected' : '' }}>Quản trị viên
                                    </option>
                                    <option value="teacher" {{ old('vaitro') == 'teacher' ? 'selected' : '' }}>Giáo viên
                                    </option>
                                    <option value="parent" {{ old('vaitro') == 'parent' ? 'selected' : '' }}>Phụ huynh
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
                                    <option value="hoatdong" {{ old('trangthai') == 'hoatdong' ? 'selected' : '' }}>Hoạt
                                        động
                                    </option>
                                    <option value="khoa" {{ old('trangthai') == 'khoa' ? 'selected' : '' }}>Khóa
                                    </option>
                                </select>
                                @error('trangthai')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-success px-4">
                                    <i class="fas fa-save"></i> Lưu người dùng
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
