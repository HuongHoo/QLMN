<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('public/storage/logo.jpg') }}" rel="icon">
    <title>MN Ánh Sao</title>
    <link href="{{ asset('admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('admin/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('admin/css/ruang-admin.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/css/admin-custom.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

</head>

<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <x-layouts.sidebar />
        <!-- Sidebar -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- TopBar -->
                <nav class="navbar navbar-expand navbar-light topbar mb-4 static-top"
                    style="background: #fff; border-bottom: 1px solid #e5e7eb;">
                    <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <span class="badge bg-light text-dark border px-3 py-2" style="font-size: 0.9rem;">ADMIN</span>

                    <ul class="navbar-nav ml-auto d-flex align-items-center">
                        <!-- Real-time Clock -->
                        <li class="nav-item mr-3">
                            <span id="realtime-clock" class="text-dark" style="font-size: 0.95rem;"></span>
                        </li>

                        <!-- User Email -->
                        <li class="nav-item mr-3">
                            <span class="text-muted"
                                style="font-size: 0.9rem;">{{ Auth::user()->email ?? 'admin@gmail.com' }}</span>
                        </li>
                        <!-- Logout Button -->
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-outline-dark btn-sm">
                                    <i class="fas fa-sign-out-alt me-1"></i> Đăng xuất
                                </button>
                            </form>
                        </li>
                    </ul>
                </nav>

                <!-- Real-time Clock Script -->
                <script>
                    function updateClock() {
                        const now = new Date();
                        const hours = String(now.getHours()).padStart(2, '0');
                        const minutes = String(now.getMinutes()).padStart(2, '0');
                        const seconds = String(now.getSeconds()).padStart(2, '0');
                        document.getElementById('realtime-clock').textContent = `${hours}:${minutes}:${seconds}`;
                    }
                    setInterval(updateClock, 1000);
                    updateClock();
                </script>
                <!-- Topbar -->

                <!-- Container Fluid-->
                <div class="container-fluid" id="container-wrapper">
                    <!-- <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
          </div> -->

                    <div class="row mb-3">
                        <!-- Earnings (Monthly) Card Example -->
                        @yield('content')
                        <!-- Earnings (Annual) Card Example -->

                        <!-- New User Card Example -->



                        <!-- Area Chart -->

                        <!-- Pie Chart -->


                        <!-- Invoice Example -->

                        <!--Row-->


                        <!-- Modal Logout -->
                        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabelLogout" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabelLogout">Ohh No!</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are you sure you want to logout?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-primary"
                                            data-dismiss="modal">Cancel</button>
                                        <a href="login.html" class="btn btn-primary">Logout</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!---Container Fluid-->
                </div>
                <!-- Footer -->
                <footer class="sticky-footer bg-white">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                            <!-- <span> &copy; <script>
                                document.write(new Date().getFullYear());
                            </script>
              <b><a href="https://indrijunanda.gitlab.io/" target="_blank"></a></b>
            </span> -->
                        </div>
                    </div>

                    <div class="container my-auto py-2">
                        <div class="copyright text-center my-auto">
                            <!-- <span> &copy; <script>
                                document.write(new Date().getFullYear());
                            </script>
              <b><a href="https://themewagon.com/" target="_blank"></a></b>
            </span> -->
                        </div>
                    </div>
                </footer>
                <!-- Footer -->
            </div>
        </div>

        <!-- Scroll to top -->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>

        <script src="{{ asset('admin/vendor/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('admin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
        <script src="{{ asset('admin/js/ruang-admin.min.js') }}"></script>
        <script src="{{ asset('admin/vendor/chart.js/Chart.min.js') }}"></script>
        <script src="{{ asset('admin/js/demo/chart-area-demo.js') }}"></script>
</body>

</html>
