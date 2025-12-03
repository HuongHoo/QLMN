@extends('layouts.guest')

@section('content')
    <style>
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .achievement-card {
            transition: all 0.3s ease;
            border: none;
            border-radius: 15px;
        }

        .achievement-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .achievement-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }

        .testimonial-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .testimonial-card::before {
            content: '"';
            font-size: 80px;
            color: #667eea;
            opacity: 0.2;
            position: absolute;
            top: 10px;
            left: 20px;
            font-family: Georgia, serif;
            line-height: 1;
        }

        .stars {
            color: #ffc107;
        }

        .class-card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .class-card:hover {
            transform: scale(1.03);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }

        .class-header {
            padding: 20px;
            color: white;
            text-align: center;
        }

        .section-title {
            position: relative;
            display: inline-block;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 2px;
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .carousel-control-prev,
        .carousel-control-next {
            width: 50px;
            height: 50px;
            background: #667eea;
            border-radius: 50%;
            top: 50%;
            transform: translateY(-50%);
            opacity: 1;
        }

        .carousel-control-prev {
            left: -25px;
        }

        .carousel-control-next {
            right: -25px;
        }

        .counter-number {
            font-size: 48px;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>

    <main class="main">
        <!-- Hero Section -->
        <section id="home" class="hero-section text-white py-5">
            <div class="container position-relative" style="z-index: 1;">
                <div class="row align-items-center min-vh-50">
                    <div class="col-lg-7">
                        <h1 class="display-4 fw-bold mb-4">
                            <i class="fas fa-graduation-cap me-3"></i>
                            Trường Mầm Non Ánh Sao
                        </h1>
                        <p class="lead mb-4">
                            Nơi ươm mầm những tài năng nhỏ, nuôi dưỡng tình yêu thương và phát triển toàn diện cho trẻ.
                            Chúng tôi cam kết mang đến môi trường học tập an toàn, vui vẻ và sáng tạo nhất cho con bạn.
                        </p>
                        <div class="d-flex flex-wrap gap-3">
                            <a href="{{ route('login') }}" class="btn btn-light btn-lg px-4 rounded-pill shadow">
                                <i class="fas fa-sign-in-alt me-2"></i>Đăng nhập
                            </a>
                            <a href="#about" class="btn btn-outline-light btn-lg px-4 rounded-pill">
                                <i class="fas fa-info-circle me-2"></i>Tìm hiểu thêm
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-5 text-center mt-4 mt-lg-0">
                        <div class="position-relative">
                            <img src="{{ asset('user/img/logo/logo.png') }}" alt="Logo" class="img-fluid"
                                style="max-height: 300px; filter: drop-shadow(0 10px 20px rgba(0,0,0,0.3));"
                                onerror="this.src='https://via.placeholder.com/300x300?text=🏫'">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Giới thiệu Section -->
        <section id="about" class="py-5 bg-light">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="fw-bold section-title">Giới Thiệu Về Trường</h2>
                    <p class="text-muted mt-4">Hơn 10 năm kinh nghiệm trong lĩnh vực giáo dục mầm non</p>
                </div>

                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="card h-100 border-0 shadow-sm rounded-4 p-4">
                            <div class="card-body">
                                <h4 class="text-primary mb-3">
                                    <i class="fas fa-heart me-2"></i>Sứ mệnh của chúng tôi
                                </h4>
                                <p class="text-muted">
                                    Trường Mầm Non Ánh Sao được thành lập với sứ mệnh tạo ra môi trường giáo dục
                                    tiên tiến, nơi mỗi em nhỏ được yêu thương, tôn trọng và khuyến khích phát triển
                                    theo cách riêng của mình.
                                </p>
                                <ul class="list-unstyled">
                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Chương trình
                                        giáo dục tiên tiến</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Đội ngũ giáo
                                        viên tận tâm, giàu kinh nghiệm</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Cơ sở vật chất
                                        hiện đại, an toàn</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Chế độ dinh
                                        dưỡng khoa học</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card h-100 border-0 shadow-sm rounded-4 p-4">
                            <div class="card-body">
                                <h4 class="text-primary mb-3">
                                    <i class="fas fa-star me-2"></i>Tầm nhìn & Giá trị
                                </h4>
                                <p class="text-muted">
                                    Chúng tôi hướng đến việc trở thành ngôi trường mầm non hàng đầu, nơi mỗi đứa trẻ
                                    đều được phát huy tối đa tiềm năng và chuẩn bị sẵn sàng cho hành trình học tập
                                    suốt đời.
                                </p>
                                <div class="row g-3 mt-3">
                                    <div class="col-6">
                                        <div class="d-flex align-items-center">
                                            <div class="feature-icon bg-primary bg-opacity-10 text-primary me-3">
                                                <i class="fas fa-shield-alt"></i>
                                            </div>
                                            <div>
                                                <strong>An toàn</strong>
                                                <small class="d-block text-muted">Môi trường bảo vệ</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="d-flex align-items-center">
                                            <div class="feature-icon bg-success bg-opacity-10 text-success me-3">
                                                <i class="fas fa-leaf"></i>
                                            </div>
                                            <div>
                                                <strong>Phát triển</strong>
                                                <small class="d-block text-muted">Toàn diện</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="d-flex align-items-center">
                                            <div class="feature-icon bg-warning bg-opacity-10 text-warning me-3">
                                                <i class="fas fa-lightbulb"></i>
                                            </div>
                                            <div>
                                                <strong>Sáng tạo</strong>
                                                <small class="d-block text-muted">Khuyến khích</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="d-flex align-items-center">
                                            <div class="feature-icon bg-danger bg-opacity-10 text-danger me-3">
                                                <i class="fas fa-heart"></i>
                                            </div>
                                            <div>
                                                <strong>Yêu thương</strong>
                                                <small class="d-block text-muted">Tận tâm</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Thành tựu Section -->
        <section class="py-5">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="fw-bold section-title">Thành Tựu Nổi Bật</h2>
                    <p class="text-muted mt-4">Những con số ấn tượng khẳng định chất lượng</p>
                </div>

                <div class="row g-4">
                    <div class="col-lg-3 col-md-6">
                        <div class="achievement-card card h-100 text-center p-4 shadow">
                            <div class="achievement-icon bg-primary bg-opacity-10">
                                <i class="fas fa-users fa-2x text-primary"></i>
                            </div>
                            <div class="counter-number">500+</div>
                            <h5 class="mb-2">Học sinh</h5>
                            <p class="text-muted small mb-0">Đã và đang theo học tại trường</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="achievement-card card h-100 text-center p-4 shadow">
                            <div class="achievement-icon bg-success bg-opacity-10">
                                <i class="fas fa-chalkboard-teacher fa-2x text-success"></i>
                            </div>
                            <div class="counter-number">30+</div>
                            <h5 class="mb-2">Giáo viên</h5>
                            <p class="text-muted small mb-0">Đội ngũ chuyên nghiệp, tận tâm</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="achievement-card card h-100 text-center p-4 shadow">
                            <div class="achievement-icon bg-warning bg-opacity-10">
                                <i class="fas fa-trophy fa-2x text-warning"></i>
                            </div>
                            <div class="counter-number">15+</div>
                            <h5 class="mb-2">Giải thưởng</h5>
                            <p class="text-muted small mb-0">Cấp quận, thành phố</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="achievement-card card h-100 text-center p-4 shadow">
                            <div class="achievement-icon bg-danger bg-opacity-10">
                                <i class="fas fa-calendar-alt fa-2x text-danger"></i>
                            </div>
                            <div class="counter-number">10+</div>
                            <h5 class="mb-2">Năm kinh nghiệm</h5>
                            <p class="text-muted small mb-0">Trong lĩnh vực giáo dục</p>
                        </div>
                    </div>
                </div>

                <div class="row g-4 mt-4">
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm h-100 rounded-4">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="fas fa-medal fa-2x text-warning me-3"></i>
                                    <h5 class="mb-0">Trường chuẩn Quốc gia</h5>
                                </div>
                                <p class="text-muted mb-0">Đạt chuẩn quốc gia về cơ sở vật chất và chất lượng giáo dục mầm
                                    non.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm h-100 rounded-4">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="fas fa-award fa-2x text-primary me-3"></i>
                                    <h5 class="mb-0">Chứng nhận STEM</h5>
                                </div>
                                <p class="text-muted mb-0">Áp dụng phương pháp giáo dục STEM tiên tiến trong chương trình
                                    học.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm h-100 rounded-4">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="fas fa-certificate fa-2x text-success me-3"></i>
                                    <h5 class="mb-0">ISO 9001:2015</h5>
                                </div>
                                <p class="text-muted mb-0">Chứng nhận hệ thống quản lý chất lượng theo tiêu chuẩn quốc tế.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Đánh giá phụ huynh Section -->
        <section id="testimonials" class="py-5 bg-light">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="fw-bold section-title">Phụ Huynh Nói Gì Về Chúng Tôi</h2>
                    <p class="text-muted mt-4">Những đánh giá chân thực từ các phụ huynh</p>
                </div>

                <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <div class="row justify-content-center">
                                <div class="col-lg-8">
                                    <div class="testimonial-card text-center">
                                        <div class="stars mb-3">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <p class="lead mb-4">
                                            "Con tôi rất thích đi học mỗi ngày. Các cô giáo rất tận tâm và yêu thương trẻ.
                                            Tôi thấy con tiến bộ rõ rệt sau mỗi học kỳ. Cảm ơn trường Ánh Sao rất nhiều!"
                                        </p>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3"
                                                style="width: 60px; height: 60px;">
                                                <i class="fas fa-user fa-lg"></i>
                                            </div>
                                            <div class="text-start">
                                                <strong>Chị Nguyễn Thị Hương</strong>
                                                <div class="text-muted small">Phụ huynh bé Minh Anh - Lớp Lá</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="row justify-content-center">
                                <div class="col-lg-8">
                                    <div class="testimonial-card text-center">
                                        <div class="stars mb-3">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <p class="lead mb-4">
                                            "Môi trường học tập sạch sẽ, an toàn. Thực đơn dinh dưỡng rất khoa học.
                                            Con tôi từ khi học ở đây khỏe mạnh hơn và hoạt bát hơn rất nhiều!"
                                        </p>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center me-3"
                                                style="width: 60px; height: 60px;">
                                                <i class="fas fa-user fa-lg"></i>
                                            </div>
                                            <div class="text-start">
                                                <strong>Anh Trần Văn Nam</strong>
                                                <div class="text-muted small">Phụ huynh bé Gia Hân - Lớp Chồi</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="row justify-content-center">
                                <div class="col-lg-8">
                                    <div class="testimonial-card text-center">
                                        <div class="stars mb-3">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <p class="lead mb-4">
                                            "Tôi rất ấn tượng với cách các cô giáo giao tiếp với phụ huynh. Hệ thống theo
                                            dõi
                                            học sinh rất tiện lợi, tôi có thể biết con mình học gì, ăn gì mỗi ngày."
                                        </p>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <div class="rounded-circle bg-warning text-white d-flex align-items-center justify-content-center me-3"
                                                style="width: 60px; height: 60px;">
                                                <i class="fas fa-user fa-lg"></i>
                                            </div>
                                            <div class="text-start">
                                                <strong>Chị Lê Thị Mai</strong>
                                                <div class="text-muted small">Phụ huynh bé Đức Anh - Lớp Mầm</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="row justify-content-center">
                                <div class="col-lg-8">
                                    <div class="testimonial-card text-center">
                                        <div class="stars mb-3">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <p class="lead mb-4">
                                            "Ban đầu con tôi rất nhút nhát, nhưng sau 1 năm học ở Ánh Sao, con đã tự tin
                                            hơn rất nhiều, biết hát múa và giao tiếp tốt với bạn bè."
                                        </p>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <div class="rounded-circle bg-info text-white d-flex align-items-center justify-content-center me-3"
                                                style="width: 60px; height: 60px;">
                                                <i class="fas fa-user fa-lg"></i>
                                            </div>
                                            <div class="text-start">
                                                <strong>Chị Phạm Thanh Thảo</strong>
                                                <div class="text-muted small">Phụ huynh bé Bảo Ngọc - Lớp Lá</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="row justify-content-center">
                                <div class="col-lg-8">
                                    <div class="testimonial-card text-center">
                                        <div class="stars mb-3">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <p class="lead mb-4">
                                            "Học phí hợp lý, chất lượng giáo dục tuyệt vời. Các hoạt động ngoại khóa
                                            đa dạng giúp con phát triển toàn diện. Tôi hoàn toàn yên tâm gửi con!"
                                        </p>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <div class="rounded-circle bg-danger text-white d-flex align-items-center justify-content-center me-3"
                                                style="width: 60px; height: 60px;">
                                                <i class="fas fa-user fa-lg"></i>
                                            </div>
                                            <div class="text-start">
                                                <strong>Anh Hoàng Minh Tuấn</strong>
                                                <div class="text-muted small">Phụ huynh bé Minh Khôi - Lớp Chồi</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>

                <div class="carousel-indicators mt-4 position-relative">
                    <button type="button" data-bs-target="#testimonialCarousel" data-bs-slide-to="0"
                        class="active bg-primary"></button>
                    <button type="button" data-bs-target="#testimonialCarousel" data-bs-slide-to="1"
                        class="bg-primary"></button>
                    <button type="button" data-bs-target="#testimonialCarousel" data-bs-slide-to="2"
                        class="bg-primary"></button>
                    <button type="button" data-bs-target="#testimonialCarousel" data-bs-slide-to="3"
                        class="bg-primary"></button>
                    <button type="button" data-bs-target="#testimonialCarousel" data-bs-slide-to="4"
                        class="bg-primary"></button>
                </div>
            </div>
        </section>

        <!-- Danh sách lớp học Section -->
        <section id="classes" class="py-5">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="fw-bold section-title">Các Lớp Học Tại Trường</h2>
                    <p class="text-muted mt-4">Hệ thống lớp học được phân chia theo độ tuổi phù hợp</p>
                </div>

                @if (isset($lopHocs) && count($lopHocs) > 0)
                    <div class="row g-4">
                        @php
                            $colors = [
                                ['bg' => 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)', 'icon' => 'fa-baby'],
                                ['bg' => 'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)', 'icon' => 'fa-child'],
                                [
                                    'bg' => 'linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)',
                                    'icon' => 'fa-user-graduate',
                                ],
                                ['bg' => 'linear-gradient(135deg, #43e97b 0%, #38f9d7 100%)', 'icon' => 'fa-star'],
                                ['bg' => 'linear-gradient(135deg, #fa709a 0%, #fee140 100%)', 'icon' => 'fa-heart'],
                                ['bg' => 'linear-gradient(135deg, #a8edea 0%, #fed6e3 100%)', 'icon' => 'fa-smile'],
                            ];
                        @endphp
                        @foreach ($lopHocs as $index => $lop)
                            @php
                                $color = $colors[$index % count($colors)];
                                $giaovien = $lop->giaovien;
                            @endphp
                            <div class="col-lg-4 col-md-6">
                                <div class="class-card card h-100 shadow">
                                    <div class="class-header" style="background: {{ $color['bg'] }};">
                                        <i class="fas {{ $color['icon'] }} fa-3x mb-2"></i>
                                        <h4 class="mb-0">{{ $lop->tenlop }}</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="fas fa-users text-primary me-2"></i>
                                                <span class="text-muted">Nhóm tuổi:</span>
                                                <strong class="ms-auto">{{ $lop->nhomtuoi ?? 'N/A' }}</strong>
                                            </div>
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="fas fa-door-open text-success me-2"></i>
                                                <span class="text-muted">Phòng học:</span>
                                                <strong class="ms-auto">{{ $lop->sophong ?? 'N/A' }}</strong>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-clock text-warning me-2"></i>
                                                <span class="text-muted">Thời gian:</span>
                                                <strong class="ms-auto">
                                                    {{ $lop->giobatdau ? substr($lop->giobatdau, 0, 5) : '07:30' }} -
                                                    {{ $lop->gioketthuc ? substr($lop->gioketthuc, 0, 5) : '17:00' }}
                                                </strong>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="d-flex align-items-center">
                                            @if ($giaovien && $giaovien->anh)
                                                <img src="{{ asset('storage/' . $giaovien->anh) }}" alt="avatar"
                                                    class="rounded-circle me-3"
                                                    style="width: 50px; height: 50px; object-fit: cover;">
                                            @else
                                                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-3"
                                                    style="width: 50px; height: 50px;">
                                                    <i class="fas fa-user-tie text-primary fa-lg"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <small class="text-muted d-block">Giáo viên chủ nhiệm</small>
                                                <strong>{{ $giaovien->tengiaovien ?? 'Chưa phân công' }}</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="row g-4">
                        <div class="col-lg-4 col-md-6">
                            <div class="class-card card h-100 shadow">
                                <div class="class-header"
                                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                    <i class="fas fa-baby fa-3x mb-2"></i>
                                    <h4 class="mb-0">Lớp Mầm</h4>
                                </div>
                                <div class="card-body">
                                    <p class="text-muted mb-3">Dành cho trẻ 3-4 tuổi. Chương trình học tập trung vào
                                        phát triển kỹ năng vận động và ngôn ngữ cơ bản.</p>
                                    <hr>
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-3"
                                            style="width: 50px; height: 50px;">
                                            <i class="fas fa-user-tie text-primary fa-lg"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">Giáo viên chủ nhiệm</small>
                                            <strong>Cô Nguyễn Thị A</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="class-card card h-100 shadow">
                                <div class="class-header"
                                    style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                                    <i class="fas fa-child fa-3x mb-2"></i>
                                    <h4 class="mb-0">Lớp Chồi</h4>
                                </div>
                                <div class="card-body">
                                    <p class="text-muted mb-3">Dành cho trẻ 4-5 tuổi. Tập trung phát triển tư duy
                                        logic, kỹ năng xã hội và sáng tạo nghệ thuật.</p>
                                    <hr>
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-3"
                                            style="width: 50px; height: 50px;">
                                            <i class="fas fa-user-tie text-primary fa-lg"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">Giáo viên chủ nhiệm</small>
                                            <strong>Cô Trần Thị B</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="class-card card h-100 shadow">
                                <div class="class-header"
                                    style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                                    <i class="fas fa-user-graduate fa-3x mb-2"></i>
                                    <h4 class="mb-0">Lớp Lá</h4>
                                </div>
                                <div class="card-body">
                                    <p class="text-muted mb-3">Dành cho trẻ 5-6 tuổi. Chuẩn bị toàn diện cho trẻ
                                        trước khi vào lớp 1 với các kỹ năng cần thiết.</p>
                                    <hr>
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-3"
                                            style="width: 50px; height: 50px;">
                                            <i class="fas fa-user-tie text-primary fa-lg"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">Giáo viên chủ nhiệm</small>
                                            <strong>Cô Lê Thị C</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </section>

        <!-- Liên hệ Section -->
        <section id="contact" class="py-5 bg-light">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="fw-bold section-title">Liên Hệ Với Chúng Tôi</h2>
                    <p class="text-muted mt-4">Hãy liên hệ để được tư vấn và đăng ký cho con</p>
                </div>
                <div class="row g-4">
                    <div class="col-lg-4">
                        <div class="card border-0 shadow-sm h-100 text-center p-4 rounded-4">
                            <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center mx-auto mb-3"
                                style="width: 80px; height: 80px;">
                                <i class="fas fa-map-marker-alt fa-2x text-primary"></i>
                            </div>
                            <h5 class="mb-2">Địa chỉ</h5>
                            <p class="text-muted mb-0">123 Đường ABC, Quận XYZ, TP.HCM</p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card border-0 shadow-sm h-100 text-center p-4 rounded-4">
                            <div class="rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center mx-auto mb-3"
                                style="width: 80px; height: 80px;">
                                <i class="fas fa-phone-alt fa-2x text-success"></i>
                            </div>
                            <h5 class="mb-2">Điện thoại</h5>
                            <p class="text-muted mb-0">0123 456 789</p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card border-0 shadow-sm h-100 text-center p-4 rounded-4">
                            <div class="rounded-circle bg-warning bg-opacity-10 d-flex align-items-center justify-content-center mx-auto mb-3"
                                style="width: 80px; height: 80px;">
                                <i class="fas fa-envelope fa-2x text-warning"></i>
                            </div>
                            <h5 class="mb-2">Email</h5>
                            <p class="text-muted mb-0">info@anhsao.edu.vn</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Call to Action Section -->
        <section class="py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-8 text-white">
                        <h3 class="fw-bold mb-3">Bạn muốn tìm hiểu thêm về trường?</h3>
                        <p class="mb-0 opacity-75">Liên hệ ngay với chúng tôi để được tư vấn miễn phí và đăng ký tham quan
                            trường.</p>
                    </div>
                    <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                        <a href="tel:0123456789" class="btn btn-light btn-lg rounded-pill px-4 shadow">
                            <i class="fas fa-phone-alt me-2"></i>0123 456 789
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
