@extends('teacher.teacher')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-eye text-primary me-2"></i>Chi tiết hoạt động
        </h1>
        <a href="{{ route('teacher.hoatdong.index') }}" class="btn btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm me-1"></i> Quay lại
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <div>
                        <span class="badge bg-{{ $hoatDong->badge_color }} me-2">
                            <i class="fas {{ $hoatDong->icon }}"></i> {{ $hoatDong->loai_text ?? ucfirst($hoatDong->loai) }}
                        </span>
                        <span class="text-muted">
                            {{ \Carbon\Carbon::parse($hoatDong->ngay)->format('d/m/Y') }}
                        </span>
                    </div>
                    <form action="{{ route('teacher.hoatdong.destroy', $hoatDong->id) }}" method="POST"
                        onsubmit="return confirm('Bạn có chắc muốn xóa hoạt động này?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger">
                            <i class="fas fa-trash me-1"></i> Xóa
                        </button>
                    </form>
                </div>
                <div class="card-body">
                    <h4 class="mb-3">{{ $hoatDong->tieude }}</h4>

                    <div class="d-flex gap-4 mb-3 text-muted">
                        <div>
                            <i class="fas fa-clock me-1"></i>
                            <strong>Thời gian:</strong>
                            {{ $hoatDong->giobatdau ? \Carbon\Carbon::parse($hoatDong->giobatdau)->format('H:i') : '' }} -
                            {{ $hoatDong->gioketthuc ? \Carbon\Carbon::parse($hoatDong->gioketthuc)->format('H:i') : '' }}
                        </div>
                        <div>
                            <i class="fas fa-chalkboard me-1"></i>
                            <strong>Lớp:</strong> {{ $hoatDong->lophoc->tenlop ?? 'N/A' }}
                        </div>
                    </div>

                    @if ($hoatDong->hocsinh)
                        <div class="alert alert-info">
                            <i class="fas fa-child me-2"></i>
                            <strong>Học sinh:</strong> {{ $hoatDong->hocsinh->hoten }}
                            <br>
                            <small class="text-muted">Chỉ phụ huynh của bé {{ $hoatDong->hocsinh->hoten }} mới thấy hoạt
                                động này</small>
                        </div>
                    @else
                        <div class="alert alert-success">
                            <i class="fas fa-users me-2"></i>
                            <strong>Áp dụng:</strong> Cả lớp
                            <br>
                            <small class="text-muted">Tất cả phụ huynh trong lớp sẽ thấy hoạt động này</small>
                        </div>
                    @endif

                    @if ($hoatDong->mota)
                        <div class="mb-4">
                            <h6 class="fw-bold"><i class="fas fa-align-left me-1"></i> Mô tả:</h6>
                            <p class="text-muted">{{ $hoatDong->mota }}</p>
                        </div>
                    @endif

                    @if ($hoatDong->anhHoatDongs->count() > 0)
                        <h6 class="fw-bold mb-3"><i class="fas fa-images me-1"></i> Ảnh hoạt động
                            ({{ $hoatDong->anhHoatDongs->count() }} ảnh):</h6>
                        <div class="row g-3">
                            @foreach ($hoatDong->anhHoatDongs as $anh)
                                <div class="col-6 col-md-4">
                                    <div class="position-relative">
                                        <img src="{{ asset('storage/' . $anh->anh) }}" alt="{{ $anh->mota }}"
                                            class="img-fluid rounded shadow-sm"
                                            style="width: 100%; height: 200px; object-fit: cover; cursor: pointer;"
                                            onclick="showImage('{{ asset('storage/' . $anh->anh) }}')"
                                            onerror="this.src='https://via.placeholder.com/300x200?text=📷'">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-image fa-3x mb-3"></i>
                            <p>Chưa có ảnh cho hoạt động này</p>
                        </div>
                    @endif
                </div>
                <div class="card-footer bg-white text-muted">
                    <i class="fas fa-user-edit me-1"></i> Đăng bởi:
                    <strong>{{ $hoatDong->giaovien->tengiaovien ?? 'Giáo viên' }}</strong>
                    <span class="float-end">
                        <i class="fas fa-clock me-1"></i> {{ $hoatDong->created_at->format('H:i d/m/Y') }}
                    </span>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow mb-4 border-left-success">
                <div class="card-header py-3 bg-success text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-info-circle me-2"></i>Thông tin hiển thị
                    </h6>
                </div>
                <div class="card-body">
                    <p class="small text-muted">
                        <i class="fas fa-check-circle text-success me-1"></i>
                        Hoạt động này đang được hiển thị cho phụ huynh.
                    </p>
                    <hr>
                    <h6 class="fw-bold">Phụ huynh sẽ thấy:</h6>
                    <ul class="small text-muted">
                        <li>Ảnh trong mục "Hoạt động của bé ở trường"</li>
                        <li>Tiêu đề và mô tả hoạt động</li>
                        <li>Thời gian diễn ra</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal xem ảnh lớn -->
    <div class="modal fade" id="imageModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered">
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
