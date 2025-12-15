@extends('teacher.teacher')

@section('content')
    <div class="col-12">
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-warning text-white">
                <h6 class="m-0 font-weight-bold"><i class="fas fa-edit"></i> Sửa học phí</h6>
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

                <form action="{{ route('teacher.hocphi.update', $hocphi->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">

                        {{-- Học sinh --}}
                        <div class="col-md-6 mb-3">
                            <label for="mahocsinh">Học sinh <span class="text-danger">*</span></label>
                            <select name="mahocsinh" id="mahocsinh" class="form-control" required>
                                <option value="">-- Chọn học sinh --</option>
                                @foreach ($hocsinh as $hs)
                                    <option value="{{ $hs->id }}"
                                        {{ old('mahocsinh', $hocphi->mahocsinh) == $hs->id ? 'selected' : '' }}>
                                        {{ $hs->tenhocsinh }} ({{ $hs->mathe ?? '' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Thời gian đóng --}}
                        <div class="col-md-6 mb-3">
                            <label for="thoigiandong">Thời gian đóng <span class="text-danger">*</span></label>
                            <input type="date" name="thoigiandong" id="thoigiandong" class="form-control"
                                value="{{ old('thoigiandong', $hocphi->thoigiandong) }}" required>
                        </div>

                        {{-- Học phí --}}
                        <div class="col-md-3 mb-3">
                            <label for="hocphi">Học phí</label>
                            <input type="number" step="1000" min="0" name="hocphi" id="hocphi"
                                class="form-control" value="{{ old('hocphi', $hocphi->hocphi ?? 0) }}">
                        </div>

                        {{-- Tiền ăn sáng --}}
                        <div class="col-md-3 mb-3">
                            <label for="tienansang">Tiền ăn sáng</label>
                            <input type="number" step="1000" min="0" name="tienansang" id="tienansang"
                                class="form-control" value="{{ old('tienansang', $hocphi->tienansang ?? 0) }}">
                        </div>

                        {{-- Tiền ăn trưa --}}
                        <div class="col-md-3 mb-3">
                            <label for="tienantrua">Tiền ăn trưa</label>
                            <input type="number" step="1000" min="0" name="tienantrua" id="tienantrua"
                                class="form-control" value="{{ old('tienantrua', $hocphi->tienantrua ?? 0) }}">
                        </div>

                        {{-- Tiền xe --}}
                        <div class="col-md-3 mb-3">
                            <label for="tienxebus">Tiền xe bus</label>
                            <input type="number" step="1000" min="0" name="tienxebus" id="tienxebus"
                                class="form-control" value="{{ old('tienxebus', $hocphi->tienxebus ?? 0) }}">
                        </div>

                        {{-- Phí khác --}}
                        <div class="col-md-3 mb-3">
                            <label for="phikhac">Phí khác</label>
                            <input type="number" step="1000" min="0" name="phikhac" id="phikhac"
                                class="form-control" value="{{ old('phikhac', $hocphi->phikhac ?? 0) }}">
                        </div>

                        {{-- Tổng tiền (tự tính) --}}
                        <div class="col-md-3 mb-3">
                            <label for="tongtien">Tổng tiền</label>
                            <input type="number" step="1000" name="tongtien" id="tongtien" class="form-control"
                                value="{{ old('tongtien', $hocphi->tongtien ?? 0) }}" readonly
                                style="background-color: #e9ecef;">
                        </div>

                        {{-- Ngày thanh toán --}}
                        <div class="col-md-3 mb-3">
                            <label for="ngaythanhtoan">Ngày thanh toán</label>
                            <input type="date" name="ngaythanhtoan" id="ngaythanhtoan" class="form-control"
                                value="{{ old('ngaythanhtoan', $hocphi->ngaythanhtoan) }}">
                        </div>

                        {{-- Đã thanh toán --}}
                        <div class="col-md-3 mb-3">
                            <label for="dathanhtoan">Đã thanh toán</label>
                            <input type="number" step="1000" min="0" name="dathanhtoan" id="dathanhtoan"
                                class="form-control" value="{{ old('dathanhtoan', $hocphi->dathanhtoan ?? 0) }}">
                        </div>

                        {{-- Ghi chú --}}
                        <div class="col-md-12 mb-3">
                            <label for="ghichu">Ghi chú</label>
                            <textarea name="ghichu" id="ghichu" rows="3" class="form-control" placeholder="Nhập ghi chú (nếu có)...">{{ old('ghichu', $hocphi->ghichu) }}</textarea>
                        </div>

                    </div>

                    <div class="text-right mt-3">
                        <button type="submit" class="btn btn-warning shadow-sm px-4">
                            <i class="fas fa-save"></i> Cập nhật
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
        // Tự động tính tổng tiền khi thay đổi các khoản
        function updateTongTien() {
            const hocphi = parseFloat(document.getElementById('hocphi').value) || 0;
            const sang = parseFloat(document.getElementById('tienansang').value) || 0;
            const trua = parseFloat(document.getElementById('tienantrua').value) || 0;
            const xe = parseFloat(document.getElementById('tienxebus').value) || 0;
            const khac = parseFloat(document.getElementById('phikhac').value) || 0;
            document.getElementById('tongtien').value = hocphi + sang + trua + xe + khac;
        }

        ['hocphi', 'tienansang', 'tienantrua', 'tienxebus', 'phikhac'].forEach(id => {
            document.getElementById(id).addEventListener('input', updateTongTien);
        });

        // Tính lần đầu
        updateTongTien();
    </script>
@endsection
