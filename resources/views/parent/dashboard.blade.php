@extends('layouts.user')

@section('content')
    <main class="main">
        <div class="container py-4">
            <!-- Welcome Banner -->
            <div class="welcome-banner mb-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="text-white mb-1">Xin chào, {{ $phuHuynh->hoten ?? (Auth::user()->name ?? 'Phụ huynh') }}!
                        </h4>
                        <p class="text-white-50 mb-0">Chúc bạn một ngày tốt lành</p>
                    </div>
                    <div class="d-none d-md-block">
                        <i class="fas fa-child fa-3x text-white-50"></i>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <!-- Left Column - Children Info -->
                <div class="col-lg-8">
                    <!-- Children List -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white border-0 py-3">
                            <h6 class="mb-0 fw-bold"><i class="fas fa-users text-primary me-2"></i>Con của bạn</h6>
                        </div>
                        <div class="card-body p-0">
                            @forelse ($children as $child)
                                <div
                                    class="child-item d-flex align-items-center p-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                                    @if ($child->anh)
                                        <img src="{{ asset($child->anh) }}" alt="avatar" class="rounded-circle me-3"
                                            style="width:55px;height:55px;object-fit:cover;">
                                    @else
                                        <div class="avatar-placeholder rounded-circle me-3 d-flex align-items-center justify-content-center"
                                            style="width:55px;height:55px;background:#e3f2fd;">
                                            <i class="fas fa-user text-primary"></i>
                                        </div>
                                    @endif
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">{{ $child->tenhocsinh }}</h6>
                                        <div class="d-flex align-items-center gap-2">
                                            <span
                                                class="badge bg-primary bg-opacity-10 text-primary">{{ $child->lophoc->tenlop ?? 'Chưa có lớp' }}</span>
                                            @if ($child->gioitinh == 'Nam')
                                                <span class="badge bg-info bg-opacity-10 text-info"><i
                                                        class="fas fa-mars"></i> Nam</span>
                                            @else
                                                <span class="badge bg-pink bg-opacity-10 text-pink"><i
                                                        class="fas fa-venus"></i> Nữ</span>
                                            @endif
                                        </div>
                                    </div>
                                    <a href="{{ route('parent.chitietbe', $child->id) }}"
                                        class="btn btn-sm btn-outline-primary">
                                        Chi tiết <i class="fas fa-chevron-right ms-1"></i>
                                    </a>
                                </div>
                            @empty
                                <div class="text-center py-5 text-muted">
                                    <i class="fas fa-child fa-3x mb-3"></i>
                                    <p class="mb-0">Chưa có thông tin học sinh</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Quick Stats -->
                    <div class="row g-3">
                        <div class="col-6 col-md-3">
                            <div class="stat-card bg-primary text-white">
                                <i class="fas fa-child"></i>
                                <div class="stat-number">{{ $children->count() }}</div>
                                <div class="stat-label">Học sinh</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="stat-card bg-success text-white">
                                <i class="fas fa-calendar-check"></i>
                                <div class="stat-number">--</div>
                                <div class="stat-label">Ngày học</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="stat-card bg-warning text-white">
                                <i class="fas fa-star"></i>
                                <div class="stat-number">--</div>
                                <div class="stat-label">Đánh giá</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="stat-card bg-info text-white">
                                <i class="fas fa-bell"></i>
                                <div class="stat-number">{{ $thongbaos->count() ?? 0 }}</div>
                                <div class="stat-label">Thông báo</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Quick Menu -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-0 py-3">
                            <h6 class="mb-0 fw-bold"><i class="fas fa-th-large text-primary me-2"></i>Truy cập nhanh</h6>
                        </div>
                        <div class="card-body p-0">
                            <a href="{{ route('parent.thongtinbe') }}"
                                class="menu-item d-flex align-items-center p-3 border-bottom">
                                <div class="menu-icon bg-primary"><i class="fas fa-child"></i></div>
                                <div class="ms-3">
                                    <h6 class="mb-0">Thông tin bé</h6>
                                    <small class="text-muted">Xem chi tiết học sinh</small>
                                </div>
                                <i class="fas fa-chevron-right ms-auto text-muted"></i>
                            </a>
                            <a href="{{ route('parent.diemdanh') }}"
                                class="menu-item d-flex align-items-center p-3 border-bottom">
                                <div class="menu-icon bg-success"><i class="fas fa-calendar-check"></i></div>
                                <div class="ms-3">
                                    <h6 class="mb-0">Điểm danh</h6>
                                    <small class="text-muted">Lịch sử điểm danh</small>
                                </div>
                                <i class="fas fa-chevron-right ms-auto text-muted"></i>
                            </a>
                            <a href="{{ route('parent.hocphi') }}"
                                class="menu-item d-flex align-items-center p-3 border-bottom">
                                <div class="menu-icon bg-warning"><i class="fas fa-wallet"></i></div>
                                <div class="ms-3">
                                    <h6 class="mb-0">Học phí</h6>
                                    <small class="text-muted">Công nợ & thanh toán</small>
                                </div>
                                <i class="fas fa-chevron-right ms-auto text-muted"></i>
                            </a>
                            <a href="{{ route('parent.danhgia') }}"
                                class="menu-item d-flex align-items-center p-3 border-bottom">
                                <div class="menu-icon bg-info"><i class="fas fa-star"></i></div>
                                <div class="ms-3">
                                    <h6 class="mb-0">Đánh giá</h6>
                                    <small class="text-muted">Nhận xét từ giáo viên</small>
                                </div>
                                <i class="fas fa-chevron-right ms-auto text-muted"></i>
                            </a>
                            <a href="{{ route('parent.suckhoe') }}" class="menu-item d-flex align-items-center p-3">
                                <div class="menu-icon bg-danger"><i class="fas fa-heartbeat"></i></div>
                                <div class="ms-3">
                                    <h6 class="mb-0">Sức khỏe</h6>
                                    <small class="text-muted">Theo dõi sức khỏe</small>
                                </div>
                                <i class="fas fa-chevron-right ms-auto text-muted"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Contact Card -->
                    <div class="card border-0 shadow-sm mt-4 bg-light">
                        <div class="card-body text-center py-4">
                            <i class="fas fa-headset fa-2x text-primary mb-3"></i>
                            <h6 class="fw-bold">Hỗ trợ</h6>
                            <p class="text-muted small mb-3">Liên hệ nhà trường nếu cần hỗ trợ</p>
                            <a href="tel:0123456789" class="btn btn-primary btn-sm w-100">
                                <i class="fas fa-phone me-1"></i> 0123 456 789
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <style>
        .welcome-banner {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 12px;
            padding: 20px 25px;
        }

        .child-item:hover {
            background-color: #f8f9fa;
        }

        .stat-card {
            border-radius: 12px;
            padding: 20px;
            text-align: center;
        }

        .stat-card i {
            font-size: 24px;
            opacity: 0.8;
        }

        .stat-card .stat-number {
            font-size: 28px;
            font-weight: 700;
            margin: 8px 0 4px;
        }

        .stat-card .stat-label {
            font-size: 12px;
            opacity: 0.9;
        }

        .menu-item {
            text-decoration: none;
            color: inherit;
            transition: background 0.2s;
        }

        .menu-item:hover {
            background-color: #f8f9fa;
            color: inherit;
        }

        .menu-item h6 {
            color: #333;
            font-size: 14px;
        }

        .menu-icon {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .bg-pink {
            background-color: #e91e63 !important;
        }

        .text-pink {
            color: #e91e63 !important;
        }
    </style>
@endsection
