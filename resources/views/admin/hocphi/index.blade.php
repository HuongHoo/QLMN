@extends('admin.welcome')

@section('title', 'Quản lý học phí')

@section('content')
    <style>
        .fee-table {
            border-collapse: collapse;
            width: 100%;
            table-layout: fixed;
        }

        .fee-table th,
        .fee-table td {
            border: 1px solid #d6e9f8;
            padding: 10px;
            vertical-align: top;
            word-wrap: break-word;
            text-align: center;
        }

        .fee-table thead th {
            background: linear-gradient(180deg, #e3f2fd 0%, #d0e9fb 100%);
            color: #0b5776;
            font-weight: 700;
        }

        .col-student {
            width: 220px;
            background: #ffffff;
            text-align: left;
            padding-left: 12px;
            font-weight: 600;
        }

        .fee-table tbody tr:hover {
            background: #fbfdff;
        }

        .table-responsive-fee {
            overflow-x: auto;
            background: #fff;
            padding: 8px;
            border-radius: 8px;
            border: 1px solid #e6f1fb;
        }
    </style>

    <div class="container-fluid" id="container-wrapper">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-primary">Quản lý học phí</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Học phí</li>
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
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold">Danh sách học phí</h6>
                <a href="{{ route('admin.hocphi.create') }}" class="btn btn-primary btn-sm">+ Thêm mới</a>
            </div>

            <div class="card-body bg-white">
                <div class="table-responsive-fee">
                    <table class="fee-table">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th class="col-student">Tên học sinh</th>
                                {{-- <th>Học phí</th>
                                <th>Tiền ăn sáng</th>
                                <th>Tiền ăn trưa</th>
                                <th>Tiền xe bus</th>
                                <th>Phí khác</th> --}}
                                <th>Tổng tiền</th>
                                <th>Ngày thanh toán</th>
                                <th>Đã thanh toán</th>
                                <th>Còn nợ</th>
                                <th>Giáo viên thu</th>
                                <th>Ghi chú</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($hocphis as $hp)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="col-student">
                                        <a href="{{ route('admin.hocphi.show', $hp->id) }}"
                                            class="text-decoration-none text-primary">
                                            {{ $hp->hocsinh->tenhocsinh ?? '-' }}
                                        </a>
                                    </td>
                                    {{-- <td>{{ number_format($hp->hocphi ?? 0, 0, ',', '.') }}</td>
                                    <td>{{ number_format($hp->tienansang ?? 0, 0, ',', '.') }}</td>
                                    <td>{{ number_format($hp->tienantrua ?? 0, 0, ',', '.') }}</td>
                                    <td>{{ number_format($hp->tienxebus ?? 0, 0, ',', '.') }}</td>
                                    <td>{{ number_format($hp->phikhac ?? 0, 0, ',', '.') }}</td> --}}
                                    <td>{{ number_format($hp->tongtien ?? 0, 0, ',', '.') }}</td>
                                    <td>
                                        {{ $hp->ngaythanhtoan ? \Carbon\Carbon::parse($hp->ngaythanhtoan)->format('d/m/Y') : '-' }}
                                    </td>
                                    <td>{{ number_format($hp->dathanhtoan ?? 0, 0, ',', '.') }}</td>
                                    <td>{{ number_format(($hp->tongtien ?? 0) - ($hp->dathanhtoan ?? 0), 0, ',', '.') }}
                                    </td>
                                    <td>{{ $hp->giaovien->tengiaovien ?? '-' }}</td>
                                    <td>{{ $hp->ghichu ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
