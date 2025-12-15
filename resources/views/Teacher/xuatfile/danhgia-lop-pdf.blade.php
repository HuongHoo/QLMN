<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Đánh giá lớp {{ $lop->tenlop }} - Tháng {{ $thang }}/{{ $nam }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            line-height: 1.4;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 15px;
            border-bottom: 2px solid #4e73df;
            padding-bottom: 10px;
        }

        .header h1 {
            color: #4e73df;
            font-size: 16px;
            margin-bottom: 5px;
        }

        .header h2 {
            color: #333;
            font-size: 13px;
            margin-bottom: 8px;
        }

        .header p {
            color: #666;
            font-size: 10px;
        }

        .info-box {
            background-color: #f8f9fc;
            border: 1px solid #e3e6f0;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 15px;
        }

        .info-box h3 {
            color: #4e73df;
            font-size: 11px;
            margin-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        th,
        td {
            border: 1px solid #e3e6f0;
            padding: 5px;
            text-align: center;
            font-size: 9px;
        }

        th {
            background-color: #4e73df;
            color: white;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f8f9fc;
        }

        .text-left {
            text-align: left;
        }

        .rating {
            display: inline-block;
            padding: 2px 5px;
            border-radius: 3px;
            font-weight: bold;
            font-size: 8px;
        }

        .rating-xs {
            background-color: #1cc88a;
            color: white;
        }

        .rating-t {
            background-color: #36b9cc;
            color: white;
        }

        .rating-d {
            background-color: #f6c23e;
            color: white;
        }

        .rating-ccg {
            background-color: #e74a3b;
            color: white;
        }

        .legend {
            margin-top: 15px;
            padding: 10px;
            background-color: #f8f9fc;
            border-radius: 5px;
        }

        .legend span {
            margin-right: 15px;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 9px;
            color: #666;
            border-top: 1px solid #e3e6f0;
            padding-top: 10px;
        }

        .stats-box {
            margin-top: 15px;
        }

        .stats-table td {
            padding: 8px;
            border: none;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>TRƯỜNG MẦM NON ÁNH SAO</h1>
        <h2>BẢNG TỔNG HỢP ĐÁNH GIÁ HỌC SINH</h2>
        <p>Tháng {{ $thang }}/{{ $nam }} - Ngày xuất: {{ $ngayXuat }}</p>
    </div>

    <div class="info-box">
        <table style="border: none;">
            <tr style="border: none;">
                <td style="border: none; width: 50%; text-align: left;">
                    <strong>Tên lớp:</strong> {{ $lop->tenlop }}
                </td>
                <td style="border: none; text-align: left;">
                    <strong>Tổng số học sinh:</strong> {{ count($danhSachDanhGia) }}
                </td>
            </tr>
            <tr style="border: none;">
                <td style="border: none; text-align: left;" colspan="2">
                    <strong>Giáo viên chủ nhiệm:</strong> {{ $teacher->tengiaovien }}
                </td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 25px;">STT</th>
                <th style="width: 100px; text-align: left;">Họ tên</th>
                <th>Thể chất</th>
                <th>Ngôn ngữ</th>
                <th>Nhận thức</th>
                <th>Cảm xúc XH</th>
                <th>Nghệ thuật</th>
                <th style="width: 150px; text-align: left;">Nhận xét</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($danhSachDanhGia as $index => $item)
                @php
                    $hs = $item['hocsinh'];
                    $dg = $item['danhgia'];
                @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td class="text-left">{{ $hs->tenhocsinh }}</td>
                    <td>
                        @if ($dg && $dg->thechat)
                            @php
                                $level = $dg->thechat;
                                $class = match (true) {
                                    $level == 5 => 'rating-xs',
                                    $level == 4 => 'rating-t',
                                    $level == 3 => 'rating-d',
                                    default => 'rating-ccg',
                                };
                            @endphp
                            <span class="rating {{ $class }}">{{ $level }}</span>
                        @else
                            <span style="color: #999;">-</span>
                        @endif
                    </td>
                    <td>
                        @if ($dg && $dg->ngonngu)
                            @php
                                $level = $dg->ngonngu;
                                $class = match (true) {
                                    $level == 5 => 'rating-xs',
                                    $level == 4 => 'rating-t',
                                    $level == 3 => 'rating-d',
                                    default => 'rating-ccg',
                                };
                            @endphp
                            <span class="rating {{ $class }}">{{ $level }}</span>
                        @else
                            <span style="color: #999;">-</span>
                        @endif
                    </td>
                    <td>
                        @if ($dg && $dg->nhanthuc)
                            @php
                                $level = $dg->nhanthuc;
                                $class = match (true) {
                                    $level == 5 => 'rating-xs',
                                    $level == 4 => 'rating-t',
                                    $level == 3 => 'rating-d',
                                    default => 'rating-ccg',
                                };
                            @endphp
                            <span class="rating {{ $class }}">{{ $level }}</span>
                        @else
                            <span style="color: #999;">-</span>
                        @endif
                    </td>
                    <td>
                        @if ($dg && $dg->camxucxahoi)
                            @php
                                $level = $dg->camxucxahoi;
                                $class = match (true) {
                                    $level == 5 => 'rating-xs',
                                    $level == 4 => 'rating-t',
                                    $level == 3 => 'rating-d',
                                    default => 'rating-ccg',
                                };
                            @endphp
                            <span class="rating {{ $class }}">{{ $level }}</span>
                        @else
                            <span style="color: #999;">-</span>
                        @endif
                    </td>
                    <td>
                        @if ($dg && $dg->nghethuat)
                            @php
                                $level = $dg->nghethuat;
                                $class = match (true) {
                                    $level == 5 => 'rating-xs',
                                    $level == 4 => 'rating-t',
                                    $level == 3 => 'rating-d',
                                    default => 'rating-ccg',
                                };
                            @endphp
                            <span class="rating {{ $class }}">{{ $level }}</span>
                        @else
                            <span style="color: #999;">-</span>
                        @endif
                    </td>
                    <td class="text-left" style="font-size: 8px;">
                        {{ $dg ? Str::limit($dg->nhanxetchung, 50) : '-' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="legend">
        <strong>Chú thích thang điểm 1-5:</strong>
        <span class="rating rating-xs">5</span> Xuất sắc
        <span class="rating rating-t">4</span> Tốt
        <span class="rating rating-d">3</span> Đạt
        <span class="rating rating-ccg">1-2</span> Cần cố gắng
    </div>

    <div class="stats-box">
        <div class="info-box">
            <h3>Thống kê đánh giá</h3>
            @php
                $soDanh = collect($danhSachDanhGia)
                    ->filter(function ($item) {
                        return $item['danhgia'] !== null;
                    })
                    ->count();
            @endphp
            <table style="border: none; width: 80%; margin: 0 auto;">
                <tr style="border: none;">
                    <td style="border: none; width: 40%;">Tổng số học sinh được đánh giá:</td>
                    <td style="border: none;"><strong>{{ $soDanh }}/{{ count($danhSachDanhGia) }}</strong></td>
                </tr>
                <tr style="border: none;">
                    <td style="border: none;">Chưa đánh giá:</td>
                    <td style="border: none; color: #e74a3b;"><strong>{{ count($danhSachDanhGia) - $soDanh }}</strong>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div style="margin-top: 30px;">
        <table style="border: none; width: 100%;">
            <tr style="border: none;">
                <td style="border: none; width: 50%; text-align: center;">
                    <p><strong>Người lập báo cáo</strong></p>
                    <p style="font-size: 8px; color: #666;">(Ký và ghi rõ họ tên)</p>
                    <p style="margin-top: 35px;">{{ $teacher->tengiaovien }}</p>
                </td>
                <td style="border: none; width: 50%; text-align: center;">
                    <p><strong>Ban giám hiệu</strong></p>
                    <p style="font-size: 8px; color: #666;">(Ký và đóng dấu)</p>
                    <p style="margin-top: 35px;">................................</p>
                </td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <p>Trường Mầm Non Ánh Sao - Địa chỉ: 123 Đường ABC, Quận XYZ</p>
        <p>Điện thoại: 0123 456 789 - Email: info@mnanhsao.edu.vn</p>
    </div>
</body>

</html>
