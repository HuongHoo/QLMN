@extends('teacher.teacher')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Tạo thông báo mới</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('teacher.teacher') }}">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="{{ route('teacher.thongbao.index') }}">Thông báo</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tạo mới</li>
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

                        <form action="{{ route('teacher.thongbao.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="tieude">Tiêu đề <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('tieude') is-invalid @enderror"
                                    id="tieude" name="tieude" value="{{ old('tieude') }}" required>
                                @error('tieude')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="loaithongbao">Loại thông báo <span class="text-danger">*</span></label>
                                <select class="form-control @error('loaithongbao') is-invalid @enderror" id="loaithongbao"
                                    name="loaithongbao" required>
                                    <option value="">-- Chọn loại --</option>
                                    <option value="chung" {{ old('loaithongbao') == 'chung' ? 'selected' : '' }}>Chung
                                    </option>
                                    <option value="khẩn cấp" {{ old('loaithongbao') == 'khẩn cấp' ? 'selected' : '' }}>
                                        Khẩn cấp</option>
                                    <option value="sự kiện" {{ old('loaithongbao') == 'sự kiện' ? 'selected' : '' }}>Sự
                                        kiện</option>
                                    <option value="nghỉ lễ" {{ old('loaithongbao') == 'nghỉ lễ' ? 'selected' : '' }}>
                                        Nghỉ lễ</option>
                                </select>
                                @error('loaithongbao')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="noidung">Nội dung <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('noidung') is-invalid @enderror" id="noidung" name="noidung" rows="6"
                                    required>{{ old('noidung') }}</textarea>
                                @error('noidung')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="tepdinhkem">Tệp đính kèm (PDF, Word, Ảnh - Tối đa 2MB)</label>
                                <input type="file" class="form-control-file @error('tepdinhkem') is-invalid @enderror"
                                    id="tepdinhkem" name="tepdinhkem"
                                    accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                @error('tepdinhkem')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Định dạng: PDF, DOC, DOCX, JPG, JPEG, PNG. Dung lượng
                                    tối đa: 2MB</small>
                            </div>

                            @if ($lophoc)
                                <div class="alert alert-info">
                                    <i class="bi bi-info-circle"></i> Thông báo sẽ được gửi đến lớp:
                                    <strong>{{ $lophoc->tenlop }}</strong>
                                </div>
                            @endif

                            <div class="alert alert-warning">
                                <i class="bi bi-exclamation-triangle"></i> Thông báo sẽ ở trạng thái <strong>"Chờ
                                    duyệt"</strong> và cần được Admin phê duyệt trước khi gửi.
                            </div>

                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle"></i> Tạo thông báo
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
