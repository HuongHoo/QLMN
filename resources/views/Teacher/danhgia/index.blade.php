@extends('teacher.teacher')

@section('content')
    <style>
        .rating-table {
            border-collapse: collapse;
            width: 100%;
        }

        .rating-table th,
        .rating-table td {
            border: 1px solid #d6e9f8;
            padding: 10px;
            vertical-align: top;
            text-align: center;
        }

        .rating-table thead th {
            background: linear-gradient(180deg, #e3f2fd 0%, #d0e9fb 100%);
            color: #0b5776;
            font-weight: 700;
        }

        .col-student {
            text-align: left;
            padding-left: 12px;
            font-weight: 600;
        }

        .rating-table tbody tr:hover {
            background: #fbfdff;
        }
    </style>

    <div class="col-12">
        <div class="card mb-4 shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Quản lý đánh giá - Lớp {{ $lophoc->tenlop }}</h6>
                <a href="{{ route('teacher.danhgia.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Thêm đánh giá
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

                <div class="table-responsive">
                    <table class="rating-table table">
                        <thead>
                            <tr>
                                <th style="width: 50px;">STT</th>
                                <th class="col-student">Tên học sinh</th>
                                <th>Tháng/Năm</th>
                                <th>Thể chất</th>
                                <th>Ngôn ngữ</th>
                                <th>Nhận thức</th>
                                <th>Cảm xúc</th>
                                <th>Nghệ thuật</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($hocsinhList as $hs)
                                @php
                                    $latestDanhGia = $hs->danhgia->first(); // lấy đánh giá mới nhất
                                @endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="col-student">{{ $hs->tenhocsinh ?? '-' }}</td>
                                    <td>
                                        @if ($latestDanhGia)
                                            {{ $latestDanhGia->thang }}/{{ $latestDanhGia->nam }}
                                        @else
                                            <span class="text-muted">Chưa đánh giá</span>
                                        @endif
                                    </td>
                                    <td>{{ $latestDanhGia->thechat ?? '-' }}</td>
                                    <td>{{ $latestDanhGia->ngonngu ?? '-' }}</td>
                                    <td>{{ $latestDanhGia->nhanthuc ?? '-' }}</td>
                                    <td>{{ $latestDanhGia->camxucxahoi ?? '-' }}</td>
                                    <td>{{ $latestDanhGia->nghethuat ?? '-' }}</td>
                                    <td>
                                        @if ($latestDanhGia)
                                            <a href="{{ route('teacher.danhgia.show', $latestDanhGia->id) }}"
                                                class="text-info me-2" title="Xem" data-bs-toggle="tooltip">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('teacher.danhgia.edit', $latestDanhGia->id) }}"
                                                class="text-warning me-2" title="Sửa" data-bs-toggle="tooltip">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                            <form action="{{ route('teacher.danhgia.destroy', $latestDanhGia->id) }}"
                                                method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="border-0 bg-transparent text-danger p-0"
                                                    onclick="return confirm('Bạn có chắc muốn xóa?')" title="Xóa"
                                                    data-bs-toggle="tooltip">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        @else
                                            <a href="{{ route('teacher.danhgia.create', ['mahocsinh' => $hs->id]) }}"
                                                class="btn btn-sm btn-success">
                                                <i class="fas fa-plus"></i> Đánh giá
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center text-muted">Chưa có học sinh trong lớp</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Phân trang --}}
                <div class="mt-3">
                    {{ $hocsinhList->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
