@extends('teacher.teacher')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Chỉnh sửa thông báo</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('teacher.teacher') }}">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="{{ route('teacher.thongbao.index') }}">Thông báo</a></li>
                <li class="breadcrumb-item active" aria-current="page">Chỉnh sửa</li>
            </ol>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Thông tin thông báo</h6>
                    </div>

                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if ($thongbao->trangthai == 'từ chối' && $thongbao->lydotuchoi)
                            <div class="alert alert-danger">
                                <strong><i class="bi bi-x-circle"></i> Lý do từ chối:</strong>
                                {{ $thongbao->lydotuchoi }}
                            </div>
                        @endif

                        <form action="{{ route('teacher.thongbao.update', $thongbao->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="tieude">Tiêu đề <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('tieude') is-invalid @enderror"
                                    id="tieude" name="tieude"
                                    value="{{ old('tieude', $thongbao->tieude) }}" required>
                                @error('tieude')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="loaithongbao">Loại thông báo <span class="text-danger">*</span></label>
                                <select class="form-control @error('loaithongbao') is-invalid @enderror" id="loaithongbao"
                                    name="loaithongbao" required>
                                    <option value="">-- Chọn loại --</option>
                                    <option value="chung"
                                        {{ old('loaithongbao', $thongbao->loaithongbao) == 'chung' ? 'selected' : '' }}>
                                        Chung</option>
                                    <option value="khẩn cấp"
                                        {{ old('loaithongbao', $thongbao->loaithongbao) == 'khẩn cấp' ? 'selected' : '' }}>
                                        Khẩn cấp</option>
                                    <option value="sự kiện"
                                        {{ old('loaithongbao', $thongbao->loaithongbao) == 'sự kiện' ? 'selected' : '' }}>
                                        Sự kiện</option>
                                    <option value="nghỉ lễ"
                                        {{ old('loaithongbao', $thongbao->loaithongbao) == 'nghỉ lễ' ? 'selected' : '' }}>
                                        Nghỉ lễ</option>
                                </select>
                                @error('loaithongbao')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="noidung">Nội dung <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('noidung') is-invalid @enderror" id="noidung" name="noidung" rows="6"
                                    required>{{ old('noidung', $thongbao->noidung) }}</textarea>
                                @error('noidung')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="tepdinhkem">Tệp đính kèm (PDF, Word, Ảnh - Tối đa 2MB)</label>

                                @if ($thongbao->tepdinhkem)
                                    <div class="mb-2">
                                        <small class="text-muted">File hiện tại:</small>
                                        <a href="{{ asset('storage/' . $thongbao->tepdinhkem) }}" target="_blank"
                                            class="btn btn-sm btn-info">
                                            <i class="bi bi-file-earmark"></i> Xem file
                                        </a>
                                    </div>
                                @endif

                                <input type="file" class="form-control-file @error('tepdinhkem') is-invalid @enderror"
                                    id="tepdinhkem" name="tepdinhkem" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                @error('tepdinhkem')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Định dạng: PDF, DOC, DOCX, JPG, JPEG, PNG. Dung lượng
                                    tối đa: 2MB. Để trống nếu không muốn thay đổi.</small>
                            </div>

                            @if ($lophoc)
                                <div class="alert alert-info">
                                    <i class="bi bi-info-circle"></i> Thông báo sẽ được gửi đến lớp:
                                    <strong>{{ $lophoc->tenlop }}</strong>
                                </div>
                            @endif

                            <div class="alert alert-warning">
                                <i class="bi bi-exclamation-triangle"></i> Sau khi chỉnh sửa, thông báo sẽ quay về trạng
                                thái <strong>"Chờ duyệt"</strong> và cần được Admin phê duyệt lại.
                            </div>

                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle"></i> Cập nhật
                                </button>
                                <a href="{{ route('teacher.thongbao.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-x-circle"></i> Hủy
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
