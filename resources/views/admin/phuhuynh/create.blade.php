@extends('admin.welcome')

@section('content')
    <div class="container-fluid" id="container-wrapper">

        <!-- Tiêu đề trang + breadcrumb -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Thêm phụ huynh mới</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.phuhuynh.index') }}">Phụ huynh</a></li>
                <li class="breadcrumb-item active" aria-current="page">Thêm mới</li>
            </ol>
        </div>

        <!-- Thông báo thành công -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <!-- Thông báo lỗi -->
        @if ($errors->any())
            <div class="alert alert-danger shadow-sm">
                <ul class="mb-0 pl-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form thêm phụ huynh -->
        <div class="row">
            <div class="col-lg-10 mb-4 mx-auto">
                <div class="card shadow-lg border-0 rounded-lg">
                    <div class="card-header bg-primary text-white">
                        <h6 class="m-0 font-weight-bold"><i class="fas fa-user-plus"></i> Nhập thông tin phụ huynh</h6>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('admin.phuhuynh.store') }}" method="POST">
                            @csrf
                            <div class="row">

                                <div class="col-md-6 mb-3">
                                    <label for="hoten">Tên phụ huynh</label>
                                    <input type="text" name="hoten" id="hoten" class="form-control"
                                        value="{{ old('hoten') }}" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="quanhe">Quan hệ</label>
                                    <select name="quanhe" id="quanhe" class="form-control" required>
                                        <option value="">-- Chọn quan hệ --</option>
                                        <option value="bố" {{ old('quanhe') == 'bố' ? 'selected' : '' }}>Bố</option>
                                        <option value="mẹ" {{ old('quanhe') == 'mẹ' ? 'selected' : '' }}>Mẹ</option>
                                        <option value="ông" {{ old('quanhe') == 'ông' ? 'selected' : '' }}>Ông</option>
                                        <option value="bà" {{ old('quanhe') == 'bà' ? 'selected' : '' }}>Bà</option>
                                        <option value="người giám hộ"
                                            {{ old('quanhe') == 'người giám hộ' ? 'selected' : '' }}>Người giám hộ</option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="sdt">Số điện thoại</label>
                                    <input type="text" name="sdt" id="sdt" class="form-control"
                                        value="{{ old('sdt') }}" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" id="email" class="form-control"
                                        value="{{ old('email') }}" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="diachithuongtru">Địa chỉ thường trú</label>
                                    <input type="text" name="diachithuongtru" id="diachithuongtru" class="form-control"
                                        value="{{ old('diachithuongtru') }}" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="diachitamtru">Địa chỉ tạm trú</label>
                                    <input type="text" name="diachitamtru" id="diachitamtru" class="form-control"
                                        value="{{ old('diachitamtru') }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="nghenghiep">Nghề nghiệp</label>
                                    <input type="text" name="nghenghiep" id="nghenghiep" class="form-control"
                                        value="{{ old('nghenghiep') }}">
                                </div>

                            </div>

                            <div class="text-right mt-4">
                                <button type="submit" class="btn btn-success shadow-sm px-4">
                                    <i class="fas fa-save"></i> Lưu
                                </button>
                                <a href="{{ route('admin.phuhuynh.index') }}" class="btn btn-secondary shadow-sm px-4">
                                    <i class="fas fa-arrow-left"></i> Quay lại
                                </a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Hiệu ứng alert tự động ẩn -->
    <script>
        setTimeout(() => {
            const alert = document.querySelector('.alert');
            if (alert) {
                alert.classList.remove('show');
                alert.classList.add('fade');
            }
        }, 3000);
    </script>
@endsection
