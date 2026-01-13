@extends('layouts.user')

@section('content')
    <main class="main">
        <div class="container py-4">
            <!-- Page Header -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="d-flex align-items-center justify-content-between page-header">
                        <div>
                            <h2 class="fw-bold mb-1"><i class="fas fa-newspaper text-primary me-2"></i>Hoạt động của bé</h2>
                            <p class="text-muted mb-0">Theo dõi mọi khoảnh khắc đặc biệt của bé ở trường</p>
                        </div>
                        <a href="{{ route('parent.home') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Quay lại
                        </a>
                    </div>
                </div>
            </div>

            <!-- Activity Cards - Newspaper/Blog Style -->
            <div class="row g-4">
                @forelse ($hoatDongHangNgays as $hoatDong)
                    <div class="col-md-6 col-lg-4">
                        <div class="activity-blog-card h-100">
                            <!-- Main Image -->
                            <div class="activity-blog-image position-relative">
                                @if ($hoatDong->anhHoatDongs && $hoatDong->anhHoatDongs->count() > 0)
                                    <img src="{{ asset('storage/' . $hoatDong->anhHoatDongs->first()->anh) }}"
                                        alt="{{ $hoatDong->tieude }}" class="w-100"
                                        onerror="this.src='https://images.unsplash.com/photo-1503454537195-1dcabb73ffb9?w=400&h=250&fit=crop'">
                                    @if ($hoatDong->anhHoatDongs->count() > 1)
                                        <div class="image-count-badge">
                                            <i class="fas fa-images me-1"></i>{{ $hoatDong->anhHoatDongs->count() }}
                                        </div>
                                    @endif
                                @else
                                    <img src="https://images.unsplash.com/photo-1503454537195-1dcabb73ffb9?w=400&h=250&fit=crop"
                                        alt="Default" class="w-100">
                                @endif
                                <div class="activity-overlay">
                                    <span class="activity-type-badge {{ $hoatDong->badge_color ?? 'bg-primary' }}">
                                        <i
                                            class="fas {{ $hoatDong->icon ?? 'fa-star' }} me-1"></i>{{ ucfirst($hoatDong->loai) }}
                                    </span>
                                </div>
                            </div>

                            <!-- Card Content -->
                            <div class="activity-blog-content">
                                <!-- Meta Info -->
                                <div class="activity-meta d-flex align-items-center gap-2 mb-2">
                                    <span class="text-muted small">
                                        <i
                                            class="far fa-calendar me-1"></i>{{ \Carbon\Carbon::parse($hoatDong->ngay)->format('d/m/Y') }}
                                    </span>
                                    <span class="text-muted small">
                                        <i class="far fa-clock me-1"></i>{{ substr($hoatDong->giobatdau, 0, 5) }}
                                    </span>
                                    @if ($hoatDong->lophoc)
                                        <span class="badge badge-outline">{{ $hoatDong->lophoc->tenlop }}</span>
                                    @endif
                                </div>

                                <!-- Title -->
                                <h5 class="activity-title mb-2">{{ $hoatDong->tieude }}</h5>

                                <!-- Description -->
                                @if ($hoatDong->mota)
                                    <p class="activity-description text-muted mb-3">
                                        {{ Str::limit($hoatDong->mota, 120) }}
                                    </p>
                                @endif

                                <!-- Teacher Info -->
                                @if ($hoatDong->giaovien)
                                    <div class="teacher-info d-flex align-items-center">
                                        <div class="teacher-avatar me-2">
                                            @if ($hoatDong->giaovien->anh)
                                                <img src="{{ asset($hoatDong->giaovien->anh) }}" alt="avatar"
                                                    onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($hoatDong->giaovien->hoten) }}&background=4e73df&color=fff'">
                                            @else
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($hoatDong->giaovien->hoten) }}&background=4e73df&color=fff"
                                                    alt="avatar">
                                            @endif
                                        </div>
                                        <div class="teacher-name">
                                            <small class="text-muted d-block">Giáo viên</small>
                                            <strong class="small">{{ $hoatDong->giaovien->hoten }}</strong>
                                        </div>
                                    </div>
                                @endif

                                <!-- Gallery Preview -->
                                @if ($hoatDong->anhHoatDongs && $hoatDong->anhHoatDongs->count() > 1)
                                    <div class="gallery-preview mt-3">
                                        <div class="row g-1">
                                            @foreach ($hoatDong->anhHoatDongs->skip(1)->take(3) as $anh)
                                                <div class="col-4">
                                                    <img src="{{ asset('storage/' . $anh->anh) }}" alt="Gallery"
                                                        class="gallery-thumb"
                                                        onerror="this.src='https://images.unsplash.com/photo-1503454537195-1dcabb73ffb9?w=100&h=100&fit=crop'">
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="empty-state text-center py-5">
                            <i class="fas fa-images fa-4x text-muted mb-3"></i>
                            <h4 class="text-muted">Chưa có hoạt động nào</h4>
                            <p class="text-muted">Các hoạt động của bé sẽ được cập nhật tại đây</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if ($hoatDongHangNgays->hasPages())
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="d-flex justify-content-center">
                            {{ $hoatDongHangNgays->links() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </main>

    <style>
        .page-header {
            padding-bottom: 15px;
            border-bottom: 2px solid #e3e6f0;
        }

        .activity-blog-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .activity-blog-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .activity-blog-image {
            height: 250px;
            overflow: hidden;
        }

        .activity-blog-image img {
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .activity-blog-card:hover .activity-blog-image img {
            transform: scale(1.1);
        }

        .activity-overlay {
            position: absolute;
            top: 15px;
            left: 15px;
            right: 15px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .activity-type-badge {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            color: white;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
        }

        .activity-type-badge.bg-success {
            background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%);
        }

        .activity-type-badge.bg-primary {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        }

        .activity-type-badge.bg-warning {
            background: linear-gradient(135deg, #f6c23e 0%, #dda20a 100%);
        }

        .activity-type-badge.bg-info {
            background: linear-gradient(135deg, #36b9cc 0%, #258391 100%);
        }

        .image-count-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            backdrop-filter: blur(10px);
        }

        .activity-blog-content {
            padding: 20px;
        }

        .activity-meta {
            flex-wrap: wrap;
        }

        .badge-outline {
            border: 1px solid #4e73df;
            color: #4e73df;
            background: transparent;
            font-size: 11px;
            padding: 3px 8px;
        }

        .activity-title {
            font-size: 18px;
            font-weight: 700;
            color: #2c3e50;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .activity-description {
            font-size: 14px;
            line-height: 1.6;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .teacher-info {
            padding-top: 15px;
            border-top: 1px solid #e3e6f0;
        }

        .teacher-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            overflow: hidden;
            border: 2px solid #4e73df;
        }

        .teacher-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .teacher-name strong {
            color: #2c3e50;
            font-size: 13px;
        }

        .gallery-preview {
            border-top: 1px solid #e3e6f0;
            padding-top: 12px;
        }

        .gallery-thumb {
            width: 100%;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .gallery-thumb:hover {
            transform: scale(1.05);
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
        }

        .empty-state {
            background: white;
            border-radius: 15px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .activity-blog-image {
                height: 200px;
            }

            .activity-title {
                font-size: 16px;
            }
        }
    </style>
@endsection
