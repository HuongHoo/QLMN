<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đăng ký - Trường MN Ánh Sao</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .register-wrapper {
            display: flex;
            width: 100%;
            min-height: 100vh;
        }

        /* Left Side - Image/Branding */
        .register-left {
            flex: 1;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.9) 0%, rgba(118, 75, 162, 0.9) 100%),
                url('{{ asset('user/assets/img/hero-carousel/anhmn2.png') }}') center/cover;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .register-left::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .register-left .content {
            position: relative;
            z-index: 1;
            text-align: center;
            max-width: 450px;
        }

        .register-left .logo {
            width: 120px;
            height: 120px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            backdrop-filter: blur(10px);
        }

        .register-left .logo i {
            font-size: 50px;
        }

        .register-left h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .register-left p {
            font-size: 1.1rem;
            opacity: 0.9;
            line-height: 1.8;
        }

        .benefits {
            margin-top: 40px;
            text-align: left;
        }

        .benefit-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            padding: 12px 20px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            backdrop-filter: blur(5px);
        }

        .benefit-item i {
            font-size: 20px;
            margin-right: 15px;
            width: 30px;
            color: #ffd700;
        }

        /* Right Side - Form */
        .register-right {
            flex: 1;
            background: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px;
            overflow-y: auto;
        }

        .register-form-container {
            width: 100%;
            max-width: 450px;
        }

        .form-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .form-header h2 {
            font-size: 1.8rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 10px;
        }

        .form-header p {
            color: #666;
            font-size: 0.95rem;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            font-weight: 500;
            color: #333;
            margin-bottom: 8px;
            font-size: 0.9rem;
        }

        .input-group-custom {
            position: relative;
        }

        .input-group-custom i.icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            font-size: 18px;
        }

        .input-group-custom input {
            width: 100%;
            padding: 13px 15px 13px 48px;
            border: 2px solid #e8e8e8;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .input-group-custom input:focus {
            outline: none;
            border-color: #667eea;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        .input-group-custom input.is-invalid {
            border-color: #dc3545;
        }

        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #999;
        }

        .btn-register {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 12px;
            color: white;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 20px 0;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e8e8e8;
        }

        .divider span {
            padding: 0 15px;
            color: #999;
            font-size: 0.9rem;
        }

        .social-register {
            display: flex;
            gap: 15px;
        }

        .btn-social {
            flex: 1;
            padding: 12px;
            border: 2px solid #e8e8e8;
            border-radius: 12px;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            color: #333;
            font-weight: 500;
        }

        .btn-social:hover {
            border-color: #667eea;
            background: #f8f9fa;
            color: #333;
        }

        .btn-social.google {
            border-color: #ea4335;
        }

        .btn-social.google:hover {
            background: #fef2f2;
        }

        .btn-social.google i {
            color: #ea4335;
        }

        .btn-social.facebook {
            border-color: #1877f2;
        }

        .btn-social.facebook:hover {
            background: #eff6ff;
        }

        .btn-social.facebook i {
            color: #1877f2;
        }

        .login-link {
            text-align: center;
            margin-top: 25px;
            color: #666;
            font-size: 0.95rem;
        }

        .login-link a {
            color: #667eea;
            font-weight: 600;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }

        .invalid-feedback {
            display: block;
            color: #dc3545;
            font-size: 0.85rem;
            margin-top: 5px;
        }

        .back-home {
            position: absolute;
            top: 30px;
            left: 30px;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 500;
            opacity: 0.9;
            transition: opacity 0.3s;
        }

        .back-home:hover {
            opacity: 1;
            color: white;
        }

        .password-requirements {
            font-size: 0.8rem;
            color: #888;
            margin-top: 5px;
        }

        .terms {
            font-size: 0.85rem;
            color: #666;
            margin-top: 15px;
            text-align: center;
        }

        .terms a {
            color: #667eea;
            text-decoration: none;
        }

        .terms a:hover {
            text-decoration: underline;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .register-left {
                display: none;
            }

            .register-right {
                flex: none;
                width: 100%;
            }
        }

        @media (max-width: 576px) {
            .register-right {
                padding: 30px 20px;
            }

            .social-register {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>
    <div class="register-wrapper">
        <!-- Left Side -->
        <div class="register-left">
            <a href="{{ url('/') }}" class="back-home">
                <i class="fas fa-arrow-left"></i> Về trang chủ
            </a>
            <div class="content">
                <div class="logo">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h1>Trường MN Ánh Sao</h1>
                <p>Tạo tài khoản để trải nghiệm hệ thống quản lý mầm non hiện đại, kết nối phụ huynh với nhà trường.</p>

                <div class="benefits">
                    <div class="benefit-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Đăng ký miễn phí, nhanh chóng</span>
                    </div>
                    <div class="benefit-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Theo dõi con em 24/7</span>
                    </div>
                    <div class="benefit-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Nhận thông báo kịp thời</span>
                    </div>
                    <div class="benefit-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Thanh toán học phí online</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Form -->
        <div class="register-right">
            <div class="register-form-container">
                <div class="form-header">
                    <h2>Tạo tài khoản mới</h2>
                    <p>Điền thông tin bên dưới để đăng ký</p>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle me-2"></i>Vui lòng kiểm tra lại thông tin
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="form-group">
                        <label for="name">Họ và tên</label>
                        <div class="input-group-custom">
                            <i class="fas fa-user icon"></i>
                            <input type="text" id="name" name="name"
                                class="@error('name') is-invalid @enderror" value="{{ old('name') }}"
                                placeholder="Nhập họ và tên" required autofocus>
                        </div>
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <div class="input-group-custom">
                            <i class="fas fa-envelope icon"></i>
                            <input type="email" id="email" name="email"
                                class="@error('email') is-invalid @enderror" value="{{ old('email') }}"
                                placeholder="Nhập địa chỉ email" required>
                        </div>
                        @error('email')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Mật khẩu</label>
                        <div class="input-group-custom">
                            <i class="fas fa-lock icon"></i>
                            <input type="password" id="password" name="password"
                                class="@error('password') is-invalid @enderror" placeholder="Nhập mật khẩu" required>
                            <span class="toggle-password" onclick="togglePassword('password', 'toggleIcon1')">
                                <i class="fas fa-eye" id="toggleIcon1"></i>
                            </span>
                        </div>
                        <div class="password-requirements">
                            <i class="fas fa-info-circle"></i> Mật khẩu tối thiểu 8 ký tự
                        </div>
                        @error('password')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password-confirm">Xác nhận mật khẩu</label>
                        <div class="input-group-custom">
                            <i class="fas fa-lock icon"></i>
                            <input type="password" id="password-confirm" name="password_confirmation"
                                placeholder="Nhập lại mật khẩu" required>
                            <span class="toggle-password" onclick="togglePassword('password-confirm', 'toggleIcon2')">
                                <i class="fas fa-eye" id="toggleIcon2"></i>
                            </span>
                        </div>
                    </div>

                    <button type="submit" class="btn-register">
                        <i class="fas fa-user-plus me-2"></i>Đăng ký
                    </button>

                    <div class="terms">
                        Bằng việc đăng ký, bạn đồng ý với <a href="#">Điều khoản sử dụng</a> và <a
                            href="#">Chính sách bảo mật</a>
                    </div>
                </form>

                {{-- Tạm ẩn đăng ký social - Bỏ comment khi đã cấu hình Google/Facebook OAuth credentials
                <div class="divider">
                    <span>Hoặc đăng ký với</span>
                </div>

                <div class="social-register">
                    <a href="{{ url('/auth/google') }}" class="btn-social google">
                        <i class="fab fa-google"></i>
                        <span>Google</span>
                    </a>
                    <a href="{{ url('/auth/facebook') }}" class="btn-social facebook">
                        <i class="fab fa-facebook-f"></i>
                        <span>Facebook</span>
                    </a>
                </div>
                --}}

                <div class="login-link">
                    Đã có tài khoản? <a href="{{ route('login') }}">Đăng nhập ngay</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const toggleIcon = document.getElementById(iconId);

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>

</html>
