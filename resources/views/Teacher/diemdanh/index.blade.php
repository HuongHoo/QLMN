@extends('teacher.teacher')

@section('content')
    <div class="container-fluid">

        <h3 class="mb-4">Điểm danh hằng ngày</h3>

        {{-- Thông báo --}}
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('teacher.diemdanh.store') }}" method="POST">
            @csrf

            {{-- Chọn ngày điểm danh --}}
            <div class="form-group mb-3">
                <label for="ngay">Chọn ngày điểm danh</label>
                <input type="date" name="ngay" id="ngay" class="form-control"
                    value="{{ old('ngay', date('Y-m-d')) }}" required>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white">
                    <h6 class="m-0 font-weight-bold">Danh sách học sinh</h6>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>Học sinh</th>
                                    <th>Giờ đến</th>
                                    <th>Phút trễ</th>
                                    <th>Trễ</th>
                                    <th>Có mặt</th>
                                    <th>Vắng</th>
                                    <th>Nghỉ phép</th>
                                    <th>Ghi chú</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($hocsinh as $hs)
                                    <tr>
                                        <td>
                                            <strong>{{ $hs->tenhocsinh }}</strong><br>
                                            <small class="text-muted">Mã: {{ $hs->mathe }}</small>
                                            <input type="hidden" name="mahocsinh[]" value="{{ $hs->id }}">
                                        </td>

                                        {{-- Giờ đến --}}
                                        <td>
                                            <input type="time" name="gioden[]" class="form-control gioden">
                                        </td>

                                        {{-- Phút trễ --}}
                                        <td>
                                            <input type="number" name="sophuttre[]" class="form-control sophuttre"
                                                readonly>
                                        </td>

                                        {{-- Checkbox trễ --}}
                                        <td class="text-center">
                                            <input type="checkbox" name="trangthai_{{ $hs->id }}[]" value="trễ"
                                                class="statusCheckbox treCheckbox">
                                        </td>

                                        {{-- Checkbox trạng thái --}}
                                        <td class="text-center">
                                            <input type="checkbox" name="trangthai_{{ $hs->id }}[]" value="có mặt"
                                                class="statusCheckbox">
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox" name="trangthai_{{ $hs->id }}[]" value="vắng mặt"
                                                class="statusCheckbox">
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox" name="trangthai_{{ $hs->id }}[]" value="nghỉ phép"
                                                class="statusCheckbox">
                                        </td>

                                        {{-- Ghi chú --}}
                                        <td>
                                            <input type="text" name="ghichu[]" class="form-control ghichu">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-success px-4">
                        <i class="fas fa-check-circle"></i> Hoàn thành điểm danh
                    </button>
                </div>
            </div>

        </form>
    </div>
@endsection

@section('scripts')
    <script>
        // Giờ bắt đầu của lớp (từ database)
        const gioVaoHoc = '{{ $gioVaoHoc }}';
        const [gioBatDau, phutBatDau] = gioVaoHoc.split(':').map(Number);
        const gioQuyDinh = gioBatDau * 60 + phutBatDau; // Chuyển sang phút

        // Tự tính phút trễ và tick checkbox "Trễ" khi nhập giờ đến
        document.querySelectorAll('.gioden').forEach((input, index) => {
            input.addEventListener('input', function() {
                const value = this.value;
                const sophuttreInput = document.querySelectorAll('.sophuttre')[index];
                const treCheckbox = document.querySelectorAll('.treCheckbox')[index];

                if (value) {
                    const [h, m] = value.split(':').map(Number);
                    const gioDen = h * 60 + m;
                    const soPhutTre = Math.max(0, gioDen - gioQuyDinh);

                    // Cập nhật số phút trễ
                    sophuttreInput.value = soPhutTre;

                    // Tự động tick checkbox "Trễ" nếu đến muộn
                    if (soPhutTre > 0) {
                        treCheckbox.checked = true;
                    } else {
                        treCheckbox.checked = false;
                    }
                } else {
                    sophuttreInput.value = 0;
                    treCheckbox.checked = false;
                }
            });
        });
    </script>
@endsection
