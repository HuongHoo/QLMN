@extends('admin.welcome')

@section('content')
    <style>
        .data-table {
            border-collapse: collapse;
            width: 100%;
        }

        .data-table th,
        .data-table td {
            border: 1px solid #d6e9f8;
            padding: 10px;
            vertical-align: middle;
        }

        .data-table thead th {
            background: linear-gradient(180deg, #e3f2fd 0%, #d0e9fb 100%);
            color: #0b5776;
            font-weight: 700;
            text-align: center;
            font-size: 13px;
        }

        .data-table tbody tr:hover {
            background: #fbfdff;
        }

        .table-responsive-custom {
            overflow-x: auto;
            background: #fff;
            padding: 8px;
            border-radius: 8px;
            border: 1px solid #e6f1fb;
        }
    </style>

    <div class="container-fluid" id="container-wrapper">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-primary">Quản lý lớp học</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Lớp học</li>
            </ol>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold">Danh sách lớp học</h6>
                <a href="{{ route('admin.lophoc.create') }}" class="btn btn-primary btn-sm">+ Thêm mới</a>
            </div>

            <div class="card-body bg-white">
                <div class="table-responsive-custom">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>TÊN LỚP</th>
                                <th>NHÓM TUỔI</th>
                                <th>SĨ SỐ</th>
                                <th>SỐ PHÒNG</th>
                                <th>NIÊN KHÓA</th>
                                <th>GHI CHÚ</th>
                                <th>THAO TÁC</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lophoc as $lop)
                                <tr>
                                    <td style="text-align:center; font-weight:600;">{{ $lop->id }}</td>
                                    <td style="font-weight:600; color:#0b5776;">{{ $lop->tenlop }}</td>
                                    <td style="text-align:center;">{{ $lop->nhomtuoi }}</td>
                                    <td style="text-align:center;">{{ $lop->siso }}</td>
                                    <td style="text-align:center;">{{ $lop->sophong }}</td>
                                    <td style="text-align:center;">{{ $lop->nienkhoa }}</td>
                                    <td>{{ $lop->ghichu }}</td>
                                    <td style="text-align:center;">
                                        <a href="{{ route('admin.lophoc.edit', $lop->id) }}"
                                            class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.lophoc.destroy', $lop->id) }}" method="POST"
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
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-3">
                    {{ $lophoc->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
