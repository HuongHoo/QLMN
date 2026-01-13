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
            font-size: 13px;
        }

        .col-student {
            width: 220px;
            background: #ffffff;
            text-align: left;
            padding-left: 12px;
            font-weight: 600;
        }

        .col-student a {
            color: #0b5776;
            text-decoration: none;
            font-weight: 600;
        }

        .col-student a:hover {
            text-decoration: underline;
            color: #084a61;
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

        .status-stable {
            background: #e8f5e9;
            color: #2e7d32;
            padding: 2px 6px;
            border-radius: 4px;
            display: inline-block;
        }

        .status-warning {
            background: #fff3e0;
            color: #ef6c00;
            padding: 2px 6px;
            border-radius: 4px;
            display: inline-block;
        }

        .status-danger {
            background: #ffebee;
            color: #c62828;
            padding: 2px 6px;
            border-radius: 4px;
            display: inline-block;
        }

        .health-table tbody tr:hover {
            background: #fbfdff;
        }

        .table-responsive-health {
            overflow-x: auto;
            background: #fff;
            padding: 8px;
            border-radius: 8px;
            border: 1px solid #e6f1fb;
        }

        /* Chi tiết ẩn/hiện */
        .health-details {
            display: none;
            background: #f8fafc;
            border-top: 2px solid #4e73df;
        }

        .health-details.show {
            display: table-row;
        }

        .health-record {
            padding: 16px;
            border-bottom: 1px solid #e3e6f0;
        }

        .health-record:last-child {
            border-bottom: none;
        }

        .health-info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 12px;
            margin-bottom: 12px;
        }

        .health-info-item {
            background: #fff;
            padding: 10px;
            border: 1px solid #d6e9f8;
            border-radius: 4px;
        }

        .health-info-label {
            font-size: 11px;
            color: #858796;
            margin-bottom: 4px;
            text-transform: uppercase;
            font-weight: 600;
        }

        .health-info-value {
            font-size: 15px;
            font-weight: 600;
            color: #5a5c69;
        }

        .health-note {
            background: #fff3cd;
            border-left: 3px solid #f6c23e;
            padding: 10px;
            border-radius: 0 4px 4px 0;
        }

        .health-note-label {
            font-size: 11px;
            color: #856404;
            margin-bottom: 2px;
            font-weight: 600;
        }

        .health-note-value {
            font-size: 13px;
            color: #856404;
        }

        .health-actions {
            margin-top: 12px;
            text-align: right;
        }

        .health-actions a,
        .health-actions button {
            margin-left: 6px;
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
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($hocsinhList as $hs)
                                <tr>
                                    <td style="text-align:center; font-weight:600; width:60px;">{{ $loop->iteration }}</td>
                                    <td class="col-student">
                                        <a href="javascript:void(0)" onclick="toggleHealth({{ $hs->id }})"
                                            class="student-name-link">
                                            {{ $hs->tenhocsinh }}
                                        </a>
                                        @if (isset($hs->lophoc->tenlop))
                                            <div style="font-size:12px; color:#666;">Lớp: {{ $hs->lophoc->tenlop }}</div>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($hs->suckhoe->count() > 0)
                                            <span class="badge bg-primary">{{ $hs->suckhoe->count() }} lần khám</span>
                                            <small class="text-muted ms-2">(Nhấn vào tên để xem chi tiết)</small>
                                        @else
                                            <span class="text-muted">Chưa có dữ liệu</span>
                                        @endif
                                    </td>
                                </tr>

                                @if ($hs->suckhoe->count() > 0)
                                    <tr class="health-details" id="health-{{ $hs->id }}">
                                        <td colspan="3">
                                            @foreach ($hs->suckhoe as $sk)
                                                <div class="health-record">
                                                    <div class="health-info-grid">
                                                        <div class="health-info-item">
                                                            <div class="health-info-label">
                                                                <i class="fas fa-calendar-alt me-1"></i> Ngày khám
                                                            </div>
                                                            <div class="health-info-value">
                                                                {{ \Carbon\Carbon::parse($sk->ngaykham)->format('d/m/Y') }}
                                                            </div>
                                                        </div>
                                                        <div class="health-info-item">
                                                            <div class="health-info-label">Chiều cao</div>
                                                            <div class="health-info-value">{{ $sk->chieucao }} cm</div>
                                                        </div>
                                                        <div class="health-info-item">
                                                            <div class="health-info-label">Cân nặng</div>
                                                            <div class="health-info-value">{{ $sk->cannang }} kg</div>
                                                        </div>
                                                        <div class="health-info-item">
                                                            <div class="health-info-label">Tình trạng</div>
                                                            <div class="health-info-value">
                                                                @php
                                                                    $statusClass = 'status-stable';
                                                                    $tinhtrang = strtolower($sk->tinhtrang);
                                                                    if (
                                                                        str_contains($tinhtrang, 'yếu') ||
                                                                        str_contains($tinhtrang, 'nặng')
                                                                    ) {
                                                                        $statusClass = 'status-danger';
                                                                    } elseif (
                                                                        str_contains($tinhtrang, 'nhẹ') ||
                                                                        str_contains($tinhtrang, 'cảm')
                                                                    ) {
                                                                        $statusClass = 'status-warning';
                                                                    }
                                                                @endphp
                                                                <span
                                                                    class="{{ $statusClass }}">{{ $sk->tinhtrang }}</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    @if ($sk->ghichu)
                                                        <div class="health-note">
                                                            <div class="health-note-label">Ghi chú</div>
                                                            <div class="health-note-value">{{ $sk->ghichu }}</div>
                                                        </div>
                                                    @endif

                                                    <div class="health-actions">
                                                        <a href="{{ route('admin.suckhoe.edit', $sk->id) }}"
                                                            class="btn btn-sm btn-outline-primary">
                                                            <i class="fas fa-edit"></i> Sửa
                                                        </a>
                                                        <form action="{{ route('admin.suckhoe.destroy', $sk->id) }}"
                                                            method="POST" class="d-inline"
                                                            onsubmit="return confirm('Bạn có chắc muốn xóa bản ghi này?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                                <i class="fas fa-trash"></i> Xóa
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </td>
                                    </tr>
                                @endif
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

    <script>
        function toggleHealth(id) {
            const detailRow = document.getElementById('health-' + id);
            if (detailRow) {
                detailRow.classList.toggle('show');
            }
        }
    </script>
@endsection
