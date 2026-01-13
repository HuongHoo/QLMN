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
            <h1 class="h3 mb-0 text-primary">Quản lý giáo viên</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Giáo viên</li>
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
                <h6 class="m-0 font-weight-bold">Danh sách giáo viên</h6>
                <a href="{{ route('admin.giaovien.create') }}" class="btn btn-primary btn-sm">+ Thêm mới</a>
            </div>

            <div class="card-body bg-white">
                <div class="table-responsive-custom">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>SỐ THẺ</th>
                                <th>HỌ TÊN</th>
                                <th>NGÀY SINH</th>
                                <th>SĐT</th>
                                <th>EMAIL</th>
                                <th>TÊN LỚP</th>
                                <th>NGÀY VÀO LÀM</th>
                                <th>ẢNH</th>
                                <th>THAO TÁC</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($giaovien as $gv)
                                <tr>
                                    <td style="text-align:center;">{{ $gv->sothe }}</td>
                                    <td style="font-weight:600; color:#0b5776;">{{ $gv->tengiaovien }}</td>
                                    <td style="text-align:center;">{{ $gv->ngaysinh }}</td>
                                    <td>{{ $gv->sdt }}</td>
                                    <td>{{ $gv->email }}</td>
                                    <td>{{ $gv->lophoc->tenlop ?? '-' }}</td>
                                    <td style="text-align:center;">{{ $gv->ngayvaolam }}</td>
                                    <td style="text-align:center;">
                                        @if ($gv->anh)
                                            <img src="{{ asset('storage/' . $gv->anh) }}" alt="Ảnh giáo viên"
                                                width="50" height="50" style="border-radius:4px;">
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td style="text-align:center;">
                                        <a href="{{ route('admin.giaovien.edit', $gv->id) }}"
                                            class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.giaovien.destroy', $gv->id) }}" method="POST"
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
                    {{ $giaovien->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
