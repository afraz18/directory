<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Bharat Directory</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #f97316;
            --primary-dark: #ea580c;
            --primary-light: #fed7aa;
            --dark: #0f172a;
            --dark-light: #1e293b;
            --gray: #64748b;
            --gray-light: #94a3b8;
            --light: #f1f5f9;
            --white: #ffffff;
            --success: #10b981;
            --error: #ef4444;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, var(--dark) 0%, var(--dark-light) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
            position: relative;
            overflow-x: hidden;
        }

        /* Background Decorations */
        body::before {
            content: '';
            position: absolute;
            top: -150px;
            right: -150px;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(249, 115, 22, 0.15) 0%, transparent 70%);
            border-radius: 50%;
        }

        body::after {
            content: '';
            position: absolute;
            bottom: -100px;
            left: -100px;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.1) 0%, transparent 70%);
            border-radius: 50%;
        }

        /* Login Container */
        .login-container {
            width: 100%;
            max-width: 420px;
            position: relative;
            z-index: 1;
        }

        /* Logo */
        .logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.6rem;
            margin-bottom: 2rem;
            text-decoration: none;
        }

        .logo-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 25px rgba(249, 115, 22, 0.35);
        }

        .logo-icon i {
            font-size: 1.4rem;
            color: var(--white);
        }

        .logo-text {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--white);
        }

        /* Login Card */
        .login-card {
            background: var(--white);
            border-radius: 24px;
            padding: 2.5rem 2rem;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.3);
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-header h1 {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }

        .login-header p {
            color: var(--gray);
            font-size: 0.95rem;
        }

        /* Form */
        .login-form {
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
        }

        .form-group {
            position: relative;
        }

        .form-group label {
            display: block;
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--dark-light);
            margin-bottom: 0.5rem;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-light);
            font-size: 1rem;
            transition: color 0.3s;
        }

        .input-wrapper input {
            width: 100%;
            padding: 0.9rem 1rem 0.9rem 2.75rem;
            border: 2px solid var(--light);
            border-radius: 12px;
            font-family: inherit;
            font-size: 0.95rem;
            color: var(--dark);
            background: var(--light);
            transition: all 0.3s;
        }

        .input-wrapper input::placeholder {
            color: var(--gray-light);
        }

        .input-wrapper input:focus {
            outline: none;
            border-color: var(--primary);
            background: var(--white);
            box-shadow: 0 0 0 4px rgba(249, 115, 22, 0.1);
        }

        .input-wrapper input:focus + i,
        .input-wrapper input:not(:placeholder-shown) + i {
            color: var(--primary);
        }

        /* Password Toggle */
        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--gray-light);
            cursor: pointer;
            font-size: 1rem;
            transition: color 0.3s;
        }

        .password-toggle:hover {
            color: var(--primary);
        }

        /* Remember & Forgot */
        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
        }

        .remember-me input {
            width: 18px;
            height: 18px;
            accent-color: var(--primary);
            cursor: pointer;
        }

        .remember-me span {
            font-size: 0.9rem;
            color: var(--gray);
        }

        .forgot-link {
            font-size: 0.9rem;
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }

        .forgot-link:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        /* Submit Button */
        .btn-login {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: var(--white);
            border: none;
            border-radius: 12px;
            font-family: inherit;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            box-shadow: 0 4px 15px rgba(249, 115, 22, 0.35);
            transition: all 0.3s;
            margin-top: 0.5rem;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(249, 115, 22, 0.45);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .btn-login.loading {
            pointer-events: none;
            opacity: 0.8;
        }

        .btn-login.loading i {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Divider */
        .divider {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin: 1.5rem 0;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--light);
        }

        .divider span {
            font-size: 0.85rem;
            color: var(--gray-light);
        }

        /* Social Login */
        .social-login {
            display: flex;
            gap: 0.75rem;
        }

        .btn-social {
            flex: 1;
            padding: 0.85rem;
            border: 2px solid var(--light);
            border-radius: 12px;
            background: var(--white);
            font-family: inherit;
            font-size: 1.1rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            transition: all 0.3s;
        }

        .btn-social:hover {
            border-color: var(--gray-light);
            background: var(--light);
        }

        .btn-social.google { color: #ea4335; }
        .btn-social.facebook { color: #1877f2; }

        /* Signup Link */
        .signup-link {
            text-align: center;
            margin-top: 2rem;
            font-size: 0.95rem;
            color: var(--gray);
        }

        .signup-link a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
        }

        .signup-link a:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        /* Back to Home */
        .back-home {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 1.5rem;
            font-size: 0.9rem;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            transition: color 0.3s;
        }

        .back-home:hover {
            color: var(--white);
        }

        /* Responsive */
        @media (max-width: 480px) {
            .login-card {
                padding: 2rem 1.5rem;
                border-radius: 20px;
            }

            .login-header h1 {
                font-size: 1.5rem;
            }

            .social-login {
                flex-direction: column;
            }

            .form-options {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.75rem;
            }
        }
    </style>
</head>
<body>

    <div class="login-container">
        <!-- Logo -->
        <a href="index.php" class="logo">
            <div class="logo-icon">
                <i class="fas fa-building"></i>
            </div>
            <span class="logo-text">Bharat Directory</span>
        </a>

        <!-- Login Card -->
        <div class="login-card">
            <div class="login-header">
                <h1>Welcome Back! 👋</h1>
                <p>Login to your account to continue</p>
            </div>

            <form class="login-form" id="loginForm">
                <!-- Email -->
                <div class="form-group">
                    <label>Email Address</label>
                    <div class="input-wrapper">
                        <input 
                            type="email" 
                            name="email" 
                            placeholder="Enter your email"
                            required
                        >
                        <i class="fas fa-envelope"></i>
                    </div>
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label>Password</label>
                    <div class="input-wrapper">
                        <input 
                            type="password" 
                            name="password" 
                            id="password"
                            placeholder="Enter your password"
                            required
                        >
                        <i class="fas fa-lock"></i>
                        <button type="button" class="password-toggle" id="togglePassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <!-- Remember & Forgot -->
                <div class="form-options">
                    <label class="remember-me">
                        <input type="checkbox" name="remember">
                        <span>Remember me</span>
                    </label>
                    <a href="forgot-password.php" class="forgot-link">Forgot Password?</a>
                </div>

                <!-- Submit -->
                <button type="submit" class="btn-login" id="loginBtn">
                    <span>Login</span>
                    <i class="fas fa-arrow-right"></i>
                </button>
            </form>

            <!-- Divider -->
            <div class="divider">
                <span>or continue with</span>
            </div>

            <!-- Social Login -->
            <div class="social-login">
                <button type="button" class="btn-social google">
                    <i class="fab fa-google"></i>
                </button>
                <button type="button" class="btn-social facebook">
                    <i class="fab fa-facebook-f"></i>
                </button>
            </div>

            <!-- Signup Link -->
            <p class="signup-link">
                Don't have an account? <a href="signup.php">Sign up free</a>
            </p>
        </div>

        <!-- Back to Home -->
        <a href="index.php" class="back-home">
            <i class="fas fa-arrow-left"></i>
            Back to Home
        </a>
    </div>

    <script>
        // Password Toggle
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');

        togglePassword.addEventListener('click', function() {
            const type = passwordInput.type === 'password' ? 'text' : 'password';
            passwordInput.type = type;
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });

        // Form Submit
        const loginForm = document.getElementById('loginForm');
        const loginBtn = document.getElementById('loginBtn');

        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();

            // Loading state
            loginBtn.classList.add('loading');
            loginBtn.innerHTML = '<i class="fas fa-spinner"></i> <span>Logging in...</span>';

            // Simulate API call
            setTimeout(() => {
                loginBtn.classList.remove('loading');
                loginBtn.innerHTML = '<span>Login</span> <i class="fas fa-arrow-right"></i>';
                
                // Redirect or show success
                alert('Login successful!');
                // window.location.href = 'dashboard.php';
            }, 2000);
        });
    </script>

</body>
</html>