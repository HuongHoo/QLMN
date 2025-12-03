@extends('layouts.user')

@section('content')
    <main class="main">
        <div class="container py-5">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('parent.home') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item active">Thông tin bé</li>
                </ol>
            </nav>

            <div class="row mb-4">
                <div class="col-12">
                    <h2 class="fw-bold text-primary"><i class="fas fa-child me-2"></i>Thông tin các bé</h2>
                    <p class="text-muted">Xem thông tin chi tiết và theo dõi tình hình của con bạn</p>
                </div>
            </div>

            <!-- Children List -->
            @foreach ($children as $child)
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 text-center mb-3 mb-md-0">
                                @if ($child->anh)
                                    <img src="{{ asset($child->anh) }}" alt="avatar" class="rounded-circle shadow"
                                        style="width:150px;height:150px;object-fit:cover;">
                                @else
                                    <div class="rounded-circle bg-gradient mx-auto d-flex align-items-center justify-content-center shadow"
                                        style="width:150px;height:150px;background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                        <i class="fas fa-user-graduate fa-3x text-white"></i>
                                    </div>
                                @endif
                                <div class="mt-3">
                                    <a href="{{ route('parent.chitietbe', $child->id) }}" class="btn btn-primary">
                                        <i class="fas fa-eye me-1"></i> Xem chi tiết
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div>
                                        <h3 class="mb-1">{{ $child->tenhocsinh }}</h3>
                                        <span
                                            class="badge bg-primary me-1">{{ $child->lophoc->tenlop ?? 'Chưa có lớp' }}</span>
                                        @if ($child->gioitinh == 'Nam')
                                            <span class="badge bg-info"><i class="fas fa-mars"></i> Nam</span>
                                        @else
                                            <span class="badge" style="background-color:#e91e63;"><i
                                                    class="fas fa-venus"></i> Nữ</span>
                                        @endif
                                    </div>
                                    <span class="text-muted">Mã thẻ: <strong>{{ $child->mathe }}</strong></span>
                                </div>

                                <div class="row g-3">
                                    <div class="col-6 col-md-3">
                                        <div class="p-3 bg-light rounded text-center">
                                            <div class="fs-5 fw-bold text-primary">
                                                {{ $child->ngaysinh ? \Carbon\Carbon::parse($child->ngaysinh)->format('d/m/Y') : '-' }}
                                            </div>
                                            <small class="text-muted">Ngày sinh</small>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <div class="p-3 bg-success bg-opacity-10 rounded text-center">
                                            <div class="fs-5 fw-bold text-success">
                                                {{ $childrenStats[$child->id]['coMat'] ?? 0 }}</div>
                                            <small class="text-muted">Ngày có mặt (tháng này)</small>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <div class="p-3 bg-danger bg-opacity-10 rounded text-center">
                                            <div class="fs-5 fw-bold text-danger">
                                                {{ $childrenStats[$child->id]['vang'] ?? 0 }}</div>
                                            <small class="text-muted">Ngày vắng (tháng này)</small>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <div class="p-3 bg-warning bg-opacity-10 rounded text-center">
                                            <div class="fs-5 fw-bold text-warning">
                                                {{ number_format($childrenStats[$child->id]['hocPhiChuaDong'] ?? 0) }}đ
                                            </div>
                                            <small class="text-muted">Học phí chưa đóng</small>
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="mb-2"><i class="fas fa-map-marker-alt text-muted me-2"></i><strong>Địa
                                                chỉ:</strong> {{ $child->diachithuongtru ?? 'Chưa cập nhật' }}</p>
                                        <p class="mb-2"><i class="fas fa-calendar-alt text-muted me-2"></i><strong>Ngày
                                                nhập học:</strong>
                                            {{ $child->ngaynhaphoc ? \Carbon\Carbon::parse($child->ngaynhaphoc)->format('d/m/Y') : 'Chưa cập nhật' }}
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-2"><i class="fas fa-heartbeat text-muted me-2"></i><strong>Ghi chú
                                                sức khỏe:</strong> {{ $child->ghichusuckhoe ?? 'Không có' }}</p>
                                        <p class="mb-2"><i class="fas fa-check-circle text-muted me-2"></i><strong>Trạng
                                                thái:</strong>
                                            <span
                                                class="badge {{ $child->trangthai == 'Đang học' ? 'bg-success' : 'bg-secondary' }}">{{ $child->trangthai ?? 'Đang học' }}</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </main>
@endsection
