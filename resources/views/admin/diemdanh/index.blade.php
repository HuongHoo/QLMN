@extends('admin.welcome')

@section('title', 'Quản lý điểm danh theo tuần')

@section('content')
    <style>
        /* style nhẹ để khớp layout ảnh: header xanh nhạt, ô trắng, border rõ */
        .attendance-table {
            border-collapse: collapse;
            width: 100%;
            table-layout: fixed;
        }

        .attendance-table th,
        .attendance-table td {
            border: 1px solid #d6e9f8;
            padding: 10px;
            vertical-align: top;
            word-wrap: break-word;
        }

        /* cột ngày header màu xanh da trời nhạt */
        .attendance-table thead th.day-header {
            background: linear-gradient(180deg, #e3f2fd 0%, #d0e9fb 100%);
            color: #0b5776;
            font-weight: 700;
        }

        /* cột tên học sinh rộng, giống ảnh */
        .col-student {
            width: 220px;
            background: #ffffff;
            text-align: left;
            padding-left: 12px;
            font-weight: 600;
        }

        /* text trong ô ngày: nhãn in đậm, giá trị xuống dòng rõ */
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

        /* các trạng thái màu sắc (nhẹ, không quá chói) */
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

        /* hover hàng */
        .attendance-table tbody tr:hover {
            background: #fbfdff;
        }

        /* responsive: cho mobile cuộn ngang */
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
            <h1 class="h3 mb-0 text-primary">Quản lý điểm danh</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Điểm danh</li>
            </ol>
        </div>

        {{-- Thông báo --}}
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-white">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div>
                        <a href="{{ route('admin.diemdanh.index', ['start' => $start->copy()->subWeek()->format('Y-m-d')]) }}"
                            class="btn btn-outline-primary btn-sm">&laquo; Tuần trước</a>

                        <a href="{{ route('admin.diemdanh.index', ['start' => $start->copy()->addWeek()->format('Y-m-d')]) }}"
                            class="btn btn-outline-primary btn-sm">Tuần sau &raquo;</a>
                    </div>
                    <div>
                        <small>Từ {{ $start->format('d/m/Y') }} đến {{ $end->format('d/m/Y') }}</small>
                    </div>
                </div>

            </div>

            <div class="d-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold">Bảng điểm danh — hiển thị theo tuần</h6>
                <a href="{{ route('admin.diemdanh.create') }}" class="btn btn-primary btn-sm">+ Thêm mới</a>
            </div>
        </div>
    </div>

    <div class="card-body bg-white">
        <div class="table-responsive-attendance">
            <table class="attendance-table">
                <thead>
                    <tr>
                        <th class="day-header" style="width:60px;">STT</th>
                        <th class="day-header col-student">Tên học sinh</th>

                        {{-- tiêu đề ngày: giống ảnh, header xanh nhạt --}}
                        @foreach ($ngayList as $ngay)
                            <th class="day-header text-center">
                                <div style="font-weight:800;">{{ $ngay->format('D') }}</div>
                                <div style="font-size:12px; font-weight:700;">{{ $ngay->format('d/m') }}</div>
                            </th>
                        @endforeach
                    </tr>
                </thead>

                <tbody>
                    @foreach ($hocsinhList as $hs)
                        <tr>
                            <td style="text-align:center; font-weight:600;">{{ $loop->iteration }}</td>

                            <td class="col-student">
                                <a href="{{ route('admin.diemdanh.show', $hs->id) }}"
                                    class="text-decoration-none text-primary">
                                    {{ $hs->tenhocsinh }}
                                </a>
                                @if (isset($hs->lophoc->tenlop))
                                    <div style="font-size:12px; color:#666;">Lớp: {{ $hs->lophoc->tenlop }}</div>
                                @endif
                            </td>

                            {{-- các cột ngày --}}
                            @foreach ($ngayList as $ngay)
                                @php
                                    // tìm điểm danh theo ngày — so sánh chỉ ngày (không quan tâm giờ)
                                    $diemdanh = $hs->diemdanh->first(function ($d) use ($ngay) {
                                        return \Carbon\Carbon::parse($d->ngaydiemdanh)->isSameDay($ngay);
                                    });
                                @endphp

                                <td>
                                    <div class="attendance-cell">
                                        {{-- Hiển giờ đến --}}
                                        <span class="label">Giờ đến</span>
                                        <span class="value">{{ $diemdanh?->gioden ?? '-' }}</span>

                                        {{-- Hiển giờ về --}}
                                        <span class="label">Giờ về</span>
                                        <span class="value">{{ $diemdanh?->giove ?? '-' }}</span>

                                        {{-- Trạng thái --}}
                                        <span class="label">Trạng thái</span>
                                        <span class="value">
                                            @if ($diemdanh)
                                                @php
                                                    $tt = mb_strtolower($diemdanh->trangthai);
                                                @endphp

                                                @if (strpos($tt, 'đúng') !== false || strpos($tt, 'có mặt') !== false)
                                                    <span class="status-present">Có mặt</span>
                                                @elseif(strpos($tt, 'trễ') !== false || strpos($tt, 'muộn') !== false)
                                                    <span class="status-late">Trễ</span>
                                                @elseif(strpos($tt, 'vắng') !== false || strpos($tt, 'nghỉ không') !== false)
                                                    <span class="status-absent">Vắng</span>
                                                @elseif(strpos($tt, 'phép') !== false)
                                                    <span class="status-leave">Phép</span>
                                                @else
                                                    <span>-</span>
                                                @endif
                                            @else
                                                <span>-</span>
                                            @endif
                                        </span>

                                        {{-- Nếu trễ bao nhiêu phút --}}
                                        @if ($diemdanh && $diemdanh->trangthai === 'trễ')
                                            <div>
                                                <span class="label">Số phút trễ</span>
                                                <span class="value text-danger fw-bold">{{ $diemdanh->sophuttre }}
                                                    phút</span>
                                            </div>
                                        @endif

                                    </div>
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- phân trang --}}
        <div class="d-flex justify-content-center mt-3">
            {{ $hocsinhList->links() }}
        </div>
    </div>
    </div>
    </div>
@endsection
