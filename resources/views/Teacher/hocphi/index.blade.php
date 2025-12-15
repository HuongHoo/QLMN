@extends('teacher.teacher')

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
            width: 200px;
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

    <div class="col-12">
        <div class="card mb-4 shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Quản lý học phí - Lớp {{ $lophoc->tenlop }}</h6>
                <a href="{{ route('teacher.hocphi.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Thêm học phí
                </a>
            </div>

            <div class="card-body">
                {{-- Thông báo --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                @endif

                {{-- Bộ lọc --}}
                <form method="GET" class="mb-3">
                    <div class="row">
                        <div class="col-md-3">
                            <select name="thang" class="form-control">
                                <option value="">-- Chọn tháng --</option>
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ request('thang') == $i ? 'selected' : '' }}>
                                        Tháng {{ $i }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="nam" class="form-control">
                                <option value="">-- Chọn năm --</option>
                                @for ($y = date('Y'); $y >= date('Y') - 5; $y--)
                                    <option value="{{ $y }}" {{ request('nam') == $y ? 'selected' : '' }}>
                                        {{ $y }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-info">
                                <i class="fas fa-filter"></i> Lọc
                            </button>
                        </div>
                    </div>
                </form>

                <div class="table-responsive-fee">
                    <table class="fee-table">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th class="col-student">Tên học sinh</th>
                                <th>Thời gian đóng</th>
                                <th>Tổng tiền</th>
                                <th>Đã thanh toán</th>
                                <th>Còn nợ</th>
                                <th>Ngày TT</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($hocphis as $hp)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="col-student">
                                        <a href="{{ route('teacher.hocphi.show', $hp->id) }}"
                                            class="text-decoration-none text-primary">
                                            {{ $hp->hocsinh->tenhocsinh ?? '-' }}
                                        </a>
                                    </td>
                                    <td>{{ $hp->thoigiandong ? \Carbon\Carbon::parse($hp->thoigiandong)->format('m/Y') : '-' }}
                                    </td>
                                    <td class="text-right">{{ number_format($hp->tongtien ?? 0, 0, ',', '.') }} đ</td>
                                    <td class="text-right">{{ number_format($hp->dathanhtoan ?? 0, 0, ',', '.') }} đ</td>
                                    <td class="text-right">
                                        <strong class="{{ $hp->con_no > 0 ? 'text-danger' : 'text-success' }}">
                                            {{ number_format($hp->con_no ?? 0, 0, ',', '.') }} đ
                                        </strong>
                                    </td>
                                    <td>{{ $hp->ngaythanhtoan ? \Carbon\Carbon::parse($hp->ngaythanhtoan)->format('d/m/Y') : '-' }}
                                    </td>
                                    <td>
                                        <a href="{{ route('teacher.hocphi.show', $hp->id) }}" class="btn btn-sm btn-info"
                                            title="Xem">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('teacher.hocphi.edit', $hp->id) }}"
                                            class="btn btn-sm btn-warning" title="Sửa">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('teacher.hocphi.destroy', $hp->id) }}" method="POST"
                                            style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Bạn có chắc muốn xóa?')" title="Xóa">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted">Chưa có dữ liệu học phí</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Phân trang --}}
                <div class="mt-3">
                    {{ $hocphis->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
