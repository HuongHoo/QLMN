@extends('teacher.teacher')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-plus-circle text-primary me-2"></i>Đăng hoạt động mới
        </h1>
        <a href="{{ route('teacher.hoatdong.index') }}" class="btn btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm me-1"></i> Quay lại
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-primary text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-camera me-2"></i>Thông tin hoạt động - Lớp {{ $lop->tenlop }}
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('teacher.hoatdong.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-8">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-heading text-primary me-1"></i> Tiêu đề hoạt động <span
                                        class="text-danger">*</span>
                                </label>
                                <input type="text" name="tieude"
                                    class="form-control @error('tieude') is-invalid @enderror" value="{{ old('tieude') }}"
                                    placeholder="VD: Giờ học vẽ, Bữa ăn trưa, Chơi ngoài trời..." required>
                                @error('tieude')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-tag text-primary me-1"></i> Loại hoạt động <span
                                        class="text-danger">*</span>
                                </label>
                                <select name="loai" class="form-select @error('loai') is-invalid @enderror" required>
                                    <option value="">-- Chọn loại --</option>
                                    <option value="gioian" {{ old('loai') == 'gioian' ? 'selected' : '' }}>🍽️ Giờ ăn
                                    </option>
                                    <option value="hoctap" {{ old('loai') == 'hoctap' ? 'selected' : '' }}>📚 Học tập
                                    </option>
                                    <option value="ngoaitroi" {{ old('loai') == 'ngoaitroi' ? 'selected' : '' }}>☀️ Ngoài
                                        trời</option>
                                    <option value="nghingoi" {{ old('loai') == 'nghingoi' ? 'selected' : '' }}>😴 Nghỉ ngơi
                                    </option>
                                    <option value="khac" {{ old('loai') == 'khac' ? 'selected' : '' }}>⭐ Khác</option>
                                </select>
                                @error('loai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-calendar text-primary me-1"></i> Ngày <span
                                        class="text-danger">*</span>
                                </label>
                                <input type="date" name="ngay"
                                    class="form-control @error('ngay') is-invalid @enderror"
                                    value="{{ old('ngay', now()->format('Y-m-d')) }}" required>
                                @error('ngay')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-clock text-primary me-1"></i> Giờ bắt đầu <span
                                        class="text-danger">*</span>
                                </label>
                                <input type="time" name="giobatdau"
                                    class="form-control @error('giobatdau') is-invalid @enderror"
                                    value="{{ old('giobatdau', now()->format('H:i')) }}" required>
                                @error('giobatdau')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-clock text-primary me-1"></i> Giờ kết thúc <span
                                        class="text-danger">*</span>
                                </label>
                                <input type="time" name="gioketthuc"
                                    class="form-control @error('gioketthuc') is-invalid @enderror"
                                    value="{{ old('gioketthuc', now()->addHour()->format('H:i')) }}" required>
                                @error('gioketthuc')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="fas fa-align-left text-primary me-1"></i> Mô tả chi tiết
                            </label>
                            <textarea name="mota" class="form-control @error('mota') is-invalid @enderror" rows="3"
                                placeholder="Mô tả hoạt động, các bé đã làm gì, ăn gì...">{{ old('mota') }}</textarea>
                            @error('mota')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Upload ảnh -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="fas fa-images text-primary me-1"></i> Ảnh hoạt động
                            </label>
                            <div class="border rounded p-3 bg-light">
                                <input type="file" name="anh[]" id="anhInput"
                                    class="form-control @error('anh.*') is-invalid @enderror" multiple accept="image/*"
                                    onchange="previewImages(this)">
                                <small class="text-muted d-block mt-2">
                                    <i class="fas fa-info-circle"></i> Có thể chọn nhiều ảnh. Định dạng: JPG, PNG, GIF. Tối
                                    đa 5MB/ảnh.
                                </small>
                                @error('anh.*')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror

                                <div id="imagePreview" class="row g-2 mt-3"></div>
                            </div>
                        </div>

                        <hr>

                        <!-- Chọn học sinh -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="fas fa-child text-primary me-1"></i> Áp dụng cho
                            </label>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="tat_ca_lop" id="tatCaLop" checked
                                    onchange="toggleHocSinhList()">
                                <label class="form-check-label" for="tatCaLop">
                                    <strong>Cả lớp</strong> - Phụ huynh của tất cả học sinh trong lớp sẽ thấy
                                </label>
                            </div>

                            <div id="hocSinhList" class="border rounded p-3 bg-light"
                                style="display: none; max-height: 300px; overflow-y: auto;">
                                <p class="text-muted small mb-2">
                                    <i class="fas fa-info-circle"></i> Chọn học sinh cụ thể (chỉ phụ huynh của học sinh
                                    được chọn mới thấy):
                                </p>
                                <div class="row">
                                    @foreach ($hocsinhs as $hs)
                                        <div class="col-md-6 col-lg-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="hocsinh_ids[]"
                                                    value="{{ $hs->id }}" id="hs{{ $hs->id }}">
                                                <label class="form-check-label" for="hs{{ $hs->id }}">
                                                    {{ $hs->hoten }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-paper-plane me-1"></i> Đăng hoạt động
                            </button>
                            <a href="{{ route('teacher.hoatdong.index') }}" class="btn btn-secondary btn-lg">
                                <i class="fas fa-times me-1"></i> Hủy
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Hướng dẫn -->
        <div class="col-lg-4">
            <div class="card shadow mb-4 border-left-info">
                <div class="card-header py-3 bg-info text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-lightbulb me-2"></i>Hướng dẫn
                    </h6>
                </div>
                <div class="card-body">
                    <h6 class="fw-bold text-primary">📸 Cách đăng ảnh:</h6>
                    <ol class="small text-muted">
                        <li>Nhập tiêu đề và chọn loại hoạt động</li>
                        <li>Chọn thời gian diễn ra hoạt động</li>
                        <li>Thêm mô tả chi tiết (không bắt buộc)</li>
                        <li>Upload ảnh từ điện thoại/máy tính</li>
                        <li>Chọn áp dụng cho cả lớp hoặc học sinh cụ thể</li>
                        <li>Bấm "Đăng hoạt động"</li>
                    </ol>

                    <hr>

                    <h6 class="fw-bold text-success">👨‍👩‍👧 Phụ huynh sẽ thấy:</h6>
                    <ul class="small text-muted">
                        <li>Ảnh hiển thị trong mục "Hoạt động của bé" trên Dashboard</li>
                        <li>Thông tin về thời gian và loại hoạt động</li>
                        <li>Mô tả chi tiết về hoạt động</li>
                    </ul>

                    <hr>

                    <h6 class="fw-bold text-warning">💡 Gợi ý nội dung:</h6>
                    <ul class="small text-muted">
                        <li><strong>Giờ ăn:</strong> Ảnh các bé ăn trưa, uống sữa...</li>
                        <li><strong>Học tập:</strong> Ảnh giờ học vẽ, múa hát...</li>
                        <li><strong>Ngoài trời:</strong> Ảnh thể dục, chơi sân...</li>
                        <li><strong>Nghỉ ngơi:</strong> Ảnh giờ ngủ trưa</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function toggleHocSinhList() {
            const checkbox = document.getElementById('tatCaLop');
            const list = document.getElementById('hocSinhList');
            list.style.display = checkbox.checked ? 'none' : 'block';

            // Bỏ chọn tất cả học sinh khi chọn "Cả lớp"
            if (checkbox.checked) {
                document.querySelectorAll('input[name="hocsinh_ids[]"]').forEach(el => el.checked = false);
            }
        }

        function previewImages(input) {
            const preview = document.getElementById('imagePreview');
            preview.innerHTML = '';

            if (input.files) {
                Array.from(input.files).forEach((file, index) => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const col = document.createElement('div');
                        col.className = 'col-4 col-md-3';
                        col.innerHTML = `
                    <div class="position-relative">
                        <img src="${e.target.result}" class="img-fluid rounded shadow-sm" style="height: 100px; width: 100%; object-fit: cover;">
                        <span class="position-absolute top-0 end-0 badge bg-primary m-1">${index + 1}</span>
                    </div>
                `;
                        preview.appendChild(col);
                    }
                    reader.readAsDataURL(file);
                });
            }
        }
    </script>
@endsection
