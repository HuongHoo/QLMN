@extends('teacher.teacher')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-camera text-primary me-2"></i>Hoạt động hàng ngày
        </h1>
        <div class="d-flex gap-2">
            <a href="{{ route('teacher.hoatdong.create') }}" class="btn btn-primary shadow-sm">
                <i class="fas fa-plus fa-sm me-1"></i> Đăng hoạt động mới
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Lọc theo ngày -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-white">
            <form method="GET" class="row g-3 align-items-center">
                <div class="col-auto">
                    <label class="col-form-label fw-bold">
                        <i class="fas fa-calendar-alt text-primary me-1"></i> Xem theo ngày:
                    </label>
                </div>
                <div class="col-auto">
                    <input type="date" name="ngay" class="form-control" value="{{ $ngay }}">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Xem
                    </button>
                </div>
                <div class="col-auto">
                    <a href="{{ route('teacher.hoatdong.index', ['ngay' => now()->format('Y-m-d')]) }}"
                        class="btn btn-outline-secondary">
                        Hôm nay
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Thông tin lớp -->
    <div class="info mb-4">
        <i class="fas fa-info-circle me-2"></i>
        Lớp <strong>{{ $lop->tenlop }}</strong> - Ngày <strong>{{ \Carbon\Carbon::parse($ngay)->format('d/m/Y') }}</strong>
        - Có <strong>{{ $hoatDongs->count() }}</strong> hoạt động đã đăng
    </div>

    <!-- Danh sách hoạt động -->
    @if ($hoatDongs->count() > 0)
        <div class="row">
            @foreach ($hoatDongs as $hoatDong)
                <div class="col-lg-6 mb-4">
                    <div class="card shadow h-100">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <div>
                                <span class="badge bg-{{ $hoatDong->badge_color }} me-2">
                                    <i class="fas {{ $hoatDong->icon }}"></i>
                                    {{ $hoatDong->loai_text ?? ucfirst($hoatDong->loai) }}
                                </span>
                                <small class="text-muted">
                                    <i class="fas fa-clock"></i>
                                    {{ $hoatDong->giobatdau ? \Carbon\Carbon::parse($hoatDong->giobatdau)->format('H:i') : '' }}
                                    -
                                    {{ $hoatDong->gioketthuc ? \Carbon\Carbon::parse($hoatDong->gioketthuc)->format('H:i') : '' }}
                                </small>
                            </div>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-light" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item"
                                            href="{{ route('teacher.hoatdong.show', $hoatDong->id) }}">
                                            <i class="fas fa-eye me-2"></i>Xem chi tiết
                                        </a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <form action="{{ route('teacher.hoatdong.destroy', $hoatDong->id) }}"
                                            method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa hoạt động này?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="fas fa-trash me-2"></i>Xóa
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $hoatDong->tieude }}</h5>
                            @if ($hoatDong->hocsinh)
                                <p class="text-info mb-2">
                                    <i class="fas fa-child me-1"></i> Bé: <strong>{{ $hoatDong->hocsinh->hoten }}</strong>
                                </p>
                            @else
                                <p class="text-success mb-2">
                                    <i class="fas fa-users me-1"></i> Cả lớp
                                </p>
                            @endif
                            <p class="card-text text-muted">{{ $hoatDong->mota }}</p>

                            @if ($hoatDong->anhHoatDongs->count() > 0)
                                <div class="row g-2 mt-2">
                                    @foreach ($hoatDong->anhHoatDongs->take(4) as $index => $anh)
                                        <div class="col-3">
                                            <div class="position-relative">
                                                <img src="{{ asset('storage/' . $anh->anh) }}" alt=""
                                                    class="img-fluid rounded"
                                                    style="height: 80px; width: 100%; object-fit: cover; cursor: pointer;"
                                                    onclick="showImage('{{ asset('storage/' . $anh->anh) }}')"
                                                    onerror="this.src='https://via.placeholder.com/100?text=📷'">
                                                @if ($index == 3 && $hoatDong->anhHoatDongs->count() > 4)
                                                    <div
                                                        class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center bg-dark bg-opacity-50 rounded text-white fw-bold">
                                                        +{{ $hoatDong->anhHoatDongs->count() - 4 }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-muted small">
                                    <i class="fas fa-image me-1"></i> Chưa có ảnh
                                </p>
                            @endif
                        </div>
                        <div class="card-footer bg-white text-muted small">
                            <i class="fas fa-user-edit me-1"></i> {{ $hoatDong->giaovien->tengiaovien ?? 'Giáo viên' }}
                            <span class="float-end">
                                <i class="fas fa-clock me-1"></i> {{ $hoatDong->created_at->format('H:i d/m/Y') }}
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="card shadow">
            <div class="card-body text-center py-5">
                <i class="fas fa-camera fa-4x text-muted mb-3"></i>
                <h5 class="text-muted">Chưa có hoạt động nào trong ngày {{ \Carbon\Carbon::parse($ngay)->format('d/m/Y') }}
                </h5>
                <p class="text-muted">Hãy đăng ảnh hoạt động để phụ huynh có thể theo dõi con em mình!</p>
                <a href="{{ route('teacher.hoatdong.create') }}" class="btn btn-primary mt-2">
                    <i class="fas fa-plus me-1"></i> Đăng hoạt động đầu tiên
                </a>
            </div>
        </div>
    @endif

    <!-- Modal xem ảnh lớn -->
    <div class="modal fade" id="imageModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <button type="button" class="btn-close position-absolute top-0 end-0 m-2 bg-white"
                        data-bs-dismiss="modal"></button>
                    <img id="modalImage" src="" class="img-fluid w-100">
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function showImage(src) {
            document.getElementById('modalImage').src = src;
            new bootstrap.Modal(document.getElementById('imageModal')).show();
        }
    </script>
@endsection
