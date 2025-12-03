@extends('layouts.user')

@section('content')
    <main class="main">
        <div class="container py-5">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('parent.home') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item active">Sức khỏe</li>
                </ol>
            </nav>

            <div class="row mb-4">
                <div class="col-12">
                    <h2 class="fw-bold text-primary"><i class="fas fa-heartbeat me-2"></i>Sức khỏe</h2>
                    <p class="text-muted">Theo dõi tình hình sức khỏe của con bạn</p>
                </div>
            </div>

            <!-- Health Records by Child -->
            @foreach ($children as $child)
                @php
                    $childHealthRecords = $sucKhoes->where('mahocsinh', $child->id);
                @endphp
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <div class="d-flex align-items-center">
                            @if ($child->anh)
                                <img src="{{ asset($child->anh) }}" class="rounded-circle me-3"
                                    style="width:50px;height:50px;object-fit:cover;">
                            @else
                                <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center me-3"
                                    style="width:50px;height:50px;">
                                    <i class="fas fa-user text-white"></i>
                                </div>
                            @endif
                            <div>
                                <h5 class="mb-0">{{ $child->tenhocsinh }}</h5>
                                <small class="text-muted">{{ $child->lophoc->tenlop ?? '' }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($child->ghichusuckhoe)
                            <div class="alert alert-info mb-3">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Ghi chú sức khỏe:</strong> {{ $child->ghichusuckhoe }}
                            </div>
                        @endif

                        @if ($childHealthRecords->count() > 0)
                            <!-- Latest Health Stats -->
                            @php
                                $latestHealth = $childHealthRecords->first();
                            @endphp
                            <div class="row g-3 mb-4">
                                <div class="col-md-4">
                                    <div class="p-3 bg-primary bg-opacity-10 rounded text-center">
                                        <i class="fas fa-ruler-vertical fa-2x text-primary mb-2"></i>
                                        <h4 class="text-primary mb-0">{{ $latestHealth->chieucao ?? '-' }} cm</h4>
                                        <small class="text-muted">Chiều cao</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="p-3 bg-success bg-opacity-10 rounded text-center">
                                        <i class="fas fa-weight fa-2x text-success mb-2"></i>
                                        <h4 class="text-success mb-0">{{ $latestHealth->cannang ?? '-' }} kg</h4>
                                        <small class="text-muted">Cân nặng</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="p-3 bg-info bg-opacity-10 rounded text-center">
                                        <i class="fas fa-calendar-alt fa-2x text-info mb-2"></i>
                                        <h4 class="text-info mb-0">
                                            {{ $latestHealth->ngaykham ? \Carbon\Carbon::parse($latestHealth->ngaykham)->format('d/m/Y') : '-' }}
                                        </h4>
                                        <small class="text-muted">Lần khám gần nhất</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Health History -->
                            <h6 class="mb-3"><i class="fas fa-history me-2"></i>Lịch sử theo dõi</h6>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Ngày khám</th>
                                            <th>Chiều cao</th>
                                            <th>Cân nặng</th>
                                            <th>Ghi chú</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($childHealthRecords as $sk)
                                            <tr>
                                                <td>{{ $sk->ngaykham ? \Carbon\Carbon::parse($sk->ngaykham)->format('d/m/Y') : '-' }}
                                                </td>
                                                <td>{{ $sk->chieucao ?? '-' }} cm</td>
                                                <td>{{ $sk->cannang ?? '-' }} kg</td>
                                                <td>{{ $sk->ghichu ?? '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-heartbeat fa-3x text-muted mb-3"></i>
                                <p class="text-muted mb-0">Chưa có dữ liệu sức khỏe cho bé</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach

            <!-- Contact -->
            <div class="card border-0 shadow-sm bg-light">
                <div class="card-body py-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h6 class="mb-2"><i class="fas fa-stethoscope text-danger me-2"></i>Cần tư vấn về sức khỏe?
                            </h6>
                            <p class="text-muted mb-0">Liên hệ với phòng y tế nhà trường để được hỗ trợ.</p>
                        </div>
                        <div class="col-md-4 text-md-end mt-3 mt-md-0">
                            <a href="tel:0123456789" class="btn btn-danger">
                                <i class="fas fa-phone me-1"></i> Liên hệ y tế
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
