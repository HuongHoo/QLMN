@extends('teacher.teacher')

@section('content')
    <div class="col-12">
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-warning text-white">
                <h6 class="m-0 font-weight-bold"><i class="fas fa-edit"></i> Sửa thông tin học sinh</h6>
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

                <form action="{{ route('teacher.hocsinh.update', $hocsinh->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">

                        {{-- Tên học sinh --}}
                        <div class="col-md-6 mb-3">
                            <label for="tenhocsinh">Tên học sinh <span class="text-danger">*</span></label>
                            <input type="text" name="tenhocsinh" id="tenhocsinh" class="form-control"
                                value="{{ old('tenhocsinh', $hocsinh->tenhocsinh) }}" required>
                        </div>

                        {{-- Ngày sinh --}}
                        <div class="col-md-6 mb-3">
                            <label for="ngaysinh">Ngày sinh</label>
                            <input type="date" name="ngaysinh" id="ngaysinh" class="form-control"
                                value="{{ old('ngaysinh', $hocsinh->ngaysinh) }}">
                        </div>

                        {{-- Giới tính --}}
                        <div class="col-md-6 mb-3">
                            <label for="gioitinh">Giới tính</label>
                            <select name="gioitinh" id="gioitinh" class="form-control">
                                <option value="">-- Chọn --</option>
                                <option value="Nam" {{ old('gioitinh', $hocsinh->gioitinh) == 'Nam' ? 'selected' : '' }}>
                                    Nam
                                </option>
                                <option value="Nữ" {{ old('gioitinh', $hocsinh->gioitinh) == 'Nữ' ? 'selected' : '' }}>
                                    Nữ
                                </option>
                            </select>
                        </div>

                        {{-- Phụ huynh --}}
                        <div class="col-md-6 mb-3">
                            <label for="maphuhuynh">Phụ huynh</label>
                            <select name="maphuhuynh" id="maphuhuynh" class="form-control">
                                <option value="">-- Chọn phụ huynh --</option>
                                @foreach ($phuhuynh as $ph)
                                    <option value="{{ $ph->id }}"
                                        {{ old('maphuhuynh', $hocsinh->maphuhuynh) == $ph->id ? 'selected' : '' }}>
                                        {{ $ph->tenphuhuynh }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Địa chỉ thường trú --}}
                        <div class="col-md-6 mb-3">
                            <label for="diachithuongtru">Địa chỉ thường trú</label>
                            <input type="text" name="diachithuongtru" id="diachithuongtru" class="form-control"
                                value="{{ old('diachithuongtru', $hocsinh->diachithuongtru) }}">
                        </div>

                        {{-- Địa chỉ tạm trú --}}
                        <div class="col-md-6 mb-3">
                            <label for="diachitamtru">Địa chỉ tạm trú</label>
                            <input type="text" name="diachitamtru" id="diachitamtru" class="form-control"
                                value="{{ old('diachitamtru', $hocsinh->diachitamtru) }}">
                        </div>

                        {{-- Ghi chú sức khỏe --}}
                        <div class="col-md-12 mb-3">
                            <label for="ghichusuckhoe">Ghi chú sức khỏe</label>
                            <textarea name="ghichusuckhoe" id="ghichusuckhoe" rows="3" class="form-control"
                                placeholder="Nhập ghi chú về sức khỏe (dị ứng, bệnh lý...)">{{ old('ghichusuckhoe', $hocsinh->ghichusuckhoe) }}</textarea>
                        </div>

                        {{-- Ảnh --}}
                        <div class="col-md-12 mb-3">
                            <label for="anh">Ảnh học sinh</label>
                            <input type="file" name="anh" id="anh" class="form-control" accept="image/*">
                            @if (!empty($hocsinh->anh))
                                <div class="mt-2">
                                    <img src="{{ asset($hocsinh->anh) }}" alt="avatar" class="img-thumbnail"
                                        style="width: 150px; height: 150px; object-fit: cover;">
                                </div>
                            @endif
                        </div>

                    </div>

                    <div class="text-right mt-3">
                        <button type="submit" class="btn btn-warning shadow-sm px-4">
                            <i class="fas fa-save"></i> Cập nhật
                        </button>
                        <a href="{{ route('teacher.hocsinh.index') }}" class="btn btn-secondary shadow-sm px-4">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
