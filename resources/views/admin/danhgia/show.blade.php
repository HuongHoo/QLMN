@extends('admin.welcome')

@section('title', 'Chi tiết đánh giá')

@section('content')
    <style>
        .evaluation-detail-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 4px;
            font-weight: 600;
            font-size: 14px;
        }

        .score-1 {
            background: #ffebee;
            color: #c62828;
        }

        .score-2 {
            background: #fff3e0;
            color: #ef6c00;
        }

        .score-3 {
            background: #e3f2fd;
            color: #0277bd;
        }

        .score-4 {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .score-5 {
            background: #f3e5f5;
            color: #7b1fa2;
        }

        .score-empty {
            background: #f5f5f5;
            color: #999;
        }

        .detail-card {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
            border-left: 4px solid #0b5776;
        }

        .detail-label {
            font-weight: 700;
            color: #0b5776;
            font-size: 13px;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .detail-value {
            font-size: 15px;
            color: #333;
        }

        .evaluation-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            margin-top: 15px;
        }

        .evaluation-item {
            background: white;
            padding: 12px;
            border: 1px solid #e6f1fb;
            border-radius: 6px;
            text-align: center;
        }

        .evaluation-item .label {
            display: block;
            font-weight: 600;
            font-size: 12px;
            color: #666;
            margin-bottom: 8px;
        }

        .evaluation-item .score {
            display: block;
            font-size: 28px;
            font-weight: 700;
            color: #0b5776;
        }
    </style>

    <div class="container-fluid" id="container-wrapper">

        {{-- Breadcrumb --}}
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-primary">Chi tiết đánh giá</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.danhgia.index') }}">Đánh giá</a></li>
                <li class="breadcrumb-item active" aria-current="page">Chi tiết</li>
            </ol>
        </div>

        {{-- Thông báo --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow mb-4">
            <div class="card-header bg-primary text-white">
                <h6 class="m-0 font-weight-bold">Thông tin học sinh và đánh giá</h6>
            </div>

            <div class="card-body">
                {{-- Thông tin cơ bản --}}
                <div class="detail-card">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="detail-label">Tên học sinh</div>
                            <div class="detail-value">{{ $danhgia->hocsinh->tenhocsinh ?? '—' }}</div>
                        </div>
                        <div class="col-md-3">
                            <div class="detail-label">Năm đánh giá</div>
                            <div class="detail-value">{{ $danhgia->nam }}</div>
                        </div>
                        <div class="col-md-3">
                            <div class="detail-label">Tháng đánh giá</div>
                            <div class="detail-value">Tháng {{ str_pad($danhgia->thang, 2, '0', STR_PAD_LEFT) }}</div>
                        </div>
                        <div class="col-md-3">
                            <div class="detail-label">Giáo viên</div>
                            <div class="detail-value">{{ $danhgia->giaovien->tengiaovien ?? '—' }}</div>
                        </div>
                    </div>
                </div>

                {{-- Hiển thị tất cả đánh giá của học sinh này trong tháng/năm --}}
                @if (count($allEvaluations) > 0)
                    <div style="margin-top: 30px;">
                        <h6 class="font-weight-bold text-primary mb-3">Các đánh giá ({{ count($allEvaluations) }} bản ghi)
                        </h6>

                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 50px;">STT</th>
                                        <th>Giáo viên</th>
                                        <th style="width: 80px;">Thể chất</th>
                                        <th style="width: 80px;">Ngôn ngữ</th>
                                        <th style="width: 80px;">Nhận thức</th>
                                        <th style="width: 100px;">Cảm xúc xã hội</th>
                                        <th style="width: 80px;">Nghệ thuật</th>
                                        <th>Nhận xét chung</th>
                                        <th style="width: 120px;">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($allEvaluations as $eval)
                                        <tr>
                                            <td style="text-align: center; font-weight: 600;">{{ $loop->iteration }}</td>
                                            <td>{{ $eval->giaovien->tengiaovien ?? '—' }}</td>

                                            <td style="text-align: center;">
                                                @if ($eval->thechat)
                                                    <span class="evaluation-detail-badge score-{{ $eval->thechat }}">
                                                        {{ $eval->thechat }}/5
                                                    </span>
                                                @else
                                                    <span class="evaluation-detail-badge score-empty">—</span>
                                                @endif
                                            </td>

                                            <td style="text-align: center;">
                                                @if ($eval->ngonngu)
                                                    <span class="evaluation-detail-badge score-{{ $eval->ngonngu }}">
                                                        {{ $eval->ngonngu }}/5
                                                    </span>
                                                @else
                                                    <span class="evaluation-detail-badge score-empty">—</span>
                                                @endif
                                            </td>

                                            <td style="text-align: center;">
                                                @if ($eval->nhanthuc)
                                                    <span class="evaluation-detail-badge score-{{ $eval->nhanthuc }}">
                                                        {{ $eval->nhanthuc }}/5
                                                    </span>
                                                @else
                                                    <span class="evaluation-detail-badge score-empty">—</span>
                                                @endif
                                            </td>

                                            <td style="text-align: center;">
                                                @if ($eval->camxucxahoi)
                                                    <span class="evaluation-detail-badge score-{{ $eval->camxucxahoi }}">
                                                        {{ $eval->camxucxahoi }}/5
                                                    </span>
                                                @else
                                                    <span class="evaluation-detail-badge score-empty">—</span>
                                                @endif
                                            </td>

                                            <td style="text-align: center;">
                                                @if ($eval->nghethuat)
                                                    <span class="evaluation-detail-badge score-{{ $eval->nghethuat }}">
                                                        {{ $eval->nghethuat }}/5
                                                    </span>
                                                @else
                                                    <span class="evaluation-detail-badge score-empty">—</span>
                                                @endif
                                            </td>

                                            <td style="font-size: 13px;">{{ $eval->nhanxetchung ?? '—' }}</td>

                                            <td style="text-align: center;">
                                                <a href="{{ route('admin.danhgia.edit', $eval->id) }}"
                                                    class="btn btn-sm btn-warning" title="Sửa">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.danhgia.destroy', $eval->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-danger" title="Xóa"
                                                        onclick="return confirm('Bạn chắc chắn muốn xóa?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> Không có đánh giá nào cho học sinh này trong tháng/năm này.
                    </div>
                @endif
            </div>

            {{-- Nút hành động --}}
            <div class="card-footer bg-light">
                <a href="{{ route('admin.danhgia.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Thêm đánh giá mới
                </a>
                <a href="{{ route('admin.danhgia.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </div>
        </div>
    </div>
@endsection
