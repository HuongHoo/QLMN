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
                    <h2 class="fw-bold text-primary"><i class="fas fa-star me-2"></i>Đánh giá</h2>
                    <p class="text-muted">Xem nhận xét và đánh giá từ giáo viên về con bạn</p>
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

            <!-- Evaluations List -->
            @if ($danhGias && $danhGias->count() > 0)
                <div class="row">
                    @foreach ($danhGias as $dg)
                        @php
                            $hs = $children->firstWhere('id', $dg->mahocsinh);
                        @endphp
                        <div class="col-md-6 mb-4 evaluation-item" data-child="{{ $dg->mahocsinh }}">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        @if ($hs && $hs->anh)
                                            <img src="{{ asset($hs->anh) }}" class="rounded-circle me-2"
                                                style="width:40px;height:40px;object-fit:cover;">
                                        @else
                                            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center me-2"
                                                style="width:40px;height:40px;">
                                                <i class="fas fa-user text-white"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <strong>{{ $hs->tenhocsinh ?? 'Học sinh' }}</strong>
                                            <div class="small text-muted">{{ $hs->lophoc->tenlop ?? '' }}</div>
                                        </div>
                                    </div>
                                    <small class="text-muted">{{ $dg->created_at?->format('d/m/Y') }}</small>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <div class="text-warning mb-2">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= ($dg->diemdanhgia ?? 0))
                                                    <i class="fas fa-star fa-lg"></i>
                                                @else
                                                    <i class="far fa-star fa-lg"></i>
                                                @endif
                                            @endfor
                                            <span class="text-muted ms-2">{{ $dg->diemdanhgia ?? 0 }}/5</span>
                                        </div>
                                    </div>
                                    @if ($dg->tieude)
                                        <h6 class="fw-bold">{{ $dg->tieude }}</h6>
                                    @endif
                                    <p class="text-muted mb-0">{{ $dg->nhanxet ?? 'Không có nhận xét' }}</p>
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
                        <p class="text-muted mb-0">Giáo viên sẽ cập nhật đánh giá cho con bạn</p>
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
