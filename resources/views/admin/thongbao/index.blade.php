@extends('admin.welcome')

@section('content')
    <div class="container-fluid" id="container-wrapper">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Duyệt thông báo</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.welcome') }}">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Duyệt thông báo</li>
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
                        <h6 class="m-0 font-weight-bold text-primary">Danh sách thông báo chờ duyệt</h6>
                        <a href="{{ route('admin.thongbao.history') }}" class="btn btn-info">
                            <i class="bi bi-clock-history"></i> Lịch sử phê duyệt
                        </a>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>STT</th>
                                        <th>Giáo viên</th>
                                        <th>Lớp</th>
                                        <th>Tiêu đề</th>
                                        <th>Loại</th>
                                        <th>Nội dung</th>
                                        <th>Ngày tạo</th>
                                        <th class="text-center">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($thongbaos as $index => $tb)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                {{ $tb->giaovien->tengiaovien ?? 'N/A' }}
                                            </td>
                                            <td>
                                                {{ $tb->lophoc->tenlop ?? 'N/A' }}
                                            </td>
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
                                            <td>
                                                <small>{{ Str::limit($tb->noidung, 100) }}</small>
                                                @if ($tb->tepdinhkem)
                                                    <br><a href="{{ asset('storage/' . $tb->tepdinhkem) }}" target="_blank"
                                                        class="btn btn-xs btn-info mt-1">
                                                        <i class="bi bi-paperclip"></i> File đính kèm
                                                    </a>
                                                @endif
                                            </td>
                                            <td>{{ $tb->ngaytao ? $tb->ngaytao->format('d/m/Y') : '' }}</td>
                                            <td class="text-center">
                                                <div class="btn-group-vertical" role="group">
                                                    <form action="{{ route('admin.thongbao.approve', $tb->id) }}"
                                                        method="POST" style="display: inline;">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-success mb-1"
                                                            onclick="return confirm('Phê duyệt thông báo này?')">
                                                            <i class="bi bi-check-circle"></i> Phê duyệt
                                                        </button>
                                                    </form>

                                                    <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                                        data-target="#rejectModal{{ $tb->id }}">
                                                        <i class="bi bi-x-circle"></i> Từ chối
                                                    </button>
                                                </div>

                                                {{-- Modal từ chối --}}
                                                <div class="modal fade" id="rejectModal{{ $tb->id }}" tabindex="-1"
                                                    role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="rejectModalLabel">Từ chối thông
                                                                    báo</h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <form action="{{ route('admin.thongbao.reject', $tb->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                <div class="modal-body">
                                                                    <div class="form-group">
                                                                        <label for="lydotuchoi">Lý do từ chối <span
                                                                                class="text-danger">*</span></label>
                                                                        <textarea class="form-control" id="lydotuchoi" name="lydotuchoi" rows="4" required
                                                                            placeholder="Nhập lý do từ chối thông báo này..."></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Đóng</button>
                                                                    <button type="submit" class="btn btn-danger">Xác nhận
                                                                        từ chối</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center">Không có thông báo nào chờ duyệt</td>
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
