@extends('admin.welcome')

@section('title', 'Quản lý đánh giá học sinh')

@section('content')
    <style>
        .rating-table {
            border-collapse: collapse;
            width: 100%;
            table-layout: fixed;
        }

        .rating-table th,
        .rating-table td {
            border: 1px solid #d6e9f8;
            padding: 10px;
            vertical-align: top;
            word-wrap: break-word;
        }

        .rating-table thead th.student-header {
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

        .rating-cell .label {
            display: block;
            font-size: 13px;
            color: #333;
            font-weight: 600;
        }

        .rating-cell .value {
            display: block;
            font-size: 14px;
            color: #111;
            margin-bottom: 6px;
        }

        .rating-cell {
            display: flex;
            gap: 16px;
            align-items: center;
            flex-wrap: wrap;
        }

        .rating-attr {
            min-width: 120px;
            max-width: 200px;
        }

        .table-responsive-rating {
            overflow-x: auto;
            background: #fff;
            padding: 8px;
            border-radius: 8px;
            border: 1px solid #e6f1fb;
        }

        .rating-table tbody tr:hover {
            background: #fbfdff;
        }
    </style>

    <div class="container-fluid" id="container-wrapper">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-primary">Quản lý đánh giá học sinh</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Đánh giá</li>
            </ol>
        </div>

        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold">Bảng đánh giá học sinh</h6>
                <a href="{{ route('admin.danhgia.create') }}" class="btn btn-primary btn-sm">+ Thêm mới</a>
            </div>

            <div class="card-body bg-white">
                <div class="table-responsive-rating">
                    <table class="rating-table">
                        <thead>
                            <tr>
                                <th class="student-header" style="width:60px;">STT</th>
                                <th class="student-header col-student">Tên học sinh</th>
                                <th class="student-header">Thông tin đánh giá</th>
                                <th class="student-header" style="width:120px;">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($hocsinhList as $hs)
                                <tr>
                                    <td style="text-align:center; font-weight:600;">{{ $loop->iteration }}</td>
                                    <td class="col-student">
                                        {{ $hs->tenhocsinh }}
                                        @if (isset($hs->lophoc->tenlop))
                                            <div style="font-size:12px; color:#666;">Lớp: {{ $hs->lophoc->tenlop }}</div>
                                        @endif
                                    </td>
                                    <td>
                                        @foreach ($hs->danhgia as $dg)
                                            <div class="rating-cell mb-2 p-2"
                                                style="border:1px solid #d6e9f8; border-radius:6px;">
                                                <div class="rating-attr">
                                                    <span class="label">Năm</span>
                                                    <span
                                                        class="value">{{ is_numeric($dg->nam) ? $dg->nam : \Carbon\Carbon::parse($dg->nam)->format('Y') }}</span>
                                                </div>
                                                <div class="rating-attr">
                                                    <span class="label">Tháng</span>
                                                    <span
                                                        class="value">{{ is_numeric($dg->thang) ? str_pad($dg->thang, 2, '0', STR_PAD_LEFT) : \Carbon\Carbon::parse($dg->thang)->format('m') }}</span>
                                                </div>
                                                <div class="rating-attr">
                                                    <span class="label">Thể chất</span>
                                                    <span class="value">{{ $dg->thechat }}</span>
                                                </div>
                                                <div class="rating-attr">
                                                    <span class="label">Ngôn ngữ</span>
                                                    <span class="value">{{ $dg->ngonngu }}</span>
                                                </div>
                                                <div class="rating-attr">
                                                    <span class="label">Nhận thức</span>
                                                    <span class="value">{{ $dg->nhanthuc }}</span>
                                                </div>
                                                <div class="rating-attr">
                                                    <span class="label">Cảm xúc xã hội</span>
                                                    <span class="value">{{ $dg->camxucxahoi }}</span>
                                                </div>
                                                <div class="rating-attr">
                                                    <span class="label">Nghệ thuật</span>
                                                    <span class="value">{{ $dg->nghethuat }}</span>
                                                </div>
                                                @if ($dg->nhanxetchung)
                                                    <div class="rating-attr" style="flex-basis:100%;">
                                                        <span class="label">Nhận xét chung</span>
                                                        <span class="value">{{ $dg->nhanxetchung }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach

                                        @if ($hs->danhgia->isEmpty())
                                            <span>- Chưa có dữ liệu -</span>
                                        @endif
                                    </td>

                                    <td style="text-align:center; vertical-align:middle;">
                                        @if ($hs->danhgia->isNotEmpty())
                                            @foreach ($hs->danhgia as $dg)
                                                <div class="mb-2 d-flex justify-content-center align-items-center">
                                                    <a href="{{ route('admin.danhgia.edit', $dg->id) }}" class="me-2"
                                                        title="Sửa" style="color: #0d6efd; font-size:16px;">
                                                        <i class="fas fa-pen"></i>
                                                    </a>
                                                    <form action="{{ route('admin.danhgia.destroy', $dg->id) }}"
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
