<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Học phí - {{ $hocsinh->tenhocsinh }}</title>
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
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #4e73df;
            color: white;
            font-weight: bold;
            font-size: 11px;
        }

        td {
            font-size: 11px;
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
        }

        .summary-box {
            background-color: #f8f9fc;
            border: 1px solid #e3e6f0;
            border-radius: 5px;
            padding: 15px;
            margin-top: 20px;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #e3e6f0;
            padding-top: 10px;
        }

        .signature {
            margin-top: 40px;
        }

        .signature-box {
            text-align: center;
            width: 45%;
            display: inline-block;
        }

        .signature-line {
            margin-top: 50px;
            border-top: 1px solid #333;
            width: 150px;
            margin-left: auto;
            margin-right: auto;
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
    </style>
</head>

<body>
    <div class="header">
        <h1>TRƯỜNG MẦM NON ÁNH SAO</h1>
        <h2>BẢNG KÊ HỌC PHÍ</h2>
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
                    <strong>Giáo viên chủ nhiệm:</strong> {{ $teacher->tengiaovien }}
                </td>
            </tr>
        </table>
    </div>

    <h3 style="color: #4e73df; margin-bottom: 10px;">Chi tiết học phí</h3>

    @if ($hocphis->count() > 0)
        <table>
            <thead>
                <tr>
                    <th class="text-center" style="width: 40px;">STT</th>
                    <th>Thời gian</th>
                    <th class="text-right">Học phí</th>
                    <th class="text-right">Ăn sáng</th>
                    <th class="text-right">Ăn trưa</th>
                    <th class="text-right">Xe bus</th>
                    <th class="text-right">Phí khác</th>
                    <th class="text-right">Tổng tiền</th>
                    <th class="text-right">Đã đóng</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($hocphis as $index => $hp)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $hp->thoigiandong ?? 'N/A' }}</td>
                        <td class="text-right">{{ number_format($hp->hocphi ?? 0) }}</td>
                        <td class="text-right">{{ number_format($hp->tienansang ?? 0) }}</td>
                        <td class="text-right">{{ number_format($hp->tienantrua ?? 0) }}</td>
                        <td class="text-right">{{ number_format($hp->tienxebus ?? 0) }}</td>
                        <td class="text-right">{{ number_format($hp->phikhac ?? 0) }}</td>
                        <td class="text-right"><strong>{{ number_format($hp->tongtien ?? 0) }}</strong></td>
                        <td class="text-right text-success">{{ number_format($hp->dathanhtoan ?? 0) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p style="text-align: center; color: #666; padding: 20px;">Chưa có dữ liệu học phí</p>
    @endif

    <div class="summary-box">
        <h3 style="color: #4e73df; margin-bottom: 10px;">Tổng kết</h3>
        <table style="border: none;">
            <tr style="border: none;">
                <td style="border: none; width: 70%;">Tổng tiền phải đóng:</td>
                <td style="border: none; text-align: right; font-weight: bold;">{{ number_format($tongTien) }} VNĐ</td>
            </tr>
            <tr style="border: none;">
                <td style="border: none;">Đã thanh toán:</td>
                <td style="border: none; text-align: right; color: #1cc88a; font-weight: bold;">
                    {{ number_format($daDong) }} VNĐ</td>
            </tr>
            <tr style="border: none;">
                <td style="border: none; font-weight: bold; font-size: 14px;">Còn nợ:</td>
                <td
                    style="border: none; text-align: right; color: {{ $conNo > 0 ? '#e74a3b' : '#1cc88a' }}; font-weight: bold; font-size: 14px;">
                    {{ number_format($conNo) }} VNĐ
                </td>
            </tr>
        </table>
    </div>

    <div class="signature">
        <div class="signature-box">
            <p><strong>Phụ huynh xác nhận</strong></p>
            <p style="font-size: 10px; color: #666;">(Ký và ghi rõ họ tên)</p>
            <div class="signature-line"></div>
        </div>
        <div class="signature-box">
            <p><strong>Giáo viên chủ nhiệm</strong></p>
            <p style="font-size: 10px; color: #666;">{{ $teacher->tengiaovien }}</p>
            <div class="signature-line"></div>
        </div>
    </div>

    <div class="footer">
        <p>Trường Mầm Non Ánh Sao - Địa chỉ: 123 Đường ABC, Quận XYZ</p>
        <p>Điện thoại: 0123 456 789 - Email: info@mnanhsao.edu.vn</p>
    </div>
</body>

</html>
