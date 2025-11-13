@extends('admin.welcome')

@section('content')
    <div class="container-fluid" id="container-wrapper">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Cập nhật thông tin phụ huynh</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.phuhuynh.index') }}">Phụ huynh</a></li>
                <li class="breadcrumb-item active" aria-current="page">Chỉnh sửa</li>
            </ol>
        </div>

        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Chỉnh sửa thông tin</h6>
                        <a href="{{ route('admin.phuhuynh.index') }}" class="btn btn-secondary btn-sm">
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

                        <form action="{{ route('admin.phuhuynh.update', $phuhuynh->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">

                                <div class="col-md-6 mb-3">
                                    <label for="hoten">Họ tên</label>
                                    <input type="text" name="hoten" id="hoten" class="form-control"
                                        value="{{ old('hoten', $phuhuynh->hoten) }}" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="quanhe">Quan hệ</label>
                                    <select name="quanhe" id="quanhe" class="form-control" required>
                                        <option value="bố"
                                            {{ old('quanhe', $phuhuynh->quanhe) == 'bố' ? 'selected' : '' }}>Bố</option>
                                        <option value="mẹ"
                                            {{ old('quanhe', $phuhuynh->quanhe) == 'mẹ' ? 'selected' : '' }}>Mẹ</option>
                                        <option value="ông"
                                            {{ old('quanhe', $phuhuynh->quanhe) == 'ông' ? 'selected' : '' }}>Ông</option>
                                        <option value="bà"
                                            {{ old('quanhe', $phuhuynh->quanhe) == 'bà' ? 'selected' : '' }}>Bà</option>
                                        <option value="người giám hộ"
                                            {{ old('quanhe', $phuhuynh->quanhe) == 'người giám hộ' ? 'selected' : '' }}>
                                            Người giám hộ</option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="sdt">Số điện thoại</label>
                                    <input type="text" name="sdt" id="sdt" class="form-control"
                                        value="{{ old('sdt', $phuhuynh->sdt) }}" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" id="email" class="form-control"
                                        value="{{ old('email', $phuhuynh->email) }}" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="diachithuongtru">Địa chỉ thường trú</label>
                                    <input type="text" name="diachithuongtru" id="diachithuongtru" class="form-control"
                                        value="{{ old('diachithuongtru', $phuhuynh->diachithuongtru) }}" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="diachitamtru">Địa chỉ tạm trú</label>
                                    <input type="text" name="diachitamtru" id="diachitamtru" class="form-control"
                                        value="{{ old('diachitamtru', $phuhuynh->diachitamtru) }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="nghenghiep">Nghề nghiệp</label>
                                    <input type="text" name="nghenghiep" id="nghenghiep" class="form-control"
                                        value="{{ old('nghenghiep', $phuhuynh->nghenghiep) }}">
                                </div>

                            </div>

                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-success px-4">
                                    <i class="fas fa-save"></i> Cập nhật
                                </button>
                                <a href="{{ route('admin.phuhuynh.index') }}" class="btn btn-secondary px-4">
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
