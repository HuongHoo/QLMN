<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Đánh giá - {{ $hocsinh->tenhocsinh }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #4e73df;
            padding-bottom: 15px;
        }

        .header h1 {
            color: #4e73df;
            font-size: 20px;
            margin-bottom: 5px;
        }

        .header h2 {
            color: #333;
            font-size: 16px;
            margin-bottom: 10px;
        }

        .header p {
            color: #666;
            font-size: 11px;
        }

        .info-box {
            background-color: #f8f9fc;
            border: 1px solid #e3e6f0;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .info-box h3 {
            color: #4e73df;
            font-size: 14px;
            margin-bottom: 10px;
            border-bottom: 1px solid #e3e6f0;
            padding-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #e3e6f0;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #4e73df;
            color: white;
            font-weight: bold;
            font-size: 12px;
        }

        td {
            font-size: 11px;
        }

        tr:nth-child(even) {
            background-color: #f8f9fc;
        }

        .text-center {
            text-align: center;
        }

        .rating {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-weight: bold;
            font-size: 10px;
        }

        .rating-excellent {
            background-color: #1cc88a;
            color: white;
        }

        .rating-good {
            background-color: #36b9cc;
            color: white;
        }

        .rating-average {
            background-color: #f6c23e;
            color: white;
        }

        .rating-needswork {
            background-color: #e74a3b;
            color: white;
        }

        .evaluation-card {
            border: 1px solid #e3e6f0;
            border-radius: 8px;
            margin-bottom: 20px;
            overflow: hidden;
        }

        .evaluation-header {
            background-color: #4e73df;
            color: white;
            padding: 10px 15px;
            font-weight: bold;
        }

        .evaluation-body {
            padding: 15px;
        }

        .comment-box {
            background-color: #f8f9fc;
            border-left: 4px solid #4e73df;
            padding: 10px 15px;
            margin-top: 10px;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #e3e6f0;
            padding-top: 10px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>TRƯỜNG MẦM NON ÁNH SAO</h1>
        <h2>PHIẾU ĐÁNH GIÁ HỌC SINH</h2>
        <p>Ngày xuất: {{ $ngayXuat }}</p>
    </div>

    <div class="info-box">
        <h3>Thông tin học sinh</h3>
        <table style="border: none;">
            <tr style="border: none;">
                <td style="border: none; width: 50%;">
                    <strong>Họ tên:</strong> {{ $hocsinh->tenhocsinh }}
                </td>
                <td style="border: none;">
                    <strong>Mã học sinh:</strong> HS{{ str_pad($hocsinh->id, 4, '0', STR_PAD_LEFT) }}
                </td>
            </tr>
            <tr style="border: none;">
                <td style="border: none;">
                    <strong>Lớp:</strong> {{ $lop->tenlop }}
                </td>
                <td style="border: none;">
                    <strong>Ngày sinh:</strong>
                    {{ $hocsinh->ngaysinh ? \Carbon\Carbon::parse($hocsinh->ngaysinh)->format('d/m/Y') : 'N/A' }}
                </td>
            </tr>
            <tr style="border: none;">
                <td style="border: none;" colspan="2">
                    <strong>Giáo viên đánh giá:</strong> {{ $teacher->tengiaovien }}
                </td>
            </tr>
        </table>
    </div>

    @if ($danhgias->count() > 0)
        @foreach ($danhgias as $dg)
            <div class="evaluation-card">
                <div class="evaluation-header">
                    Đánh giá tháng {{ $dg->thang }}/{{ $dg->nam }}
                </div>
                <div class="evaluation-body">
                    <table>
                        <thead>
                            <tr>
                                <th style="width: 200px;">Lĩnh vực phát triển</th>
                                <th class="text-center">Mức đánh giá</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>Thể chất</strong></td>
                                <td class="text-center">
                                    @php
                                        $level = $dg->thechat;
                                        $class = match (true) {
                                            $level == 5 => 'rating-excellent',
                                            $level == 4 => 'rating-good',
                                            $level == 3 => 'rating-average',
                                            default => 'rating-needswork',
                                        };
                                        $text = match (true) {
                                            $level == 5 => 'Xuất sắc',
                                            $level == 4 => 'Tốt',
                                            $level == 3 => 'Đạt',
                                            $level >= 1 => 'Cần cố gắng',
                                            default => 'Chưa đánh giá',
                                        };
                                    @endphp
                                    <span class="rating {{ $class }}">{{ $text }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Ngôn ngữ</strong></td>
                                <td class="text-center">
                                    @php
                                        $level = $dg->ngonngu;
                                        $class = match (true) {
                                            $level == 5 => 'rating-excellent',
                                            $level == 4 => 'rating-good',
                                            $level == 3 => 'rating-average',
                                            default => 'rating-needswork',
                                        };
                                        $text = match (true) {
                                            $level == 5 => 'Xuất sắc',
                                            $level == 4 => 'Tốt',
                                            $level == 3 => 'Đạt',
                                            $level >= 1 => 'Cần cố gắng',
                                            default => 'Chưa đánh giá',
                                        };
                                    @endphp
                                    <span class="rating {{ $class }}">{{ $text }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Nhận thức</strong></td>
                                <td class="text-center">
                                    @php
                                        $level = $dg->nhanthuc;
                                        $class = match (true) {
                                            $level == 5 => 'rating-excellent',
                                            $level == 4 => 'rating-good',
                                            $level == 3 => 'rating-average',
                                            default => 'rating-needswork',
                                        };
                                        $text = match (true) {
                                            $level == 5 => 'Xuất sắc',
                                            $level == 4 => 'Tốt',
                                            $level == 3 => 'Đạt',
                                            $level >= 1 => 'Cần cố gắng',
                                            default => 'Chưa đánh giá',
                                        };
                                    @endphp
                                    <span class="rating {{ $class }}">{{ $text }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Cảm xúc - Xã hội</strong></td>
                                <td class="text-center">
                                    @php
                                        $level = $dg->camxucxahoi;
                                        $class = match (true) {
                                            $level == 5 => 'rating-excellent',
                                            $level == 4 => 'rating-good',
                                            $level == 3 => 'rating-average',
                                            default => 'rating-needswork',
                                        };
                                        $text = match (true) {
                                            $level == 5 => 'Xuất sắc',
                                            $level == 4 => 'Tốt',
                                            $level == 3 => 'Đạt',
                                            $level >= 1 => 'Cần cố gắng',
                                            default => 'Chưa đánh giá',
                                        };
                                    @endphp
                                    <span class="rating {{ $class }}">{{ $text }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Nghệ thuật</strong></td>
                                <td class="text-center">
                                    @php
                                        $level = $dg->nghethuat;
                                        $class = match (true) {
                                            $level == 5 => 'rating-excellent',
                                            $level == 4 => 'rating-good',
                                            $level == 3 => 'rating-average',
                                            default => 'rating-needswork',
                                        };
                                        $text = match (true) {
                                            $level == 5 => 'Xuất sắc',
                                            $level == 4 => 'Tốt',
                                            $level == 3 => 'Đạt',
                                            $level >= 1 => 'Cần cố gắng',
                                            default => 'Chưa đánh giá',
                                        };
                                    @endphp
                                    <span class="rating {{ $class }}">{{ $text }}</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    @if ($dg->nhanxetchung)
                        <div class="comment-box">
                            <strong>Nhận xét chung:</strong><br>
                            {{ $dg->nhanxetchung }}
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    @else
        <div class="info-box">
            <p style="text-align: center; color: #666;">Chưa có dữ liệu đánh giá cho học sinh này.</p>
        </div>
    @endif

    <div style="margin-top: 40px;">
        <table style="border: none; width: 100%;">
            <tr style="border: none;">
                <td style="border: none; width: 50%; text-align: center;">
                    <p><strong>Phụ huynh xác nhận</strong></p>
                    <p style="font-size: 9px; color: #666;">(Ký và ghi rõ họ tên)</p>
                    <p style="margin-top: 40px;">................................</p>
                </td>
                <td style="border: none; width: 50%; text-align: center;">
                    <p><strong>Giáo viên đánh giá</strong></p>
                    <p style="font-size: 9px; color: #666;">{{ $teacher->tengiaovien }}</p>
                    <p style="margin-top: 40px;">................................</p>
                </td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <p>Trường Mầm Non Ánh Sao - Địa chỉ: 123 Đường ABC, Quận XYZ</p>
        <p>Điện thoại: 0123 456 789 - Email: info@mnanhsao.edu.vn</p>
        <p style="margin-top: 5px;">Mức đánh giá:
            <span class="rating rating-excellent">5 - Xuất sắc</span>
            <span class="rating rating-good">4 - Tốt</span>
            <span class="rating rating-average">3 - Đạt</span>
            <span class="rating rating-needswork">1,2 - Cần cố gắng</span>
        </p>
    </div>
</body>

</html>
