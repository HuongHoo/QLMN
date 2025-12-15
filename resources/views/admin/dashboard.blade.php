@extends('admin.welcome')

@section('content')
    <!-- Page Header -->
    <div class="col-12 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-1 fw-bold text-dark">Bảng điều khiển Admin</h4>
                <p class="text-muted mb-0">Theo dõi tổng quan hoạt động và hiệu suất của nhà trường.</p>
            </div>
        </div>
    </div>

    <!-- Stats Cards Row 1 -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card h-100 border-left-primary">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Tổng số học sinh</div>
                        <div class="h4 mb-0 font-weight-bold text-gray-800">{{ number_format($tongHocSinh ?? 0) }}</div>
                        <div class="mt-2 small text-muted">
                            <i class="fas fa-male"></i> Nam: {{ $hocSinhNam ?? 0 }} |
                            <i class="fas fa-female"></i> Nữ: {{ $hocSinhNu ?? 0 }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-muted"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card h-100 border-left-success">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Tổng số giáo viên</div>
                        <div class="h4 mb-0 font-weight-bold text-gray-800">{{ number_format($tongGiaoVien ?? 0) }}</div>
                        <div class="mt-2 small text-muted">
                            <i class="fas fa-check"></i> Đang làm: {{ $giaoVienDangLam ?? 0 }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-chalkboard-teacher fa-2x text-muted"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card h-100 border-left-warning">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Tổng số lớp học</div>
                        <div class="h4 mb-0 font-weight-bold text-gray-800">{{ number_format($tongLopHoc ?? 0) }}</div>
                        <div class="mt-2 small text-muted">
                            <i class="fas fa-door-open"></i> Đang hoạt động
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-school fa-2x text-muted"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card h-100 border-left-info">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Tổng số phụ huynh</div>
                        <div class="h4 mb-0 font-weight-bold text-gray-800">{{ number_format($tongPhuHuynh ?? 0) }}</div>
                        <div class="mt-2 small text-muted">
                            <i class="fas fa-user-friends"></i> Đã liên kết
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-friends fa-2x text-muted"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Row 2: Biểu đồ học sinh theo lớp -->
    <div class="col-lg-6 mb-4">
        <div class="card h-100">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-chart-pie text-muted me-2"></i> Học sinh theo lớp
                </h6>
            </div>
            <div class="card-body">
                @if (isset($lopHocStats) && count($lopHocStats) > 0)
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead>
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
                                                <div class="progress-bar bg-dark" role="progressbar"
                                                    style="width: {{ $percent }}%" aria-valuenow="{{ $percent }}"
                                                    aria-valuemin="0" aria-valuemax="100">
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

    <!-- Hoạt động gần đây -->
    <div class="col-lg-6 mb-4">
        <div class="card h-100">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-clock text-muted me-2"></i> Hoạt động gần đây
                </h6>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <div class="list-group-item d-flex align-items-center px-0 border-0">
                        <div class="rounded-circle bg-light text-dark p-2 me-3"
                            style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <div>
                            <small class="text-muted">Học sinh mới</small>
                            <p class="mb-0 fw-bold">{{ $tongHocSinh ?? 0 }} học sinh đã đăng ký</p>
                        </div>
                    </div>
                    <div class="list-group-item d-flex align-items-center px-0 border-0">
                        <div class="rounded-circle bg-light text-dark p-2 me-3"
                            style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                        <div>
                            <small class="text-muted">Giáo viên</small>
                            <p class="mb-0 fw-bold">{{ $tongGiaoVien ?? 0 }} giáo viên đang giảng dạy</p>
                        </div>
                    </div>
                    <div class="list-group-item d-flex align-items-center px-0 border-0">
                        <div class="rounded-circle bg-light text-dark p-2 me-3"
                            style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-school"></i>
                        </div>
                        <div>
                            <small class="text-muted">Lớp học</small>
                            <p class="mb-0 fw-bold">{{ $tongLopHoc ?? 0 }} lớp đang hoạt động</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-bolt text-muted me-2"></i> Thao tác nhanh
                </h6>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-3 col-6 mb-3">
                        <a href="{{ route('admin.hocsinh.create') }}" class="btn btn-outline-dark btn-block p-3 w-100">
                            <i class="fas fa-user-plus fa-2x mb-2"></i><br>
                            Thêm học sinh
                        </a>
                    </div>
                    <div class="col-md-3 col-6 mb-3">
                        <a href="{{ route('admin.giaovien.create') }}" class="btn btn-outline-dark btn-block p-3 w-100">
                            <i class="fas fa-chalkboard-teacher fa-2x mb-2"></i><br>
                            Thêm giáo viên
                        </a>
                    </div>
                    <div class="col-md-3 col-6 mb-3">
                        <a href="{{ route('admin.lophoc.create') }}" class="btn btn-outline-dark btn-block p-3 w-100">
                            <i class="fas fa-plus-square fa-2x mb-2"></i><br>
                            Thêm lớp học
                        </a>
                    </div>
                    <div class="col-md-3 col-6 mb-3">
                        <a href="{{ route('admin.diemdanh.index') }}" class="btn btn-outline-dark btn-block p-3 w-100">
                            <i class="fas fa-clipboard-check fa-2x mb-2"></i><br>
                            Điểm danh
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
