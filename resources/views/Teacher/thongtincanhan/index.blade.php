@extends('teacher.teacher')

@section('content')
    <style>
        .profile-card {
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            overflow: hidden;
            background: #fff;
        }

        .profile-header {
            background: #fff;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .profile-header h5 {
            margin: 0;
            font-weight: 600;
            color: #1f2937;
            font-size: 1rem;
        }

        .profile-body {
            padding: 2rem;
        }

        .profile-sidebar {
            text-align: center;
            padding-right: 2rem;
            border-right: 1px solid #e5e7eb;
        }

        .profile-avatar {
            width: 140px;
            height: 140px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #e5e7eb;
            margin-bottom: 1rem;
        }

        .profile-avatar-placeholder {
            width: 140px;
            height: 140px;
            border-radius: 50%;
            background: #f3f4f6;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 3px solid #e5e7eb;
            margin-bottom: 1rem;
        }

        .profile-avatar-placeholder i {
            font-size: 60px;
            color: #9ca3af;
        }

        .profile-name {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 0.25rem;
        }

        .profile-role {
            color: #6b7280;
            font-size: 0.9rem;
            margin-bottom: 0.75rem;
        }

        .profile-status {
            display: inline-block;
            padding: 0.35rem 0.75rem;
            background: #d1fae5;
            color: #059669;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .profile-meta {
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e5e7eb;
            text-align: left;
        }

        .profile-meta-item {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
            font-size: 0.9rem;
        }

        .profile-meta-item .label {
            color: #6b7280;
        }

        .profile-meta-item .value {
            color: #1f2937;
            font-weight: 500;
        }

        .info-section {
            margin-bottom: 2rem;
        }

        .info-section:last-child {
            margin-bottom: 0;
        }

        .info-section-title {
            font-size: 0.85rem;
            font-weight: 600;
            color: #1a1a2e;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #1a1a2e;
            display: inline-block;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }

        .info-item .label {
            font-size: 0.8rem;
            color: #6b7280;
            margin-bottom: 0.25rem;
        }

        .info-item .value {
            font-size: 0.95rem;
            color: #1f2937;
            font-weight: 500;
        }

        .info-item .value a {
            color: #1a1a2e;
            text-decoration: none;
        }

        .info-item .value a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .profile-sidebar {
                border-right: none;
                border-bottom: 1px solid #e5e7eb;
                padding-right: 0;
                padding-bottom: 2rem;
                margin-bottom: 2rem;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="col-12">
        <div class="profile-card">
            <div class="profile-header">
                <h5>Thông tin cá nhân</h5>
                <a href="{{ isset($teacher->id) ? route('teacher.thongtincanhan.edit', $teacher->id) : '#' }}"
                    class="btn btn-sm btn-outline-dark">
                    <i class="fas fa-edit me-1"></i> Sửa thông tin
                </a>
            </div>

            <div class="profile-body">
                <div class="row">
                    <!-- Avatar & Basic Info Section -->
                    <div class="col-md-4 profile-sidebar">
                        @if ($teacher->anh)
                            <img src="{{ asset('storage/' . $teacher->anh) }}" class="profile-avatar" alt="Avatar">
                        @else
                            <div class="profile-avatar-placeholder">
                                <i class="fas fa-user"></i>
                            </div>
                        @endif

                        <div class="profile-name">{{ $teacher->tengiaovien }}</div>
                        <div class="profile-role">{{ $teacher->chucvu ?? 'giáo viên' }}</div>
                        <div class="profile-status">
                            <i class="fas fa-check-circle me-1"></i> {{ $teacher->trangthai ?? 'Đang công tác' }}
                        </div>

                        <div class="profile-meta">
                            <div class="profile-meta-item">
                                <span class="label">Số thẻ</span>
                                <span class="value">{{ $teacher->sothe ?? '-' }}</span>
                            </div>
                            <div class="profile-meta-item">
                                <span class="label">CCCD</span>
                                <span class="value">{{ $teacher->cccd ?? '-' }}</span>
                            </div>
                            <div class="profile-meta-item">
                                <span class="label">Ngày vào làm</span>
                                <span class="value">
                                    @if ($teacher->ngayvaolam)
                                        {{ \Carbon\Carbon::parse($teacher->ngayvaolam)->format('d/m/Y') }}
                                    @else
                                        -
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Details Section -->
                    <div class="col-md-8 ps-md-4">
                        <!-- Basic Information -->
                        <div class="info-section">
                            <div class="info-section-title">
                                <i class="fas fa-user me-1"></i> Thông tin cơ bản
                            </div>
                            <div class="info-grid">
                                <div class="info-item">
                                    <div class="label">Ngày sinh</div>
                                    <div class="value">
                                        @if ($teacher->ngaysinh)
                                            {{ \Carbon\Carbon::parse($teacher->ngaysinh)->format('d/m/Y') }}
                                        @else
                                            -
                                        @endif
                                    </div>
                                </div>
                                <div class="info-item">
                                    <div class="label">Giới tính</div>
                                    <div class="value">{{ $teacher->gioitinh ?? '-' }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div class="info-section">
                            <div class="info-section-title">Thông tin liên lạc</div>
                            <div class="info-grid">
                                <div class="info-item">
                                    <div class="label">Số điện thoại</div>
                                    <div class="value">
                                        @if ($teacher->sdt)
                                            <a href="tel:{{ $teacher->sdt }}">{{ $teacher->sdt }}</a>
                                        @else
                                            -
                                        @endif
                                    </div>
                                </div>
                                <div class="info-item">
                                    <div class="label">Email</div>
                                    <div class="value">
                                        @if ($teacher->email)
                                            <a href="mailto:{{ $teacher->email }}">{{ $teacher->email }}</a>
                                        @else
                                            -
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Address Information -->
                        <div class="info-section">
                            <div class="info-section-title">
                                <i class="fas fa-map-marker-alt me-1"></i> Địa chỉ
                            </div>
                            <div class="info-grid">
                                <div class="info-item">
                                    <div class="label">Địa chỉ thường trú</div>
                                    <div class="value">{{ $teacher->diachithuongtru ?? '-' }}</div>
                                </div>
                                <div class="info-item">
                                    <div class="label">Địa chỉ tạm trú</div>
                                    <div class="value">{{ $teacher->diachitamtru ?? '-' }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Work Information -->
                        <div class="info-section">
                            <div class="info-section-title">
                                <i class="fas fa-briefcase me-1"></i> Thông tin công việc
                            </div>
                            <div class="info-grid">
                                <div class="info-item">
                                    <div class="label">Lớp chủ nhiệm</div>
                                    <div class="value">
                                        @if ($teacher->lophoc)
                                            {{ $teacher->lophoc->tenlop }}
                                        @else
                                            Không có
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
