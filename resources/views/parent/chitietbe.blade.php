@extends('layouts.user')

@section('content')
    <main class="main">
        <div class="container py-5">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('parent.home') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('parent.thongtinbe') }}">Thông tin bé</a></li>
                    <li class="breadcrumb-item active">{{ $child->tenhocsinh }}</li>
                </ol>
            </nav>

            <!-- Child Profile Header -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-2 text-center">
                            @if ($child->anh)
                                <img src="{{ asset($child->anh) }}" alt="avatar" class="rounded-circle shadow"
                                    style="width:120px;height:120px;object-fit:cover;">
                            @else
                                <div class="rounded-circle bg-gradient mx-auto d-flex align-items-center justify-content-center shadow"
                                    style="width:120px;height:120px;background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);">
                                    <i class="fas fa-user-graduate fa-3x text-white"></i>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-10">
                            <h2 class="mb-2">{{ $child->tenhocsinh }}</h2>
                            <div class="mb-2">
                                <span class="badge bg-primary me-1">{{ $child->lophoc->tenlop ?? 'Chưa có lớp' }}</span>
                                @if ($child->gioitinh == 'Nam')
                                    <span class="badge bg-info"><i class="fas fa-mars"></i> Nam</span>
                                @else
                                    <span class="badge" style="background-color:#e91e63;"><i class="fas fa-venus"></i>
                                        Nữ</span>
                                @endif
                                <span class="badge bg-secondary">{{ $child->mathe }}</span>
                            </div>
                            <p class="text-muted mb-0">
                                <i class="fas fa-birthday-cake me-1"></i>
                                {{ $child->ngaysinh ? \Carbon\Carbon::parse($child->ngaysinh)->format('d/m/Y') : '-' }}
                                <span class="mx-2">|</span>
                                <i class="fas fa-map-marker-alt me-1"></i> {{ $child->diachithuongtru ?? 'Chưa cập nhật' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabs -->
            <ul class="nav nav-tabs mb-4" id="childTabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="attendance-tab" data-bs-toggle="tab" href="#attendance">
                        <i class="fas fa-calendar-check me-1"></i> Điểm danh
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="fee-tab" data-bs-toggle="tab" href="#fee">
                        <i class="fas fa-wallet me-1"></i> Học phí
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="evaluation-tab" data-bs-toggle="tab" href="#evaluation">
                        <i class="fas fa-star me-1"></i> Đánh giá
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="health-tab" data-bs-toggle="tab" href="#health">
                        <i class="fas fa-heartbeat me-1"></i> Sức khỏe
                    </a>
                </li>
            </ul>

            <div class="tab-content">
                <!-- Điểm danh Tab -->
                <div class="tab-pane fade show active" id="attendance">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0"><i class="fas fa-calendar-check text-success me-2"></i>Điểm danh tháng
                                {{ \Carbon\Carbon::now()->format('m/Y') }}</h5>
                        </div>
                        <div class="card-body">
                            @if ($diemDanhThang && $diemDanhThang->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Ngày</th>
                                                <th>Trạng thái</th>
                                                <th>Ghi chú</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($diemDanhThang as $dd)
                                                <tr>
                                                    <td>{{ \Carbon\Carbon::parse($dd->ngaydiemdanh)->format('d/m/Y') }}
                                                    </td>
                                                    <td>
                                                        @if (str_contains(strtolower($dd->trangthai ?? ''), 'có mặt'))
                                                            <span class="badge bg-success"><i class="fas fa-check"></i> Có
                                                                mặt</span>
                                                        @else
                                                            <span class="badge bg-danger"><i class="fas fa-times"></i>
                                                                Vắng</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $dd->ghichu ?? '-' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-muted text-center mb-0">Chưa có dữ liệu điểm danh</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Học phí Tab -->
                <div class="tab-pane fade" id="fee">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0"><i class="fas fa-wallet text-warning me-2"></i>Học phí</h5>
                        </div>
                        <div class="card-body">
                            @if ($hocPhis && $hocPhis->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Kỳ</th>
                                                <th>Tổng tiền</th>
                                                <th>Trạng thái</th>
                                                <th>Ngày đóng</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($hocPhis as $hp)
                                                <tr>
                                                    <td>{{ $hp->kyhoc ?? ($hp->thang ?? '-') }}</td>
                                                    <td><strong>{{ number_format($hp->tongtien ?? 0) }}đ</strong></td>
                                                    <td>
                                                        @if ($hp->dathanhtoan)
                                                            <span class="badge bg-success"><i class="fas fa-check"></i> Đã
                                                                đóng</span>
                                                        @else
                                                            <span class="badge bg-danger"><i class="fas fa-times"></i> Chưa
                                                                đóng</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $hp->ngaydong ? \Carbon\Carbon::parse($hp->ngaydong)->format('d/m/Y') : '-' }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-muted text-center mb-0">Chưa có dữ liệu học phí</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Đánh giá Tab -->
                <div class="tab-pane fade" id="evaluation">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0"><i class="fas fa-star text-info me-2"></i>Đánh giá từ giáo viên</h5>
                        </div>
                        <div class="card-body">
                            @if ($danhGias && $danhGias->count() > 0)
                                @foreach ($danhGias as $dg)
                                    <div class="border-bottom pb-3 mb-3">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <strong>{{ $dg->tieude ?? 'Đánh giá' }}</strong>
                                                <div class="text-warning">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($i <= ($dg->diemdanhgia ?? 0))
                                                            <i class="fas fa-star"></i>
                                                        @else
                                                            <i class="far fa-star"></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                            </div>
                                            <small class="text-muted">{{ $dg->created_at?->format('d/m/Y') }}</small>
                                        </div>
                                        <p class="text-muted mt-2 mb-0">{{ $dg->nhanxet ?? 'Không có nhận xét' }}</p>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-muted text-center mb-0">Chưa có đánh giá</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sức khỏe Tab -->
                <div class="tab-pane fade" id="health">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0"><i class="fas fa-heartbeat text-danger me-2"></i>Theo dõi sức khỏe</h5>
                        </div>
                        <div class="card-body">
                            @if ($sucKhoes && $sucKhoes->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Ngày khám</th>
                                                <th>Chiều cao</th>
                                                <th>Cân nặng</th>
                                                <th>Ghi chú</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($sucKhoes as $sk)
                                                <tr>
                                                    <td>{{ $sk->ngaykham ? \Carbon\Carbon::parse($sk->ngaykham)->format('d/m/Y') : '-' }}
                                                    </td>
                                                    <td>{{ $sk->chieucao ?? '-' }} cm</td>
                                                    <td>{{ $sk->cannang ?? '-' }} kg</td>
                                                    <td>{{ $sk->ghichu ?? '-' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-muted text-center mb-0">Chưa có dữ liệu sức khỏe</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
