@extends('admin.welcome')

@section('content')
    <div class="container-fluid" id="container-wrapper">

        <!-- Tiêu đề trang + breadcrumb -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Thêm học sinh mới</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.hocsinh.index') }}">Học sinh</a></li>
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

        <!-- Form thêm học sinh -->
        <div class="row">
            <div class="col-lg-10 mb-4 mx-auto">
                <div class="card shadow-lg border-0 rounded-lg">
                    <div class="card-header bg-primary text-white">
                        <h6 class="m-0 font-weight-bold"><i class="fas fa-user-plus"></i> Nhập thông tin học sinh</h6>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('admin.hocsinh.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="mathe">Mã thẻ</label>
                                    <input type="text" name="mathe" id="mathe" class="form-control"
                                        value="{{ old('mathe') }}" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="tenhocsinh">Họ Tên</label>
                                    <input type="text" name="tenhocsinh" id="tenhocsinh" class="form-control"
                                        value="{{ old('tenhocsinh') }}" required>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="ngaysinh">Ngày sinh</label>
                                    <input type="date" name="ngaysinh" id="ngaysinh" class="form-control"
                                        value="{{ old('ngaysinh') }}" required>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="gioitinh">Giới tính</label>
                                    <select name="gioitinh" id="gioitinh" class="form-control" required>
                                        <option value="">-- Chọn giới tính --</option>
                                        <option value="nam" {{ old('gioitinh') == 'nam' ? 'selected' : '' }}>Nam</option>
                                        <option value="nữ" {{ old('gioitinh') == 'nữ' ? 'selected' : '' }}>Nữ</option>
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="ngaynhaphoc">Ngày nhập học</label>
                                    <input type="date" name="ngaynhaphoc" id="ngaynhaphoc" class="form-control"
                                        value="{{ old('ngaynhaphoc') }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="malop">Lớp</label>
                                    <select name="malop" id="malop" class="form-control">
                                        <option value="">-- Chọn lớp --</option>
                                        @foreach ($lophoc as $lop)
                                            <option value="{{ $lop->id }}"
                                                {{ old('malop') == $lop->id ? 'selected' : '' }}>
                                                {{ $lop->tenlop }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                {{-- <div class="col-md-6 mb-3">
                                    <label for="maphuhuynh">Phụ huynh</label>
                                    <select name="maphuhuynh" id="maphuhuynh" class="form-control">
                                        <option value="">-- Chọn phụ huynh --</option>
                                        @foreach ($phuhuynh as $ph)
                                            <option value="{{ $ph->id }}"
                                                {{ old('maphuhuynh') == $ph->id ? 'selected' : '' }}>
                                                {{ $ph->hoten }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div> --}}
                                <div class="col-md-6 mb-3">
                                    <label for="maphuhuynh">Phụ huynh</label>
                                    <select name="maphuhuynh" id="maphuhuynh" class="form-control">
                                        <option value="">-- Chọn phụ huynh --</option>
                                        @foreach ($phuhuynh as $ph)
                                            <option value="{{ $ph->id }}"
                                                {{ old('maphuhuynh') == $ph->id ? 'selected' : '' }}>{{ $ph->hoten }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>


                                <div class="col-md-6 mb-3">
                                    <label for="diachithuongtru">Địa chỉ thường trú</label>
                                    <input type="text" name="diachithuongtru" id="diachithuongtru" class="form-control"
                                        value="{{ old('diachithuongtru') }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="diachitamtru">Địa chỉ tạm trú</label>
                                    <input type="text" name="diachitamtru" id="diachitamtru" class="form-control"
                                        value="{{ old('diachitamtru') }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="trangthai">Trạng thái</label>
                                    <select name="trangthai" id="trangthai" class="form-control">
                                        <option value="đang học" {{ old('trangthai') == 'đang học' ? 'selected' : '' }}>
                                            Đang học</option>
                                        <option value="nghỉ học" {{ old('trangthai') == 'nghỉ học' ? 'selected' : '' }}>
                                            Nghỉ học</option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="anh">Ảnh học sinh</label>
                                    <input type="file" name="anh" id="anh" class="form-control-file">
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="ghichusuckhoe">Ghi chú sức khỏe</label>
                                    <textarea name="ghichusuckhoe" id="ghichusuckhoe" rows="3" class="form-control">{{ old('ghichusuckhoe') }}</textarea>
                                </div>

                            </div>

                            <div class="text-right mt-4">
                                <button type="submit" class="btn btn-success shadow-sm px-4">
                                    <i class="fas fa-save"></i> Lưu
                                </button>
                                <a href="{{ route('admin.hocsinh.index') }}" class="btn btn-secondary shadow-sm px-4">
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
