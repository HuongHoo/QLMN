@extends('admin.welcome')

@section('content')
    <div class="container-fluid py-4" id="container-wrapper">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
            <div>
                <h3 class="fw-bold text-primary mb-1"><i class="bi bi-journal-plus me-2"></i>Thêm lớp học mới</h3>
                <p class="text-muted small mb-0">Nhập thông tin chi tiết bên dưới để tạo mới một lớp học.</p>
            </div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 bg-transparent p-0 small">
                    <li class="breadcrumb-item"><a href="/" class="text-decoration-none text-muted">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.lophoc.index') }}"
                            class="text-decoration-none text-muted">Lớp học</a></li>
                    <li class="breadcrumb-item active text-primary" aria-current="page">Thêm mới</li>
                </ol>
            </nav>
        </div>

        <!-- Thông báo -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-start border-success border-4"
                role="alert">
                <i class="bi bi-check-circle-fill me-2"></i><strong>Thành công!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show shadow-sm border-start border-danger border-4"
                role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i><strong>Lỗi!</strong> Vui lòng kiểm tra lại các trường
                nhập bên dưới.
                <ul class="mt-2 mb-0 small">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
            </div>
        @endif

        <!-- Card Form -->
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header bg-primary text-white rounded-top-4 py-3">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-pencil-square me-2"></i>Thông tin lớp học</h6>
            </div>
            <div class="card-body bg-light">
                <form action="{{ route('admin.lophoc.store') }}" method="POST" class="row g-4 needs-validation" novalidate>
                    @csrf
                    <div class="col-md-6">
                        <label for="tenlop" class="form-label fw-semibold">Tên lớp <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control shadow-sm" id="tenlop" name="tenlop"
                            placeholder="VD: Mầm Non A1" value="{{ old('tenlop') }}" required>
                        <div class="invalid-feedback">Vui lòng nhập tên lớp.</div>
                    </div>

                    <div class="col-md-6">
                        <label for="nhomtuoi" class="form-label fw-semibold">Nhóm tuổi <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control shadow-sm" id="nhomtuoi" name="nhomtuoi"
                            placeholder="VD: 3 - 4 tuổi" value="{{ old('nhomtuoi') }}" required>
                        <div class="invalid-feedback">Vui lòng nhập nhóm tuổi.</div>
                    </div>

                    <div class="col-md-6">
                        <label for="siso" class="form-label fw-semibold">Sĩ số <span
                                class="text-danger">*</span></label>
                        <input type="number" class="form-control shadow-sm" id="siso" name="siso"
                            placeholder="VD: 30" value="{{ old('siso') }}" required>
                        <div class="invalid-feedback">Vui lòng nhập sĩ số.</div>
                    </div>

                    <div class="col-md-6">
                        <label for="sophong" class="form-label fw-semibold">Số phòng</label>
                        <input type="text" class="form-control shadow-sm" id="sophong" name="sophong"
                            placeholder="VD: P201" value="{{ old('sophong') }}">
                    </div>

                    <div class="col-md-6">
                        <label for="nienkhoa" class="form-label fw-semibold">Niên khóa</label>
                        <input type="text" class="form-control shadow-sm" id="nienkhoa" name="nienkhoa"
                            placeholder="VD: 2024 - 2025" value="{{ old('nienkhoa') }}">
                    </div>

                    <div class="col-12">
                        <label for="ghichu" class="form-label fw-semibold">Ghi chú</label>
                        <textarea class="form-control shadow-sm" id="ghichu" name="ghichu" rows="3"
                            placeholder="Nhập ghi chú nếu có...">{{ old('ghichu') }}</textarea>
                    </div>

                    <div class="col-12 d-flex justify-content-end mt-4">
                        <a href="{{ route('admin.lophoc.index') }}" class="btn btn-outline-secondary me-2">
                            <i class="bi bi-arrow-left"></i> Quay lại
                        </a>
                        <button type="submit" class="btn btn-primary shadow-sm">
                            <i class="bi bi-save2"></i> Lưu lớp học
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Script kiểm tra form Bootstrap -->
    <script>
        (function() {
            'use strict'
            const forms = document.querySelectorAll('.needs-validation')
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>
@endsection
