@extends('admin.welcome')

@section('content')
    <!-- Welcome Banner -->
    <div class="col-12 mb-4">
        <div class="card bg-primary text-white shadow">
            <div class="card-body d-flex align-items-center">
                <div class="me-4">
                    <img src="{{ asset('admin/img/boy.png') }}" alt="avatar" class="rounded-circle"
                        style="width:80px;height:80px;border:3px solid white;">
                </div>
                <div>
                    <h4 class="mb-1">Xin chào, {{ Auth::user()->name ?? 'Admin' }}!</h4>
                    <p class="mb-0 opacity-75">Bạn đang xem dữ liệu tổng quan về tình hình nhà trường.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards Row 1 -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card h-100 border-left-primary shadow">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Tổng số học sinh</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($tongHocSinh ?? 0) }}</div>
                        <div class="mt-2 small">
                            <span class="text-info"><i class="fas fa-male"></i> Nam: {{ $hocSinhNam ?? 0 }}</span>
                            <span class="text-danger ml-2"><i class="fas fa-female"></i> Nữ: {{ $hocSinhNu ?? 0 }}</span>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card h-100 border-left-success shadow">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Tổng số giáo viên</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($tongGiaoVien ?? 0) }}</div>
                        <div class="mt-2 small">
                            <span class="text-success"><i class="fas fa-check"></i> Đang làm:
                                {{ $giaoVienDangLam ?? 0 }}</span>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-chalkboard-teacher fa-2x text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card h-100 border-left-info shadow">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tổng số lớp học</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($tongLopHoc ?? 0) }}</div>
                        <div class="mt-2 small text-muted">
                            <i class="fas fa-door-open"></i> Đang hoạt động
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-school fa-2x text-info"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card h-100 border-left-warning shadow">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Tổng số phụ huynh</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($tongPhuHuynh ?? 0) }}</div>
                        <div class="mt-2 small text-muted">
                            <i class="fas fa-user-friends"></i> Đã liên kết
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-friends fa-2x text-warning"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Điểm danh hôm nay -->
    <div class="col-12 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 d-flex justify-content-between align-items-center bg-light">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-calendar-check"></i> Điểm danh hôm nay - {{ \Carbon\Carbon::now()->format('d/m/Y') }}
                </h6>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-4">
                        <div class="border rounded p-3">
                            <h3 class="text-primary mb-1">{{ $diemDanhHomNay ?? 0 }}</h3>
                            <small class="text-muted">Tổng điểm danh</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="border rounded p-3">
                            <h3 class="text-success mb-1">{{ $coMatHomNay ?? 0 }}</h3>
                            <small class="text-muted">Có mặt</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="border rounded p-3">
                            <h3 class="text-danger mb-1">{{ $vangHomNay ?? 0 }}</h3>
                            <small class="text-muted">Vắng mặt</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Row 2: Biểu đồ và Thống kê -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow h-100">
            <div class="card-header py-3 bg-light">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-chart-pie"></i> Học sinh theo lớp
                </h6>
            </div>
            <div class="card-body">
                @if (isset($lopHocStats) && count($lopHocStats) > 0)
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>Lớp</th>
                                    <th>Sĩ số</th>
                                    <th>Tỷ lệ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($lopHocStats as $lop)
                                    @php
                                        $percent =
                                            $tongHocSinh > 0 ? round(($lop->hocsinh_count / $tongHocSinh) * 100, 1) : 0;
                                    @endphp
                                    <tr>
                                        <td>{{ $lop->tenlop }}</td>
                                        <td><strong>{{ $lop->hocsinh_count }}</strong></td>
                                        <td style="width:50%;">
                                            <div class="progress" style="height: 20px;">

                                                <div" aria-valuemin=0"class="progress-bar bg-info" role="progressbar"
                                                    style="width: {{ $percent }}%"
                                                    aria-valuenow="{{ $percent }}" aria-valuemin="0"
                                                    aria-valuemax="100">
                                                    {{ $percent }}%
                                            </div>
                    </div>
                    </td>
                    </tr>
                @endforeach
                </tbody>
                </table>
            </div>
        @else
            <p class="text-muted text-center">Chưa có dữ liệu lớp học.</p>
            @endif
        </div>
    </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="card shadow h-100">
            <div class="card-header py-3 bg-light">
                <h6 class="m-0 font-weight-bold text-success">
                    <i class="fas fa-money-bill-wave"></i> Thống kê học phí
                </h6>
            </div>
            <div class="card-body">
                <div class="row text-center mb-4">
                    <div class="col-6">
                        <div class="border rounded p-3 bg-success text-white">
                            <h4 class="mb-1">{{ number_format($hocPhiDaThu ?? 0) }} đ</h4>
                            <small>Đã thu</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="border rounded p-3 bg-danger text-white">
                            <h4 class="mb-1">{{ number_format($hocPhiChuaThu ?? 0) }} đ</h4>
                            <small>Chưa thu</small>
                        </div>
                    </div>
                </div>

                @php
                    $tongHocPhi = ($hocPhiDaThu ?? 0) + ($hocPhiChuaThu ?? 0);
                    $percentDaThu = $tongHocPhi > 0 ? round(($hocPhiDaThu / $tongHocPhi) * 100, 1) : 0;
                @endphp

                <h6 class="small font-weight-bold">Tỷ lệ thu học phí <span
                        class="float-right">{{ $percentDaThu }}%</span></h6>
                <div class="progress mb-4" style="height: 20px;">
                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ $percentDaThu }}%"
                        aria-valuenow="{{ $percentDaThu }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>

                <div class="text-center">
                    <a href="{{ route('admin.hocphi.index') }}" class="btn btn-outline-success btn-sm">
                        <i class="fas fa-eye"></i> Xem chi tiết
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="col-12 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 bg-light">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-bolt"></i> Thao tác nhanh
                </h6>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-3 col-6 mb-3">
                        <a href="{{ route('admin.hocsinh.create') }}" class="btn btn-outline-primary btn-block p-3">
                            <i class="fas fa-user-plus fa-2x mb-2"></i><br>
                            Thêm học sinh
                        </a>
                    </div>
                    <div class="col-md-3 col-6 mb-3">
                        <a href="{{ route('admin.giaovien.create') }}" class="btn btn-outline-success btn-block p-3">
                            <i class="fas fa-chalkboard-teacher fa-2x mb-2"></i><br>
                            Thêm giáo viên
                        </a>
                    </div>
                    <div class="col-md-3 col-6 mb-3">
                        <a href="{{ route('admin.lophoc.create') }}" class="btn btn-outline-info btn-block p-3">
                            <i class="fas fa-plus-square fa-2x mb-2"></i><br>
                            Thêm lớp học
                        </a>
                    </div>
                    <div class="col-md-3 col-6 mb-3">
                        <a href="{{ route('admin.diemdanh.index') }}" class="btn btn-outline-warning btn-block p-3">
                            <i class="fas fa-clipboard-check fa-2x mb-2"></i><br>
                            Điểm danh
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .bg-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .border-left-primary {
            border-left: 4px solid #4e73df !important;
        }

        .border-left-success {
            border-left: 4px solid #1cc88a !important;
        }

        .border-left-info {
            border-left: 4px solid #36b9cc !important;
        }

        .border-left-warning {
            border-left: 4px solid #f6c23e !important;
        }

        .card {
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-2px);
        }
    </style>
@endsection
