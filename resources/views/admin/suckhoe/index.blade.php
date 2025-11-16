@extends('admin.welcome')

@section('title', 'Quản lý sức khỏe học sinh')

@section('content')
    <style>
        .health-table {
            border-collapse: collapse;
            width: 100%;
            table-layout: fixed;
        }

        .health-table th,
        .health-table td {
            border: 1px solid #d6e9f8;
            padding: 10px;
            vertical-align: top;
            word-wrap: break-word;
        }

        .health-table thead th.student-header {
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

        .health-cell .label {
            display: block;
            font-size: 13px;
            color: #333;
            font-weight: 600;
        }

        .health-cell .value {
            display: block;
            font-size: 14px;
            color: #111;
            margin-bottom: 6px;
        }

        /* Make each health record layout horizontal */
        .health-cell {
            display: flex;
            gap: 16px;
            align-items: center;
            flex-wrap: wrap;
        }

        .health-attr {
            min-width: 120px;
            max-width: 240px;
        }

        .table-responsive-health {
            overflow-x: auto;
            background: #fff;
            padding: 8px;
            border-radius: 8px;
            border: 1px solid #e6f1fb;
        }

        .health-table tbody tr:hover {
            background: #fbfdff;
        }
    </style>

    <div class="container-fluid" id="container-wrapper">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-primary">Quản lý sức khỏe học sinh</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Sức khỏe</li>
            </ol>
        </div>

        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold">Bảng sức khỏe học sinh</h6>
                <a href="{{ route('admin.suckhoe.create') }}" class="btn btn-primary btn-sm">+ Thêm mới</a>
            </div>

            <div class="card-body bg-white">
                <div class="table-responsive-health">
                    <table class="health-table">
                        <thead>
                            <tr>
                                <th class="student-header" style="width:60px;">STT</th>
                                <th class="student-header col-student">Tên học sinh</th>
                                <th class="student-header">Thông tin sức khỏe</th>
                                <th class="student-header" style="width:120px;">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($hocsinhList as $hs)
                                <tr>
                                    <td style="text-align:center; font-weight:600; width:60px;">{{ $loop->iteration }}</td>
                                    <td class="col-student">
                                        {{ $hs->tenhocsinh }}
                                        @if (isset($hs->lophoc->tenlop))
                                            <div style="font-size:12px; color:#666;">Lớp: {{ $hs->lophoc->tenlop }}</div>
                                        @endif
                                    </td>
                                    <td>
                                        @foreach ($hs->suckhoe as $sk)
                                            <div class="health-cell mb-2 p-2"
                                                style="border:1px solid #d6e9f8; border-radius:6px;">
                                                <div class="health-attr">
                                                    <span class="label">Ngày khám</span>
                                                    <span
                                                        class="value">{{ \Carbon\Carbon::parse($sk->ngaykham)->format('d/m/Y') }}</span>
                                                </div>

                                                <div class="health-attr">
                                                    <span class="label">Chiều cao</span>
                                                    <span class="value">{{ $sk->chieucao }} cm</span>
                                                </div>

                                                <div class="health-attr">
                                                    <span class="label">Cân nặng</span>
                                                    <span class="value">{{ $sk->cannang }} kg</span>
                                                </div>

                                                <div class="health-attr">
                                                    <span class="label">Tình trạng</span>
                                                    <span class="value">{{ $sk->tinhtrang }}</span>
                                                </div>

                                                @if ($sk->ghichu)
                                                    <div class="health-attr" style="flex-basis:100%;">
                                                        <span class="label">Ghi chú</span>
                                                        <span class="value">{{ $sk->ghichu }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach

                                        @if ($hs->suckhoe->isEmpty())
                                            <span>- Chưa có dữ liệu -</span>
                                        @endif
                                    </td>

                                    {{-- Thao tác: edit/delete cho từng bản ghi sức khỏe của học sinh --}}
                                    <td style="text-align:center; vertical-align:middle;">
                                        @if ($hs->suckhoe->isNotEmpty())
                                            @foreach ($hs->suckhoe as $sk)
                                                <div class="mb-2 d-flex justify-content-center align-items-center">
                                                    <a href="{{ route('admin.suckhoe.edit', $sk->id) }}" class="me-2"
                                                        title="Sửa" style="color: #0d6efd; font-size:16px;">
                                                        <i class="fas fa-pen"></i>
                                                    </a>

                                                    <form action="{{ route('admin.suckhoe.destroy', $sk->id) }}"
                                                        method="POST" style="display:inline-block;"
                                                        onsubmit="return confirm('Bạn có chắc muốn xóa bản ghi này?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" title="Xóa"
                                                            style="background:none;border:none;padding:0;color:#dc3545;font-size:16px;">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            @endforeach
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
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
