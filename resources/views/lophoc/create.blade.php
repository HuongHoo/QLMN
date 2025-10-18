@extends('admin.welcome')

@section('content')
<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Thêm lớp học mới</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('lophoc.index') }}">Lớp học</a></li>
            <li class="breadcrumb-item active" aria-current="page">Thêm mới</li>
        </ol>
    </div>

    <div class="row">
        <div class="col-lg-8 mb-4">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Nhập thông tin lớp học</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('lophoc.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="tenlop">Tên lớp</label>
                            <input type="text" class="form-control" id="tenlop" name="tenlop" value="{{ old('tenlop') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="nhomtuoi">Nhóm tuổi</label>
                            <input type="text" class="form-control" id="nhomtuoi" name="nhomtuoi" value="{{ old('nhomtuoi') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="siso">Sĩ số</label>
                            <input type="number" class="form-control" id="siso" name="siso" value="{{ old('siso') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="sophong">Số phòng</label>
                            <input type="text" class="form-control" id="sophong" name="sophong" value="{{ old('sophong') }}">
                        </div>
                        <div class="form-group">
                            <label for="nienkhoa">Niên khóa</label>
                            <input type="text" class="form-control" id="nienkhoa" name="nienkhoa" value="{{ old('nienkhoa') }}">
                        </div>
                        <div class="form-group">
                            <label for="ghichu">Ghi chú</label>
                            <textarea class="form-control" id="ghichu" name="ghichu">{{ old('ghichu') }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Lưu</button>
                        <a href="{{ route('lophoc.index') }}" class="btn btn-secondary">Quay lại</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection