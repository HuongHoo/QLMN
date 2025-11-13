@extends('admin.welcome')

@section('content')
    <div class="container-fluid" id="container-wrapper">

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Thêm điểm danh</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.diemdanh.index') }}">Điểm danh</a></li>
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
                        <h6 class="m-0 font-weight-bold"><i class="fas fa-user-check"></i> Nhập thông tin điểm danh</h6>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('admin.diemdanh.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">

                                {{-- Học sinh --}}
                                <div class="col-md-4 mb-3">
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

                                {{-- Ngày điểm danh --}}
                                <div class="col-md-3 mb-3">
                                    <label for="ngaydiemdanh">Ngày điểm danh</label>
                                    <input type="date" name="ngaydiemdanh" id="ngaydiemdanh" class="form-control"
                                        value="{{ old('ngaydiemdanh') }}" required>
                                </div>

                                {{-- Trạng thái --}}
                                <div class="col-md-5 mb-3">
                                    <label>Trạng thái</label>
                                    <div class="d-flex align-items-center">
                                        <div class="form-check mr-3">
                                            <input class="form-check-input" type="radio" name="trangthai" id="comat"
                                                value="có mặt" {{ old('trangthai') == 'có mặt' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="comat">Có mặt</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="trangthai" id="tre"
                                                value="trễ"
                                                {{ old('trangthai', $diemdanh->trangthai ?? '') == 'trễ' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="tre">Trễ</label>
                                        </div>

                                        <div class="form-check mr-3">
                                            <input class="form-check-input" type="radio" name="trangthai" id="vangmat"
                                                value="vắng mặt" {{ old('trangthai') == 'vắng mặt' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="vangmat">Vắng mặt</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="trangthai" id="nghiphep"
                                                value="nghỉ phép" {{ old('trangthai') == 'nghỉ phép' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="nghiphep">Nghỉ phép</label>
                                        </div>
                                    </div>
                                </div>

                                {{-- Giờ bắt đầu --}}
                                <div class="col-md-3 mb-3">
                                    <label for="gioden">Giờ đến</label>
                                    <input type="time" name="gioden" id="gioden" class="form-control"
                                        value="{{ old('gioden') }}">
                                </div>

                                {{-- Giờ kết thúc --}}
                                <div class="col-md-3 mb-3">
                                    <label for="giove">Giờ về</label>
                                    <input type="time" name="giove" id="giove" class="form-control"
                                        value="{{ old('giove') }}">
                                </div>

                                {{-- Lý do --}}
                                <div class="col-md-6 mb-3">
                                    <label for="lydo">Lý do</label>
                                    <input type="text" name="lydo" id="lydo" class="form-control"
                                        value="{{ old('lydo') }}">
                                </div>
                                {{-- Số phút trễ --}}
                                {{-- Số phút trễ --}}
                                <div class="col-md-6 mb-3">
                                    <label for="sophuttre">Số phút trễ (nếu có)</label>
                                    <input type="number" name="sophuttre" id="sophuttre" class="form-control"
                                        value="{{ old('sophuttre') }}" readonly>
                                </div>

                                <script>
                                    document.getElementById('gioden').addEventListener('input', function() {
                                        const gioBatDau = 7 * 60; // 7:00 tính bằng phút
                                        const giodenValue = this.value; // định dạng "HH:MM"
                                        if (giodenValue) {
                                            const [h, m] = giodenValue.split(':').map(Number);
                                            const gioDen = h * 60 + m;
                                            const tre = Math.max(0, gioDen - gioBatDau);
                                            document.getElementById('sophuttre').value = tre;
                                        } else {
                                            document.getElementById('sophuttre').value = 0;
                                        }
                                    });
                                </script>
                                {{-- File đính kèm --}}
                                <div class="col-md-6 mb-3">
                                    <label for="tepdinhkem">File đính kèm</label>
                                    <input type="file" name="tepdinhkem" id="tepdinhkem" class="form-control-file">
                                </div>

                                {{-- Nhiệt độ --}}
                                <div class="col-md-3 mb-3">
                                    <label for="nhietdo">Nhiệt độ (°C)</label>
                                    <input type="number" step="0.1" name="nhietdo" id="nhietdo"
                                        class="form-control" value="{{ old('nhietdo') }}">
                                </div>

                                {{-- Giáo viên --}}
                                <div class="col-md-4 mb-3">
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

                                {{-- Ghi chú --}}
                                <div class="col-md-5 mb-3">
                                    <label for="ghichu">Ghi chú</label>
                                    <textarea name="ghichu" id="ghichu" rows="1" class="form-control">{{ old('ghichu') }}</textarea>
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
@endsection
