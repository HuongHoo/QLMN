@extends('teacher.teacher')

@section('content')
    <style>
        .info-card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .star-rating {
            display: inline-flex;
            gap: 3px;
            font-size: 22px;
        }

        .star-rating .star {
            color: #ddd;
        }

        .star-rating .star.filled {
            color: #ffc107;
        }

        .rating-text {
            color: #999;
            font-size: 14px;
            margin-left: 8px;
        }

        .student-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #17a2b8;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        .student-avatar-placeholder {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            border: 3px solid #17a2b8;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        .section-title {
            color: #0088cc;
            font-weight: 600;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 2px solid #e3f2fd;
        }

        .comment-box {
            background: #f8f9fa;
            border-left: 4px solid #17a2b8;
            padding: 15px;
            border-radius: 4px;
        }
    </style>

    <div class="col-12">
        <div class="card mb-4 info-card">
            <div class="card-header" style="background: #17a2b8; color: white;">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-star"></i> Chi tiết đánh giá học sinh
                </h6>
            </div>
            <div class="card-body p-4">
                <div class="row mb-4">
                    {{-- Thông tin chung --}}
                    <div class="col-md-6">
                        <h5 class="section-title">Thông tin chung</h5>
                        <table class="table table-bordered">
                            <tr>
                                <th width="40%">Học sinh</th>
                                <td><strong>{{ $danhgia->hocsinh->tenhocsinh ?? '-' }}</strong></td>
                            </tr>
                            <tr>
                                <th>Lớp</th>
                                <td>{{ $danhgia->hocsinh->lophoc->tenlop ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Tháng/Năm đánh giá</th>
                                <td><strong>{{ $danhgia->thang }}/{{ $danhgia->nam }}</strong></td>
                            </tr>
                            <tr>
                                <th>Giáo viên đánh giá</th>
                                <td>{{ $danhgia->giaovien->tengiaovien ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>

                    {{-- Kết quả đánh giá --}}
                    <div class="col-md-6">
                        <h5 class="section-title">Kết quả đánh giá</h5>
                        <table class="table table-bordered">
                            @php
                                $fields = [
                                    'thechat' => 'Thể chất',
                                    'ngonngu' => 'Ngôn ngữ',
                                    'nhanthuc' => 'Nhận thức',
                                    'camxucxahoi' => 'Cảm xúc xã hội',
                                    'nghethuat' => 'Nghệ thuật',
                                ];
                            @endphp
                            @foreach ($fields as $key => $label)
                                <tr>
                                    <th width="45%">{{ $label }}</th>
                                    <td>
                                        <div class="star-rating">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i
                                                    class="fas fa-star star {{ $i <= ($danhgia->$key ?? 0) ? 'filled' : '' }}"></i>
                                            @endfor
                                        </div>
                                        <span class="rating-text">({{ $danhgia->$key ?? 0 }}/5)</span>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>

                {{-- Nhận xét chung --}}
                <div class="row">
                    <div class="col-12">
                        <h5 class="section-title">Nhận xét chung</h5>
                        <div class="comment-box">
                            <p class="mb-0">{{ $danhgia->nhanxetchung ?? 'Chưa có nhận xét' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Các đánh giá khác trong cùng tháng --}}
                @if (isset($allEvaluations) && $allEvaluations->count() > 1)
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5 class="section-title">Các đánh giá khác trong cùng tháng</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm">
                                    <thead style="background: #e3f2fd;">
                                        <tr>
                                            <th>Ngày tạo</th>
                                            <th>Giáo viên</th>
                                            <th>Thể chất</th>
                                            <th>Ngôn ngữ</th>
                                            <th>Nhận thức</th>
                                            <th>Cảm xúc XH</th>
                                            <th>Nghệ thuật</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($allEvaluations as $eval)
                                            <tr class="{{ $eval->id == $danhgia->id ? 'table-info' : '' }}">
                                                <td>{{ $eval->created_at->format('d/m/Y H:i') }}</td>
                                                <td>{{ $eval->giaovien->tengiaovien ?? '-' }}</td>
                                                <td>{{ $eval->thechat ?? '-' }}/5</td>
                                                <td>{{ $eval->ngonngu ?? '-' }}/5</td>
                                                <td>{{ $eval->nhanthuc ?? '-' }}/5</td>
                                                <td>{{ $eval->camxucxahoi ?? '-' }}/5</td>
                                                <td>{{ $eval->nghethuat ?? '-' }}/5</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="text-right mt-4">
                    <a href="{{ route('teacher.danhgia.edit', $danhgia->id) }}" class="btn btn-warning px-4 shadow-sm">
                        <i class="fas fa-edit"></i> Sửa đánh giá
                    </a>
                    <a href="{{ route('teacher.danhgia.index') }}" class="btn btn-secondary px-4 shadow-sm">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
