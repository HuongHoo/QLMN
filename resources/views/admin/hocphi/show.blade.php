@extends('admin.welcome')

@section('title', 'Chi tiết học phí')

@section('content')
    <div class="container-fluid" id="container-wrapper">

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Chi tiết học phí</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.hocphi.index') }}">Học phí</a></li>
                <li class="breadcrumb-item active" aria-current="page">Chi tiết</li>
            </ol>
        </div>

        <div class="row">
            <div class="col-lg-4">
                <div class="card shadow-sm mb-4">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            @if ($hocphi->hocsinh->anh)
                                <img src="{{ asset($hocphi->hocsinh->anh) }}" alt="avatar" class="rounded-circle"
                                    style="width:110px;height:110px;object-fit:cover;border:2px solid #e9eef6;">
                            @else
                                <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center"
                                    style="width:110px;height:110px;border:2px solid #e9eef6;">
                                    <i class="fas fa-user fa-2x text-muted"></i>
                                </div>
                            @endif
                        </div>
                        <h5 class="mb-0">{{ $hocphi->hocsinh->tenhocsinh ?? '-' }}</h5>
                        <div class="text-muted small">Lớp: {{ $hocphi->hocsinh->lophoc->tenlop ?? '-' }}</div>
                        {{-- student card actions removed to keep layout clean; actions are at bottom --}}
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card shadow-sm mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="m-0 font-weight-bold"><i class="fas fa-wallet"></i> Chi tiết thanh toán</h6>
                            <small class="text-muted">Thời gian đóng:
                                {{ $hocphi->thoigiandong ? \Carbon\Carbon::parse($hocphi->thoigiandong)->format('d/m/Y') : '-' }}</small>
                        </div>
                        <div>
                            <span class="badge bg-success">Đã thanh toán:
                                {{ number_format($hocphi->dathanhtoan ?? 0, 0, ',', '.') }} đ</span>
                            <span class="badge bg-warning text-dark">Còn nợ:
                                {{ number_format(($hocphi->tongtien ?? 0) - ($hocphi->dathanhtoan ?? 0), 0, ',', '.') }}
                                đ</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="fw-600 text-muted">Học phí</div>
                                <div class="fs-5">{{ number_format($hocphi->hocphi ?? 0, 0, ',', '.') }} đ</div>
                            </div>
                            <div class="col-md-6">
                                <div class="fw-600 text-muted">Tiền ăn sáng</div>
                                <div class="fs-5">{{ number_format($hocphi->tienansang ?? 0, 0, ',', '.') }} đ</div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="fw-600 text-muted">Tiền ăn trưa</div>
                                <div class="fs-5">{{ number_format($hocphi->tienantrua ?? 0, 0, ',', '.') }} đ</div>
                            </div>
                            <div class="col-md-6">
                                <div class="fw-600 text-muted">Tiền xe bus</div>
                                <div class="fs-5">{{ number_format($hocphi->tienxebus ?? 0, 0, ',', '.') }} đ</div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="fw-600 text-muted">Phí khác</div>
                                <div class="fs-5">{{ number_format($hocphi->phikhac ?? 0, 0, ',', '.') }} đ</div>
                            </div>
                            <div class="col-md-6">
                                <div class="fw-600 text-muted">Tổng tiền</div>
                                <div class="fs-4 fw-bold">{{ number_format($hocphi->tongtien ?? 0, 0, ',', '.') }} đ</div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="fw-600 text-muted">Ngày thanh toán</div>
                            <div>
                                {{ $hocphi->ngaythanhtoan ? \Carbon\Carbon::parse($hocphi->ngaythanhtoan)->format('d/m/Y') : '-' }}
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="fw-600 text-muted">Giáo viên thu</div>
                            <div>{{ $hocphi->giaovien->tengiaovien ?? '-' }}</div>
                        </div>

                        <div class="mb-3">
                            <div class="fw-600 text-muted">Ghi chú</div>
                            <div>{{ $hocphi->ghichu ?? '-' }}</div>
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('admin.hocphi.index') }}" class="btn btn-light"><i
                                    class="fas fa-arrow-left"></i>
                                Quay lại</a>
                            <a href="{{ route('admin.hocphi.edit', $hocphi->id) }}" class="btn btn-primary ms-2"><i
                                    class="fas fa-pen"></i> Chỉnh sửa</a>

                            <form action="{{ route('admin.hocphi.destroy', $hocphi->id) }}" method="POST"
                                class="d-inline-block ms-2" onsubmit="return confirm('Bạn có chắc muốn xóa học phí này?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash"></i> Xóa
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
