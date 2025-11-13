@extends('admin.welcome')

@section('content')
    <div class="container-fluid" id="container-wrapper">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Quản lý giáo viên</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Giáo viên</li>
            </ol>
        </div>

        <div class="row">
            <div class="col-lg-12 mb-4">
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
                        <h6 class="m-0 font-weight-bold text-primary">Danh sách giáo viên</h6>
                        <a href="{{ route('admin.giaovien.create') }}" class="btn btn-primary">Thêm mới</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    {{-- <th>ID</th> --}}
                                    <th>Số thẻ</th>
                                    <th>Họ Tên</th>
                                    <th>Ngày sinh</th>
                                    {{-- <th>Giới tính</th> --}}
                                    <th>SĐT</th>
                                    <th>Email</th>
                                    {{-- <th>Địa chỉ thường trú</th> --}}
                                    {{-- <th>Địa chỉ tạm trú</th> --}}
                                    {{-- <th>Chức vụ</th> --}}
                                    <th>Tên lớp</th>
                                    <th>Ngày vào làm</th>
                                    {{-- <th>Trạng thái</th> --}}
                                    <th>Ảnh</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($giaovien as $gv)
                                    <tr>
                                        {{-- <td>{{ $gv->id }}</td> --}}
                                        <td>{{ $gv->sothe }}</td>
                                        <td>{{ $gv->tengiaovien }}</td>
                                        <td>{{ $gv->ngaysinh }}</td>
                                        {{-- <td>{{ $gv->gioitinh }}</td> --}}
                                        <td>{{ $gv->sdt }}</td>
                                        <td>{{ $gv->email }}</td>
                                        {{-- <td>{{ $gv->diachithuongtru }}</td> --}}
                                        {{-- <td>{{ $gv->diachitamtru }}</td> --}}
                                        {{-- <td>{{ $gv->chucvu }}</td> --}}
                                        <td>{{ $gv->lophoc->tenlop ?? '' }}</td>

                                        <td>{{ $gv->ngayvaolam }}</td>
                                        {{-- <td>{{ $gv->trangthai }}</td> --}}
                                        <td>
                                            @if ($gv->anh)
                                                <img src="{{ asset('storage/' . $gv->anh) }}" alt="Ảnh giáo viên"
                                                    width="50" height="50">
                                            @else
                                                Chưa có ảnh
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.giaovien.edit', $gv->id) }}"
                                                class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.giaovien.destroy', $gv->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Bạn có chắc muốn xóa?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    {{ $giaovien->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
