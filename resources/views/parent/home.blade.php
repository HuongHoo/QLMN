@extends('layouts.guest')

@section('content')
    <style>
        .hero-section {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
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
            color: #4e73df;
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
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
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
            background: #4e73df;
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
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Gallery Styles */
        .gallery-card {
            transition: all 0.4s ease;
            cursor: pointer;
        }

        .gallery-card:hover {
            transform: scale(1.05);
        }

        .gallery-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to top, rgba(78, 115, 223, 0.9), rgba(34, 74, 190, 0.5), transparent);
            opacity: 0;
            transition: all 0.4s ease;
            display: flex;
            align-items: flex-end;
            padding: 20px;
        }

        .gallery-card:hover .gallery-overlay {
            opacity: 1;
        }

        .gallery-info {
            width: 100%;
            transform: translateY(20px);
            transition: all 0.4s ease;
        }

        .gallery-card:hover .gallery-info {
            transform: translateY(0);
        }

        .btn-group .btn.active {
            background: #4e73df;
            color: white;
            border-color: #4e73df;
        }

        /* Activity Timeline Styles */
        .activity-timeline {
            position: relative;
            padding-left: 30px;
        }

        .activity-timeline::before {
            content: '';
            position: absolute;
            left: 10px;
            top: 0;
            bottom: 0;
            width: 3px;
            background: linear-gradient(to bottom, #4e73df, #224abe, #1cc88a, #f6c23e);
            border-radius: 3px;
        }

        .activity-item {
            position: relative;
            padding: 15px 0;
            padding-left: 25px;
        }

        .activity-item::before {
            content: '';
            position: absolute;
            left: -24px;
            top: 20px;
            width: 14px;
            height: 14px;
            background: white;
            border: 3px solid #4e73df;
            border-radius: 50%;
            z-index: 1;
        }

        .activity-item:nth-child(2)::before {
            border-color: #1cc88a;
        }

        .activity-item:nth-child(3)::before {
            border-color: #f6c23e;
        }

        .activity-item:nth-child(4)::before {
            border-color: #e74a3b;
        }

        .activity-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            border-left: 4px solid #4e73df;
        }

        .activity-card:hover {
            transform: translateX(10px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
        }

        .activity-item:nth-child(2) .activity-card {
            border-left-color: #1cc88a;
        }

        .activity-item:nth-child(3) .activity-card {
            border-left-color: #f6c23e;
        }

        .activity-item:nth-child(4) .activity-card {
            border-left-color: #e74a3b;
        }

        .activity-img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 12px;
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

        <!-- Gallery Hoạt Động Section -->
        <section id="gallery" class="py-5">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="fw-bold section-title">Hoạt Động Của Trường</h2>
                    <p class="text-muted mt-4">Hình ảnh các hoạt động vui chơi, học tập tại Trường Mầm Non Ánh Sao</p>
                </div>

                <!-- Filter Buttons -->
                <div class="text-center mb-4">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-outline-primary active px-4" data-filter="all">Tất
                            cả</button>
                        <button type="button" class="btn btn-outline-primary px-4" data-filter="hoctap">Học tập</button>
                        <button type="button" class="btn btn-outline-primary px-4" data-filter="vuichoi">Vui
                            chơi</button>
                        <button type="button" class="btn btn-outline-primary px-4" data-filter="sukien">Sự kiện</button>
                    </div>
                </div>

                <div class="row g-4" id="galleryGrid">
                    @if (isset($hoatDongs) && $hoatDongs->count() > 0)
                        @foreach ($hoatDongs as $hoatDong)
                            @php
                                $icons = [
                                    'hoctap' => 'fa-book-reader',
                                    'vuichoi' => 'fa-smile-beam',
                                    'sukien' => 'fa-calendar-star',
                                    'khac' => 'fa-star',
                                ];
                                $icon = $icons[$hoatDong->loai] ?? 'fa-star';
                            @endphp
                            <div class="col-lg-4 col-md-6 gallery-item" data-category="{{ $hoatDong->loai }}">
                                <div class="gallery-card position-relative overflow-hidden rounded-4 shadow">
                                    <img src="{{ $hoatDong->anh_url }}" alt="{{ $hoatDong->tieude }}"
                                        class="img-fluid w-100" style="height: 280px; object-fit: cover;"
                                        onerror="this.src='https://images.unsplash.com/photo-1503454537195-1dcabb73ffb9?w=400&h=280&fit=crop'">
                                    <div class="gallery-overlay">
                                        <div class="gallery-info text-center text-white">
                                            <h5 class="mb-2"><i
                                                    class="fas {{ $icon }} me-2"></i>{{ $hoatDong->tieude }}</h5>
                                            <p class="small mb-0">{{ $hoatDong->mota }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <!-- Fallback: Ảnh mặc định khi chưa có dữ liệu -->
                        <div class="col-lg-4 col-md-6 gallery-item" data-category="hoctap">
                            <div class="gallery-card position-relative overflow-hidden rounded-4 shadow">
                                <img src="https://images.unsplash.com/photo-1503454537195-1dcabb73ffb9?w=400&h=280&fit=crop"
                                    alt="Giờ học" class="img-fluid w-100" style="height: 280px; object-fit: cover;">
                                <div class="gallery-overlay">
                                    <div class="gallery-info text-center text-white">
                                        <h5 class="mb-2"><i class="fas fa-palette me-2"></i>Giờ học vẽ</h5>
                                        <p class="small mb-0">Phát triển sáng tạo nghệ thuật</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 gallery-item" data-category="vuichoi">
                            <div class="gallery-card position-relative overflow-hidden rounded-4 shadow">
                                <img src="https://images.unsplash.com/photo-1587654780291-39c9404d746b?w=400&h=280&fit=crop"
                                    alt="Vui chơi ngoài trời" class="img-fluid w-100"
                                    style="height: 280px; object-fit: cover;">
                                <div class="gallery-overlay">
                                    <div class="gallery-info text-center text-white">
                                        <h5 class="mb-2"><i class="fas fa-tree me-2"></i>Hoạt động ngoài trời</h5>
                                        <p class="small mb-0">Vui chơi và khám phá thiên nhiên</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 gallery-item" data-category="sukien">
                            <div class="gallery-card position-relative overflow-hidden rounded-4 shadow">
                                <img src="https://images.unsplash.com/photo-1544776193-352d25ca82cd?w=400&h=280&fit=crop"
                                    alt="Lễ hội" class="img-fluid w-100" style="height: 280px; object-fit: cover;">
                                <div class="gallery-overlay">
                                    <div class="gallery-info text-center text-white">
                                        <h5 class="mb-2"><i class="fas fa-birthday-cake me-2"></i>Lễ hội Trung thu</h5>
                                        <p class="small mb-0">Vui Tết Trung thu cùng các bé</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 gallery-item" data-category="hoctap">
                            <div class="gallery-card position-relative overflow-hidden rounded-4 shadow">
                                <img src="https://images.unsplash.com/photo-1484820540004-14229fe36ca4?w=400&h=280&fit=crop"
                                    alt="Giờ ăn" class="img-fluid w-100" style="height: 280px; object-fit: cover;">
                                <div class="gallery-overlay">
                                    <div class="gallery-info text-center text-white">
                                        <h5 class="mb-2"><i class="fas fa-utensils me-2"></i>Giờ ăn dinh dưỡng</h5>
                                        <p class="small mb-0">Bữa ăn đầy đủ chất dinh dưỡng</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 gallery-item" data-category="vuichoi">
                            <div class="gallery-card position-relative overflow-hidden rounded-4 shadow">
                                <img src="https://images.unsplash.com/photo-1596464716127-f2a82984de30?w=400&h=280&fit=crop"
                                    alt="Thể dục" class="img-fluid w-100" style="height: 280px; object-fit: cover;">
                                <div class="gallery-overlay">
                                    <div class="gallery-info text-center text-white">
                                        <h5 class="mb-2"><i class="fas fa-running me-2"></i>Thể dục buổi sáng</h5>
                                        <p class="small mb-0">Rèn luyện sức khỏe mỗi ngày</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 gallery-item" data-category="sukien">
                            <div class="gallery-card position-relative overflow-hidden rounded-4 shadow">
                                <img src="https://images.unsplash.com/photo-1564429238067-4a96f9f0a4d3?w=400&h=280&fit=crop"
                                    alt="Văn nghệ" class="img-fluid w-100" style="height: 280px; object-fit: cover;">
                                <div class="gallery-overlay">
                                    <div class="gallery-info text-center text-white">
                                        <h5 class="mb-2"><i class="fas fa-music me-2"></i>Văn nghệ cuối năm</h5>
                                        <p class="small mb-0">Biểu diễn tài năng các bé</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 gallery-item" data-category="hoctap">
                            <div class="gallery-card position-relative overflow-hidden rounded-4 shadow">
                                <img src="https://images.unsplash.com/photo-1567057419565-4349c49d8a04?w=400&h=280&fit=crop"
                                    alt="STEM" class="img-fluid w-100" style="height: 280px; object-fit: cover;">
                                <div class="gallery-overlay">
                                    <div class="gallery-info text-center text-white">
                                        <h5 class="mb-2"><i class="fas fa-flask me-2"></i>Học STEM</h5>
                                        <p class="small mb-0">Khám phá khoa học vui</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 gallery-item" data-category="vuichoi">
                            <div class="gallery-card position-relative overflow-hidden rounded-4 shadow">
                                <img src="https://images.unsplash.com/photo-1503454537195-1dcabb73ffb9?w=400&h=280&fit=crop"
                                    alt="Góc chơi" class="img-fluid w-100" style="height: 280px; object-fit: cover;">
                                <div class="gallery-overlay">
                                    <div class="gallery-info text-center text-white">
                                        <h5 class="mb-2"><i class="fas fa-puzzle-piece me-2"></i>Góc chơi sáng tạo</h5>
                                        <p class="small mb-0">Phát triển tư duy qua trò chơi</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 gallery-item" data-category="sukien">
                            <div class="gallery-card position-relative overflow-hidden rounded-4 shadow">
                                <img src="https://images.unsplash.com/photo-1472162072942-cd5147eb3902?w=400&h=280&fit=crop"
                                    alt="Ngày hội" class="img-fluid w-100" style="height: 280px; object-fit: cover;">
                                <div class="gallery-overlay">
                                    <div class="gallery-info text-center text-white">
                                        <h5 class="mb-2"><i class="fas fa-star me-2"></i>Ngày hội bé khỏe</h5>
                                        <p class="small mb-0">Thi đua thể thao vui nhộn</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>

        <!-- Danh sách lớp học Section -->
        <section id="classes" class="py-5 bg-light">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="fw-bold section-title">Các Lớp Học Tại Trường</h2>
                    <p class="text-muted mt-4">Hệ thống lớp học được phân chia theo độ tuổi phù hợp</p>
                </div>

                @if (isset($lopHocs) && count($lopHocs) > 0)
                    <div class="row g-4">
                        @php
                            $colors = [
                                ['bg' => 'linear-gradient(135deg, #4e73df 0%, #224abe 100%)', 'icon' => 'fa-baby'],
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
                                    style="background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);">
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
        <section class="py-5" style="background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);">
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

    <!-- Chatbot Widget -->
    <div id="chatbot-container">
        <!-- Chatbot Button -->
        <div id="chatbot-toggle" class="chatbot-toggle">
            <i class="fas fa-comments"></i>
            <span class="chatbot-badge">Hỏi đáp</span>
        </div>

        <!-- Chatbot Window -->
        <div id="chatbot-window" class="chatbot-window" style="display: none;">
            <div class="chatbot-header">
                <div class="d-flex align-items-center">
                    <div class="chatbot-avatar">
                        <i class="fas fa-robot"></i>
                    </div>
                    <div class="ms-2">
                        <h6 class="mb-0">Trợ lý ảo Ánh Sao</h6>
                        <small class="text-white-50">Online</small>
                    </div>
                </div>
                <button id="chatbot-close" class="btn-close btn-close-white"></button>
            </div>

            <div class="chatbot-body" id="chatbot-messages">
                <div class="message bot-message">
                    <div class="message-content">
                        <p>Xin chào! 👋 Tôi là trợ lý ảo của Trường MN Ánh Sao. Tôi có thể giúp bạn:</p>
                        <ul class="mb-0">
                            <li>Tìm hiểu về học phí, chương trình học</li>
                            <li>Thông tin các lớp học</li>
                            <li>Thủ tục đăng ký nhập học</li>
                            <li>Và nhiều thông tin khác!</li>
                        </ul>
                        <p class="mb-0 mt-2">Bạn cần hỗ trợ gì ạ? 😊</p>
                    </div>
                    <small class="message-time"></small>
                </div>
            </div>

            <div class="chatbot-quick-replies" id="quick-replies">
                <button class="quick-reply-btn" data-type="tuition">
                    <i class="fas fa-money-bill-wave me-1"></i> Học phí
                </button>
                <button class="quick-reply-btn" data-type="schedule">
                    <i class="fas fa-clock me-1"></i> Giờ học
                </button>
                <button class="quick-reply-btn" data-type="contact">
                    <i class="fas fa-phone me-1"></i> Liên hệ
                </button>
                <button class="quick-reply-btn" data-type="register">
                    <i class="fas fa-file-alt me-1"></i> Đăng ký
                </button>
            </div>

            <div class="chatbot-footer">
                <div class="input-group">
                    <input type="text" id="chatbot-input" class="form-control" placeholder="Nhập câu hỏi của bạn..."
                        autocomplete="off">
                    <button id="chatbot-send" class="btn btn-primary">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
                <div id="chatbot-loading" class="text-center mt-2" style="display: none;">
                    <div class="spinner-border spinner-border-sm text-primary" role="status">
                        <span class="visually-hidden">Đang xử lý...</span>
                    </div>
                    <small class="text-muted ms-2">Đang suy nghĩ...</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Chatbot Styles -->
    <style>
        #chatbot-container {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
        }

        .chatbot-toggle {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 20px rgba(78, 115, 223, 0.4);
            transition: all 0.3s ease;
            position: relative;
        }

        .chatbot-toggle:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 30px rgba(78, 115, 223, 0.6);
        }

        .chatbot-toggle i {
            font-size: 24px;
        }

        .chatbot-badge {
            position: absolute;
            top: -10px;
            right: -10px;
            background: #f6c23e;
            color: #333;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: bold;
            white-space: nowrap;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        .chatbot-window {
            position: fixed;
            bottom: 90px;
            right: 20px;
            width: 380px;
            max-width: calc(100vw - 40px);
            height: 600px;
            max-height: calc(100vh - 120px);
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            animation: slideUp 0.3s ease;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .chatbot-header {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            color: white;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .chatbot-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .chatbot-body {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
            background: #f8f9fc;
        }

        .message {
            margin-bottom: 15px;
            animation: messageSlide 0.3s ease;
        }

        @keyframes messageSlide {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .message-content {
            display: inline-block;
            max-width: 80%;
            padding: 12px 16px;
            border-radius: 15px;
            line-height: 1.5;
        }

        .bot-message .message-content {
            background: white;
            color: #333;
            border-bottom-left-radius: 4px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .user-message {
            text-align: right;
        }

        .user-message .message-content {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            color: white;
            border-bottom-right-radius: 4px;
        }

        .message-time {
            display: block;
            margin-top: 5px;
            font-size: 11px;
            color: #999;
        }

        .chatbot-quick-replies {
            padding: 10px 20px;
            background: white;
            border-top: 1px solid #e3e6f0;
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .quick-reply-btn {
            flex: 1;
            min-width: 45%;
            padding: 8px 12px;
            border: 1px solid #4e73df;
            background: white;
            color: #4e73df;
            border-radius: 20px;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .quick-reply-btn:hover {
            background: #4e73df;
            color: white;
        }

        .chatbot-footer {
            padding: 15px 20px;
            background: white;
            border-top: 1px solid #e3e6f0;
        }

        #chatbot-input {
            border-radius: 25px;
            border: 1px solid #d1d3e2;
            padding: 10px 20px;
        }

        #chatbot-input:focus {
            border-color: #4e73df;
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }

        #chatbot-send {
            border-radius: 50%;
            width: 42px;
            height: 42px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            border: none;
        }

        #chatbot-send:hover {
            background: linear-gradient(135deg, #224abe 0%, #4e73df 100%);
        }

        /* Mobile Responsive */
        @media (max-width: 576px) {
            .chatbot-window {
                width: calc(100vw - 40px);
                height: calc(100vh - 120px);
                bottom: 90px;
                right: 20px;
            }

            .quick-reply-btn {
                min-width: 100%;
            }
        }

        /* Scrollbar Styling */
        .chatbot-body::-webkit-scrollbar {
            width: 6px;
        }

        .chatbot-body::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .chatbot-body::-webkit-scrollbar-thumb {
            background: #4e73df;
            border-radius: 3px;
        }

        .chatbot-body::-webkit-scrollbar-thumb:hover {
            background: #224abe;
        }
    </style>

    <!-- Chatbot JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chatbotToggle = document.getElementById('chatbot-toggle');
            const chatbotWindow = document.getElementById('chatbot-window');
            const chatbotClose = document.getElementById('chatbot-close');
            const chatbotInput = document.getElementById('chatbot-input');
            const chatbotSend = document.getElementById('chatbot-send');
            const chatbotMessages = document.getElementById('chatbot-messages');
            const chatbotLoading = document.getElementById('chatbot-loading');
            const quickReplyBtns = document.querySelectorAll('.quick-reply-btn');

            // Toggle chatbot window
            chatbotToggle.addEventListener('click', function() {
                if (chatbotWindow.style.display === 'none') {
                    chatbotWindow.style.display = 'flex';
                    chatbotInput.focus();
                } else {
                    chatbotWindow.style.display = 'none';
                }
            });

            // Close chatbot
            chatbotClose.addEventListener('click', function() {
                chatbotWindow.style.display = 'none';
            });

            // Send message function
            async function sendMessage(message, isQuickReply = false) {
                if (!message.trim() && !isQuickReply) return;

                // Add user message to chat
                if (!isQuickReply) {
                    addMessage(message, 'user');
                    chatbotInput.value = '';
                }

                // Show loading
                chatbotLoading.style.display = 'block';

                try {
                    const url = isQuickReply ? '{{ route('chatbot.quick') }}' : '{{ route('chatbot.send') }}';
                    const data = isQuickReply ? {
                        type: message
                    } : {
                        message: message
                    };

                    const response = await fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(data)
                    });

                    const result = await response.json();

                    if (result.success) {
                        addMessage(result.message, 'bot');
                    } else {
                        // Hiển thị lỗi chi tiết để debug
                        addMessage(result.message || 'Xin lỗi, có lỗi xảy ra. Vui lòng thử lại sau.', 'bot');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    addMessage('Xin lỗi, không thể kết nối đến máy chủ. Vui lòng thử lại sau.', 'bot');
                } finally {
                    chatbotLoading.style.display = 'none';
                }
            }

            // Add message to chat
            function addMessage(text, sender) {
                const messageDiv = document.createElement('div');
                messageDiv.className = `message ${sender}-message`;

                const contentDiv = document.createElement('div');
                contentDiv.className = 'message-content';

                // Convert markdown-like formatting to HTML
                let formattedText = text
                    .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
                    .replace(/\n/g, '<br>');

                contentDiv.innerHTML = formattedText;

                const timeSmall = document.createElement('small');
                timeSmall.className = 'message-time';
                const now = new Date();
                timeSmall.textContent = now.getHours().toString().padStart(2, '0') + ':' +
                    now.getMinutes().toString().padStart(2, '0');

                messageDiv.appendChild(contentDiv);
                messageDiv.appendChild(timeSmall);
                chatbotMessages.appendChild(messageDiv);

                // Scroll to bottom
                chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
            }

            // Send button click
            chatbotSend.addEventListener('click', function() {
                const message = chatbotInput.value;
                sendMessage(message);
            });

            // Enter key to send
            chatbotInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    const message = chatbotInput.value;
                    sendMessage(message);
                }
            });

            // Quick reply buttons
            quickReplyBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const type = this.getAttribute('data-type');
                    sendMessage(type, true);
                });
            });

            // Set current time for initial bot message
            const initialTime = document.querySelector('.bot-message .message-time');
            if (initialTime) {
                const now = new Date();
                initialTime.textContent = now.getHours().toString().padStart(2, '0') + ':' +
                    now.getMinutes().toString().padStart(2, '0');
            }
        });
    </script>

    <script>
        // Gallery Filter
        document.addEventListener('DOMContentLoaded', function() {
            const filterBtns = document.querySelectorAll('[data-filter]');
            const galleryItems = document.querySelectorAll('.gallery-item');

            filterBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    // Remove active class from all buttons
                    filterBtns.forEach(b => b.classList.remove('active'));
                    // Add active class to clicked button
                    this.classList.add('active');

                    const filter = this.getAttribute('data-filter');

                    galleryItems.forEach(item => {
                        if (filter === 'all' || item.getAttribute('data-category') ===
                            filter) {
                            item.style.display = 'block';
                            item.style.animation = 'fadeIn 0.5s ease';
                        } else {
                            item.style.display = 'none';
                        }
                    });
                });
            });
        });
    </script>

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endsection
