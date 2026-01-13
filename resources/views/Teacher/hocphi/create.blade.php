@extends('teacher.teacher')

@section('content')
    <div class="col-12">
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-primary text-white">
                <h6 class="m-0 font-weight-bold"><i class="fas fa-wallet"></i> Thêm học phí mới</h6>
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

                <form action="{{ route('teacher.hocphi.store') }}" method="POST">
                    @csrf
                    <div class="row">

                        {{-- Học sinh --}}
                        <div class="col-md-6 mb-3">
                            <label for="mahocsinh">Học sinh <span class="text-danger">*</span></label>
                            <select name="mahocsinh" id="mahocsinh" class="form-control" required>
                                <option value="">-- Chọn học sinh --</option>
                                @foreach ($hocsinh as $hs)
                                    <option value="{{ $hs->id }}" {{ old('mahocsinh') == $hs->id ? 'selected' : '' }}>
                                        {{ $hs->tenhocsinh }} ({{ $hs->mathe ?? '' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Thời gian đóng --}}
                        <div class="col-md-6 mb-3">
                            <label for="thoigiandong">Thời gian đóng <span class="text-danger">*</span></label>
                            <input type="date" name="thoigiandong" id="thoigiandong" class="form-control"
                                value="{{ old('thoigiandong', date('Y-m-01')) }}" required>
                            <small class="text-muted">Mặc định ngày 01 tháng hiện tại</small>
                        </div>

                        {{-- Từ ngày --}}
                        <div class="col-md-6 mb-3">
                            <label for="tu_ngay">Tính từ ngày <small class="text-muted">(cho tiền ăn)</small></label>
                            <input type="date" name="tu_ngay" id="tu_ngay" class="form-control"
                                value="{{ old('tu_ngay') }}" onchange="loadSoNgayDiHoc()">
                        </div>

                        {{-- Đến ngày --}}
                        <div class="col-md-6 mb-3">
                            <label for="den_ngay">Đến ngày <small class="text-muted">(cho tiền ăn)</small></label>
                            <input type="date" name="den_ngay" id="den_ngay" class="form-control"
                                value="{{ old('den_ngay') }}" onchange="loadSoNgayDiHoc()">
                        </div>
                    </div>

                    <div class="row">
                        {{-- Giá tiền ăn/ngày --}}
                        <div class="col-md-4 mb-3">
                            <label for="gia_tien_an_ngay">Giá tiền ăn/ngày <small class="text-info">(tự động tính)</small></label>
                            <input type="number" step="1000" name="gia_tien_an_ngay" id="gia_tien_an_ngay" 
                                class="form-control" value="{{ old('gia_tien_an_ngay', 30000) }}"
                                onchange="loadSoNgayDiHoc()">
                        </div>

                        {{-- Số ngày đi học --}}
                        <div class="col-md-4 mb-3">
                            <label for="so_ngay_di_hoc">Số ngày đi học <small class="text-success">(từ điểm danh)</small></label>
                            <input type="number" name="so_ngay_di_hoc" id="so_ngay_di_hoc" 
                                class="form-control bg-light" value="{{ old('so_ngay_di_hoc', 0) }}" readonly>
                        </div>

                        {{-- Tiền ăn trưa (tự động) --}}
                        <div class="col-md-4 mb-3">
                            <label for="tienantrua_auto">Tiền ăn trưa <small class="text-success">(tự động)</small></label>
                            <input type="number" step="1000" name="tienantrua_auto" id="tienantrua_auto"
                                class="form-control bg-light" value="{{ old('tienantrua_auto', 0) }}" readonly>
                        </div>
                    </div>

                    <div class="info mb-3">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Lưu ý:</strong> Mức học phí và các loại phí được quản lý bởi Admin. Bạn chỉ cần nhập thông
                        tin thanh toán của học sinh.
                    </div>

                    @if ($mucPhiMacDinh)
                        <div class="card mb-3 border-primary">
                            <div class="card-header bg-light">
                                <h6 class="mb-0"><i class="fas fa-money-bill-wave text-primary me-2"></i>Mức phí hiện tại
                                    của lớp</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <small class="text-muted">Học phí</small>
                                        <p class="mb-0 fw-bold">{{ number_format($mucPhiMacDinh->hocphi ?? 0) }} ₫</p>
                                    </div>
                                    <div class="col-md-3">
                                        <small class="text-muted">Tiền ăn sáng</small>
                                        <p class="mb-0 fw-bold">{{ number_format($mucPhiMacDinh->tienansang ?? 0) }} ₫</p>
                                    </div>
                                    <div class="col-md-3">
                                        <small class="text-muted">Tiền ăn trưa</small>
                                        <p class="mb-0 fw-bold">{{ number_format($mucPhiMacDinh->tienantrua ?? 0) }} ₫</p>
                                    </div>
                                    <div class="col-md-3">
                                        <small class="text-muted">Tiền xe bus</small>
                                        <p class="mb-0 fw-bold">{{ number_format($mucPhiMacDinh->tienxebus ?? 0) }} ₫</p>
                                    </div>
                                </div>
                                <hr class="my-2">
                                <div class="row">
                                    <div class="col-md-6">
                                        <small class="text-muted">Phí khác</small>
                                        <p class="mb-0 fw-bold">{{ number_format($mucPhiMacDinh->phikhac ?? 0) }} ₫</p>
                                    </div>
                                    <div class="col-md-6 text-end">
                                        <small class="text-muted">Tổng cộng</small>
                                        <p class="mb-0 fw-bold text-primary" style="font-size: 1.2rem;">
                                            {{ number_format(($mucPhiMacDinh->hocphi ?? 0) + ($mucPhiMacDinh->tienansang ?? 0) + ($mucPhiMacDinh->tienantrua ?? 0) + ($mucPhiMacDinh->tienxebus ?? 0) + ($mucPhiMacDinh->phikhac ?? 0)) }}
                                            ₫
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-warning mb-3">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Chưa có mức phí mặc định cho lớp. Vui lòng liên hệ Admin để thiết lập mức phí.
                        </div>
                    @endif

                    <div class="row">
                        {{-- Ngày thanh toán --}}
                        <div class="col-md-6 mb-3">
                            <label for="ngaythanhtoan">Ngày thanh toán <span class="text-danger">*</span></label>
                            <input type="date" name="ngaythanhtoan" id="ngaythanhtoan" class="form-control"
                                value="{{ old('ngaythanhtoan', date('Y-m-d')) }}" required>
                            <small class="text-muted">Ngày phụ huynh nộp tiền</small>
                        </div>

                        {{-- Đã thanh toán --}}
                        <div class="col-md-6 mb-3">
                            <label for="dathanhtoan">Số tiền đã thanh toán <span class="text-danger">*</span></label>
                            <input type="number" step="1000" min="0" name="dathanhtoan" id="dathanhtoan"
                                class="form-control" value="{{ old('dathanhtoan', 0) }}" required>
                            <small class="text-muted">Nhập số tiền phụ huynh đã nộp</small>
                        </div>

                        {{-- Ghi chú --}}
                        <div class="col-md-12 mb-3">
                            <label for="ghichu">Ghi chú</label>
                            <textarea name="ghichu" id="ghichu" rows="3" class="form-control" placeholder="Nhập ghi chú (nếu có)...">{{ old('ghichu') }}</textarea>
                        </div>

                    </div>

                    <div class="text-right mt-3">
                        <button type="submit" class="btn btn-success shadow-sm px-4">
                            <i class="fas fa-save"></i> Lưu học phí
                        </button>
                        <a href="{{ route('teacher.hocphi.index') }}" class="btn btn-secondary shadow-sm px-4">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Tự động tải số ngày đi học từ điểm danh
        function loadSoNgayDiHoc() {
            const mahocsinh = document.getElementById('mahocsinh').value;
            const tuNgay = document.getElementById('tu_ngay').value;
            const denNgay = document.getElementById('den_ngay').value;
            const giaTienAn = parseFloat(document.getElementById('gia_tien_an_ngay').value) || 0;

            if (!mahocsinh || !tuNgay || !denNgay) {
                return;
            }

            // Gọi API để lấy số ngày đi học
            fetch(`/teacher/hocphi/get-so-ngay-di-hoc?mahocsinh=${mahocsinh}&tu_ngay=${tuNgay}&den_ngay=${denNgay}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('so_ngay_di_hoc').value = data.so_ngay_di_hoc;
                    // Tự động tính tiền ăn trưa
                    const tienAnTrua = data.so_ngay_di_hoc * giaTienAn;
                    document.getElementById('tienantrua_auto').value = tienAnTrua.toFixed(0);
                })
                .catch(error => {
                    console.error('Lỗi:', error);
                });
        }

        // Thêm sự kiện khi chọn học sinh
        document.getElementById('mahocsinh').addEventListener('change', loadSoNgayDiHoc);
    </script>
@endsection
