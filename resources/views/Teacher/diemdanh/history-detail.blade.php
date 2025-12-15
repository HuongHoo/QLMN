@extends('teacher.teacher')

@section('content')
    <div class="container-fluid">
        <!-- Header -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800">
                    <i class="fas fa-clipboard-list text-primary me-2"></i>Chi tiết điểm danh
                </h1>
                <p class="text-muted mb-0">
                    Lớp {{ $lophoc->tenlop }} -
                    <span
                        class="text-primary fw-bold">{{ \Carbon\Carbon::parse($diemdanh->first()->ngaydiemdanh ?? now())->format('d/m/Y') }}</span>
                </p>
            </div>
            <a href="{{ route('teacher.diemdanh.history') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Quay lại
            </a>
        </div>

        @php
            $coMat = $diemdanh->where('trangthai', 'có mặt')->count();
            $vangMat = $diemdanh->where('trangthai', 'vắng mặt')->count();
            $nghiPhep = $diemdanh->where('trangthai', 'nghỉ phép')->count();
            $tre = $diemdanh->where('trangthai', 'trễ')->count();
            $tongSo = $diemdanh->count();
        @endphp

        <!-- Thống kê -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-uppercase mb-1">Có mặt</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $coMat }} /
                                    {{ $tongSo }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-check-circle fa-2x text-muted"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-uppercase mb-1">Vắng mặt</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $vangMat }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-times-circle fa-2x text-muted"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-uppercase mb-1">Nghỉ phép</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $nghiPhep }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-file-alt fa-2x text-muted"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-uppercase mb-1">Đi trễ</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $tre }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clock fa-2x text-muted"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bảng chi tiết -->
        <div class="card mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-users me-2 text-muted"></i>Danh sách học sinh
                </h6>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr class="bg-light">
                                <th class="text-center" style="width: 50px;">#</th>
                                <th><i class="fas fa-child me-2 text-primary"></i>Học sinh</th>
                                <th class="text-center"><i class="fas fa-tag me-2 text-primary"></i>Trạng thái</th>
                                <th><i class="fas fa-sticky-note me-2 text-primary"></i>Ghi chú</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($diemdanh as $index => $item)
                                <tr>
                                    <td class="text-center fw-bold text-muted">{{ $index + 1 }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar me-2"
                                                style="width: 40px; height: 40px; border-radius: 50%; background: #e3e6f0; display: flex; align-items: center; justify-content: center;">
                                                @if ($item->hocsinh && $item->hocsinh->anh)
                                                    <img src="{{ asset('uploads/anh_hocsinh/' . $item->hocsinh->anh) }}"
                                                        class="rounded-circle"
                                                        style="width: 40px; height: 40px; object-fit: cover;">
                                                @else
                                                    <i class="fas fa-user-graduate text-primary"></i>
                                                @endif
                                            </div>
                                            <div>
                                                <strong>{{ $item->hocsinh->tenhocsinh ?? 'N/A' }}</strong>
                                                <br>
                                                <small class="text-muted">Mã:
                                                    HS{{ str_pad($item->hocsinh->id ?? 0, 4, '0', STR_PAD_LEFT) }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        @switch($item->trangthai)
                                            @case('có mặt')
                                                <span class="badge bg-success px-3 py-2">
                                                    <i class="fas fa-check me-1"></i> Có mặt
                                                </span>
                                            @break

                                            @case('vắng mặt')
                                                <span class="badge bg-danger px-3 py-2">
                                                    <i class="fas fa-times me-1"></i> Vắng mặt
                                                </span>
                                            @break

                                            @case('nghỉ phép')
                                                <span class="badge bg-warning text-dark px-3 py-2">
                                                    <i class="fas fa-file-alt me-1"></i> Nghỉ phép
                                                </span>
                                            @break

                                            @case('trễ')
                                                <span class="badge bg-info px-3 py-2">
                                                    <i class="fas fa-clock me-1"></i> Đi trễ
                                                </span>
                                            @break

                                            @default
                                                <span class="badge bg-secondary px-3 py-2">{{ $item->trangthai }}</span>
                                        @endswitch
                                    </td>
                                    <td>
                                        @if ($item->ghichu)
                                            <span class="text-muted"><i
                                                    class="fas fa-comment me-1"></i>{{ $item->ghichu }}</span>
                                        @else
                                            <span class="text-muted fst-italic">Không có ghi chú</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4">
                                            <i class="fas fa-inbox fa-3x text-muted mb-2"></i>
                                            <p class="text-muted mb-0">Chưa có dữ liệu điểm danh</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <style>
            .border-left-primary {
                border-left: 4px solid #4e73df !important;
            }

            .border-left-success {
                border-left: 4px solid #1cc88a !important;
            }

            .border-left-danger {
                border-left: 4px solid #e74a3b !important;
            }

            .border-left-info {
                border-left: 4px solid #36b9cc !important;
            }

            .border-left-warning {
                border-left: 4px solid #f6c23e !important;
            }
        </style>
    @endsection
