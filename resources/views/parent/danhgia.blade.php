@extends('layouts.user')

@section('content')
    <main class="main">
        <div class="container py-5">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('parent.home') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item active">Đánh giá</li>
                </ol>
            </nav>

            <div class="row mb-4">
                <div class="col-12">
                    <h2 class="fw-bold text-primary"><i class="fas fa-star me-2"></i>Đánh giá phát triển</h2>
                    <p class="text-muted">Xem đánh giá mức độ phát triển các lĩnh vực của con theo thang điểm 1-5</p>
                </div>
            </div>

            <!-- Filter by child -->
            @if ($children->count() > 1)
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex flex-wrap gap-2">
                            <span class="me-2 py-1">Lọc theo bé:</span>
                            <button class="btn btn-primary btn-sm active" data-filter="all">Tất cả</button>
                            @foreach ($children as $child)
                                <button class="btn btn-outline-primary btn-sm"
                                    data-filter="{{ $child->id }}">{{ $child->tenhocsinh }}</button>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Chú thích thang điểm -->
            <div class="card border-0 shadow-sm mb-4 bg-light">
                <div class="card-body py-3">
                    <h6 class="mb-2"><i class="fas fa-info-circle text-primary me-2"></i>Thang điểm đánh giá:</h6>
                    <div class="d-flex flex-wrap gap-3">
                        <span><span class="badge bg-danger">1</span> Chưa đạt</span>
                        <span><span class="badge bg-warning text-dark">2</span> Cần cố gắng</span>
                        <span><span class="badge bg-info">3</span> Đạt yêu cầu</span>
                        <span><span class="badge bg-primary">4</span> Tốt</span>
                        <span><span class="badge bg-success">5</span> Xuất sắc</span>
                    </div>
                </div>
            </div>

            <!-- Evaluations List -->
            @if ($danhGias && $danhGias->count() > 0)
                <div class="row">
                    @foreach ($danhGias as $dg)
                        @php
                            $hs = $children->firstWhere('id', $dg->mahocsinh);

                            // Xử lý hiển thị tháng/năm
                            $thangNam = '';
                            $thangValue = $dg->thang;
                            $namValue = $dg->nam;

                            // Nếu thang là date object, lấy tháng
                            if ($thangValue instanceof \Carbon\Carbon) {
                                $thangValue = $thangValue->month;
                            } elseif (is_string($thangValue) && strlen($thangValue) > 2) {
                                // Nếu là chuỗi date, parse và lấy tháng
                                try {
                                    $thangValue = \Carbon\Carbon::parse($thangValue)->month;
                                } catch (\Exception $e) {
                                    $thangValue = intval($thangValue);
                                }
                            }

                            // Nếu nam là date object, lấy năm
                            if ($namValue instanceof \Carbon\Carbon) {
                                $namValue = $namValue->year;
                            } elseif (is_string($namValue) && strlen($namValue) > 4) {
                                // Nếu là chuỗi date, parse và lấy năm
                                try {
                                    $namValue = \Carbon\Carbon::parse($namValue)->year;
                                } catch (\Exception $e) {
                                    $namValue = intval($namValue);
                                }
                            }

                            // Tạo chuỗi hiển thị
                            if ($thangValue && $namValue) {
                                $thangNam = 'Tháng ' . $thangValue . '/' . $namValue;
                            } elseif ($namValue) {
                                $thangNam = 'Năm ' . $namValue;
                            } elseif ($thangValue) {
                                $thangNam = 'Tháng ' . $thangValue;
                            } else {
                                $thangNam = $dg->created_at ? $dg->created_at->format('m/Y') : '';
                            }
                        @endphp
                        <div class="col-lg-6 mb-4 evaluation-item" data-child="{{ $dg->mahocsinh }}">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-header bg-gradient bg-primary text-white py-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            @if ($hs && $hs->anh)
                                                <img src="{{ asset($hs->anh) }}"
                                                    class="rounded-circle me-2 border border-2 border-white"
                                                    style="width:45px;height:45px;object-fit:cover;">
                                            @else
                                                <div class="rounded-circle bg-white d-flex align-items-center justify-content-center me-2"
                                                    style="width:45px;height:45px;">
                                                    <i class="fas fa-child text-primary"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <strong>{{ $hs->tenhocsinh ?? 'Học sinh' }}</strong>
                                                <div class="small opacity-75">{{ $hs->lophoc->tenlop ?? '' }}</div>
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <div class="small opacity-75">Kỳ đánh giá</div>
                                            <strong>{{ $thangNam ?: $dg->created_at?->format('m/Y') }}</strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <!-- 5 lĩnh vực đánh giá -->
                                    <div class="mb-4">
                                        <!-- Thể chất -->
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle bg-danger bg-opacity-10 p-2 me-2">
                                                    <i class="fas fa-running text-danger"></i>
                                                </div>
                                                <span class="fw-medium">Thể chất</span>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= ($dg->thechat ?? 0))
                                                        <i class="fas fa-star text-warning"></i>
                                                    @else
                                                        <i class="far fa-star text-muted"></i>
                                                    @endif
                                                @endfor
                                                <span
                                                    class="badge bg-{{ $dg->thechat >= 4 ? 'success' : ($dg->thechat >= 3 ? 'info' : 'warning') }} ms-2">{{ $dg->thechat ?? 0 }}/5</span>
                                            </div>
                                        </div>

                                        <!-- Ngôn ngữ -->
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle bg-primary bg-opacity-10 p-2 me-2">
                                                    <i class="fas fa-comments text-primary"></i>
                                                </div>
                                                <span class="fw-medium">Ngôn ngữ</span>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= ($dg->ngonngu ?? 0))
                                                        <i class="fas fa-star text-warning"></i>
                                                    @else
                                                        <i class="far fa-star text-muted"></i>
                                                    @endif
                                                @endfor
                                                <span
                                                    class="badge bg-{{ $dg->ngonngu >= 4 ? 'success' : ($dg->ngonngu >= 3 ? 'info' : 'warning') }} ms-2">{{ $dg->ngonngu ?? 0 }}/5</span>
                                            </div>
                                        </div>

                                        <!-- Nhận thức -->
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle bg-success bg-opacity-10 p-2 me-2">
                                                    <i class="fas fa-brain text-success"></i>
                                                </div>
                                                <span class="fw-medium">Nhận thức</span>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= ($dg->nhanthuc ?? 0))
                                                        <i class="fas fa-star text-warning"></i>
                                                    @else
                                                        <i class="far fa-star text-muted"></i>
                                                    @endif
                                                @endfor
                                                <span
                                                    class="badge bg-{{ $dg->nhanthuc >= 4 ? 'success' : ($dg->nhanthuc >= 3 ? 'info' : 'warning') }} ms-2">{{ $dg->nhanthuc ?? 0 }}/5</span>
                                            </div>
                                        </div>

                                        <!-- Cảm xúc - Xã hội -->
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle bg-info bg-opacity-10 p-2 me-2">
                                                    <i class="fas fa-heart text-info"></i>
                                                </div>
                                                <span class="fw-medium">Cảm xúc - Xã hội</span>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= ($dg->camxucxahoi ?? 0))
                                                        <i class="fas fa-star text-warning"></i>
                                                    @else
                                                        <i class="far fa-star text-muted"></i>
                                                    @endif
                                                @endfor
                                                <span
                                                    class="badge bg-{{ $dg->camxucxahoi >= 4 ? 'success' : ($dg->camxucxahoi >= 3 ? 'info' : 'warning') }} ms-2">{{ $dg->camxucxahoi ?? 0 }}/5</span>
                                            </div>
                                        </div>

                                        <!-- Nghệ thuật -->
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle bg-warning bg-opacity-10 p-2 me-2">
                                                    <i class="fas fa-palette text-warning"></i>
                                                </div>
                                                <span class="fw-medium">Nghệ thuật</span>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= ($dg->nghethuat ?? 0))
                                                        <i class="fas fa-star text-warning"></i>
                                                    @else
                                                        <i class="far fa-star text-muted"></i>
                                                    @endif
                                                @endfor
                                                <span
                                                    class="badge bg-{{ $dg->nghethuat >= 4 ? 'success' : ($dg->nghethuat >= 3 ? 'info' : 'warning') }} ms-2">{{ $dg->nghethuat ?? 0 }}/5</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Điểm trung bình -->
                                    @php
                                        $tongDiem =
                                            ($dg->thechat ?? 0) +
                                            ($dg->ngonngu ?? 0) +
                                            ($dg->nhanthuc ?? 0) +
                                            ($dg->camxucxahoi ?? 0) +
                                            ($dg->nghethuat ?? 0);
                                        $diemTB = $tongDiem > 0 ? round($tongDiem / 5, 1) : 0;
                                    @endphp
                                    <div class="bg-light rounded p-3 mb-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="fw-bold">Điểm trung bình:</span>
                                            <div>
                                                <span
                                                    class="fs-4 fw-bold text-{{ $diemTB >= 4 ? 'success' : ($diemTB >= 3 ? 'primary' : 'warning') }}">{{ $diemTB }}</span>
                                                <span class="text-muted">/5</span>
                                            </div>
                                        </div>
                                        <div class="progress mt-2" style="height: 8px;">
                                            <div class="progress-bar bg-{{ $diemTB >= 4 ? 'success' : ($diemTB >= 3 ? 'primary' : 'warning') }}"
                                                style="width: {{ ($diemTB / 5) * 100 }}%"></div>
                                        </div>
                                    </div>

                                    <!-- Nhận xét chung -->
                                    @if ($dg->nhanxetchung)
                                        <div class="border-top pt-3">
                                            <h6 class="fw-bold text-primary mb-2">
                                                <i class="fas fa-comment-dots me-1"></i> Nhận xét của giáo viên:
                                            </h6>
                                            <p class="text-muted mb-0 fst-italic">"{{ $dg->nhanxetchung }}"</p>
                                        </div>
                                    @endif

                                    <!-- Giáo viên đánh giá -->
                                    @if ($dg->giaovien)
                                        <div class="border-top pt-3 mt-3">
                                            <small class="text-muted">
                                                <i class="fas fa-user-tie me-1"></i> Giáo viên:
                                                <strong>{{ $dg->giaovien->tengiaovien ?? 'N/A' }}</strong>
                                            </small>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-star fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Chưa có đánh giá</h5>
                        <p class="text-muted mb-0">Giáo viên sẽ cập nhật đánh giá phát triển cho con bạn theo từng kỳ</p>
                    </div>
                </div>
            @endif
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterBtns = document.querySelectorAll('[data-filter]');
            const items = document.querySelectorAll('.evaluation-item');

            filterBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    filterBtns.forEach(b => b.classList.remove('btn-primary', 'active'));
                    filterBtns.forEach(b => b.classList.add('btn-outline-primary'));
                    this.classList.remove('btn-outline-primary');
                    this.classList.add('btn-primary', 'active');

                    const filter = this.dataset.filter;
                    items.forEach(item => {
                        if (filter === 'all' || item.dataset.child === filter) {
                            item.style.display = 'block';
                        } else {
                            item.style.display = 'none';
                        }
                    });
                });
            });
        });
    </script>
@endsection
