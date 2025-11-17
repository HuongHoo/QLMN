@extends('teacher.teacher')

@section('content')
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Danh sách học sinh - Lớp {{ $lophoc->tenlop }}</h6>
            </div>
            <div class="card-body">
                @if (isset($hocsinhs) && count($hocsinhs))
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Ảnh</th>
                                    <th>Tên học sinh</th>
                                    <th>Giới tính</th>
                                    <th>Ngày sinh</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($hocsinhs as $index => $hs)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            @if (!empty($hs->anh))
                                                <img src="{{ asset($hs->anh) }}" alt="avatar"
                                                    style="width:48px;height:48px;object-fit:cover;border-radius:50%;">
                                            @else
                                                <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center"
                                                    style="width:48px;height:48px;">
                                                    <i class="fas fa-user text-muted"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td>{{ $hs->tenhocsinh ?? '-' }}</td>
                                        <td>{{ $hs->gioitinh ?? '-' }}</td>
                                        <td>{{ isset($hs->ngaysinh) ? \Carbon\Carbon::parse($hs->ngaysinh)->format('d/m/Y') : '-' }}
                                        </td>
                                        <td>
                                            <a href="{{ isset($hs->id) ? route('teacher.hocsinh.show', $hs->id) : '#' }}"
                                                class="btn btn-sm btn-info">Xem</a>
                                            <a href="{{ isset($hs->id) ? route('teacher.hocsinh.edit', $hs->id) : '#' }}"
                                                class="btn btn-sm btn-warning">Sửa</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted">Chưa có học sinh trong lớp.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
