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
            --primary-purple: #667eea;
            --primary-purple-dark: #764ba2;
            --accent-orange: #ff6b35;
            --accent-orange-dark: #e55a2b;
        }

        /* === Header chỉnh lại === */
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 12px 0;
            box-shadow: 0 4px 15px rgba(139, 92, 246, 0.3);
        }

        .logo img {
            height: 40px;
        }

        .navmenu ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            gap: 24px;
        }

        .navmenu a {
            color: #fff;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s;
            padding: 8px 12px;
            border-radius: 8px;
        }

        .navmenu a:hover {
            color: #ff6b35;
            background: rgba(255, 255, 255, 0.1);
        }

        .navmenu a.active {
            color: #fff;
            background: rgba(255, 107, 53, 0.3);
            border-bottom: 2px solid #ff6b35;
        }

        .user-info .btn {
            border: 1px solid #fff;
            color: #fff;
        }

        .user-info .btn:hover {
            background-color: #ff6b35;
            border-color: #ff6b35;
            color: #fff;
        }

        /* === Welcome Card === */
        .welcome-card,
        .card.bg-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(139, 92, 246, 0.3);
        }

        /* === Stats Cards === */
        .stats-card {
            border-radius: 15px;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .stats-card.purple {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .stats-card.green {
            background: linear-gradient(135deg, #28a745 0%, #34ce57 100%);
        }

        .stats-card.orange {
            background: linear-gradient(135deg, #ff6b35 0%, #ff8c5a 100%);
        }

        .stats-card.yellow {
            background: linear-gradient(135deg, #ffc107 0%, #ffca2c 100%);
        }

        /* === Quick Access Cards === */
        .quick-access-item {
            border-radius: 12px;
            transition: all 0.3s ease;
            border: none;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
        }

        .quick-access-item:hover {
            transform: translateX(5px);
            box-shadow: 0 5px 20px rgba(139, 92, 246, 0.2);
        }

        .quick-access-item .icon-box {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .quick-access-item .icon-box.purple {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .quick-access-item .icon-box.green {
            background: linear-gradient(135deg, #28a745 0%, #34ce57 100%);
        }

        .quick-access-item .icon-box.orange {
            background: linear-gradient(135deg, #ff6b35 0%, #ff8c5a 100%);
        }

        .quick-access-item .icon-box.yellow {
            background: linear-gradient(135deg, #ffc107 0%, #ffca2c 100%);
        }

        .quick-access-item .icon-box.red {
            background: linear-gradient(135deg, #dc3545 0%, #e4606d 100%);
        }

        /* === Buttons === */
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            box-shadow: 0 4px 15px rgba(139, 92, 246, 0.3);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #ff6b35 0%, #ff8c5a 100%);
            box-shadow: 0 4px 15px rgba(255, 107, 53, 0.3);
        }

        .btn-outline-primary {
            border-color: #667eea;
            color: #667eea;
        }

        .btn-outline-primary:hover {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-color: #667eea;
        }

        /* === Cards General === */
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        }

        .card-header {
            background: transparent;
            border-bottom: 1px solid #eee;
        }

        .card-header h5,
        .card-header h6 {
            color: #667eea;
            font-weight: 600;
        }

        /* === Badge === */
        .badge.bg-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        }

        .badge.bg-warning {
            background: linear-gradient(135deg, #ff6b35 0%, #ff8c5a 100%) !important;
            color: #fff !important;
        }

        /* === Notification Dropdown === */
        .dropdown-menu {
            border: none;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
        }

        .dropdown-item:hover {
            background: rgba(139, 92, 246, 0.1);
            color: #667eea;
        }

        .notification {
            position: absolute;
            top: -5px;
            right: -5px;
            font-size: 10px;
            background: #ff6b35;
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
            color: #667eea;
            transition: color 0.3s;
        }

        a:hover {
            color: #ff6b35;
        }

        /* === Welcome Banner === */
        .welcome-banner {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px;
            padding: 25px 30px;
            box-shadow: 0 10px 30px rgba(139, 92, 246, 0.3);
        }

        /* === Stat Cards === */
        .stat-card {
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        }

        .stat-card.bg-success {
            background: linear-gradient(135deg, #28a745 0%, #34ce57 100%) !important;
        }

        .stat-card.bg-warning {
            background: linear-gradient(135deg, #ff6b35 0%, #ff8c5a 100%) !important;
        }

        .stat-card.bg-info {
            background: linear-gradient(135deg, #17a2b8 0%, #5bc0de 100%) !important;
        }

        /* === Quick Access List === */
        .quick-access-list .list-group-item {
            border: none;
            border-radius: 12px !important;
            margin-bottom: 10px;
            padding: 15px 20px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .quick-access-list .list-group-item:hover {
            transform: translateX(5px);
            box-shadow: 0 5px 15px rgba(139, 92, 246, 0.15);
            background: rgba(139, 92, 246, 0.03);
        }

        .quick-access-list .icon-circle {
            width: 45px;
            height: 45px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
        }

        .quick-access-list .icon-circle.bg-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        }

        .quick-access-list .icon-circle.bg-success {
            background: linear-gradient(135deg, #28a745 0%, #34ce57 100%) !important;
        }

        .quick-access-list .icon-circle.bg-warning {
            background: linear-gradient(135deg, #ff6b35 0%, #ff8c5a 100%) !important;
        }

        .quick-access-list .icon-circle.bg-info {
            background: linear-gradient(135deg, #17a2b8 0%, #5bc0de 100%) !important;
        }

        .quick-access-list .icon-circle.bg-danger {
            background: linear-gradient(135deg, #dc3545 0%, #e4606d 100%) !important;
        }

        /* === Footer Custom === */
        .footer-custom {
            background: linear-gradient(180deg, #1a1a2e 0%, #16213e 100%);
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
            color: #ff6b35;
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
            color: #667eea;
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
            background: linear-gradient(135deg, #ff6b35 0%, #ff8c5a 100%) !important;
            border-radius: 50%;
        }

        .scroll-top:hover {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
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
                            <span class="notification text-danger">{{ $thongbaos->count() }}</span>
                        </a>
                        <div class="dropdown-menu notif-box animated fadeIn p-3" aria-labelledby="notifDropdown"
                            style="width: 400px;">

                            <div class="dropdown-title">
                                Bạn có {{ $thongbaos->count() }} thông báo
                            </div>

                            @foreach ($thongbaos as $thongbao)
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-dark" href="#">
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
                            <span class="me-3 text-white fw-semibold">Xin chào,
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

    {{-- Chatbox Component --}}
    @include('components.chatbox')

</body>

</html>
