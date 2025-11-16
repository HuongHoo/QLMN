@extends('admin.welcome')

@section('content')
    <div class="container-fluid" id="container-wrapper">

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Chỉnh sửa thông tin sức khỏe</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.suckhoe.index') }}">Sức khỏe</a></li>
                <li class="breadcrumb-item active">Chỉnh sửa</li>
            </ol>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-10 mb-4 mx-auto">
                <div class="card shadow-lg border-0 rounded-lg">
                    <div class="card-header bg-primary text-white">
                        <h6 class="m-0 font-weight-bold"><i class="fas fa-user-md"></i> Chỉnh sửa sức khỏe học sinh</h6>
                    </div>

                    <div class="card-body p-4">
                        <form action="{{ route('admin.suckhoe.update', $suckhoe->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <!-- Học sinh -->
                                <div class="col-md-6 mb-3">
                                    <label for="mahocsinh">Học sinh</label>
                                    <select name="mahocsinh" id="mahocsinh" class="form-control">
                                        <option value="">-- Chọn học sinh --</option>
                                        @foreach ($hocsinh as $hs)
                                            <option value="{{ $hs->id }}"
                                                {{ old('mahocsinh', $suckhoe->mahocsinh) == $hs->id ? 'selected' : '' }}>
                                                {{ $hs->tenhocsinh }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Ngày khám -->
                                <div class="col-md-6 mb-3">
                                    <label for="ngaykham">Ngày khám</label>
                                    <input type="date" name="ngaykham" id="ngaykham" class="form-control"
                                        value="{{ old('ngaykham', $suckhoe->ngaykham) }}">
                                </div>

                                <!-- Chiều cao -->
                                <div class="col-md-6 mb-3">
                                    <label for="chieucao">Chiều cao (cm)</label>
                                    <input type="number" step="0.1" name="chieucao" id="chieucao" class="form-control"
                                        value="{{ old('chieucao', $suckhoe->chieucao) }}">
                                </div>

                                <!-- Cân nặng -->
                                <div class="col-md-6 mb-3">
                                    <label for="cannang">Cân nặng (kg)</label>
                                    <input type="number" step="0.1" name="cannang" id="cannang" class="form-control"
                                        value="{{ old('cannang', $suckhoe->cannang) }}">
                                </div>

                                <!-- Tình trạng -->
                                <div class="col-md-12 mb-3">
                                    <label for="tinhtrang">Tình trạng sức khỏe</label>
                                    <input type="text" name="tinhtrang" id="tinhtrang" class="form-control"
                                        value="{{ old('tinhtrang', $suckhoe->tinhtrang) }}">
                                </div>

                                <!-- Ghi chú -->
                                <div class="col-md-12 mb-3">
                                    <label for="ghichu">Ghi chú</label>
                                    <textarea name="ghichu" id="ghichu" rows="3" class="form-control">{{ old('ghichu', $suckhoe->ghichu) }}</textarea>
                                </div>
                            </div>

                            <div class="text-right mt-4">
                                <button type="submit" class="btn btn-success shadow-sm px-4">
                                    <i class="fas fa-save"></i> Lưu
                                </button>
                                <a href="{{ route('admin.suckhoe.index') }}" class="btn btn-secondary shadow-sm px-4">
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
