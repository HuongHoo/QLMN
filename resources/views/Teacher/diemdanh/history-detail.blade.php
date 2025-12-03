@extends('teacher.teacher')

@section('content')
    <div class="container-fluid">

        <div class="d-flex justify-content-between mb-3">
            <h3>Lịch sử điểm danh – Lớp {{ $lophoc->tenlop }}</h3>
            <a href="{{ route('teacher.diemdanh.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Quay lại
            </a>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header bg-primary text-white">
                <strong>Lịch sử điểm danh</strong>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>Ngày</th>
                                <th>Học sinh</th>
                                <th>Trạng thái</th>
                                <th>Ghi chú</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($diemdanh as $item)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($item->ngaydiemdanh)->format('d/m/Y') }}</td>
                                    <td>{{ $item->hocsinh->tenhocsinh }}</td>
                                    <td>
                                        <span
                                            class="badge
                                    @if ($item->trangthai == 'có mặt') text-bg-primary
                                    @elseif ($item->trangthai == 'vắng mặt')
                                        text-bg-success
                                    @elseif ($item->trangthai == 'nghỉ phép')
                                        text-bg-danger
                                    @elseif ($item->trangthai == 'trễ')
                                        text-bg-warning @endif ">
                                            {{ $item->trangthai }}</span>
                                    </td>
                                    <td>{{ $item->ghichu }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Chưa có lịch sử điểm danh</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection
