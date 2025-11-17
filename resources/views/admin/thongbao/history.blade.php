@extends('admin.welcome')

@section('content')
    <div class="container-fluid" id="container-wrapper">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Lịch sử phê duyệt thông báo</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.welcome') }}">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.thongbao.index') }}">Duyệt thông báo</a></li>
                <li class="breadcrumb-item active" aria-current="page">Lịch sử</li>
            </ol>
        </div>

        <div class="row">
            <div class="col-lg-12 mb-4">

                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Danh sách thông báo đã xử lý</h6>
                        <a href="{{ route('admin.thongbao.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Quay lại
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
                                        <th>Ngày tạo</th>
                                        <th>Trạng thái</th>
                                        <th>Ngày gửi</th>
                                        <th>Lý do từ chối</th>
                                        <th>Ngày xử lý</th>
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
                                            <td>
                                                {{ $tb->tieude }}
                                                @if ($tb->tepdinhkem)
                                                    <br><a href="{{ asset('storage/' . $tb->tepdinhkem) }}"
                                                        target="_blank" class="btn btn-xs btn-info mt-1">
                                                        <i class="bi bi-paperclip"></i> File
                                                    </a>
                                                @endif
                                            </td>
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
                                            <td class="text-center">
                                                @if ($tb->trangthai == 'đã duyệt')
                                                    <span class="badge badge-success">Đã duyệt</span>
                                                @else
                                                    <span class="badge badge-danger">Từ chối</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $tb->ngaygui ? $tb->ngaygui->format('d/m/Y') : '-' }}
                                            </td>
                                            <td>
                                                @if ($tb->trangthai == 'từ chối' && $tb->lydotuchoi)
                                                    <small class="text-danger">{{ $tb->lydotuchoi }}</small>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>{{ $tb->updated_at->format('d/m/Y H:i') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10" class="text-center">Chưa có lịch sử phê duyệt</td>
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
