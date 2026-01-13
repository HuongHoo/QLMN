@extends('admin.welcome')

@section('title', 'Thêm học phí')

@section('content')
    <div class="container-fluid" id="container-wrapper">

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Thêm học phí</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.hocphi.index') }}">Học phí</a></li>
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
                        <h6 class="m-0 font-weight-bold"><i class="fas fa-wallet"></i> Nhập thông tin học phí</h6>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('admin.hocphi.store') }}" method="POST">
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
                                                {{ $hs->tenhocsinh }} ({{ $hs->mathe ?? '' }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Thời gian đóng --}}
                                <div class="col-md-6 mb-3">
                                    <label for="thoigiandong">Thời gian đóng</label>
                                    <input type="date" name="thoigiandong" id="thoigiandong" class="form-control"
                                        value="{{ old('thoigiandong') }}" required>
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

                                {{-- Học phí --}}
                                <div class="col-md-4 mb-3">
                                    <label for="hocphi">Học phí</label>
                                    <input type="number" step="0.01" name="hocphi" id="hocphi" class="form-control"
                                        value="{{ old('hocphi', 0) }}">
                                </div>

                                {{-- Giá tiền ăn/ngày --}}
                                <div class="col-md-4 mb-3">
                                    <label for="gia_tien_an_ngay">Giá tiền ăn/ngày <small class="text-info">(tự động tính)</small></label>
                                    <input type="number" step="0.01" name="gia_tien_an_ngay" id="gia_tien_an_ngay" 
                                        class="form-control" value="{{ old('gia_tien_an_ngay', 30000) }}"
                                        onchange="loadSoNgayDiHoc()">
                                </div>

                                {{-- Số ngày đi học --}}
                                <div class="col-md-4 mb-3">
                                    <label for="so_ngay_di_hoc">Số ngày đi học <small class="text-success">(từ điểm danh)</small></label>
                                    <input type="number" name="so_ngay_di_hoc" id="so_ngay_di_hoc" 
                                        class="form-control bg-light" value="{{ old('so_ngay_di_hoc', 0) }}" readonly>
                                </div>

                                {{-- Tiền ăn sáng --}}
                                <div class="col-md-3 mb-3">
                                    <label for="tienansang">Tiền ăn sáng <small class="text-muted">(tùy chỉnh)</small></label>
                                    <input type="number" step="0.01" name="tienansang" id="tienansang"
                                        class="form-control" value="{{ old('tienansang', 0) }}">
                                </div>

                                {{-- Tiền ăn trưa --}}
                                <div class="col-md-3 mb-3">
                                    <label for="tienantrua">Tiền ăn trưa <small class="text-success">(tự động)</small></label>
                                    <input type="number" step="0.01" name="tienantrua" id="tienantrua"
                                        class="form-control bg-light" value="{{ old('tienantrua', 0) }}" readonly>
                                </div>

                                {{-- Tiền xe --}}
                                <div class="col-md-3 mb-3">
                                    <label for="tienxebus">Tiền xe bus</label>
                                    <input type="number" step="0.01" name="tienxebus" id="tienxebus"
                                        class="form-control" value="{{ old('tienxebus', 0) }}">
                                </div>

                                {{-- Phí khác --}}
                                <div class="col-md-3 mb-3">
                                    <label for="phikhac">Phí khác</label>
                                    <input type="number" step="0.01" name="phikhac" id="phikhac" class="form-control"
                                        value="{{ old('phikhac', 0) }}">
                                </div>

                                {{-- Tổng tiền (tự tính) --}}
                                <div class="col-md-3 mb-3">
                                    <label for="tongtien">Tổng tiền</label>
                                    <input type="number" step="0.01" name="tongtien" id="tongtien" class="form-control"
                                        value="{{ old('tongtien', 0) }}" readonly>
                                </div>

                                {{-- Ngày thanh toán --}}
                                <div class="col-md-3 mb-3">
                                    <label for="ngaythanhtoan">Ngày thanh toán</label>
                                    <input type="date" name="ngaythanhtoan" id="ngaythanhtoan" class="form-control"
                                        value="{{ old('ngaythanhtoan') }}" required>
                                </div>

                                {{-- Đã thanh toán --}}
                                <div class="col-md-3 mb-3">
                                    <label for="dathanhtoan">Đã thanh toán</label>
                                    <input type="number" step="0.01" name="dathanhtoan" id="dathanhtoan"
                                        class="form-control" value="{{ old('dathanhtoan', 0) }}">
                                </div>

                                {{-- Giáo viên thu --}}
                                <div class="col-md-4 mb-3">
                                    <label for="magiaovien">Giáo viên thu</label>
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
                                <div class="col-md-8 mb-3">
                                    <label for="ghichu">Ghi chú</label>
                                    <textarea name="ghichu" id="ghichu" rows="2" class="form-control">{{ old('ghichu') }}</textarea>
                                </div>

                            </div>

                            <div class="text-right mt-4">
                                <button type="submit" class="btn btn-success shadow-sm px-4">
                                    <i class="fas fa-save"></i> Lưu
                                </button>
                                <a href="{{ route('admin.hocphi.index') }}" class="btn btn-secondary shadow-sm px-4">
                                    <i class="fas fa-arrow-left"></i> Quay lại
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
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
            fetch(`/admin/hocphi/get-so-ngay-di-hoc?mahocsinh=${mahocsinh}&tu_ngay=${tuNgay}&den_ngay=${denNgay}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('so_ngay_di_hoc').value = data.so_ngay_di_hoc;
                    // Tự động tính tiền ăn trưa
                    const tienAnTrua = data.so_ngay_di_hoc * giaTienAn;
                    document.getElementById('tienantrua').value = tienAnTrua.toFixed(2);
                    updateTongTien();
                })
                .catch(error => {
                    console.error('Lỗi:', error);
                });
        }

        // Thêm sự kiện khi chọn học sinh
        document.getElementById('mahocsinh').addEventListener('change', loadSoNgayDiHoc);

        // Tự động tính tổng tiền khi thay đổi các khoản
        function updateTongTien() {
            const hocphi = parseFloat(document.getElementById('hocphi').value) || 0;
            const sang = parseFloat(document.getElementById('tienansang').value) || 0;
            const trua = parseFloat(document.getElementById('tienantrua').value) || 0;
            const xe = parseFloat(document.getElementById('tienxebus').value) || 0;
            const khac = parseFloat(document.getElementById('phikhac').value) || 0;
            document.getElementById('tongtien').value = (hocphi + sang + trua + xe + khac).toFixed(2);
        }

        ['hocphi', 'tienansang', 'tienantrua', 'tienxebus', 'phikhac'].forEach(id => {
            document.getElementById(id).addEventListener('input', updateTongTien);
        });

        // Tính lần đầu
        updateTongTien();
    </script>
@endsection
