@extends('teacher.teacher')

@section('content')
    <div class="col-12">
        <!-- Profile Card -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-gradient-primary d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-white">Thông tin cá nhân</h6>
                <a href="{{ isset($teacher->id) ? route('teacher.thongtincanhan.edit', $teacher->id) : '#' }}"
                    class="btn btn-sm btn-light">
                    <i class="fas fa-edit"></i> Sửa thông tin
                </a>
            </div>

            <div class="card-body">
                <div class="row">
                    <!-- Avatar & Basic Info Section -->
                    <div class="col-md-4 text-center border-right">
                        <div class="mb-3">
                            @if ($teacher->anh)
                                <img src="{{ asset('storage/' . $teacher->anh) }}" class="rounded-circle shadow"
                                    style="width:160px;height:160px;object-fit:cover;border:4px solid #e3f2fd;">
                            @else
                                <div class="rounded-circle bg-light d-inline-flex justify-content-center align-items-center shadow"
                                    style="width:160px;height:160px;border:4px solid #e3f2fd;">
                                    <i class="fas fa-user-circle text-muted" style="font-size:80px;"></i>
                                </div>
                            @endif
                        </div>

                        <h5 class="font-weight-bold text-primary mb-1">{{ $teacher->tengiaovien }}</h5>
                        <p class="text-muted small mb-3">{{ $teacher->chucvu ?? 'Giáo viên' }}</p>

                        <div class="badge badge-success mb-3">
                            <i class="fas fa-check-circle"></i> {{ $teacher->trangthai ?? 'Hoạt động' }}
                        </div>

                        <hr>

                        <div class="text-left">
                            <p class="mb-2"><strong>Số thẻ:</strong> {{ $teacher->sothe }}</p>
                            <p class="mb-2"><strong>CCCD:</strong> {{ $teacher->cccd ?? '-' }}</p>
                            <p class="mb-0"><strong>Ngày vào làm:</strong>
                                @if ($teacher->ngayvaolam)
                                    {{ \Carbon\Carbon::parse($teacher->ngayvaolam)->format('d/m/Y') }}
                                @else
                                    -
                                @endif
                            </p>
                        </div>
                    </div>

                    <!-- Details Section -->
                    <div class="col-md-8">
                        <!-- Basic Information -->
                        <h6 class="font-weight-bold text-primary mb-3">
                            <i class="fas fa-user-circle"></i> Thông tin cơ bản
                        </h6>
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">Ngày sinh</label>
                                <p class="font-weight-500">
                                    @if ($teacher->ngaysinh)
                                        {{ \Carbon\Carbon::parse($teacher->ngaysinh)->format('d/m/Y') }}
                                    @else
                                        -
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">Giới tính</label>
                                <p class="font-weight-500">{{ $teacher->gioitinh ?? '-' }}</p>
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <h6 class="font-weight-bold text-primary mb-3">
                            <i class="fas fa-phone-alt"></i> Thông tin liên lạc
                        </h6>
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">Số điện thoại</label>
                                <p class="font-weight-500">
                                    @if ($teacher->sdt)
                                        <a href="tel:{{ $teacher->sdt }}">{{ $teacher->sdt }}</a>
                                    @else
                                        -
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">Email</label>
                                <p class="font-weight-500">
                                    @if ($teacher->email)
                                        <a href="mailto:{{ $teacher->email }}">{{ $teacher->email }}</a>
                                    @else
                                        -
                                    @endif
                                </p>
                            </div>
                        </div>

                        <!-- Address Information -->
                        <h6 class="font-weight-bold text-primary mb-3">
                            <i class="fas fa-map-marker-alt"></i> Địa chỉ
                        </h6>
                        <div class="mb-3">
                            <label class="text-muted small">Địa chỉ thường trú</label>
                            <p class="font-weight-500">{{ $teacher->diachithuongtru ?? '-' }}</p>
                        </div>
                        <div class="mb-4">
                            <label class="text-muted small">Địa chỉ tạm trú</label>
                            <p class="font-weight-500">{{ $teacher->diachitamtru ?? '-' }}</p>
                        </div>

                        <!-- Work Information -->
                        <h6 class="font-weight-bold text-primary mb-3">
                            <i class="fas fa-briefcase"></i> Thông tin công việc
                        </h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">Lớp chủ nhiệm</label>
                                <p class="font-weight-500">
                                    @if ($teacher->lophoc)
                                        {{ $teacher->lophoc->tenlop }}
                                    @else
                                        Không có
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .bg-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .border-right {
            border-right: 1px solid #e3e6f0;
        }

        @media (max-width: 768px) {
            .border-right {
                border-right: none;
                border-bottom: 1px solid #e3e6f0;
                padding-bottom: 20px;
                margin-bottom: 20px;
            }
        }
    </style>
@endsection
