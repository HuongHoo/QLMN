@extends('admin.welcome')

@section('title', 'Chi tiết học sinh')

@section('content')
    <style>
        /* Style tổng quan */
        .card-stat {
            display: inline-block;
            width: 150px;
            height: 100px;
            background: #f1f5f9;
            border-radius: 10px;
            margin-right: 15px;
            text-align: center;
            padding: 15px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .card-stat h4 {
            margin: 10px 0 0;
            font-size: 20px;
            font-weight: 700;
        }

        .card-stat span {
            font-size: 14px;
            color: #555;
        }

        .attendance-table {
            border-collapse: collapse;
            width: 100%;
            table-layout: fixed;
        }

        .attendance-table th,
        .attendance-table td {
            border: 1px solid #d6e9f8;
            padding: 8px;
            vertical-align: top;
            word-wrap: break-word;
        }

        .attendance-table thead th.day-header {
            background: linear-gradient(180deg, #e3f2fd 0%, #d0e9fb 100%);
            color: #0b5776;
            font-weight: 700;
            text-align: center;
        }

        .col-student {
            width: 220px;
            background: #ffffff;
            text-align: left;
            padding-left: 12px;
            font-weight: 600;
        }

        .attendance-cell .label {
            display: block;
            font-size: 13px;
            color: #333;
            font-weight: 600;
        }

        .attendance-cell .value {
            display: block;
            font-size: 14px;
            color: #111;
            margin-bottom: 6px;
        }

        .status-present {
            background: #e8f5e9;
            color: #2e7d32;
            padding: 2px 6px;
            border-radius: 4px;
            display: inline-block;
        }

        .status-late {
            background: #fff3e0;
            color: #ef6c00;
            padding: 2px 6px;
            border-radius: 4px;
            display: inline-block;
        }

        .status-absent {
            background: #ffebee;
            color: #c62828;
            padding: 2px 6px;
            border-radius: 4px;
            display: inline-block;
        }

        .status-leave {
            background: #e1f5fe;
            color: #0277bd;
            padding: 2px 6px;
            border-radius: 4px;
            display: inline-block;
        }

        .table-responsive-attendance {
            overflow-x: auto;
            background: #fff;
            padding: 8px;
            border-radius: 8px;
            border: 1px solid #e6f1fb;
        }
    </style>

    <div class="container-fluid" id="container-wrapper">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-primary">Chi tiết học sinh</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.diemdanh.index') }}">Điểm danh</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $hocsinh->tenhocsinh }}</li>
            </ol>
        </div>
        <div class="d-flex justify-content-between align-items-start my-4 px-2">
            {{-- Thông tin học sinh --}}
            <div>
                <h2 class="mb-1">{{ $hocsinh->tenhocsinh }}</h2>
                <div class="fw-semibold" style="font-size:16px; color:#555;">
                    Lớp: {{ $hocsinh->lophoc->tenlop ?? '-' }}
                </div>
                <div class="text-muted" style="font-size:15px;">
                    Ngày sinh: {{ $hocsinh->ngaysinh ?? '-' }}
                </div>
            </div>
        </div>
    </div>


    {{-- Thống kê tổng quan --}}
    <div class="mb-4 d-flex flex-wrap">
        @php
            $tongVang = $hocsinh->diemdanh->where('trangthai', 'vắng')->count();
            $tongTre = $hocsinh->diemdanh->where('trangthai', 'trễ')->count();
            $tongDungGio = $hocsinh->diemdanh->where('trangthai', 'đúng giờ')->count();
            $tongPhep = $hocsinh->diemdanh->where('trangthai', 'có phép')->count();
        @endphp
        <div class="card-stat">
            <span>Tổng số buổi vắng</span>
            <h4>{{ $tongVang }}</h4>
        </div>
        <div class="card-stat">
            <span>Tổng số buổi đi muộn</span>
            <h4>{{ $tongTre }}</h4>
        </div>
        <div class="card-stat">
            <span>Tổng số buổi đúng giờ</span>
            <h4>{{ $tongDungGio }}</h4>
        </div>
        <div class="card-stat">
            <span>Tổng số buổi có phép</span>
            <h4>{{ $tongPhep }}</h4>
        </div>
    </div>

    {{-- Bảng điểm danh chi tiết --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-body bg-white">
            <div class="table-responsive-attendance">
                <table class="attendance-table">
                    <thead>
                        <tr>
                            <th class="day-header" style="width:60px;">STT</th>
                            <th class="day-header col-student">Ngày</th>
                            <th class="day-header">Giờ đến</th>
                            <th class="day-header">Giờ về</th>
                            <th class="day-header">Trạng thái</th>
                            <th class="day-header">Số phút trễ</th>
                            <th class="day-header">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($hocsinh->diemdanh as $index => $dd)
                            <tr>
                                <td style="text-align:center; font-weight:600;">{{ $index + 1 }}</td>
                                <td>{{ \Carbon\Carbon::parse($dd->ngaydiemdanh)->format('d/m/Y') }}</td>
                                <td>{{ $dd->gioden ?? '-' }}</td>
                                <td>{{ $dd->giove ?? '-' }}</td>
                                <td>
                                    @php $tt = mb_strtolower($dd->trangthai); @endphp
                                    @if (strpos($tt, 'đúng') !== false || strpos($tt, 'có mặt') !== false)
                                        <span class="status-present">Có mặt</span>
                                    @elseif(strpos($tt, 'trễ') !== false || strpos($tt, 'muộn') !== false)
                                        <span class="status-late">Trễ</span>
                                    @elseif(strpos($tt, 'vắng') !== false)
                                        <span class="status-absent">Vắng</span>
                                    @elseif(strpos($tt, 'phép') !== false)
                                        <span class="status-leave">Phép</span>
                                    @else
                                        <span>-</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($dd->trangthai === 'trễ')
                                        {{ $dd->sophuttre }} phút
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.diemdanh.edit', $dd->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.diemdanh.destroy', $dd->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Bạn có chắc muốn xóa?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        @if ($hocsinh->diemdanh->isEmpty())
                            <tr>
                                <td colspan="6" class="text-center">Chưa có dữ liệu điểm danh</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
@endsection
