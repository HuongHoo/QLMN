@extends('admin.welcome')

@section('content')
    <div class="container-fluid" id="container-wrapper">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Quản lý phụ huynh</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Phụ huynh</li>
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
                        <h6 class="m-0 font-weight-bold text-primary">Danh sách phụ huynh</h6>
                        <a href="{{ route('admin.phuhuynh.create') }}" class="btn btn-primary">Thêm mới</a>
                    </div>

                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Tên phụ huynh</th>
                                    <th>Quan hệ</th>
                                    <th>SĐT</th>
                                    <th>Email</th>
                                    <th>Địa chỉ thường trú</th>
                                    <th>Địa chỉ tạm trú</th>
                                    <th>Nghề nghiệp</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($phuhuynh as $ph)
                                    <tr>
                                        <td>{{ $ph->id }}</td>
                                        <td>{{ $ph->hoten }}</td>
                                        <td>{{ $ph->quanhe }}</td>
                                        <td>{{ $ph->sdt }}</td>
                                        <td>{{ $ph->email }}</td>
                                        <td>{{ $ph->diachithuongtru }}</td>
                                        <td>{{ $ph->diachitamtru }}</td>
                                        <td>{{ $ph->nghenghiep }}</td>
                                        <td>
                                            <a href="{{ route('admin.phuhuynh.edit', $ph->id) }}"
                                                class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.phuhuynh.destroy', $ph->id) }}" method="POST"
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

                    <div class="card-footer">
                        {{ $phuhuynh->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
