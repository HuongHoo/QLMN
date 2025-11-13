@extends('admin.welcome')

@section('content')
    <div class="container-fluid" id="container-wrapper">

        <!-- Tiêu đề và breadcrumb -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Chỉnh sửa lớp học</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.lophoc.index') }}">Lớp học</a></li>
                <li class="breadcrumb-item active" aria-current="page">Chỉnh sửa</li>
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

        <!-- Form chỉnh sửa -->
        <div class="row">
            <div class="col-lg-8 mx-auto mb-4">
                <div class="card shadow-lg border-0 rounded-lg">
                    <div class="card-header bg-primary text-white">
                        <h6 class="m-0 font-weight-bold"><i class="fas fa-edit"></i> Cập nhật thông tin lớp học</h6>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('admin.lophoc.update', $lophoc->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="tenlop">Tên lớp</label>
                                <input type="text" name="tenlop" id="tenlop" class="form-control"
                                    value="{{ old('tenlop', $lophoc->tenlop) }}" required>
                            </div>

                            <div class="form-group">
                                <label for="nhomtuoi">Nhóm tuổi</label>
                                <input type="text" name="nhomtuoi" id="nhomtuoi" class="form-control"
                                    value="{{ old('nhomtuoi', $lophoc->nhomtuoi) }}" required>
                            </div>

                            <div class="form-group">
                                <label for="siso">Sĩ số</label>
                                <input type="number" name="siso" id="siso" class="form-control"
                                    value="{{ old('siso', $lophoc->siso) }}" required>
                            </div>

                            <div class="form-group">
                                <label for="sophong">Số phòng</label>
                                <input type="text" name="sophong" id="sophong" class="form-control"
                                    value="{{ old('sophong', $lophoc->sophong) }}">
                            </div>

                            <div class="form-group">
                                <label for="nienkhoa">Niên khóa</label>
                                <input type="text" name="nienkhoa" id="nienkhoa" class="form-control"
                                    value="{{ old('nienkhoa', $lophoc->nienkhoa) }}">
                            </div>

                            <div class="form-group">
                                <label for="ghichu">Ghi chú</label>
                                <textarea name="ghichu" id="ghichu" class="form-control">{{ old('ghichu', $lophoc->ghichu) }}</textarea>
                            </div>

                            <div class="text-right mt-4">
                                <button type="submit" class="btn btn-success shadow-sm px-4">
                                    <i class="fas fa-save"></i> Lưu
                                </button>
                                <a href="{{ route('admin.lophoc.index') }}" class="btn btn-secondary shadow-sm px-4">
                                    <i class="fas fa-arrow-left"></i> Quay lại
                                </a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
