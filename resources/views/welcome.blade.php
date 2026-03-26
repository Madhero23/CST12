<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login | RozMed Medical Equipment & Supplies</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        /* ===== Variables (matching project theme) ===== */
        :root {
            --primary-color: #235c63;
            --secondary-color: #2f7a85;
            --accent-color: #5fb1b7;
            --red-accent: #dc143c;
            --text-dark: #0f172a;
            --text-gray: #475569;
            --light-bg: #f4f9fa;
            --white: #ffffff;
            --transition: all 0.3s ease;
            --shadow-sm: 0px 4px 6px -4px rgba(0, 0, 0, 0.1), 0px 10px 15px -3px rgba(0, 0, 0, 0.1);
            --shadow-md: 0px 10px 15px -3px rgba(0, 0, 0, 0.1), 0px 4px 6px -4px rgba(0, 0, 0, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
            background: var(--light-bg);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        /* ===== Background decoration ===== */
        body::before {
            content: '';
            position: absolute;
            top: -120px;
            right: -120px;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(95, 177, 183, 0.15) 0%, transparent 70%);
            border-radius: 50%;
            z-index: 0;
        }

        body::after {
            content: '';
            position: absolute;
            bottom: -100px;
            left: -100px;
            width: 350px;
            height: 350px;
            background: radial-gradient(circle, rgba(220, 20, 60, 0.08) 0%, transparent 70%);
            border-radius: 50%;
            z-index: 0;
        }

        /* ===== Login Container ===== */
        .login-container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 440px;
            padding: 0 1.25rem;
            animation: fadeInUp 0.6s ease-out;
        }

        /* ===== Login Card ===== */
        .login-card {
            background: var(--white);
            border: 1.25px solid rgba(95, 177, 183, 0.2);
            border-radius: 16px;
            padding: 2.5rem 2rem;
            box-shadow: var(--shadow-md);
            transition: var(--transition);
        }

        .login-card:hover {
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
        }

        /* ===== Logo / Branding ===== */
        .login-brand {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-brand-icon {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, rgba(47, 122, 133, 0.15) 0%, rgba(95, 177, 183, 0.15) 100%);
            border: 1px solid rgba(95, 177, 183, 0.3);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            color: var(--secondary-color);
            font-size: 1.4rem;
        }

        .login-brand h1 {
            font-size: 28px;
            font-weight: 700;
            letter-spacing: 1px;
            line-height: 1;
            margin-bottom: 0.5rem;
        }

        .login-brand h1 .roz-red {
            color: var(--red-accent);
        }

        .login-brand h1 .med-blue {
            color: var(--secondary-color);
        }

        .login-brand p {
            color: var(--text-gray);
            font-size: 14px;
            line-height: 20px;
        }

        /* ===== Form ===== */
        .login-form {
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.4rem;
        }

        .form-group label {
            color: var(--primary-color);
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 0.3px;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-wrapper i.field-icon {
            position: absolute;
            left: 14px;
            color: var(--accent-color);
            font-size: 14px;
            pointer-events: none;
            transition: color 0.2s ease;
        }

        .input-wrapper input {
            width: 100%;
            padding: 0.7rem 0.75rem 0.7rem 2.5rem;
            border: 1.25px solid rgba(95, 177, 183, 0.3);
            border-radius: 10px;
            font-family: inherit;
            font-size: 14px;
            color: var(--text-dark);
            background: var(--light-bg);
            outline: none;
            transition: var(--transition);
        }

        .input-wrapper input:focus {
            border-color: var(--secondary-color);
            background: var(--white);
            box-shadow: 0 0 0 3px rgba(47, 122, 133, 0.12);
        }

        .input-wrapper input::placeholder {
            color: #94a3b8;
        }

        /* Error state for inputs */
        .input-wrapper input.input-error {
            border-color: var(--red-accent);
        }

        .input-wrapper input.input-error:focus {
            box-shadow: 0 0 0 3px rgba(220, 20, 60, 0.12);
        }

        .toggle-password {
            position: absolute;
            right: 14px;
            background: none;
            border: none;
            color: var(--text-gray);
            cursor: pointer;
            font-size: 14px;
            padding: 4px;
            pointer-events: all;
            transition: color 0.2s ease;
        }

        .toggle-password:hover {
            color: var(--secondary-color);
        }

        /* ===== Inline Validation Error (FR-AUTH-03) ===== */
        .field-error {
            color: var(--red-accent);
            font-size: 12px;
            margin-top: 2px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .field-error i {
            font-size: 11px;
        }

        /* ===== Generic Login Error Alert (FR-AUTH-02) ===== */
        .login-alert {
            background: rgba(220, 20, 60, 0.08);
            border: 1px solid rgba(220, 20, 60, 0.2);
            border-radius: 8px;
            padding: 0.6rem 0.9rem;
            color: var(--red-accent);
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.25rem;
        }

        /* ===== Remember Me & Forgot ===== */
        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: -0.25rem;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            cursor: pointer;
        }

        .remember-me input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: var(--secondary-color);
            cursor: pointer;
        }

        .remember-me span {
            color: var(--text-gray);
            font-size: 13px;
        }

        .forgot-link {
            color: var(--secondary-color);
            font-size: 13px;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .forgot-link:hover {
            color: var(--primary-color);
            text-decoration: underline;
        }

        /* ===== Submit Button ===== */
        .btn-login {
            width: 100%;
            padding: 0.75rem 1.5rem;
            background: var(--secondary-color);
            color: var(--white);
            border: none;
            border-radius: 12px;
            font-family: inherit;
            font-size: 15px;
            font-weight: 600;
            letter-spacing: 0.4px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.6rem;
            transition: var(--transition);
            margin-top: 0.25rem;
        }

        .btn-login:hover {
            background: var(--primary-color);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(35, 92, 99, 0.25);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        /* ===== Divider ===== */
        .login-divider {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-top: 0.25rem;
        }

        .login-divider::before,
        .login-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(95, 177, 183, 0.2);
        }

        .login-divider span {
            color: var(--text-gray);
            font-size: 12px;
            letter-spacing: 0.3px;
            white-space: nowrap;
        }

        /* ===== Back to Home Link ===== */
        .back-home {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            color: var(--accent-color);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: var(--transition);
        }

        .back-home:hover {
            color: var(--secondary-color);
            gap: 0.65rem;
        }

        /* ===== Animation ===== */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ===== Responsive ===== */
        @media (max-width: 480px) {
            .login-card {
                padding: 2rem 1.5rem;
            }

            .login-brand h1 {
                font-size: 24px;
            }

            .form-options {
                flex-direction: column;
                gap: 0.5rem;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>

    <div class="login-container">
        <div class="login-card">
            <!-- Branding -->
            <div class="login-brand">
                <div class="login-brand-icon">
                    <i class="fas fa-heartbeat"></i>
                </div>
                <h1>
                    <span class="roz-red">Roz</span><span class="med-blue">Med</span>
                </h1>
                <p>Sign in to admin panel</p>
            </div>

            {{-- FR-AUTH-02: Generic login error message --}}
            @if($errors->has('login'))
                <div class="login-alert">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>{{ $errors->first('login') }}</span>
                </div>
            @endif

            {{-- Login Form — standard POST, no JS preventDefault --}}
            <form class="login-form" id="loginForm" method="POST" action="{{ route('login.submit') }}">
                @csrf

                <div class="form-group">
                    <label for="Username">Username</label>
                    <div class="input-wrapper">
                        <i class="fas fa-user field-icon"></i>
                        <input type="text"
                               id="Username"
                               name="Username"
                               placeholder="Enter your username"
                               value="{{ old('Username') }}"
                               autocomplete="username"
                               class="{{ $errors->has('Username') ? 'input-error' : '' }}">
                    </div>
                    {{-- FR-AUTH-03: Inline validation error for Username --}}
                    @error('Username')
                        <div class="field-error">
                            <i class="fas fa-exclamation-circle"></i>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="Password">Password</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock field-icon"></i>
                        <input type="password"
                               id="Password"
                               name="Password"
                               placeholder="Enter your password"
                               autocomplete="current-password"
                               class="{{ $errors->has('Password') ? 'input-error' : '' }}">
                        <button type="button" class="toggle-password" id="togglePassword" aria-label="Toggle password visibility">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    {{-- FR-AUTH-03: Inline validation error for Password --}}
                    @error('Password')
                        <div class="field-error">
                            <i class="fas fa-exclamation-circle"></i>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                </div>

                <div class="form-options">
                    <label class="remember-me">
                        <input type="checkbox" name="remember">
                        <span>Remember me</span>
                    </label>
                    <a href="#" class="forgot-link">Forgot password?</a>
                </div>

                <button type="submit" class="btn-login" id="btnLogin">
                    <i class="fas fa-sign-in-alt"></i>
                    <span>Sign In</span>
                </button>

                <div class="login-divider">
                    <span>or</span>
                </div>

                <a href="{{ route('home.index') }}" class="back-home">
                    <i class="fas fa-arrow-left"></i>
                    <span>Back to Home</span>
                </a>
            </form>
        </div>
    </div>

    <script>
        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function () {
            const passwordInput = document.getElementById('Password');
            const icon = this.querySelector('i');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        });
    </script>

</body>
</html>