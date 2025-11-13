@extends('admin.welcome')

@section('content')
    <div class="container-fluid" id="container-wrapper">

        <!-- Tiêu đề trang + breadcrumb -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Thêm giáo viên mới</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.giaovien.index') }}">Giáo viên</a></li>
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

        <!-- Form thêm giáo viên -->
        <div class="row">
            <div class="col-lg-10 mb-4 mx-auto">
                <div class="card shadow-lg border-0 rounded-lg">
                    <div class="card-header bg-primary text-white">
                        <h6 class="m-0 font-weight-bold"><i class="fas fa-user-plus"></i> Nhập thông tin giáo viên</h6>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('admin.giaovien.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="sothe">Số thẻ</label>
                                    <input type="text" name="sothe" id="sothe" class="form-control"
                                        value="{{ old('sothe') }}" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="tengiaovien">Tên giáo viên</label>
                                    <input type="text" name="tengiaovien" id="tengiaovien" class="form-control"
                                        value="{{ old('tengiaovien') }}" required>
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
                                        <option value="khác" {{ old('gioitinh') == 'khác' ? 'selected' : '' }}>Khác
                                        </option>
                                    </select>
                                </div>


                                <div class="col-md-4 mb-3">
                                    <label for="sdt">Số điện thoại</label>
                                    <input type="text" name="sdt" id="sdt" class="form-control"
                                        value="{{ old('sdt') }}" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" id="email" class="form-control"
                                        value="{{ old('email') }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="chucvu">Chức vụ</label>
                                    <select name="chucvu" id="chucvu" class="form-control" required>
                                        <option value="">-- Chọn chức vụ --</option>
                                        <option value="giáo viên" {{ old('chucvu') == 'giáo viên' ? 'selected' : '' }}>Giáo
                                            viên</option>
                                        <option value="hiệu trưởng" {{ old('chucvu') == 'hiệu trưởng' ? 'selected' : '' }}>
                                            Hiệu trưởng</option>
                                        <option value="hiệu phó" {{ old('chucvu') == 'hiệu phó' ? 'selected' : '' }}>Hiệu
                                            phó
                                        </option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="malopchunhiem">Lớp chủ nhiệm</label>
                                    <select name="malopchunhiem" id="malopchunhiem" class="form-control">
                                        <option value="">-- Chọn lớp --</option>
                                        @foreach ($lophoc as $lop)
                                            <option value="{{ $lop->id }}"
                                                {{ old('malopchunhiem') == $lop->id ? 'selected' : '' }}>
                                                {{ $lop->tenlop }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="cccd">CCCD</label>
                                    <input type="text" name="cccd" id="cccd" class="form-control"
                                        value="{{ old('cccd') }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="ngayvaolam">Ngày vào làm</label>
                                    <input type="date" name="ngayvaolam" id="ngayvaolam" class="form-control"
                                        value="{{ old('ngayvaolam') }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="trangthai">Trạng thái</label>
                                    <select name="trangthai" id="trangthai" class="form-control">
                                        <option value="Đang công tác"
                                            {{ old('trangthai') == 'Đang công tác' ? 'selected' : '' }}>Đang công tác
                                        </option>
                                        <option value="Nghỉ phép" {{ old('trangthai') == 'Nghỉ phép' ? 'selected' : '' }}>
                                            Nghỉ phép</option>
                                        <option value="Đã nghỉ việc"
                                            {{ old('trangthai') == 'Đã nghỉ việc' ? 'selected' : '' }}>Đã nghỉ việc
                                        </option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="anh">Ảnh đại diện</label>
                                    <input type="file" name="anh" id="anh" class="form-control-file">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="diachithuongtru">Địa chỉ thường trú</label>
                                    <input type="text" name="diachithuongtru" id="diachithuongtru"
                                        class="form-control" value="{{ old('diachithuongtru') }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="diachitamtru">Địa chỉ tạm trú</label>
                                    <input type="text" name="diachitamtru" id="diachitamtru" class="form-control"
                                        value="{{ old('diachitamtru') }}">
                                </div>
                            </div>

                            <div class="text-right mt-4">
                                <button type="submit" class="btn btn-success shadow-sm px-4">
                                    <i class="fas fa-save"></i> Lưu
                                </button>
                                <a href="{{ route('admin.giaovien.index') }}" class="btn btn-secondary shadow-sm px-4">
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
