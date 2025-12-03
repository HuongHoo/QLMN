<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Trường Mầm Non Ánh Sao</title>
    <meta name="description" content="Trường Mầm Non Ánh Sao - Nơi ươm mầm tài năng">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Poppins:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --primary-color: #ff6b35;
            --secondary-color: #004e89;
            --dark-color: #1a1a2e;
        }

        body {
            font-family: 'Poppins', sans-serif;
        }

        /* Header */
        .navbar-guest {
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 15px 0;
        }

        .navbar-guest .nav-link {
            color: #333;
            font-weight: 500;
            padding: 8px 16px;
            transition: color 0.3s;
        }

        .navbar-guest .nav-link:hover,
        .navbar-guest .nav-link.active {
            color: var(--primary-color);
        }

        .btn-login {
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            padding: 8px 24px;
            border-radius: 25px;
            font-weight: 500;
            transition: all 0.3s;
        }

        .btn-login:hover {
            background: var(--primary-color);
            color: white;
        }

        .btn-register {
            background: var(--primary-color);
            color: white;
            padding: 8px 24px;
            border-radius: 25px;
            font-weight: 500;
            border: 2px solid var(--primary-color);
            transition: all 0.3s;
        }

        .btn-register:hover {
            background: #e55a2b;
            border-color: #e55a2b;
            color: white;
        }

        .logo-text {
            font-size: 28px;
            font-weight: 700;
            color: var(--primary-color);
        }

        /* Hero Section */
        .hero-section {
            position: relative;
            min-height: 600px;
            display: flex;
            align-items: center;
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),
                url('{{ asset('user/assets/img/hero-carousel/anhmn2.png') }}') center/cover no-repeat;
        }

        .hero-section h1 {
            font-size: 48px;
            font-weight: 700;
            color: white;
            margin-bottom: 20px;
        }

        .hero-section p {
            font-size: 18px;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 30px;
        }

        .btn-explore {
            background: var(--primary-color);
            color: white;
            padding: 14px 32px;
            border-radius: 30px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
        }

        .btn-explore:hover {
            background: #e55a2b;
            color: white;
            transform: translateY(-2px);
        }

        .btn-contact {
            background: transparent;
            color: white;
            padding: 14px 32px;
            border-radius: 30px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            border: 2px solid white;
            transition: all 0.3s;
        }

        .btn-contact:hover {
            background: white;
            color: var(--dark-color);
        }

        /* Sections */
        .section-title {
            font-size: 36px;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 15px;
        }

        .section-subtitle {
            color: #666;
            font-size: 16px;
            margin-bottom: 40px;
        }

        /* Feature Cards */
        .feature-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 30px rgba(0, 0, 0, 0.08);
            transition: all 0.3s;
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .feature-icon {
            width: 70px;
            height: 70px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            font-size: 28px;
        }

        /* Stats */
        .stat-box {
            text-align: center;
            padding: 30px;
        }

        .stat-number {
            font-size: 48px;
            font-weight: 700;
            color: var(--primary-color);
        }

        .stat-label {
            color: #666;
            font-size: 16px;
        }

        /* Class Cards */
        .class-card {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s;
        }

        .class-card:hover {
            transform: scale(1.03);
        }

        .class-header {
            padding: 25px;
            color: white;
            text-align: center;
        }

        /* Testimonials */
        .testimonial-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        }

        .stars {
            color: #ffc107;
            margin-bottom: 15px;
        }

        /* Footer */
        .footer {
            background: var(--dark-color);
            color: white;
            padding: 60px 0 30px;
        }

        .footer h5 {
            font-weight: 600;
            margin-bottom: 20px;
        }

        .footer a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer a:hover {
            color: var(--primary-color);
        }

        .social-icons a {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 1px solid rgba(255, 255, 255, 0.3);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            transition: all 0.3s;
        }

        .social-icons a:hover {
            background: var(--primary-color);
            border-color: var(--primary-color);
        }

        /* CTA Section */
        .cta-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, #e55a2b 100%);
            padding: 60px 0;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-guest sticky-top">
        <div class="container">
            <a class="navbar-brand logo-text" href="{{ url('/') }}">
                <i class="fas fa-graduation-cap me-2"></i>MN Ánh Sao
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#home">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">Giới thiệu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#classes">Lớp học</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#testimonials">Đánh giá</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Liên hệ</a>
                    </li>
                </ul>
                <div class="d-flex gap-2">
                    <a href="{{ route('login') }}" class="btn btn-login">Đăng nhập</a>
                    <a href="{{ route('register') }}" class="btn btn-register">Đăng ký</a>
                </div>
            </div>
        </div>
    </nav>

    @yield('content')

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h5><i class="fas fa-graduation-cap me-2"></i>MN Ánh Sao</h5>
                    <p class="text-white-50">Nơi ươm mầm những tài năng nhỏ, nuôi dưỡng tình yêu thương và phát triển
                        toàn diện cho trẻ.</p>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div class="col-lg-2">
                    <h5>Liên kết</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#about">Giới thiệu</a></li>
                        <li class="mb-2"><a href="#classes">Lớp học</a></li>
                        <li class="mb-2"><a href="#testimonials">Đánh giá</a></li>
                        <li class="mb-2"><a href="#contact">Liên hệ</a></li>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h5>Liên hệ</h5>
                    <ul class="list-unstyled text-white-50">
                        <li class="mb-2"><i class="fas fa-map-marker-alt me-2"></i>123 Đường ABC, TP.HCM</li>
                        <li class="mb-2"><i class="fas fa-phone me-2"></i>0123 456 789</li>
                        <li class="mb-2"><i class="fas fa-envelope me-2"></i>info@anhsao.edu.vn</li>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h5>Giờ làm việc</h5>
                    <ul class="list-unstyled text-white-50">
                        <li class="mb-2">Thứ 2 - Thứ 6: 7:00 - 17:30</li>
                        <li class="mb-2">Thứ 7: 7:00 - 11:30</li>
                        <li class="mb-2">Chủ nhật: Nghỉ</li>
                    </ul>
                </div>
            </div>
            <hr class="my-4" style="border-color: rgba(255,255,255,0.1);">
            <div class="text-center text-white-50">
                <small>© 2024 Trường Mầm Non Ánh Sao. All rights reserved.</small>
            </div>
        </div>
    </footer>

    {{-- Chatbox Component --}}
    @include('components.chatbox')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
