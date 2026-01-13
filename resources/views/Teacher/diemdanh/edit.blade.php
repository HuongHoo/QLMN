@extends('teacher.teacher')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <div>
                <h3 class="mb-0"><i class="fas fa-edit text-warning me-2"></i>Sửa điểm danh</h3>
                <p class="text-muted mb-0">Ngày: {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}
                    ({{ \Carbon\Carbon::parse($date)->locale('vi')->dayName }})</p>
            </div>
            <a href="{{ route('teacher.diemdanh.history') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Quay lại
            </a>
        </div>

        {{-- Thông báo --}}
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('teacher.diemdanh.update', $date) }}" method="POST">
            @csrf
            <input type="hidden" name="ngaydiemdanh" value="{{ $date }}">

            <div class="card shadow mb-4">
                <div class="card-header bg-warning text-white">
                    <h6 class="m-0 font-weight-bold"><i class="fas fa-users me-2"></i>Danh sách học sinh</h6>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>Học sinh</th>
                                    <th class="text-center">Trễ</th>
                                    <th class="text-center">Có mặt</th>
                                    <th class="text-center">Vắng</th>
                                    <th class="text-center">Nghỉ phép</th>
                                    <th>Ghi chú</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($hocsinh as $hs)
                                    @php
                                        $diemdanh = $diemdanhRecords->get($hs->id);
                                        $trangthaiArr = $diemdanh ? explode(', ', $diemdanh->trangthai) : [];
                                    @endphp
                                    <tr>
                                        <td>
                                            <strong>{{ $hs->tenhocsinh }}</strong><br>
                                            <small class="text-muted">Mã: {{ $hs->mathe }}</small>
                                            <input type="hidden" name="mahocsinh[]" value="{{ $hs->id }}">
                                        </td>

                                        {{-- Checkbox trễ --}}
                                        <td class="text-center">
                                            <input type="checkbox" name="trangthai_{{ $hs->id }}[]" value="trễ"
                                                class="statusCheckbox treCheckbox"
                                                {{ in_array('trễ', $trangthaiArr) ? 'checked' : '' }}>
                                        </td>

                                        {{-- Checkbox trạng thái --}}
                                        <td class="text-center">
                                            <input type="checkbox" name="trangthai_{{ $hs->id }}[]" value="có mặt"
                                                class="statusCheckbox"
                                                {{ in_array('có mặt', $trangthaiArr) ? 'checked' : '' }}>
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox" name="trangthai_{{ $hs->id }}[]" value="vắng mặt"
                                                class="statusCheckbox"
                                                {{ in_array('vắng mặt', $trangthaiArr) ? 'checked' : '' }}>
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox" name="trangthai_{{ $hs->id }}[]" value="nghỉ phép"
                                                class="statusCheckbox"
                                                {{ in_array('nghỉ phép', $trangthaiArr) ? 'checked' : '' }}>
                                        </td>

                                        {{-- Ghi chú --}}
                                        <td>
                                            <input type="text" name="ghichu[]" class="form-control ghichu"
                                                value="{{ $diemdanh ? $diemdanh->ghichu : '' }}">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-warning px-4">
                        <i class="fas fa-save"></i> Cập nhật điểm danh
                    </button>
                    <a href="{{ route('teacher.diemdanh.history') }}" class="btn btn-secondary px-4">
                        <i class="fas fa-times"></i> Hủy
                    </a>
                </div>
            </div>
        </form>
    </div>
@endsection
