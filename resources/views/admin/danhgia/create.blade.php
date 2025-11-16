@extends('admin.welcome')

@section('content')
    <div class="container-fluid" id="container-wrapper">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Thêm đánh giá</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.danhgia.index') }}">Đánh giá</a></li>
                <li class="breadcrumb-item active" aria-current="page">Thêm mới</li>
            </ol>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-10 mx-auto mb-4">
                <div class="card shadow-lg border-0 rounded-lg">
                    <div class="card-header bg-primary text-white">
                        <h6 class="m-0 font-weight-bold"><i class="fas fa-star"></i> Nhập thông tin đánh giá</h6>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('admin.danhgia.store') }}" method="POST">
                            @csrf
                            <div class="row">

                                {{-- Học sinh --}}
                                <div class="col-md-6 mb-3">
                                    <label for="mahocsinh">Học sinh</label>
                                    <select name="mahocsinh" id="mahocsinh" class="form-control" required>
                                        <option value="">-- Chọn học sinh --</option>
                                        @foreach ($hocsinh as $hs)
                                            <option value="{{ $hs->id }}"
                                                {{ old('mahocsinh') == $hs->id ? 'selected' : '' }}>
                                                {{ $hs->tenhocsinh }} ({{ $hs->mathe }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Giáo viên --}}
                                <div class="col-md-6 mb-3">
                                    <label for="magiaovien">Giáo viên</label>
                                    <select name="magiaovien" id="magiaovien" class="form-control" required>
                                        <option value="">-- Chọn giáo viên --</option>
                                        @foreach ($giaovien as $gv)
                                            <option value="{{ $gv->id }}"
                                                {{ old('magiaovien') == $gv->id ? 'selected' : '' }}>
                                                {{ $gv->tengiaovien }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Năm --}}
                                <div class="col-md-3 mb-3">
                                    <label for="nam">Năm</label>
                                    <input type="number" name="nam" id="nam" class="form-control"
                                        value="{{ old('nam', date('Y')) }}">
                                </div>

                                {{-- Tháng --}}
                                <div class="col-md-3 mb-3">
                                    <label for="thang">Tháng</label>
                                    <input type="number" name="thang" id="thang" class="form-control"
                                        value="{{ old('thang', date('m')) }}">
                                </div>

                                {{-- Các lĩnh vực đánh giá --}}
                                @php
                                    $fields = [
                                        'thechat' => 'Thể chất',
                                        'ngonngu' => 'Ngôn ngữ',
                                        'nhanthuc' => 'Nhận thức',
                                        'camxucxahoi' => 'Cảm xúc xã hội',
                                        'nghethuat' => 'Nghệ thuật',
                                    ];
                                @endphp

                                @foreach ($fields as $key => $label)
                                    <div class="col-md-4 mb-3">
                                        <label for="{{ $key }}">{{ $label }}</label>
                                        <input type="number" name="{{ $key }}" id="{{ $key }}"
                                            class="form-control" min="0" max="10" value="{{ old($key) }}">
                                    </div>
                                @endforeach

                                {{-- Nhận xét chung --}}
                                <div class="col-md-12 mb-3">
                                    <label for="nhanxetchung">Nhận xét chung</label>
                                    <textarea name="nhanxetchung" id="nhanxetchung" rows="3" class="form-control">{{ old('nhanxetchung') }}</textarea>
                                </div>

                            </div>

                            <div class="text-right mt-4">
                                <button type="submit" class="btn btn-success shadow-sm px-4">
                                    <i class="fas fa-save"></i> Lưu
                                </button>
                                <a href="{{ route('admin.danhgia.index') }}" class="btn btn-secondary shadow-sm px-4">
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
