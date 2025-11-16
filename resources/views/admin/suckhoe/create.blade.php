@extends('admin.welcome')

@section('title', 'Thêm sức khỏe học sinh')

@section('content')
    <div class="container-fluid" id="container-wrapper">

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Thêm sức khỏe học sinh</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.suckhoe.index') }}">Sức khỏe</a></li>
                <li class="breadcrumb-item active" aria-current="page">Thêm mới</li>
            </ol>
        </div>

        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card shadow-sm border-0 rounded-lg">
                    <div class="card-header bg-primary text-white">
                        <h6 class="m-0 font-weight-bold"><i class="fas fa-notes-medical"></i> Nhập thông tin sức khỏe</h6>
                    </div>
                    <div class="card-body p-4">

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('admin.suckhoe.store') }}" method="POST">
                            @csrf

                            {{-- Học sinh --}}
                            <div class="form-group mb-3">
                                <label for="mahocsinh">Học sinh</label>
                                <select name="mahocsinh" id="mahocsinh" class="form-control">
                                    <option value="">-- Chọn học sinh --</option>
                                    @foreach ($hocsinh as $hs)
                                        <option value="{{ $hs->id }}"
                                            {{ old('mahocsinh') == $hs->id ? 'selected' : '' }}>
                                            {{ $hs->tenhocsinh }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Ngày khám + Tình trạng --}}
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="ngaykham">Ngày khám</label>
                                    <input type="date" name="ngaykham" id="ngaykham" class="form-control"
                                        value="{{ old('ngaykham') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="tinhtrang">Tình trạng sức khỏe</label>
                                    <input type="text" name="tinhtrang" id="tinhtrang" class="form-control"
                                        placeholder="Ví dụ: Khỏe mạnh, cảm nhẹ,..." value="{{ old('tinhtrang') }}">
                                </div>
                            </div>

                            {{-- Chiều cao + Cân nặng --}}
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="chieucao">Chiều cao (cm)</label>
                                    <input type="number" step="0.1" name="chieucao" id="chieucao" class="form-control"
                                        placeholder="Ví dụ: 112.5" value="{{ old('chieucao') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="cannang">Cân nặng (kg)</label>
                                    <input type="number" step="0.1" name="cannang" id="cannang" class="form-control"
                                        placeholder="Ví dụ: 19.8" value="{{ old('cannang') }}">
                                </div>
                            </div>

                            {{-- Ghi chú --}}
                            <div class="form-group mb-3">
                                <label for="ghichu">Ghi chú</label>
                                <textarea name="ghichu" id="ghichu" rows="3" class="form-control">{{ old('ghichu') }}</textarea>
                            </div>

                            <div class="text-right">
                                <button type="submit" class="btn btn-success shadow-sm px-4">
                                    <i class="fas fa-save"></i> Lưu
                                </button>
                                <a href="{{ route('admin.suckhoe.index') }}" class="btn btn-secondary shadow-sm px-4">
                                    <i class="fas fa-arrow-left"></i> Hủy
                                </a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
