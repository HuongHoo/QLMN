@extends('teacher.teacher')

@section('content')
    <style>
        .star-rating-input {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 30px;
        }

        .star-rating-input .star {
            cursor: pointer;
            color: #ddd;
            transition: color 0.2s;
        }

        .star-rating-input .star:hover,
        .star-rating-input .star.hovered {
            color: #ffc107;
        }

        .star-rating-input .star.selected {
            color: #ffc107;
        }

        .rating-label {
            margin-left: 10px;
            font-size: 16px;
            font-weight: 600;
            color: #333;
        }
    </style>

    <div class="col-12">
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-warning text-white">
                <h6 class="m-0 font-weight-bold"><i class="fas fa-edit"></i> Sửa đánh giá học sinh</h6>
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

                <form action="{{ route('teacher.danhgia.update', $danhgia->id) }}" method="POST" id="danhgiaForm">
                    @csrf
                    @method('PUT')
                    <div class="row">

                        {{-- Học sinh --}}
                        <div class="col-md-6 mb-3">
                            <label for="mahocsinh">Học sinh <span class="text-danger">*</span></label>
                            <select name="mahocsinh" id="mahocsinh" class="form-control" required>
                                <option value="">-- Chọn học sinh --</option>
                                @foreach ($hocsinh as $hs)
                                    <option value="{{ $hs->id }}"
                                        {{ old('mahocsinh', $danhgia->mahocsinh) == $hs->id ? 'selected' : '' }}>
                                        {{ $hs->tenhocsinh }} ({{ $hs->mathe ?? '' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Tháng --}}
                        <div class="col-md-3 mb-3">
                            <label for="thang">Tháng <span class="text-danger">*</span></label>
                            <select name="thang" id="thang" class="form-control" required>
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}"
                                        {{ old('thang', $danhgia->thang) == $i ? 'selected' : '' }}>
                                        Tháng {{ $i }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        {{-- Năm --}}
                        <div class="col-md-3 mb-3">
                            <label for="nam">Năm <span class="text-danger">*</span></label>
                            <input type="number" name="nam" id="nam" class="form-control" min="2000"
                                max="2100" value="{{ old('nam', $danhgia->nam) }}" required>
                        </div>

                        {{-- Các lĩnh vực đánh giá (1-5 sao) --}}
                        <div class="col-12 mb-3 mt-3">
                            <h6 class="text-primary">Đánh giá các lĩnh vực (Click vào sao để đánh giá)</h6>
                        </div>

                        @php
                            $fields = [
                                'thechat' => 'Thể chất',
                                'ngonngu' => 'Ngôn ngữ',
                                'nhanthuc' => 'Nhận thức',
                                'camxucxahoi' => 'Cảm xúc xã hội',
                                'nghethuat' => 'Nghệ thuật',
                            ];
                        @endphp

                        @foreach ($fields as $key => $label)
                            <div class="col-md-6 mb-4">
                                <label class="mb-2">{{ $label }}</label>
                                <div class="star-rating-input" data-field="{{ $key }}">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star star" data-value="{{ $i }}"></i>
                                    @endfor
                                    <span class="rating-label">(<span class="current-rating">0</span>/5)</span>
                                </div>
                                <input type="hidden" name="{{ $key }}" id="{{ $key }}"
                                    value="{{ old($key, $danhgia->$key ?? 0) }}">
                            </div>
                        @endforeach

                        {{-- Nhận xét chung --}}
                        <div class="col-md-12 mb-3">
                            <label for="nhanxetchung">Nhận xét chung</label>
                            <textarea name="nhanxetchung" id="nhanxetchung" rows="4" class="form-control"
                                placeholder="Nhập nhận xét về học sinh...">{{ old('nhanxetchung', $danhgia->nhanxetchung) }}</textarea>
                        </div>

                    </div>

                    <div class="text-right mt-3">
                        <button type="submit" class="btn btn-warning shadow-sm px-4">
                            <i class="fas fa-save"></i> Cập nhật
                        </button>
                        <a href="{{ route('teacher.danhgia.index') }}" class="btn btn-secondary shadow-sm px-4">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Xử lý đánh giá sao
            const ratingContainers = document.querySelectorAll('.star-rating-input');

            ratingContainers.forEach(container => {
                const stars = container.querySelectorAll('.star');
                const field = container.getAttribute('data-field');
                const hiddenInput = document.getElementById(field);
                const ratingLabel = container.querySelector('.current-rating');
                let currentRating = parseInt(hiddenInput.value) || 0;

                // Hiển thị rating ban đầu
                updateStars(currentRating);

                // Click vào sao
                stars.forEach(star => {
                    star.addEventListener('click', function() {
                        const value = parseInt(this.getAttribute('data-value'));
                        currentRating = value;
                        hiddenInput.value = value;
                        ratingLabel.textContent = value;
                        updateStars(value);
                    });

                    // Hover effect
                    star.addEventListener('mouseenter', function() {
                        const value = parseInt(this.getAttribute('data-value'));
                        highlightStars(value);
                    });
                });

                // Mouse leave - về trạng thái đã chọn
                container.addEventListener('mouseleave', function() {
                    updateStars(currentRating);
                });

                function updateStars(rating) {
                    stars.forEach((star, index) => {
                        if (index < rating) {
                            star.classList.add('selected');
                            star.classList.remove('hovered');
                        } else {
                            star.classList.remove('selected', 'hovered');
                        }
                    });
                    ratingLabel.textContent = rating;
                }

                function highlightStars(rating) {
                    stars.forEach((star, index) => {
                        if (index < rating) {
                            star.classList.add('hovered');
                        } else {
                            star.classList.remove('hovered');
                        }
                    });
                }
            });
        });
    </script>
@endsection
