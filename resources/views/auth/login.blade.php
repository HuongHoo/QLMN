@extends('layouts.app')

@section('content')
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
        }

        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.08);
            background: #ffffff;
            width: 100%;
            max-width: 420px;
            animation: fadeIn 0.5s ease-in-out;
        }

        .card-header {
            background: transparent;
            text-align: center;
            font-size: 1.5rem;
            font-weight: 600;
            color: #007bff;
            border-bottom: none;
            margin-top: 10px;
        }

        .card-body {
            padding: 2rem;
        }

        label {
            font-weight: 500;
            color: #333;
        }

        .form-control {
            border-radius: 10px;
            padding: 10px 12px;
            border: 1px solid #ced4da;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            border-radius: 25px;
            padding: 10px 25px;
            width: 100%;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }

        .form-check-label {
            color: #555;
            font-size: 0.9rem;
        }

        a.btn-link {
            color: #007bff;
            text-decoration: none;
            font-size: 0.9rem;
        }

        a.btn-link:hover {
            text-decoration: underline;
        }

        .login-title {
            text-align: center;
            color: #666;
            margin-bottom: 20px;
            font-size: 1rem;
        }

        .register-link {
            text-align: center;
            margin-top: 20px;
            font-size: 0.95rem;
            color: #555;
        }

        .register-link a {
            color: #007bff;
            text-decoration: none;
            font-weight: 500;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <div class="login-container">
        <div class="card">
            <div class="card-header">{{ __('Đăng nhập') }}</div>

            <div class="card-body">
                {{-- Hiển thị thông báo đăng ký thành công --}}
                @if (session('success'))
                    <div class="alert alert-success text-center mt-2">
                        {{ session('success') }}
                    </div>
                @endif

                <p class="login-title">Chào mừng bạn quay lại! Vui lòng đăng nhập để tiếp tục.</p>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email">{{ __('Email') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password">{{ __('Mật khẩu') }}</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" required autocomplete="current-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3 form-check d-flex align-items-center">
                        <input class="form-check-input me-2" type="checkbox" name="remember" id="remember"
                            {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">
                            {{ __('Ghi nhớ đăng nhập') }}
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        {{ __('Đăng nhập') }}
                    </button>

                    @if (Route::has('password.request'))
                        <div class="text-center mt-3">
                            <a class="btn-link" href="{{ route('password.request') }}">
                                {{ __('Quên mật khẩu?') }}
                            </a>
                        </div>
                    @endif
                </form>

                {{-- Thêm liên kết đăng ký --}}
                <div class="register-link">
                    <p>Chưa có tài khoản?
                        <a href="{{ route('register') }}">Đăng ký ngay</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
