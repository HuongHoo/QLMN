<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Học phí lớp {{ $lop->tenlop }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            line-height: 1.4;
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
            font-size: 18px;
            margin-bottom: 5px;
        }

        .header h2 {
            color: #333;
            font-size: 14px;
            margin-bottom: 10px;
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
            font-size: 12px;
            margin-bottom: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        th,
        td {
            border: 1px solid #e3e6f0;
            padding: 6px;
            text-align: left;
            font-size: 10px;
        }

        th {
            background-color: #4e73df;
            color: white;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f8f9fc;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .total-row {
            background-color: #f8f9fc;
            font-weight: bold;
        }

        .total-row td {
            border-top: 2px solid #4e73df;
            font-weight: bold;
        }

        .text-success {
            color: #1cc88a;
        }

        .text-danger {
            color: #e74a3b;
        }

        .text-warning {
            color: #f6c23e;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 9px;
            color: #666;
            border-top: 1px solid #e3e6f0;
            padding-top: 10px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>TRƯỜNG MẦM NON ÁNH SAO</h1>
        <h2>BÁO CÁO HỌC PHÍ TOÀN LỚP</h2>
        <p>Ngày xuất: {{ $ngayXuat }}</p>
    </div>

    <div class="info-box">
        <h3>Thông tin lớp học</h3>
        <table style="border: none;">
            <tr style="border: none;">
                <td style="border: none; width: 50%;">
                    <strong>Tên lớp:</strong> {{ $lop->tenlop }}
                </td>
                <td style="border: none;">
                    <strong>Tổng số học sinh:</strong> {{ count($danhSachHocPhi) }}
                </td>
            </tr>
            <tr style="border: none;">
                <td style="border: none;">
                    <strong>Giáo viên chủ nhiệm:</strong> {{ $teacher->tengiaovien }}
                </td>
                <td style="border: none;">
                    <strong>Năm học:</strong> {{ date('Y') }} - {{ date('Y') + 1 }}
                </td>
            </tr>
        </table>
    </div>

    <h3 style="color: #4e73df; margin-bottom: 10px;">Bảng tổng hợp học phí</h3>

    <table>
        <thead>
            <tr>
                <th class="text-center" style="width: 30px;">STT</th>
                <th style="width: 120px;">Họ tên</th>
                <th class="text-right" style="width: 80px;">Tổng tiền</th>
                <th class="text-right" style="width: 80px;">Đã đóng</th>
                <th class="text-right" style="width: 80px;">Còn nợ</th>
                <th class="text-center" style="width: 60px;">Trạng thái</th>
            </tr>
        </thead>
        <tbody>
            @php
                $tongTatCa = 0;
                $daDongTatCa = 0;
                $conNoTatCa = 0;
            @endphp
            @foreach ($danhSachHocPhi as $index => $item)
                @php
                    $tongTatCa += $item['tongTien'];
                    $daDongTatCa += $item['daDong'];
                    $conNoTatCa += $item['conNo'];
                @endphp
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $item['hocsinh']->tenhocsinh }}</td>
                    <td class="text-right"><strong>{{ number_format($item['tongTien']) }}</strong></td>
                    <td class="text-right text-success">{{ number_format($item['daDong']) }}</td>
                    <td class="text-right {{ $item['conNo'] > 0 ? 'text-danger' : 'text-success' }}">
                        {{ number_format($item['conNo']) }}</td>
                    <td class="text-center">
                        @if ($item['conNo'] <= 0)
                            <span style="color: #1cc88a;">Đủ</span>
                        @else
                            <span style="color: #e74a3b;">Nợ</span>
                        @endif
                    </td>
                </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="2" class="text-right"><strong>TỔNG CỘNG:</strong></td>
                <td class="text-right"><strong>{{ number_format($tongTatCa) }}</strong></td>
                <td class="text-right text-success"><strong>{{ number_format($daDongTatCa) }}</strong></td>
                <td class="text-right {{ $conNoTatCa > 0 ? 'text-danger' : 'text-success' }}">
                    <strong>{{ number_format($conNoTatCa) }}</strong></td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <div class="info-box">
        <h3>Thống kê tổng hợp</h3>
        <table style="border: none; width: 60%; margin: 0 auto;">
            <tr style="border: none;">
                <td style="border: none; width: 50%;">Tổng số học sinh:</td>
                <td style="border: none; text-align: right;"><strong>{{ count($danhSachHocPhi) }} em</strong></td>
            </tr>
            <tr style="border: none;">
                <td style="border: none;">Đã đóng đủ học phí:</td>
                <td style="border: none; text-align: right; color: #1cc88a;">
                    <strong>{{ collect($danhSachHocPhi)->filter(function ($item) {
                            return $item['conNo'] <= 0;
                        })->count() }}
                        em</strong></td>
            </tr>
            <tr style="border: none;">
                <td style="border: none;">Còn nợ học phí:</td>
                <td style="border: none; text-align: right; color: #e74a3b;">
                    <strong>{{ collect($danhSachHocPhi)->filter(function ($item) {
                            return $item['conNo'] > 0;
                        })->count() }}
                        em</strong></td>
            </tr>
            <tr style="border: none; border-top: 1px dashed #ccc;">
                <td style="border: none; padding-top: 10px;">Tổng số tiền phải thu:</td>
                <td style="border: none; text-align: right; padding-top: 10px;">
                    <strong>{{ number_format($tongTienLop) }} VNĐ</strong></td>
            </tr>
            <tr style="border: none;">
                <td style="border: none;">Tổng số tiền đã thu:</td>
                <td style="border: none; text-align: right; color: #1cc88a;">
                    <strong>{{ number_format($tongDaDongLop) }} VNĐ</strong></td>
            </tr>
            <tr style="border: none;">
                <td style="border: none; font-size: 12px;"><strong>Tổng số tiền còn phải thu:</strong></td>
                <td style="border: none; text-align: right; color: #e74a3b; font-size: 12px;">
                    <strong>{{ number_format($tongConNoLop) }} VNĐ</strong></td>
            </tr>
        </table>
    </div>

    <div style="margin-top: 30px;">
        <table style="border: none; width: 100%;">
            <tr style="border: none;">
                <td style="border: none; width: 50%; text-align: center;">
                    <p><strong>Người lập báo cáo</strong></p>
                    <p style="font-size: 9px; color: #666;">(Ký và ghi rõ họ tên)</p>
                    <p style="margin-top: 40px;">{{ $teacher->tengiaovien }}</p>
                </td>
                <td style="border: none; width: 50%; text-align: center;">
                    <p><strong>Ban giám hiệu</strong></p>
                    <p style="font-size: 9px; color: #666;">(Ký và đóng dấu)</p>
                    <p style="margin-top: 40px;">................................</p>
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
