@extends('teacher.teacher')

@section('content')
    <div class="container-fluid">
        <!-- Header -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800">
                    <i class="fas fa-history text-primary me-2"></i>Lịch sử điểm danh
                </h1>
                <p class="text-muted mb-0">Lớp {{ $lophoc->tenlop }} - Tổng {{ $tongHocSinh }} học sinh</p>
            </div>
            <a href="{{ route('teacher.diemdanh.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Quay lại
            </a>
        </div>

        <!-- Bảng lịch sử -->
        <div class="card mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-calendar-alt me-2 text-muted"></i>Danh sách buổi điểm danh ({{ count($diemdanh) }}
                    buổi)
                </h6>
            </div>

            <div class="card-body p-0">
                @if (count($diemdanh) > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-center" style="width: 50px;">#</th>
                                    <th><i class="fas fa-calendar-day me-1 text-primary"></i>Ngày</th>
                                    <th class="text-center"><i class="fas fa-check-circle me-1 text-success"></i>Có mặt</th>
                                    <th class="text-center"><i class="fas fa-times-circle me-1 text-danger"></i>Vắng</th>
                                    <th class="text-center"><i class="fas fa-file-alt me-1 text-warning"></i>Nghỉ phép</th>
                                    <th class="text-center"><i class="fas fa-clock me-1 text-info"></i>Trễ</th>
                                    <th class="text-center">Tỷ lệ</th>
                                    <th class="text-center" style="width: 120px;">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($diemdanh as $index => $item)
                                    @php
                                        $tyLe = $item->tongSo > 0 ? round(($item->coMat / $item->tongSo) * 100) : 0;
                                    @endphp
                                    <tr>
                                        <td class="text-center text-muted">{{ $index + 1 }}</td>
                                        <td>
                                            <strong>{{ \Carbon\Carbon::parse($item->ngaydiemdanh)->format('d/m/Y') }}</strong>
                                            <br>
                                            <small
                                                class="text-muted">{{ \Carbon\Carbon::parse($item->ngaydiemdanh)->locale('vi')->dayName }}</small>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-success px-2 py-1">{{ $item->coMat }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-danger px-2 py-1">{{ $item->vangMat }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-warning text-dark px-2 py-1">{{ $item->nghiPhep }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-info px-2 py-1">{{ $item->tre }}</span>
                                        </td>
                                        <td class="text-center">
                                            <div class="progress" style="height: 20px; min-width: 80px;">
                                                <div class="progress-bar bg-success" role="progressbar"
                                                    style="width: {{ $tyLe }}%">
                                                    {{ $tyLe }}%
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('teacher.diemdanh.history-detail', ['date' => $item->ngaydiemdanh]) }}"
                                                class="text-info me-2" title="Xem chi tiết" data-bs-toggle="tooltip">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('teacher.diemdanh.edit', ['date' => $item->ngaydiemdanh]) }}"
                                                class="text-warning" title="Sửa điểm danh" data-bs-toggle="tooltip">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-calendar-times fa-4x text-muted mb-3"></i>
                        <h5 class="text-muted">Chưa có lịch sử điểm danh</h5>
                        <p class="text-muted">Bắt đầu điểm danh để xem lịch sử tại đây</p>
                        <a href="{{ route('teacher.diemdanh.index') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i> Điểm danh ngay
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
