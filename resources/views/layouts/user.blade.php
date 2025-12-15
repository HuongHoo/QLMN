<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Phụ huynh</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicons -->
    <link href="{{ asset('user/assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('user/assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Poppins:wght@400;500;600&family=Raleway:wght@400;500;700&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('user/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('user/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('user/assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('user/assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('user/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('user/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="{{ asset('user/assets/css/main.css') }}" rel="stylesheet">

    <style>
        :root {
            --primary-color: #1a1a2e;
            --text-color: #1f2937;
            --text-muted: #6b7280;
            --border-color: #e5e7eb;
            --bg-light: #f9fafb;
            --bg-white: #ffffff;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
        }

        /* === Header - CLEAN WHITE === */
        .header {
            background: var(--bg-white);
            padding: 12px 0;
            box-shadow: 0 1px 0 0 var(--border-color);
            border-bottom: 1px solid var(--border-color);
        }

        .logo img {
            height: 40px;
        }

        .navmenu ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            gap: 8px;
        }

        .navmenu a {
            color: var(--text-color);
            text-decoration: none;
            font-weight: 500;
            font-size: 1rem;
            transition: all 0.15s ease;
            padding: 10px 16px;
            border-radius: 8px;
        }

        .navmenu a:hover {
            color: var(--text-color);
            background: var(--bg-light);
        }

        .navmenu a.active {
            color: #fff;
            background: var(--primary-color);
            border-bottom: none;
        }

        .user-info .btn {
            border: 1px solid var(--border-color);
            color: var(--text-color);
        }

        .user-info .btn:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: #fff;
        }

        /* === Welcome Card === */
        .welcome-card,
        .card.bg-primary {
            background: var(--primary-color) !important;
            border-radius: 12px;
            box-shadow: none;
            border: 1px solid var(--border-color);
        }

        /* === Stats Cards - MINIMAL === */
        .stats-card {
            border-radius: 12px;
            transition: all 0.15s ease;
            box-shadow: none;
            border: 1px solid var(--border-color);
        }

        .stats-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .stats-card.purple {
            background: var(--bg-white);
            border-left: 3px solid var(--primary-color);
        }

        .stats-card.green {
            background: var(--bg-white);
            border-left: 3px solid var(--success-color);
        }

        .stats-card.orange {
            background: var(--bg-white);
            border-left: 3px solid var(--warning-color);
        }

        .stats-card.yellow {
            background: var(--bg-white);
            border-left: 3px solid var(--warning-color);
        }

        /* === Quick Access Cards === */
        .quick-access-item {
            border-radius: 12px;
            transition: all 0.15s ease;
            border: 1px solid var(--border-color);
            box-shadow: none;
        }

        .quick-access-item:hover {
            transform: translateX(3px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        .quick-access-item .icon-box {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .quick-access-item .icon-box.purple {
            background: var(--primary-color);
        }

        .quick-access-item .icon-box.green {
            background: var(--success-color);
        }

        .quick-access-item .icon-box.orange {
            background: var(--warning-color);
        }

        .quick-access-item .icon-box.yellow {
            background: var(--warning-color);
        }

        .quick-access-item .icon-box.red {
            background: var(--danger-color);
        }

        /* === Buttons - MINIMAL === */
        .btn-primary {
            background: var(--primary-color);
            border: none;
            box-shadow: none;
        }

        .btn-primary:hover {
            background: #2d2d44;
            box-shadow: none;
        }

        .btn-outline-primary {
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        .btn-outline-primary:hover {
            background: var(--primary-color);
            border-color: var(--primary-color);
        }

        /* === Cards General === */
        .card {
            border: 1px solid var(--border-color);
            border-radius: 12px;
            box-shadow: none;
        }

        .card-header {
            background: transparent;
            border-bottom: 1px solid var(--border-color);
        }

        .card-header h5,
        .card-header h6 {
            color: var(--primary-color);
            font-weight: 600;
        }

        /* === Badge === */
        .badge.bg-primary {
            background: var(--primary-color) !important;
        }

        .badge.bg-warning {
            background: var(--warning-color) !important;
            color: #fff !important;
        }

        /* === Notification Dropdown === */
        .dropdown-menu {
            border: 1px solid var(--border-color);
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .dropdown-item:hover {
            background: var(--bg-light);
            color: var(--primary-color);
        }

        .notification {
            position: absolute;
            top: -5px;
            right: -5px;
            font-size: 10px;
            background: var(--danger-color);
            color: #fff;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* === Links === */
        a {
            color: var(--primary-color);
            transition: color 0.15s;
        }

        a:hover {
            color: #2d2d44;
        }

        /* === Welcome Banner === */
        .welcome-banner {
            background: var(--primary-color);
            border-radius: 12px;
            padding: 25px 30px;
            box-shadow: none;
            border: 1px solid var(--border-color);
        }

        /* === Stat Cards === */
        .stat-card {
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            transition: all 0.15s ease;
            box-shadow: none;
            border: 1px solid var(--border-color);
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .stat-card i {
            font-size: 1.5rem;
            margin-bottom: 10px;
        }

        .stat-card .stat-number {
            font-size: 1.8rem;
            font-weight: 700;
        }

        .stat-card .stat-label {
            font-size: 0.85rem;
            opacity: 0.9;
        }

        .stat-card.bg-primary {
            background: var(--primary-color) !important;
        }

        .stat-card.bg-success {
            background: var(--success-color) !important;
        }

        .stat-card.bg-warning {
            background: var(--warning-color) !important;
        }

        .stat-card.bg-info {
            background: #3b82f6 !important;
        }

        /* === Quick Access List === */
        .quick-access-list .list-group-item {
            border: 1px solid var(--border-color);
            border-radius: 10px !important;
            margin-bottom: 10px;
            padding: 15px 20px;
            transition: all 0.15s ease;
            box-shadow: none;
        }

        .quick-access-list .list-group-item:hover {
            transform: translateX(3px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            background: var(--bg-light);
        }

        .quick-access-list .icon-circle {
            width: 45px;
            height: 45px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
        }

        .quick-access-list .icon-circle.bg-primary {
            background: var(--primary-color) !important;
        }

        .quick-access-list .icon-circle.bg-success {
            background: var(--success-color) !important;
        }

        .quick-access-list .icon-circle.bg-warning {
            background: var(--warning-color) !important;
        }

        .quick-access-list .icon-circle.bg-info {
            background: #3b82f6 !important;
        }

        .quick-access-list .icon-circle.bg-danger {
            background: var(--danger-color) !important;
        }

        /* === Footer Custom === */
        .footer-custom {
            background: var(--primary-color);
            padding: 60px 0 30px;
            color: #fff;
        }

        .footer-brand {
            color: #fff;
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .footer-desc {
            color: rgba(255, 255, 255, 0.6);
            line-height: 1.8;
            margin-bottom: 20px;
        }

        .footer-custom .social-icons {
            display: flex;
            gap: 12px;
        }

        .footer-custom .social-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 1px solid rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            transition: all 0.3s ease;
        }

        .footer-custom .social-icon:hover {
            background: #4e73df;
            border-color: transparent;
            transform: translateY(-3px);
        }

        .footer-title {
            color: #fff;
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 20px;
            position: relative;
        }

        .footer-title::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -8px;
            width: 30px;
            height: 2px;
            background: #4e73df;
        }

        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-links li {
            margin-bottom: 12px;
        }

        .footer-links a {
            color: rgba(255, 255, 255, 0.6);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .footer-links a:hover {
            color: #4e73df;
            padding-left: 5px;
        }

        .footer-contact {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-contact li {
            color: rgba(255, 255, 255, 0.6);
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .footer-contact i {
            color: #4e73df;
            width: 20px;
        }

        .footer-hours {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-hours li {
            color: rgba(255, 255, 255, 0.6);
            margin-bottom: 12px;
        }

        .footer-divider {
            border-color: rgba(255, 255, 255, 0.1);
            margin: 40px 0 20px;
        }

        .footer-copyright {
            text-align: center;
            color: rgba(255, 255, 255, 0.5);
        }

        /* === Scroll to Top === */
        .scroll-top {
            background: #4e73df !important;
            border-radius: 50%;
        }

        .scroll-top:hover {
            background: #4e73df !important;
        }
    </style>
</head>

<body class="index-page">

    <!-- ======= Header ======= -->
    <header id="header" class="header sticky-top">
        <div class="container d-flex align-items-center justify-content-between">

            <!-- Logo -->
            <a href="{{ url('/') }}" class="logo d-flex align-items-center">
                <img src="{{ asset('user/assets/img/logo.png') }}" alt="Logo" class="me-2">
                <!-- <h1 class="sitename">Medicio</h1> -->
            </a>

            <!-- Navigation -->
            <nav id="navmenu" class="navmenu d-flex align-items-center">
                <ul class="d-flex align-items-center mb-0">
                    <li><a href="{{ route('parent.home') }}"
                            class="{{ request()->routeIs('parent.home') ? 'active' : '' }}">Trang chủ</a></li>
                    <li><a href="{{ route('parent.thongtinbe') }}"
                            class="{{ request()->routeIs('parent.thongtinbe', 'parent.chitietbe') ? 'active' : '' }}">Thông
                            tin bé</a></li>
                    <li><a href="{{ route('parent.diemdanh') }}"
                            class="{{ request()->routeIs('parent.diemdanh') ? 'active' : '' }}">Điểm danh</a></li>
                    <li><a href="{{ route('parent.hocphi') }}"
                            class="{{ request()->routeIs('parent.hocphi') ? 'active' : '' }}">Học phí</a></li>
                    <li><a href="{{ route('parent.danhgia') }}"
                            class="{{ request()->routeIs('parent.danhgia') ? 'active' : '' }}">Đánh giá</a></li>
                    <li><a href="{{ route('parent.suckhoe') }}"
                            class="{{ request()->routeIs('parent.suckhoe') ? 'active' : '' }}">Sức khỏe</a></li>
                    <li class="dropdown">
                        <a class="nav-link dropdown-toggle" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="fs-6 fa fa-bell"></i>
                            <span
                                class="notification badge text-danger">{{ $userThongbaos->where('is_read', 0)->count() }}</span>
                        </a>
                        <div class="dropdown-menu notif-box animated fadeIn p-3" aria-labelledby="notifDropdown"
                            style="width: 400px;">

                            <div class="dropdown-title">
                                Bạn có {{ $userThongbaos->count() }} thông báo
                            </div>

                            @foreach ($userThongbaos as $thongbao)
                                <div class="dropdown-divider"></div>
                                <a data-id="{{ $thongbao->id }}" onclick="showNotificationDetail({{ $thongbao->id }})"
                                    class="dropdown-item text-dark">
                                    <div class="notification-content d-flex align-items-center">
                                        <div class="icon me-3">
                                            <i class="fs-6 fa fa-bell"></i>
                                        </div>
                                        <div class="content">
                                            <div class="notification-title">
                                                {{ $thongbao->tieude }}
                                            </div>
                                            <div class="notification-time">
                                                {{ $thongbao->created_at->locale('vi')->diffForHumans() }}
                                            </div>
                                        </div>
                                        @if ($thongbao->is_read == 0)
                                            <div class="ms-2">
                                                <i class="fs-6 fa-solid fa-circle-exclamation text-danger"></i>
                                            </div>
                                        @endif
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </li>
                    <li class="dropdown">
                        <a class="nav-link dropdown-toggle" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <span class="me-3 text-black fw-semibold">Xin chào,
                                {{ Auth::user()->name ?? 'parent' }}</span>
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item text-dark" href="#">Thông tin cá nhân</a>
                            <form method="POST" action="{{ route('logout') }}" class="m-0">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">Đăng
                                    xuất</button>
                            </form>
                        </div>
                    </li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>

            <!-- Hộp thông báo chi tiết -->
            <div id="notificationDetail" class="p-4 border rounded shadow-lg bg-white col-10 col-md-6 col-lg-4"
                style="z-index:2000; display: none; transition: all 0.3s ease; position: fixed; top: 10%; left: 50%; transform: translateX(-50%);">

                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="d-flex align-items-center">
                        <i class="fa-solid fa-bell fa-lg text-primary me-2"></i>
                        <h5 id="notificationDetailTitle" class="mb-0 fw-bold">Chi tiết thông báo</h5>
                    </div>
                </div>

                <p id="notificationDetailContent" class="text-secondary mb-2"></p>

                <div class="text-end">
                    <small id="notificationDetailTime" class="text-muted">
                        <i class="fa-regular fa-clock me-1"></i>
                    </small>
                </div>
            </div>

            <script>
                // Hàm hiển thị chi tiết thông báo
                function showNotificationDetail(id) {
                    fetch("{{ url('/nguoidung/thongbaodetail') }}" + "/" + id) // route Laravel trả về JSON
                        .then(response => response.json())
                        .then(data => {
                            document.getElementById('notificationDetail').style.display = 'block';
                            document.getElementById('notificationDetailTitle').innerText = data.title || 'Thông báo';
                            document.getElementById('notificationDetailContent').innerText = data.content ||
                                '(Không có nội dung)';
                            document.getElementById('notificationDetailTime').innerText = data.created_at;

                            // Hiển thị box & overlay
                            document.getElementById('notificationDetail').style.display = 'block';
                            document.getElementById('notificationOverlay').style.display = 'block';
                        });
                }

                document.addEventListener('click', function(event) {
                    const detailBox = document.getElementById('notificationDetail');
                    const overlay = document.getElementById('notificationOverlay');

                    // Nếu box đang hiển thị và click nằm ngoài box
                    if (detailBox.style.display === 'block' && !detailBox.contains(event.target)) {
                        detailBox.style.display = 'none';
                        overlay.style.display = 'none';
                    }
                });
            </script>
        </div>
    </header>
    <!-- End Header -->

    <!-- ======= Main Content ======= -->
    @yield('content')

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer-custom">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h5 class="footer-brand"><i class="fas fa-graduation-cap me-2"></i>MN Ánh Sao</h5>
                    <p class="footer-desc">Nơi ươm mầm những tài năng nhỏ, nuôi dưỡng tình yêu thương và phát triển
                        toàn diện cho trẻ.</p>
                    <div class="social-icons">
                        <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-youtube"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h5 class="footer-title">Liên kết</h5>
                    <ul class="footer-links">
                        <li><a href="{{ route('parent.home') }}">Trang chủ</a></li>
                        <li><a href="{{ route('parent.thongtinbe') }}">Thông tin bé</a></li>
                        <li><a href="{{ route('parent.diemdanh') }}">Điểm danh</a></li>
                        <li><a href="{{ route('parent.hocphi') }}">Học phí</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="footer-title">Liên hệ</h5>
                    <ul class="footer-contact">
                        <li><i class="fas fa-map-marker-alt"></i>123 Đường ABC, TP.HCM</li>
                        <li><i class="fas fa-phone"></i>0123 456 789</li>
                        <li><i class="fas fa-envelope"></i>info@anhsao.edu.vn</li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="footer-title">Giờ làm việc</h5>
                    <ul class="footer-hours">
                        <li>Thứ 2 - Thứ 6: 7:00 - 17:30</li>
                        <li>Thứ 7: 7:00 - 11:30</li>
                        <li>Chủ nhật: Nghỉ</li>
                    </ul>
                </div>
            </div>
            <hr class="footer-divider">
            <div class="footer-copyright">
                <small>© 2024 Trường Mầm Non Ánh Sao. All rights reserved.</small>
            </div>
        </div>
    </footer>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center">
        <i class="bi bi-arrow-up-short"></i>
    </a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="{{ asset('user/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('user/assets/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('user/assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('user/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('user/assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
    <script src="{{ asset('user/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>

    <!-- Main JS File -->
    <script src="{{ asset('user/assets/js/main.js') }}"></script>

    {{-- Chat with Teacher Component --}}
    @include('components.parent-chat')

</body>

</html>
