@extends('admin.welcome')

@section('content')
    <div class="container-fluid" id="container-wrapper">
        <!-- Tiêu đề + breadcrumb -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Quản lý người dùng</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Người dùng</li>
            </ol>
        </div>

        <div class="row">
            <div class="col-lg-12 mb-4">

                {{-- Thông báo thành công --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                {{-- Thông báo lỗi --}}
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger shadow-sm">
                        <ul class="mb-0 pl-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card shadow-lg border-0 rounded-lg">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold"><i class="fas fa-users"></i> Danh sách người dùng</h6>
                        <a href="{{ route('admin.nguoidung.create') }}" class="btn btn-light btn-sm shadow-sm">
                            <i class="fas fa-user-plus"></i> Thêm mới
                        </a>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table align-items-center table-hover mb-0">
                                <thead class="thead-light">
                                    <tr class="text-center">
                                        <th>#</th>
                                        <th>Họ tên</th>
                                        <th>Email</th>
                                        <th>Vai trò</th>
                                        <th>Trạng thái</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($users as $user)
                                        <tr class="text-center align-middle">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                @if ($user->vaitro === 'admin')
                                                    <span class="badge badge-danger px-2 py-1">Admin</span>
                                                @elseif ($user->vaitro === 'teacher')
                                                    <span class="badge badge-primary px-2 py-1">Giáo viên</span>
                                                @else
                                                    <span class="badge badge-secondary px-2 py-1">Phụ huynh</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($user->trangthai === 'hoatdong')
                                                    <span class="badge badge-success px-2 py-1">Hoạt động</span>
                                                @else
                                                    <span class="badge badge-warning px-2 py-1">Khóa</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.nguoidung.edit', $user->id) }}"
                                                    class="btn btn-sm btn-warning shadow-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>

                                                <form action="{{ route('admin.nguoidung.destroy', $user->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger shadow-sm"
                                                        onclick="return confirm('Bạn có chắc muốn xóa người dùng này?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-3">
                                                <i class="fas fa-info-circle"></i> Chưa có người dùng nào.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    @if (method_exists($users, 'links'))
                        <div class="card-footer d-flex justify-content-center">
                            {{ $users->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Auto-hide alert -->
    <script>
        setTimeout(() => {
            const alert = document.querySelector('.alert');
            if (alert) {
                alert.classList.remove('show');
                alert.classList.add('fade');
            }
        }, 3000);
    </script>
@endsection
