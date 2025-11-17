@extends('teacher.teacher')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Quản lý thông báo</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('teacher.teacher') }}">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Thông báo</li>
            </ol>
        </div>

        <div class="row">
            <div class="col-lg-12 mb-4">

                {{-- Hiển thị thông báo --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Danh sách thông báo</h6>
                        <a href="{{ route('teacher.thongbao.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Thêm mới
                        </a>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>STT</th>
                                        <th>Tiêu đề</th>
                                        <th>Loại</th>
                                        <th>Ngày tạo</th>
                                        <th>Trạng thái</th>
                                        <th>Lý do từ chối</th>
                                        <th class="text-center">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($thongbaos as $index => $tb)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $tb->tieude }}</td>
                                            <td>
                                                @if ($tb->loaithongbao == 'khẩn cấp')
                                                    <span class="badge badge-danger">{{ $tb->loaithongbao }}</span>
                                                @elseif($tb->loaithongbao == 'sự kiện')
                                                    <span class="badge badge-info">{{ $tb->loaithongbao }}</span>
                                                @else
                                                    <span class="badge badge-secondary">{{ $tb->loaithongbao }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $tb->ngaytao ? $tb->ngaytao->format('d/m/Y') : '' }}</td>
                                            <td>
                                                @if ($tb->trangthai == 'chờ duyệt')
                                                    <span class="badge badge-warning">Chờ duyệt</span>
                                                @elseif($tb->trangthai == 'đã duyệt')
                                                    <span class="badge badge-success">Đã duyệt</span>
                                                @else
                                                    <span class="badge badge-danger">Từ chối</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($tb->trangthai == 'từ chối' && $tb->lydotuchoi)
                                                    <small class="text-danger">{{ $tb->lydotuchoi }}</small>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group">
                                                    @if (in_array($tb->trangthai, ['chờ duyệt', 'từ chối']))
                                                        <a href="{{ route('teacher.thongbao.edit', $tb->id) }}"
                                                            class="btn btn-sm btn-warning" title="Sửa">
                                                            <i class="bi bi-pencil"></i>
                                                        </a>
                                                    @endif

                                                    <form action="{{ route('teacher.thongbao.destroy', $tb->id) }}"
                                                        method="POST" style="display: inline;"
                                                        onsubmit="return confirm('Bạn có chắc muốn xóa thông báo này?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" title="Xóa">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">Chưa có thông báo nào</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
