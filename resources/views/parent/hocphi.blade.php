@extends('layouts.user')

@section('content')
    <main class="main">
        <div class="container py-5">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('parent.home') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item active">Học phí</li>
                </ol>
            </nav>

            <div class="row mb-4">
                <div class="col-12">
                    <h2 class="fw-bold text-primary"><i class="fas fa-wallet me-2"></i>Học phí</h2>
                    <p class="text-muted">Theo dõi tình hình đóng học phí của con bạn</p>
                </div>
            </div>

            <!-- Stats -->
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body py-4">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center me-3"
                                    style="width:60px;height:60px;">
                                    <i class="fas fa-check-circle fa-2x text-success"></i>
                                </div>
                                <div>
                                    <p class="text-muted mb-1">Đã đóng</p>
                                    <h3 class="text-success mb-0">{{ number_format($tongDaDong) }}đ</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body py-4">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-danger bg-opacity-10 d-flex align-items-center justify-content-center me-3"
                                    style="width:60px;height:60px;">
                                    <i class="fas fa-exclamation-circle fa-2x text-danger"></i>
                                </div>
                                <div>
                                    <p class="text-muted mb-1">Chưa đóng</p>
                                    <h3 class="text-danger mb-0">{{ number_format($tongChuaDong) }}đ</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Fee List -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="fas fa-list text-info me-2"></i>Chi tiết học phí</h5>
                </div>
                <div class="card-body">
                    @if ($hocPhis && $hocPhis->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Học sinh</th>
                                        <th>Kỳ học / Tháng</th>
                                        <th>Tổng tiền</th>
                                        <th>Đã đóng</th>
                                        <th>Còn nợ</th>
                                        <th>Trạng thái</th>
                                        <th>Ngày đóng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($hocPhis as $hp)
                                        @php
                                            $hs = $children->firstWhere('id', $hp->mahocsinh);
                                            $conNo = ($hp->tongtien ?? 0) - ($hp->dathanhtoan ?? 0);
                                        @endphp
                                        <tr>
                                            <td>
                                                <strong>{{ $hs->tenhocsinh ?? 'Học sinh' }}</strong>
                                                <div class="small text-muted">{{ $hs->lophoc->tenlop ?? '' }}</div>
                                            </td>
                                            <td>{{ $hp->thoigiandong ? \Carbon\Carbon::parse($hp->thoigiandong)->format('m/Y') : '-' }}
                                            </td>
                                            <td><strong
                                                    class="text-primary">{{ number_format($hp->tongtien ?? 0) }}đ</strong>
                                            </td>
                                            <td><strong
                                                    class="text-success">{{ number_format($hp->dathanhtoan ?? 0) }}đ</strong>
                                            </td>
                                            <td><strong class="text-danger">{{ number_format($conNo) }}đ</strong></td>
                                            <td>
                                                @if ($conNo <= 0)
                                                    <span class="badge bg-success"><i class="fas fa-check me-1"></i>Đã đóng
                                                        đủ</span>
                                                @else
                                                    <span class="badge bg-warning text-dark"><i
                                                            class="fas fa-exclamation me-1"></i>Còn nợ</span>
                                                @endif
                                            </td>
                                            <td>{{ $hp->ngaythanhtoan ? \Carbon\Carbon::parse($hp->ngaythanhtoan)->format('d/m/Y') : '-' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-wallet fa-3x text-muted mb-3"></i>
                            <p class="text-muted mb-0">Chưa có dữ liệu học phí</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Contact -->
            <div class="card border-0 shadow-sm mt-4 bg-light">
                <div class="card-body py-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h6 class="mb-2"><i class="fas fa-info-circle text-info me-2"></i>Cần hỗ trợ về học phí?</h6>
                            <p class="text-muted mb-0">Liên hệ với nhà trường để được hỗ trợ về các vấn đề liên quan đến học
                                phí.</p>
                        </div>
                        <div class="col-md-4 text-md-end mt-3 mt-md-0">
                            <a href="tel:0123456789" class="btn btn-primary">
                                <i class="fas fa-phone me-1"></i> Liên hệ
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
