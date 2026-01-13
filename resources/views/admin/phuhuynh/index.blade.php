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
            <h1 class="h3 mb-0 text-primary">Quản lý phụ huynh</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Phụ huynh</li>
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
                <h6 class="m-0 font-weight-bold">Danh sách phụ huynh</h6>
                <a href="{{ route('admin.phuhuynh.create') }}" class="btn btn-primary btn-sm">+ Thêm mới</a>
            </div>

            <div class="card-body bg-white">
                <div class="table-responsive-custom">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>TÊN PHỤ HUYNH</th>
                                <th>QUAN HỆ</th>
                                <th>SĐT</th>
                                <th>EMAIL</th>
                                <th>ĐỊA CHỈ THƯỜNG TRÚ</th>
                                <th>ĐỊA CHỈ TẠM TRÚ</th>
                                <th>NGHỀ NGHIỆP</th>
                                <th>THAO TÁC</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($phuhuynh as $ph)
                                <tr>
                                    <td style="text-align:center; font-weight:600;">{{ $ph->id }}</td>
                                    <td style="font-weight:600; color:#0b5776;">{{ $ph->hoten }}</td>
                                    <td style="text-align:center;">{{ $ph->quanhe }}</td>
                                    <td>{{ $ph->sdt }}</td>
                                    <td>{{ $ph->email }}</td>
                                    <td>{{ $ph->diachithuongtru }}</td>
                                    <td>{{ $ph->diachitamtru }}</td>
                                    <td>{{ $ph->nghenghiep }}</td>
                                    <td style="text-align:center;">
                                        <a href="{{ route('admin.phuhuynh.edit', $ph->id) }}"
                                            class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.phuhuynh.destroy', $ph->id) }}" method="POST"
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
                    {{ $phuhuynh->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
