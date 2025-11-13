@extends('admin.welcome')

@section('content')
    <div class="container-fluid" id="container-wrapper">

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Chỉnh sửa điểm danh</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.diemdanh.index') }}">Điểm danh</a></li>
                <li class="breadcrumb-item active" aria-current="page">Chỉnh sửa</li>
            </ol>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger shadow-sm">
                <ul class="mb-0 pl-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-10 mb-4 mx-auto">
                <div class="card shadow-lg border-0 rounded-lg">
                    <div class="card-header bg-primary text-white">
                        <h6 class="m-0 font-weight-bold"><i class="fas fa-edit"></i> Chỉnh sửa thông tin điểm danh</h6>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('admin.diemdanh.update', $diemdanh->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="mahocsinh">Học sinh</label>
                                    <select name="mahocsinh" id="mahocsinh" class="form-control" required>
                                        <option value="">-- Chọn học sinh --</option>
                                        @foreach ($hocsinh as $hs)
                                            <option value="{{ $hs->id }}"
                                                {{ old('mahocsinh', $diemdanh->mahocsinh) == $hs->id ? 'selected' : '' }}>
                                                {{ $hs->tenhocsinh }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="ngaydiemdanh">Ngày điểm danh</label>
                                    <input type="date" name="ngaydiemdanh" id="ngaydiemdanh" class="form-control"
                                        value="{{ old('ngaydiemdanh', $diemdanh->ngaydiemdanh) }}" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Trạng thái</label><br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input radio-co" type="radio" name="trangthai"
                                            value="có mặt"
                                            {{ old('trangthai', $diemdanh->trangthai) == 'có mặt' ? 'checked' : '' }}>
                                        <label class="form-check-label">Có mặt</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input radio-tre" type="radio" name="trangthai"
                                            value="trễ"
                                            {{ old('trangthai', $diemdanh->trangthai) == 'trễ' ? 'checked' : '' }}>
                                        <label class="form-check-label">Trễ</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input radio-vang" type="radio" name="trangthai"
                                            value="vắng mặt"
                                            {{ old('trangthai', $diemdanh->trangthai) == 'vắng mặt' ? 'checked' : '' }}>
                                        <label class="form-check-label">Vắng mặt</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input radio-nghi" type="radio" name="trangthai"
                                            value="nghỉ phép"
                                            {{ old('trangthai', $diemdanh->trangthai) == 'nghỉ phép' ? 'checked' : '' }}>
                                        <label class="form-check-label">Nghỉ phép</label>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="gioden">Giờ đến</label>
                                    <input type="time" name="gioden" id="gioden" class="form-control"
                                        value="{{ old('gioden', $diemdanh->gioden ? \Carbon\Carbon::parse($diemdanh->gioden)->format('H:i') : '') }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="giove">Giờ kết thúc</label>
                                    <input type="time" name="giove" id="giove" class="form-control"
                                        value="{{ old('giove', $diemdanh->giove ? \Carbon\Carbon::parse($diemdanh->giove)->format('H:i') : '') }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="nhietdo">Nhiệt độ (°C)</label>
                                    <input type="number" name="nhietdo" id="nhietdo" step="0.1" class="form-control"
                                        value="{{ old('nhietdo', $diemdanh->nhietdo) }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="magiaovien">Giáo viên điểm danh</label>
                                    <select name="magiaovien" id="magiaovien" class="form-control">
                                        <option value="">-- Chọn giáo viên --</option>
                                        @foreach ($giaovien as $gv)
                                            <option value="{{ $gv->id }}"
                                                {{ old('magiaovien', $diemdanh->magiaovien) == $gv->id ? 'selected' : '' }}>
                                                {{ $gv->tengiaovien }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="lydo">Lý do (nếu có)</label>
                                    <input type="text" name="lydo" id="lydo" class="form-control"
                                        value="{{ old('lydo', $diemdanh->lydo) }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="sophuttre">Số phút trễ (nếu có)</label>
                                    <input type="number" name="sophuttre" id="sophuttre" class="form-control"
                                        value="{{ old('sophuttre', $diemdanh->sophuttre) }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="tepdinhkem">Tệp đính kèm</label>
                                    <input type="file" name="tepdinhkem" id="tepdinhkem" class="form-control-file">
                                    @if ($diemdanh->tepdinhkem)
                                        <a href="{{ asset('storage/' . $diemdanh->tepdinhkem) }}" target="_blank"
                                            class="d-block mt-2 text-primary">
                                            <i class="fas fa-paperclip"></i> Xem tệp hiện tại
                                        </a>
                                    @endif
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="ghichu">Ghi chú</label>
                                    <textarea name="ghichu" id="ghichu" rows="3" class="form-control">{{ old('ghichu', $diemdanh->ghichu) }}</textarea>
                                </div>
                            </div>

                            <div class="text-right mt-4">
                                <button type="submit" class="btn btn-success shadow-sm px-4">
                                    <i class="fas fa-save"></i> Lưu
                                </button>
                                <a href="{{ route('admin.diemdanh.index') }}" class="btn btn-secondary shadow-sm px-4">
                                    <i class="fas fa-arrow-left"></i> Quay lại
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* màu radio theo trạng thái */
        .form-check-input.radio-co:checked {
            background-color: #28a745;
            border-color: #28a745;
        }

        .form-check-input.radio-vang:checked {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .form-check-input.radio-nghi:checked {
            background-color: #ffc107;
            border-color: #ffc107;
        }

        .form-check-label {
            color: black;
            font-weight: 600;
        }
    </style>

    <script>
        // Ẩn thông báo sau 3s
        setTimeout(() => {
            const alert = document.querySelector('.alert');
            if (alert) {
                alert.classList.remove('show');
                alert.classList.add('fade');
            }
        }, 3000);
    </script>
@endsection
