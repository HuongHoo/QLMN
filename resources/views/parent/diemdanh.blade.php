@extends('layouts.user')

@section('content')
    <main class="main">
        <div class="container py-5">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('parent.home') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item active">Điểm danh</li>
                </ol>
            </nav>

            <div class="row mb-4">
                <div class="col-12">
                    <h2 class="fw-bold text-primary"><i class="fas fa-calendar-check me-2"></i>Điểm danh</h2>
                    <p class="text-muted">Theo dõi tình hình điểm danh của con bạn</p>
                </div>
            </div>

            <!-- Stats -->
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100 text-center">
                        <div class="card-body py-4">
                            <div class="rounded-circle bg-success bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3"
                                style="width:60px;height:60px;">
                                <i class="fas fa-check fa-2x text-success"></i>
                            </div>
                            <h3 class="text-success">{{ $soNgayCoMat }}</h3>
                            <p class="text-muted mb-0">Ngày có mặt (tháng này)</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100 text-center">
                        <div class="card-body py-4">
                            <div class="rounded-circle bg-danger bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3"
                                style="width:60px;height:60px;">
                                <i class="fas fa-times fa-2x text-danger"></i>
                            </div>
                            <h3 class="text-danger">{{ $soNgayVang }}</h3>
                            <p class="text-muted mb-0">Ngày vắng (tháng này)</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100 text-center">
                        <div class="card-body py-4">
                            <div class="rounded-circle bg-primary bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3"
                                style="width:60px;height:60px;">
                                <i class="fas fa-percentage fa-2x text-primary"></i>
                            </div>
                            @php
                                $total = $soNgayCoMat + $soNgayVang;
                                $percent = $total > 0 ? round(($soNgayCoMat / $total) * 100, 1) : 0;
                            @endphp
                            <h3 class="text-primary">{{ $percent }}%</h3>
                            <p class="text-muted mb-0">Tỷ lệ đi học</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Today Attendance -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="fas fa-clock text-primary me-2"></i>Điểm danh hôm nay -
                        {{ \Carbon\Carbon::now()->format('d/m/Y') }}</h5>
                </div>
                <div class="card-body">
                    @if ($diemDanhHomNay && $diemDanhHomNay->count() > 0)
                        <div class="row">
                            @foreach ($diemDanhHomNay as $dd)
                                @php
                                    $hs = $children->firstWhere('id', $dd->mahocsinh);
                                @endphp
                                <div class="col-md-6 mb-3">
                                    <div class="d-flex align-items-center p-3 bg-light rounded">
                                        @if ($hs && $hs->anh)
                                            <img src="{{ asset($hs->anh) }}" class="rounded-circle me-3"
                                                style="width:50px;height:50px;object-fit:cover;">
                                        @else
                                            <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center me-3"
                                                style="width:50px;height:50px;">
                                                <i class="fas fa-user text-white"></i>
                                            </div>
                                        @endif
                                        <div class="flex-grow-1">
                                            <strong>{{ $hs->tenhocsinh ?? 'Học sinh' }}</strong>
                                            <div class="small text-muted">{{ $hs->lophoc->tenlop ?? '' }}</div>
                                        </div>
                                        @if (str_contains(strtolower($dd->trangthai ?? ''), 'có mặt'))
                                            <span class="badge bg-success fs-6"><i class="fas fa-check me-1"></i>Có
                                                mặt</span>
                                        @else
                                            <span class="badge bg-danger fs-6"><i class="fas fa-times me-1"></i>Vắng</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-clock fa-3x text-muted mb-3"></i>
                            <p class="text-muted mb-0">Chưa có điểm danh hôm nay</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- History -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="fas fa-history text-info me-2"></i>Lịch sử điểm danh tháng
                        {{ \Carbon\Carbon::now()->format('m/Y') }}</h5>
                </div>
                <div class="card-body">
                    @if ($diemDanhThang && $diemDanhThang->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Ngày</th>
                                        <th>Học sinh</th>
                                        <th>Trạng thái</th>
                                        <th>Ghi chú</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($diemDanhThang as $dd)
                                        @php
                                            $hs = $children->firstWhere('id', $dd->mahocsinh);
                                        @endphp
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($dd->ngaydiemdanh)->format('d/m/Y') }}</td>
                                            <td>{{ $hs->tenhocsinh ?? 'Học sinh' }}</td>
                                            <td>
                                                @if (str_contains(strtolower($dd->trangthai ?? ''), 'có mặt'))
                                                    <span class="badge bg-success"><i class="fas fa-check"></i> Có
                                                        mặt</span>
                                                @else
                                                    <span class="badge bg-danger"><i class="fas fa-times"></i> Vắng</span>
                                                @endif
                                            </td>
                                            <td>{{ $dd->ghichu ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <p class="text-muted mb-0">Chưa có dữ liệu điểm danh</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>
@endsection
