@extends('teacher.teacher')

@section('content')
    <!-- Welcome Banner -->
    <div class="col-12 mb-4">
        <div class="card text-white shadow bg-primary">
            <div class="card-body d-flex align-items-center">
                <div class="me-4">
                    @if ($teacher->anh)
                        <img src="{{ asset('storage/' . $teacher->anh) }}" alt="avatar" class="rounded-circle"
                            style="width:80px;height:80px;object-fit:cover;border:3px solid white;">
                    @else
                        <div class="rounded-circle bg-white d-flex justify-content-center align-items-center"
                            style="width:80px;height:80px;">
                            <i class="fas fa-user-circle text-primary" style="font-size:50px;"></i>
                        </div>
                    @endif
                </div>
                <div>
                    <h4 class="mb-1">Xin chào, {{ $teacher->tengiaovien ?? 'Giáo viên' }}!</h4>
                    <p class="mb-0 opacity-75">
                        <i class="fas fa-chalkboard"></i> Lớp chủ nhiệm:
                        <strong>{{ $lop->tenlop ?? 'Chưa phân công' }}</strong>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card h-100 border-left-primary shadow">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Sĩ số lớp</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $tongHocSinh ?? 0 }}</div>
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
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Có mặt hôm nay</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $coMatHomNay ?? 0 }}</div>
                        <div class="mt-2 small text-muted">
                            <i class="fas fa-check-circle text-success"></i> Đã điểm danh
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-check fa-2x text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card h-100 border-left-danger shadow">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Vắng mặt hôm nay</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $vangHomNay ?? 0 }}</div>
                        <div class="mt-2 small text-muted">
                            <i class="fas fa-exclamation-circle text-danger"></i> Cần theo dõi
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-times fa-2x text-danger"></i>
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
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Điểm danh tuần này</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $diemDanhTuan ?? 0 }}</div>
                        <div class="mt-2 small text-muted">
                            <i class="fas fa-calendar-week"></i> Lượt điểm danh
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-info"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Điểm danh hôm nay -->
    <div class="col-lg-8 mb-4">
        <div class="card shadow h-100">
            <div class="card-header py-3 d-flex justify-content-between align-items-center bg-light">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-calendar-check"></i> Điểm danh hôm nay - {{ \Carbon\Carbon::now()->format('d/m/Y') }}
                </h6>
                <a href="{{ route('teacher.diemdanh.index') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-edit"></i> Điểm danh
                </a>
            </div>
            <div class="card-body">
                <div class="row text-center mb-4">
                    <div class="col-md-4">
                        <div class="border rounded p-3 bg-light">
                            <h3 class="text-primary mb-1">{{ $tongHocSinh ?? 0 }}</h3>
                            <small class="text-muted">Tổng sĩ số</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="border rounded p-3 bg-success text-white">
                            <h3 class="mb-1">{{ $coMatHomNay ?? 0 }}</h3>
                            <small>Có mặt</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="border rounded p-3 bg-danger text-white">
                            <h3 class="mb-1">{{ $vangHomNay ?? 0 }}</h3>
                            <small>Vắng mặt</small>
                        </div>
                    </div>
                </div>

                @php
                    $percentCoMat = $tongHocSinh > 0 ? round(($coMatHomNay / $tongHocSinh) * 100, 1) : 0;
                @endphp

                <h6 class="small font-weight-bold">Tỷ lệ có mặt <span class="float-right">{{ $percentCoMat }}%</span></h6>
                <div class="progress mb-4" style="height: 20px;">
                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ $percentCoMat }}%"
                        aria-valuenow="{{ $percentCoMat }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Danh sách học sinh -->
    <div class="col-lg-4 mb-4">
        <div class="card shadow h-100">
            <div class="card-header py-3 bg-light d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-users"></i> Học sinh trong lớp
                </h6>
                <a href="{{ route('teacher.hocsinh.index') }}" class="btn btn-sm btn-outline-primary">
                    Xem tất cả
                </a>
            </div>
            <div class="card-body p-0">
                @if (isset($hocsinhs) && count($hocsinhs) > 0)
                    <ul class="list-group list-group-flush">
                        @foreach ($hocsinhs as $hs)
                            <li class="list-group-item d-flex align-items-center">
                                @if ($hs->anh)
                                    <img src="{{ asset('storage/' . $hs->anh) }}" class="rounded-circle mr-3"
                                        style="width:40px;height:40px;object-fit:cover;">
                                @else
                                    <div class="rounded-circle bg-light d-flex justify-content-center align-items-center mr-3"
                                        style="width:40px;height:40px;">
                                        <i class="fas fa-user text-muted"></i>
                                    </div>
                                @endif
                                <div>
                                    <strong>{{ $hs->tenhocsinh }}</strong>
                                    <br><small class="text-muted">Mã: {{ $hs->mathe }}</small>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="p-3 text-center text-muted">
                        <i class="fas fa-info-circle"></i> Chưa có học sinh trong lớp
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Thao tác nhanh -->
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
                        <a href="{{ route('teacher.diemdanh.index') }}" class="btn btn-outline-success btn-block p-3">
                            <i class="fas fa-clipboard-check fa-2x mb-2"></i><br>
                            Điểm danh
                        </a>
                    </div>
                    <div class="col-md-3 col-6 mb-3">
                        <a href="{{ route('teacher.hocsinh.index') }}" class="btn btn-outline-primary btn-block p-3">
                            <i class="fas fa-users fa-2x mb-2"></i><br>
                            Danh sách HS
                        </a>
                    </div>
                    <div class="col-md-3 col-6 mb-3">
                        <a href="{{ route('teacher.thongtincanhan.index') }}" class="btn btn-outline-info btn-block p-3">
                            <i class="fas fa-user-circle fa-2x mb-2"></i><br>
                            Thông tin cá nhân
                        </a>
                    </div>
                    <div class="col-md-3 col-6 mb-3">
                        <a href="#" class="btn btn-outline-warning btn-block p-3">
                            <i class="fas fa-chart-bar fa-2x mb-2"></i><br>
                            Báo cáo
                        </a>
                    </div>
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

        .card {
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-2px);
        }
    </style>
@endsection
