@extends('teacher.teacher')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="mb-1 fw-bold text-dark">Xuất file báo cáo</h4>
            <p class="text-muted mb-0">Xuất báo cáo học phí và đánh giá học sinh</p>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Thông tin lớp -->
    <div class="info mb-4">
        <i class="fas fa-info-circle me-2"></i>
        Lớp <strong>{{ $lop->tenlop }}</strong> - Giáo viên: <strong>{{ $teacher->tengiaovien }}</strong>
        - Sĩ số: <strong>{{ $hocsinhs->count() }}</strong> học sinh
    </div>

    <div class="row">
        <!-- Xuất học phí cả lớp -->
        <div class="col-lg-6 mb-4">
            <div class="card h-100 border-left-primary">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-file-invoice-dollar me-2 text-muted"></i>Xuất báo cáo học phí
                    </h6>
                </div>
                <div class="card-body">
                    <p class="text-muted">Xuất báo cáo học phí tổng hợp của cả lớp hoặc từng học sinh.</p>

                    <div class="d-grid gap-2">
                        <a href="{{ route('teacher.xuatfile.hocphi-lop') }}" class="btn btn-dark">
                            <i class="fas fa-download me-1"></i> Xuất học phí cả lớp (PDF)
                        </a>
                    </div>

                    <hr>
                    <h6 class="fw-bold mb-3">Hoặc chọn học sinh cụ thể:</h6>
                    <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                        <table class="table table-sm table-hover">
                            <thead class="table-light sticky-top">
                                <tr>
                                    <th>Học sinh</th>
                                    <th class="text-center">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($hocsinhs as $hs)
                                    <tr>
                                        <td>
                                            <i class="fas fa-child text-primary me-1"></i>
                                            {{ $hs->tenhocsinh }}
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('teacher.xuatfile.hocphi', $hs->id) }}"
                                                class="btn btn-sm btn-outline-primary" title="Tải xuống PDF">
                                                <i class="fas fa-download"></i>
                                            </a>
                                            <a href="{{ route('teacher.xuatfile.xemtruoc-hocphi', $hs->id) }}"
                                                class="btn btn-sm btn-outline-info" target="_blank" title="Xem trước">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Xuất đánh giá cả lớp -->
        <div class="col-lg-6 mb-4">
            <div class="card h-100 border-left-success">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-star me-2 text-muted"></i>Xuất bảng đánh giá
                    </h6>
                </div>
                <div class="card-body">
                    <p class="text-muted">Xuất bảng đánh giá phát triển của học sinh theo tháng/năm.</p>

                    <!-- Form xuất đánh giá cả lớp -->
                    <form action="{{ route('teacher.xuatfile.danhgia-lop') }}" method="GET" class="mb-3">
                        <div class="row g-2 mb-2">
                            <div class="col-6">
                                <label class="form-label small">Năm:</label>
                                <select name="nam" class="form-select form-select-sm">
                                    @for ($y = date('Y'); $y >= date('Y') - 2; $y--)
                                        <option value="{{ $y }}">{{ $y }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label small">Tháng:</label>
                                <select name="thang" class="form-select form-select-sm">
                                    @for ($m = 1; $m <= 12; $m++)
                                        <option value="{{ $m }}" {{ $m == date('m') ? 'selected' : '' }}>
                                            Tháng {{ $m }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-dark w-100">
                            <i class="fas fa-download me-1"></i> Xuất đánh giá cả lớp (PDF)
                        </button>
                    </form>

                    <hr>
                    <h6 class="fw-bold mb-3">Hoặc chọn học sinh cụ thể:</h6>
                    <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                        <table class="table table-sm table-hover">
                            <thead class="table-light sticky-top">
                                <tr>
                                    <th>Học sinh</th>
                                    <th class="text-center">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($hocsinhs as $hs)
                                    <tr>
                                        <td>
                                            <i class="fas fa-child text-success me-1"></i>
                                            {{ $hs->tenhocsinh }}
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('teacher.xuatfile.danhgia', $hs->id) }}"
                                                class="btn btn-sm btn-outline-success" title="Tải xuống PDF">
                                                <i class="fas fa-download"></i>
                                            </a>
                                            <a href="{{ route('teacher.xuatfile.xemtruoc-danhgia', $hs->id) }}"
                                                class="btn btn-sm btn-outline-info" target="_blank" title="Xem trước">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Hướng dẫn -->
    <div class="card mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">
                <i class="fas fa-lightbulb me-2 text-muted"></i>Hướng dẫn sử dụng
            </h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="fw-bold"><i class="fas fa-file-invoice-dollar me-2 text-muted"></i>Xuất học phí:</h6>
                    <ul class="small text-muted">
                        <li><strong>Cả lớp:</strong> Bảng tổng hợp học phí của tất cả học sinh</li>
                        <li><strong>Từng học sinh:</strong> Chi tiết các khoản thu của từng bé</li>
                        <li>File PDF có thể in hoặc gửi cho phụ huynh</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h6 class="fw-bold"><i class="fas fa-star me-2 text-muted"></i>Xuất đánh giá:</h6>
                    <ul class="small text-muted">
                        <li><strong>Cả lớp:</strong> Bảng đánh giá tất cả học sinh theo tháng</li>
                        <li><strong>Từng học sinh:</strong> Đánh giá chi tiết 5 lĩnh vực phát triển</li>
                        <li>Bao gồm: Thể chất, Ngôn ngữ, Nhận thức, Cảm xúc-Xã hội, Nghệ thuật</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
