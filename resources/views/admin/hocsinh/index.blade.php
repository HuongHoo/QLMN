@extends('admin.welcome')

@section('content')
    <div class="container-fluid" id="container-wrapper">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Quản lý học sinh</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Học sinh</li>
            </ol>
        </div>

        <div class="row">
            <div class="col-lg-12 mb-4">

                {{-- Hiển thị thông báo --}}
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Danh sách học sinh</h6>
                        <a href="{{ route('admin.hocsinh.create') }}" class="btn btn-primary">Thêm mới</a>
                    </div>

                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th>Mã thẻ</th>
                                    <th>Họ Tên</th>
                                    <th>Ngày sinh</th>
                                    <th>Giới tính</th>
                                    <th>Địa chỉ thường trú</th>
                                    <th>Địa chỉ tạm trú</th>
                                    <th>Lớp</th>
                                    <th>Phụ huynh</th>
                                    <th>Ngày nhập học</th>
                                    <th>Trạng thái</th>
                                    <th>Ảnh</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($hocsinh as $hs)
                                    <tr>
                                        <td>{{ $hs->mathe }}</td>
                                        <td>{{ $hs->tenhocsinh }}</td>
                                        <td>{{ $hs->ngaysinh }}</td>
                                        <td>{{ $hs->gioitinh }}</td>
                                        <td>{{ $hs->diachithuongtru }}</td>
                                        <td>{{ $hs->diachitamtru }}</td>
                                        <td>{{ $hs->lophoc->tenlop ?? '' }}</td>
                                        <td>{{ $hs->phuhuynh->hoten ?? '' }}</td>
                                        <td>{{ $hs->ngaynhaphoc }}</td>
                                        <td>{{ $hs->trangthai }}</td>
                                        <td>
                                            @if ($hs->anh)
                                                <img src="{{ asset('uploads/anh_hocsinh/' . basename($hs->anh)) }}"
                                                    alt="Ảnh học sinh" width="50" height="50">
                                            @else
                                                Chưa có ảnh
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.hocsinh.edit', $hs->id) }}"
                                                class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.hocsinh.destroy', $hs->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Bạn có chắc muốn xóa học sinh này?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Phân trang --}}
                    <div class="card-footer">
                        {{ $hocsinh->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
