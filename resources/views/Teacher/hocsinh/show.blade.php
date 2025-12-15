@extends('teacher.teacher')

@section('content')
    <div class="col-12">
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-info text-white">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-user-graduate"></i> Thông tin chi tiết học sinh
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    {{-- Ảnh học sinh --}}
                    <div class="col-md-3 text-center mb-4">
                        @if (!empty($hocsinh->anh))
                            <img src="{{ asset($hocsinh->anh) }}" alt="avatar" class="img-fluid rounded-circle mb-3"
                                style="width: 200px; height: 200px; object-fit: cover; border: 3px solid #17a2b8;">
                        @else
                            <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center mb-3"
                                style="width: 200px; height: 200px; border: 3px solid #17a2b8;">
                                <i class="fas fa-user text-muted" style="font-size: 80px;"></i>
                            </div>
                        @endif
                        <h5 class="mt-2">{{ $hocsinh->tenhocsinh }}</h5>
                        <p class="text-muted">Mã thẻ: {{ $hocsinh->mathe ?? '-' }}</p>
                    </div>

                    {{-- Thông tin cơ bản --}}
                    <div class="col-md-9">
                        <h5 class="text-primary mb-3">Thông tin cơ bản</h5>
                        <table class="table table-bordered">
                            <tr>
                                <th width="30%">Tên học sinh</th>
                                <td>{{ $hocsinh->tenhocsinh ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Ngày sinh</th>
                                <td>{{ $hocsinh->ngaysinh ? \Carbon\Carbon::parse($hocsinh->ngaysinh)->format('d/m/Y') : '-' }}
                                </td>
                            </tr>
                            <tr>
                                <th>Giới tính</th>
                                <td>{{ $hocsinh->gioitinh ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Lớp</th>
                                <td>{{ $hocsinh->lophoc->tenlop ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Địa chỉ thường trú</th>
                                <td>{{ $hocsinh->diachithuongtru ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Địa chỉ tạm trú</th>
                                <td>{{ $hocsinh->diachitamtru ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Phụ huynh</th>
                                <td>{{ $hocsinh->phuhuynh->tenphuhuynh ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Ngày nhập học</th>
                                <td>{{ $hocsinh->ngaynhaphoc ? \Carbon\Carbon::parse($hocsinh->ngaynhaphoc)->format('d/m/Y') : '-' }}
                                </td>
                            </tr>
                            <tr>
                                <th>Trạng thái</th>
                                <td>
                                    <span
                                        class="badge {{ $hocsinh->trangthai == 'Đang học' ? 'badge-success' : 'badge-secondary' }}">
                                        {{ $hocsinh->trangthai ?? '-' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Ghi chú sức khỏe</th>
                                <td>{{ $hocsinh->ghichusuckhoe ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                {{-- Thông tin học phí --}}
                <div class="row mt-4">
                    <div class="col-12">
                        <h5 class="text-primary mb-3">
                            <i class="fas fa-money-bill-wave"></i> Thông tin học phí gần đây
                        </h5>
                        @if ($hocsinh->hocphi && $hocsinh->hocphi->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Tháng</th>
                                            <th>Tổng tiền</th>
                                            <th>Đã thanh toán</th>
                                            <th>Còn nợ</th>
                                            <th>Ngày TT</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($hocsinh->hocphi->take(5) as $hp)
                                            @php
                                                $tongtien =
                                                    ($hp->hocphi ?? 0) +
                                                    ($hp->tienansang ?? 0) +
                                                    ($hp->tienantrua ?? 0) +
                                                    ($hp->tienxebus ?? 0) +
                                                    ($hp->phikhac ?? 0);
                                                $conno = $tongtien - ($hp->dathanhtoan ?? 0);
                                            @endphp
                                            <tr>
                                                <td>{{ $hp->thoigiandong ? \Carbon\Carbon::parse($hp->thoigiandong)->format('m/Y') : '-' }}
                                                </td>
                                                <td>{{ number_format($tongtien, 0, ',', '.') }} đ</td>
                                                <td>{{ number_format($hp->dathanhtoan ?? 0, 0, ',', '.') }} đ</td>
                                                <td class="{{ $conno > 0 ? 'text-danger' : 'text-success' }}">
                                                    {{ number_format($conno, 0, ',', '.') }} đ
                                                </td>
                                                <td>{{ $hp->ngaythanhtoan ? \Carbon\Carbon::parse($hp->ngaythanhtoan)->format('d/m/Y') : '-' }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted">Chưa có thông tin học phí</p>
                        @endif
                    </div>
                </div>

                {{-- Thông tin đánh giá --}}
                <div class="row mt-4">
                    <div class="col-12">
                        <h5 class="text-primary mb-3">
                            <i class="fas fa-star"></i> Đánh giá gần đây
                        </h5>
                        @if ($hocsinh->danhgia && $hocsinh->danhgia->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Tháng/Năm</th>
                                            <th>Thể chất</th>
                                            <th>Ngôn ngữ</th>
                                            <th>Nhận thức</th>
                                            <th>Cảm xúc XH</th>
                                            <th>Nghệ thuật</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($hocsinh->danhgia->take(5) as $dg)
                                            <tr>
                                                <td>{{ $dg->thang }}/{{ $dg->nam }}</td>
                                                <td>{{ $dg->thechat ?? '-' }}</td>
                                                <td>{{ $dg->ngonngu ?? '-' }}</td>
                                                <td>{{ $dg->nhanthuc ?? '-' }}</td>
                                                <td>{{ $dg->camxucxahoi ?? '-' }}</td>
                                                <td>{{ $dg->nghethuat ?? '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted">Chưa có đánh giá</p>
                        @endif
                    </div>
                </div>

                <div class="text-right mt-4">
                    <a href="{{ route('teacher.hocsinh.edit', $hocsinh->id) }}" class="btn btn-warning px-4">
                        <i class="fas fa-edit"></i> Sửa thông tin
                    </a>
                    <a href="{{ route('teacher.hocsinh.index') }}" class="btn btn-secondary px-4">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
