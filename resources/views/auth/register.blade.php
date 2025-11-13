@extends('layouts.app')

@section('content')
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
        }

        .register-container {
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
            max-width: 480px;
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

        .text-muted {
            color: #6c757d;
        }

        .login-link {
            text-align: center;
            margin-top: 15px;
            font-size: 0.95rem;
        }

        .login-link a {
            color: #007bff;
            text-decoration: none;
            font-weight: 500;
        }

        .login-link a:hover {
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

    <div class="register-container">
        <div class="card">
            <div class="card-header">{{ __('Đăng ký tài khoản') }}</div>

            <div class="card-body">
                <p class="text-center text-muted mb-4">
                    Vui lòng điền đầy đủ thông tin để tạo tài khoản mới.
                </p>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="name">{{ __('Họ và tên') }}</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                            name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email">{{ __('Email') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="email">

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password">{{ __('Mật khẩu') }}</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" required autocomplete="new-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password-confirm">{{ __('Xác nhận mật khẩu') }}</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                            required autocomplete="new-password">
                    </div>

                    <button type="submit" class="btn btn-primary">
                        {{ __('Đăng ký') }}
                    </button>

                    <div class="login-link">
                        <p>Đã có tài khoản?
                            <a href="{{ route('login') }}">Đăng nhập ngay</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
