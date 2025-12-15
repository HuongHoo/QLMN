@extends('layouts.user')

@section('content')
    <main class="main">
        <div class="container py-4">
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
                                                class="badge border text-dark">{{ $child->lophoc->tenlop ?? 'Chưa có lớp' }}</span>
                                            @if ($child->gioitinh == 'Nam')
                                                <span class="badge border text-dark"><i class="fas fa-mars text-info"></i>
                                                    Nam</span>
                                            @else
                                                <span class="badge border text-dark"><i class="fas fa-venus text-pink"></i>
                                                    Nữ</span>
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
                            <div class="stat-card bg-primary">
                                <i class="fas fa-child"></i>
                                <div class="stat-number">{{ $children->count() }}</div>
                                <div class="stat-label">Học sinh</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="stat-card bg-success">
                                <i class="fas fa-calendar-check"></i>
                                <div class="stat-number">--</div>
                                <div class="stat-label">Ngày học</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="stat-card bg-warning">
                                <i class="fas fa-star"></i>
                                <div class="stat-number">--</div>
                                <div class="stat-label">Đánh giá</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="stat-card bg-info">
                                <i class="fas fa-bell"></i>
                                <div class="stat-number">{{ isset($userThongbaos) ? $userThongbaos->count() : 0 }}</div>
                                <div class="stat-label">Thông báo</div>
                            </div>
                        </div>
                    </div>

                    <!-- Hoạt động của bé ở trường -->
                    <div class="card border-0 shadow-sm mt-4">
                        <div class="card-header bg-white border-0 py-3 d-flex align-items-center justify-content-between">
                            <h6 class="mb-0 fw-bold"><i class="fas fa-camera text-primary me-2"></i>Hoạt động của bé ở
                                trường</h6>
                            <a href="#" class="text-primary small text-decoration-none">Xem tất cả <i
                                    class="fas fa-arrow-right ms-1"></i></a>
                        </div>
                        <div class="card-body">
                            <!-- Activity Timeline -->
                            <div class="activity-timeline">
                                @if (isset($hoatDongHangNgays) && $hoatDongHangNgays->count() > 0)
                                    @foreach ($hoatDongHangNgays->take(4) as $index => $hoatDong)
                                        @php
                                            $badgeColors = [
                                                'bg-success',
                                                'bg-primary',
                                                'bg-warning text-dark',
                                                'bg-info',
                                            ];
                                            $badgeColor = $hoatDong->badge_color ?? $badgeColors[$index % 4];
                                            $icon = $hoatDong->icon ?? 'fa-star';
                                        @endphp
                                        <div class="activity-item">
                                            <div class="activity-card">
                                                <div class="d-flex align-items-start gap-3">
                                                    @if ($hoatDong->anhHoatDongs && $hoatDong->anhHoatDongs->count() > 0)
                                                        <div class="activity-img-wrapper flex-shrink-0">
                                                            <img src="{{ asset('storage/' . $hoatDong->anhHoatDongs->first()->anh) }}"
                                                                alt="{{ $hoatDong->tieude }}" class="activity-img"
                                                                onerror="this.src='https://images.unsplash.com/photo-1503454537195-1dcabb73ffb9?w=120&h=100&fit=crop'">
                                                        </div>
                                                    @else
                                                        <div class="activity-img-wrapper flex-shrink-0">
                                                            <img src="https://images.unsplash.com/photo-1503454537195-1dcabb73ffb9?w=120&h=100&fit=crop"
                                                                alt="{{ $hoatDong->tieude }}" class="activity-img">
                                                        </div>
                                                    @endif
                                                    <div class="flex-grow-1">
                                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                                            <span class="badge {{ $badgeColor }}"><i
                                                                    class="fas {{ $icon }} me-1"></i>{{ ucfirst($hoatDong->loai) }}</span>
                                                            <small class="text-muted"><i
                                                                    class="fas fa-clock me-1"></i>{{ $hoatDong->giobatdau ? substr($hoatDong->giobatdau, 0, 5) : '' }}
                                                                -
                                                                {{ $hoatDong->gioketthuc ? substr($hoatDong->gioketthuc, 0, 5) : '' }}</small>
                                                        </div>
                                                        <h6 class="mb-1">{{ $hoatDong->tieude }}</h6>
                                                        <p class="text-muted small mb-0">
                                                            {{ Str::limit($hoatDong->mota, 100) }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <!-- Fallback: Dữ liệu mẫu khi chưa có hoạt động -->
                                    <!-- Giờ ăn sáng -->
                                    <div class="activity-item">
                                        <div class="activity-card">
                                            <div class="d-flex align-items-start gap-3">
                                                <div class="activity-img-wrapper flex-shrink-0">
                                                    <img src="https://images.unsplash.com/photo-1484820540004-14229fe36ca4?w=120&h=100&fit=crop"
                                                        alt="Giờ ăn" class="activity-img">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                                        <span class="badge bg-success"><i
                                                                class="fas fa-utensils me-1"></i>Giờ ăn</span>
                                                        <small class="text-muted"><i class="fas fa-clock me-1"></i>7:30 -
                                                            8:00</small>
                                                    </div>
                                                    <h6 class="mb-1">Bữa sáng dinh dưỡng</h6>
                                                    <p class="text-muted small mb-0">Các bé được ăn sáng với thực đơn cháo
                                                        thịt bằm, sữa tươi và trái cây.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Hoạt động học tập -->
                                    <div class="activity-item">
                                        <div class="activity-card">
                                            <div class="d-flex align-items-start gap-3">
                                                <div class="activity-img-wrapper flex-shrink-0">
                                                    <img src="https://images.unsplash.com/photo-1503454537195-1dcabb73ffb9?w=120&h=100&fit=crop"
                                                        alt="Học tập" class="activity-img">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                                        <span class="badge bg-primary"><i class="fas fa-book me-1"></i>Học
                                                            tập</span>
                                                        <small class="text-muted"><i class="fas fa-clock me-1"></i>8:30 -
                                                            10:00</small>
                                                    </div>
                                                    <h6 class="mb-1">Giờ học vẽ & thủ công</h6>
                                                    <p class="text-muted small mb-0">Các bé tham gia hoạt động vẽ tranh về
                                                        gia đình và làm đồ thủ công.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Hoạt động ngoài trời -->
                                    <div class="activity-item">
                                        <div class="activity-card">
                                            <div class="d-flex align-items-start gap-3">
                                                <div class="activity-img-wrapper flex-shrink-0">
                                                    <img src="https://images.unsplash.com/photo-1587654780291-39c9404d746b?w=120&h=100&fit=crop"
                                                        alt="Ngoài trời" class="activity-img">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                                        <span class="badge bg-warning text-dark"><i
                                                                class="fas fa-sun me-1"></i>Ngoài trời</span>
                                                        <small class="text-muted"><i class="fas fa-clock me-1"></i>10:00 -
                                                            10:30</small>
                                                    </div>
                                                    <h6 class="mb-1">Hoạt động thể chất</h6>
                                                    <p class="text-muted small mb-0">Tập thể dục, chơi trò chơi vận động,
                                                        khám phá sân chơi ngoài trời.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Giờ ngủ trưa -->
                                    <div class="activity-item">
                                        <div class="activity-card">
                                            <div class="d-flex align-items-start gap-3">
                                                <div class="activity-img-wrapper flex-shrink-0">
                                                    <img src="https://images.unsplash.com/photo-1596464716127-f2a82984de30?w=120&h=100&fit=crop"
                                                        alt="Nghỉ ngơi" class="activity-img">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                                        <span class="badge bg-info"><i class="fas fa-moon me-1"></i>Nghỉ
                                                            ngơi</span>
                                                        <small class="text-muted"><i class="fas fa-clock me-1"></i>11:30 -
                                                            14:00</small>
                                                    </div>
                                                    <h6 class="mb-1">Giờ ngủ trưa</h6>
                                                    <p class="text-muted small mb-0">Các bé được nghỉ ngơi trong phòng mát
                                                        mẻ, đầy đủ ánh sáng phù hợp.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Photo Gallery Preview -->
                            <div class="mt-4">
                                <h6 class="fw-bold mb-3"><i class="fas fa-images text-primary me-2"></i>Hình ảnh hoạt động
                                    hôm nay</h6>
                                <div class="row g-2">
                                    @if (isset($anhHoatDongs) && $anhHoatDongs->count() > 0)
                                        @foreach ($anhHoatDongs->take(3) as $index => $anh)
                                            <div class="col-4">
                                                <div class="gallery-thumb position-relative rounded overflow-hidden">
                                                    <img src="{{ asset('storage/' . $anh->anh) }}"
                                                        alt="{{ $anh->mota ?? 'Ảnh hoạt động' }}" class="w-100"
                                                        style="height: 80px; object-fit: cover;"
                                                        onerror="this.src='https://images.unsplash.com/photo-1503454537195-1dcabb73ffb9?w=100&h=80&fit=crop'">
                                                    @if ($index == 2 && $anhHoatDongs->count() > 3)
                                                        <div
                                                            class="gallery-more position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center bg-dark bg-opacity-50 text-white fw-bold">
                                                            +{{ $anhHoatDongs->count() - 3 }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="col-4">
                                            <div class="gallery-thumb position-relative rounded overflow-hidden">
                                                <img src="https://images.unsplash.com/photo-1503454537195-1dcabb73ffb9?w=100&h=80&fit=crop"
                                                    alt="" class="w-100"
                                                    style="height: 80px; object-fit: cover;">
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="gallery-thumb position-relative rounded overflow-hidden">
                                                <img src="https://images.unsplash.com/photo-1587654780291-39c9404d746b?w=100&h=80&fit=crop"
                                                    alt="" class="w-100"
                                                    style="height: 80px; object-fit: cover;">
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="gallery-thumb position-relative rounded overflow-hidden">
                                                <img src="https://images.unsplash.com/photo-1544776193-352d25ca82cd?w=100&h=80&fit=crop"
                                                    alt="" class="w-100"
                                                    style="height: 80px; object-fit: cover;">
                                                <div
                                                    class="gallery-more position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center bg-dark bg-opacity-50 text-white fw-bold">
                                                    +5
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
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
            background: #4e73df;
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
            border-left: 4px solid;
            background: #fff;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, .1);
        }

        .stat-card.bg-primary {
            background: linear-gradient(135deg, #f8f9ff 0%, #e8ecff 100%) !important;
            border-left-color: #4e73df;
            color: #333 !important;
        }

        .stat-card.bg-success {
            background: linear-gradient(135deg, #f0fff8 0%, #d4f5e9 100%) !important;
            border-left-color: #1cc88a;
            color: #333 !important;
        }

        .stat-card.bg-warning {
            background: linear-gradient(135deg, #fff5f5 0%, #ffe0de 100%) !important;
            border-left-color: #e74a3b;
            color: #333 !important;
        }

        .stat-card.bg-info {
            background: linear-gradient(135deg, #fffcf0 0%, #fff3d4 100%) !important;
            border-left-color: #f6c23e;
            color: #333 !important;
        }

        .stat-card i {
            font-size: 24px;
        }

        .stat-card.bg-primary i {
            color: #4e73df;
        }

        .stat-card.bg-success i {
            color: #1cc88a;
        }

        .stat-card.bg-warning i {
            color: #e74a3b;
        }

        .stat-card.bg-info i {
            color: #f6c23e;
        }

        .stat-card .stat-number {
            font-size: 28px;
            font-weight: 700;
            margin: 8px 0 4px;
            color: #3a3b45;
        }

        .stat-card .stat-label {
            font-size: 12px;
            color: #6e707e;
            text-transform: uppercase;
            font-weight: 600;
        }

        .menu-item {
            text-decoration: none;
            color: inherit;
            transition: all 0.2s;
        }

        .menu-item:hover {
            background-color: #f8f9fc;
            color: inherit;
            transform: translateX(3px);
        }

        .menu-item h6 {
            color: #3a3b45;
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

        .menu-icon.bg-primary {
            background: #4e73df !important;
        }

        .menu-icon.bg-success {
            background: #1cc88a !important;
        }

        .menu-icon.bg-warning {
            background: #f6c23e !important;
        }

        .menu-icon.bg-info {
            background: #36b9cc !important;
        }

        .menu-icon.bg-danger {
            background: #e74a3b !important;
        }

        .bg-pink {
            background-color: #e91e63 !important;
        }

        .text-pink {
            color: #e91e63 !important;
        }

        .card {
            border-radius: 0.5rem;
        }

        .btn-primary {
            background-color: #4e73df;
            border-color: #4e73df;
        }

        .btn-primary:hover {
            background-color: #224abe;
            border-color: #224abe;
        }

        .text-primary {
            color: #4e73df !important;
        }

        /* Activity Timeline Styles */
        .activity-timeline {
            position: relative;
            padding-left: 25px;
        }

        .activity-timeline::before {
            content: '';
            position: absolute;
            left: 8px;
            top: 20px;
            bottom: 20px;
            width: 3px;
            background: linear-gradient(to bottom, #4e73df, #1cc88a, #f6c23e, #36b9cc);
            border-radius: 3px;
        }

        .activity-item {
            position: relative;
            margin-bottom: 20px;
        }

        .activity-item:last-child {
            margin-bottom: 0;
        }

        .activity-item::before {
            content: '';
            position: absolute;
            left: -21px;
            top: 20px;
            width: 12px;
            height: 12px;
            background: white;
            border: 3px solid #4e73df;
            border-radius: 50%;
            z-index: 1;
        }

        .activity-item:nth-child(2)::before {
            border-color: #1cc88a;
        }

        .activity-item:nth-child(3)::before {
            border-color: #f6c23e;
        }

        .activity-item:nth-child(4)::before {
            border-color: #36b9cc;
        }

        .activity-card {
            background: #f8f9fc;
            border-radius: 12px;
            padding: 15px;
            border-left: 4px solid #4e73df;
            transition: all 0.3s ease;
        }

        .activity-card:hover {
            background: white;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            transform: translateX(5px);
        }

        .activity-item:nth-child(2) .activity-card {
            border-left-color: #1cc88a;
        }

        .activity-item:nth-child(3) .activity-card {
            border-left-color: #f6c23e;
        }

        .activity-item:nth-child(4) .activity-card {
            border-left-color: #36b9cc;
        }

        .activity-img {
            width: 100px;
            height: 70px;
            object-fit: cover;
            border-radius: 8px;
        }

        .gallery-thumb {
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .gallery-thumb:hover {
            transform: scale(1.05);
        }

        .gallery-more {
            cursor: pointer;
        }
    </style>
@endsection
