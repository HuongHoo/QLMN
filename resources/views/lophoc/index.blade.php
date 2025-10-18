@extends('admin.welcome')

@section('content')
<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Quản lý lớp học</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Lớp học</li>
        </ol>
    </div>

    <div class="row">
        <div class="col-lg-12 mb-4">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
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
                    <h6 class="m-0 font-weight-bold text-primary">Danh sách lớp học</h6>
                    <a href="{{ route('lophoc.create') }}" class="btn btn-primary">Thêm mới</a>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th>ID</th>
                                <th>Tên lớp</th>
                                <th>Nhóm tuổi</th>
                                <th>Sĩ số</th>
                                <th>Số phòng</th>
                                <th>Niên khóa</th>
                                <th>Ghi chú</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lophoc as $lop)
                            <tr>
                                <td>{{ $lop->id }}</td>
                                <td>{{ $lop->tenlop }}</td>
                                <td>{{ $lop->nhomtuoi }}</td>
                                <td>{{ $lop->siso }}</td>
                                <td>{{ $lop->sophong }}</td>
                                <td>{{ $lop->nienkhoa }}</td>
                                <td>{{ $lop->ghichu }}</td>
                                <td>
                                    <a href="{{ route('lophoc.index', $lop->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('lophoc.index', $lop->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa?')">
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
                {{ $lophoc->links() }}
            </div>
        </div>
    </div>
</div>
@endsection