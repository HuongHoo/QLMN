@extends('teacher.teacher')

@section('content')
    <style>
        .info-card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .payment-status {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
        }

        .payment-status.paid {
            background: #d4edda;
            color: #155724;
        }

        .payment-status.partial {
            background: #fff3cd;
            color: #856404;
        }

        .payment-status.unpaid {
            background: #f8d7da;
            color: #721c24;
        }

        .amount-box {
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 15px;
        }

        .amount-box.total {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .amount-box.paid {
            background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%);
            color: #155724;
        }

        .amount-box.debt {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            color: #721c24;
        }

        .amount-label {
            font-size: 14px;
            opacity: 0.9;
            margin-bottom: 5px;
        }

        .amount-value {
            font-size: 24px;
            font-weight: 700;
        }
    </style>

    <div class="col-12">
        <div class="card mb-4 shadow-sm info-card">
            <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-money-bill-wave"></i> Chi tiết học phí
                </h6>
            </div>
            <div class="card-body p-4">
                {{-- Thông tin tổng quan --}}
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="amount-box total">
                            <div class="amount-label">Tổng tiền</div>
                            <div class="amount-value">{{ number_format($hocphi->tongtien ?? 0, 0, ',', '.') }} đ</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="amount-box paid">
                            <div class="amount-label">Đã thanh toán</div>
                            <div class="amount-value">{{ number_format($hocphi->dathanhtoan ?? 0, 0, ',', '.') }} đ</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="amount-box debt">
                            <div class="amount-label">Còn nợ</div>
                            <div class="amount-value">{{ number_format($hocphi->con_no ?? 0, 0, ',', '.') }} đ</div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    {{-- Thông tin chung --}}
                    <div class="col-md-6">
                        <h5 class="text-primary mb-3">
                            <i class="fas fa-info-circle"></i> Thông tin chung
                        </h5>
                        <table class="table table-bordered">
                            <tr>
                                <th width="40%">Học sinh</th>
                                <td>
                                    <strong>{{ $hocphi->hocsinh->tenhocsinh ?? '-' }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $hocphi->hocsinh->mathe ?? '' }}</small>
                                </td>
                            </tr>
                            <tr>
                                <th>Lớp</th>
                                <td>{{ $hocphi->hocsinh->lophoc->tenlop ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Thời gian đóng</th>
                                <td>
                                    <strong>
                                        {{ $hocphi->thoigiandong ? \Carbon\Carbon::parse($hocphi->thoigiandong)->format('m/Y') : '-' }}
                                    </strong>
                                </td>
                            </tr>
                            <tr>
                                <th>Ngày thanh toán</th>
                                <td>{{ $hocphi->ngaythanhtoan ? \Carbon\Carbon::parse($hocphi->ngaythanhtoan)->format('d/m/Y') : '-' }}
                                </td>
                            </tr>
                            <tr>
                                <th>Giáo viên thu</th>
                                <td>{{ $hocphi->giaovien->tengiaovien ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Trạng thái</th>
                                <td>
                                    @php
                                        $conNo = $hocphi->con_no ?? 0;
                                        $tongTien = $hocphi->tongtien ?? 0;
                                    @endphp
                                    @if ($conNo == 0)
                                        <span class="payment-status paid">Đã thanh toán</span>
                                    @elseif($hocphi->dathanhtoan > 0)
                                        <span class="payment-status partial">Thanh toán 1 phần</span>
                                    @else
                                        <span class="payment-status unpaid">Chưa thanh toán</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>

                    {{-- Chi tiết các khoản phí --}}
                    <div class="col-md-6">
                        <h5 class="text-primary mb-3">
                            <i class="fas fa-receipt"></i> Chi tiết các khoản
                        </h5>
                        <table class="table table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>Khoản phí</th>
                                    <th class="text-right">Số tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Học phí</td>
                                    <td class="text-right">{{ number_format($hocphi->hocphi ?? 0, 0, ',', '.') }} đ</td>
                                </tr>
                                <tr>
                                    <td>Tiền ăn sáng</td>
                                    <td class="text-right">{{ number_format($hocphi->tienansang ?? 0, 0, ',', '.') }} đ
                                    </td>
                                </tr>
                                <tr>
                                    <td>Tiền ăn trưa</td>
                                    <td class="text-right">{{ number_format($hocphi->tienantrua ?? 0, 0, ',', '.') }} đ
                                    </td>
                                </tr>
                                <tr>
                                    <td>Tiền xe bus</td>
                                    <td class="text-right">{{ number_format($hocphi->tienxebus ?? 0, 0, ',', '.') }} đ
                                    </td>
                                </tr>
                                <tr>
                                    <td>Phí khác</td>
                                    <td class="text-right">{{ number_format($hocphi->phikhac ?? 0, 0, ',', '.') }} đ
                                    </td>
                                </tr>
                                <tr class="table-info">
                                    <th>Tổng cộng</th>
                                    <th class="text-right">{{ number_format($hocphi->tongtien ?? 0, 0, ',', '.') }} đ
                                    </th>
                                </tr>
                                <tr class="table-success">
                                    <th>Đã thanh toán</th>
                                    <th class="text-right">
                                        {{ number_format($hocphi->dathanhtoan ?? 0, 0, ',', '.') }} đ</th>
                                </tr>
                                <tr class="table-danger">
                                    <th>Còn nợ</th>
                                    <th class="text-right">{{ number_format($hocphi->con_no ?? 0, 0, ',', '.') }} đ
                                    </th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Ghi chú --}}
                @if ($hocphi->ghichu)
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5 class="text-primary mb-3">
                                <i class="fas fa-sticky-note"></i> Ghi chú
                            </h5>
                            <div class="alert alert-info">
                                <p class="mb-0">{{ $hocphi->ghichu }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="text-right mt-4">
                    <a href="{{ route('teacher.hocphi.edit', $hocphi->id) }}" class="btn btn-warning px-4">
                        <i class="fas fa-edit"></i> Sửa học phí
                    </a>
                    <a href="{{ route('teacher.hocphi.index') }}" class="btn btn-secondary px-4">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
