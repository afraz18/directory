<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Bharat Directory</title>
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
            left: -150px;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(249, 115, 22, 0.15) 0%, transparent 70%);
            border-radius: 50%;
        }

        body::after {
            content: '';
            position: absolute;
            bottom: -100px;
            right: -100px;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.1) 0%, transparent 70%);
            border-radius: 50%;
        }

        /* Signup Container */
        .signup-container {
            width: 100%;
            max-width: 480px;
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

        /* Signup Card */
        .signup-card {
            background: var(--white);
            border-radius: 24px;
            padding: 2.5rem 2rem;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.3);
        }

        .signup-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .signup-header h1 {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }

        .signup-header p {
            color: var(--gray);
            font-size: 0.95rem;
        }

        /* Form */
        .signup-form {
            display: flex;
            flex-direction: column;
            gap: 1.1rem;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .form-group {
            position: relative;
        }

        .form-group label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--dark-light);
            margin-bottom: 0.4rem;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i.icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-light);
            font-size: 0.95rem;
            transition: color 0.3s;
        }

        .input-wrapper input {
            width: 100%;
            padding: 0.85rem 1rem 0.85rem 2.65rem;
            border: 2px solid var(--light);
            border-radius: 10px;
            font-family: inherit;
            font-size: 0.9rem;
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
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.1);
        }

        .input-wrapper input:focus + i.icon {
            color: var(--primary);
        }

        /* Password Toggle */
        .password-toggle {
            position: absolute;
            right: 0.85rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--gray-light);
            cursor: pointer;
            font-size: 0.95rem;
            transition: color 0.3s;
        }

        .password-toggle:hover {
            color: var(--primary);
        }

        /* Password Strength */
        .password-strength {
            display: flex;
            gap: 0.25rem;
            margin-top: 0.4rem;
        }

        .strength-bar {
            flex: 1;
            height: 4px;
            background: var(--light);
            border-radius: 2px;
            transition: background 0.3s;
        }

        .strength-bar.weak { background: var(--error); }
        .strength-bar.medium { background: #f59e0b; }
        .strength-bar.strong { background: var(--success); }

        /* Terms */
        .terms {
            display: flex;
            align-items: flex-start;
            gap: 0.6rem;
            margin-top: 0.5rem;
        }

        .terms input {
            width: 18px;
            height: 18px;
            accent-color: var(--primary);
            cursor: pointer;
            margin-top: 0.15rem;
        }

        .terms label {
            font-size: 0.85rem;
            color: var(--gray);
            line-height: 1.5;
            cursor: pointer;
        }

        .terms a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }

        .terms a:hover {
            text-decoration: underline;
        }

        /* Submit Button */
        .btn-signup {
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
            margin-top: 0.75rem;
        }

        .btn-signup:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(249, 115, 22, 0.45);
        }

        .btn-signup:active {
            transform: translateY(0);
        }

        .btn-signup.loading {
            pointer-events: none;
            opacity: 0.8;
        }

        .btn-signup.loading i {
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
            margin: 1.25rem 0;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--light);
        }

        .divider span {
            font-size: 0.8rem;
            color: var(--gray-light);
        }

        /* Social Signup */
        .social-signup {
            display: flex;
            gap: 0.75rem;
        }

        .btn-social {
            flex: 1;
            padding: 0.8rem;
            border: 2px solid var(--light);
            border-radius: 10px;
            background: var(--white);
            font-family: inherit;
            font-size: 1rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            transition: all 0.3s;
        }

        .btn-social span {
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--gray);
        }

        .btn-social:hover {
            border-color: var(--gray-light);
            background: var(--light);
        }

        .btn-social.google i { color: #ea4335; }
        .btn-social.facebook i { color: #1877f2; }

        /* Login Link */
        .login-link {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.9rem;
            color: var(--gray);
        }

        .login-link a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
        }

        .login-link a:hover {
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
        @media (max-width: 520px) {
            .signup-card {
                padding: 2rem 1.5rem;
                border-radius: 20px;
            }

            .signup-header h1 {
                font-size: 1.5rem;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .social-signup {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>

    <div class="signup-container">
        <!-- Logo -->
        <a href="index.php" class="logo">
            <div class="logo-icon">
                <i class="fas fa-building"></i>
            </div>
            <span class="logo-text">Bharat Directory</span>
        </a>

        <!-- Signup Card -->
        <div class="signup-card">
            <div class="signup-header">
                <h1>Create Account 🚀</h1>
                <p>Join Bharat Directory today</p>
            </div>

            <form class="signup-form" id="signupForm">
                <!-- Name Row -->
                <div class="form-row">
                    <div class="form-group">
                        <label>First Name</label>
                        <div class="input-wrapper">
                            <input 
                                type="text" 
                                name="first_name" 
                                placeholder="First name"
                                required
                            >
                            <i class="fas fa-user icon"></i>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <div class="input-wrapper">
                            <input 
                                type="text" 
                                name="last_name" 
                                placeholder="Last name"
                                required
                            >
                            <i class="fas fa-user icon"></i>
                        </div>
                    </div>
                </div>

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
                        <i class="fas fa-envelope icon"></i>
                    </div>
                </div>

                <!-- Phone -->
                <div class="form-group">
                    <label>Phone Number</label>
                    <div class="input-wrapper">
                        <input 
                            type="tel" 
                            name="phone" 
                            placeholder="+91 98765 43210"
                            required
                        >
                        <i class="fas fa-phone icon"></i>
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
                            placeholder="Create a password"
                            required
                        >
                        <i class="fas fa-lock icon"></i>
                        <button type="button" class="password-toggle" id="togglePassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <div class="password-strength" id="strengthBars">
                        <div class="strength-bar"></div>
                        <div class="strength-bar"></div>
                        <div class="strength-bar"></div>
                        <div class="strength-bar"></div>
                    </div>
                </div>

                <!-- Confirm Password -->
                <div class="form-group">
                    <label>Confirm Password</label>
                    <div class="input-wrapper">
                        <input 
                            type="password" 
                            name="confirm_password" 
                            id="confirmPassword"
                            placeholder="Confirm your password"
                            required
                        >
                        <i class="fas fa-lock icon"></i>
                        <button type="button" class="password-toggle" id="toggleConfirmPassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <!-- Terms -->
                <div class="terms">
                    <input type="checkbox" id="terms" name="terms" required>
                    <label for="terms">
                        I agree to the <a href="terms.php">Terms of Service</a> and <a href="privacy.php">Privacy Policy</a>
                    </label>
                </div>

                <!-- Submit -->
                <button type="submit" class="btn-signup" id="signupBtn">
                    <span>Create Account</span>
                    <i class="fas fa-arrow-right"></i>
                </button>
            </form>

            <!-- Divider -->
            <div class="divider">
                <span>or sign up with</span>
            </div>

            <!-- Social Signup -->
            <div class="social-signup">
                <button type="button" class="btn-social google">
                    <i class="fab fa-google"></i>
                    <span>Google</span>
                </button>
                <button type="button" class="btn-social facebook">
                    <i class="fab fa-facebook-f"></i>
                    <span>Facebook</span>
                </button>
            </div>

            <!-- Login Link -->
            <p class="login-link">
                Already have an account? <a href="login.php">Login here</a>
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
        function setupPasswordToggle(toggleId, inputId) {
            const toggle = document.getElementById(toggleId);
            const input = document.getElementById(inputId);

            toggle.addEventListener('click', function() {
                const type = input.type === 'password' ? 'text' : 'password';
                input.type = type;
                this.querySelector('i').classList.toggle('fa-eye');
                this.querySelector('i').classList.toggle('fa-eye-slash');
            });
        }

        setupPasswordToggle('togglePassword', 'password');
        setupPasswordToggle('toggleConfirmPassword', 'confirmPassword');

        // Password Strength
        const passwordInput = document.getElementById('password');
        const strengthBars = document.querySelectorAll('.strength-bar');

        passwordInput.addEventListener('input', function() {
            const password = this.value;
            let strength = 0;

            if (password.length >= 6) strength++;
            if (password.length >= 10) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^A-Za-z0-9]/.test(password)) strength++;

            strengthBars.forEach((bar, index) => {
                bar.classList.remove('weak', 'medium', 'strong');
                if (index < strength) {
                    if (strength <= 2) bar.classList.add('weak');
                    else if (strength <= 3) bar.classList.add('medium');
                    else bar.classList.add('strong');
                }
            });
        });

        // Form Submit
        const signupForm = document.getElementById('signupForm');
        const signupBtn = document.getElementById('signupBtn');

        signupForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value;

            if (password !== confirmPassword) {
                alert('Passwords do not match!');
                return;
            }

            // Loading state
            signupBtn.classList.add('loading');
            signupBtn.innerHTML = '<i class="fas fa-spinner"></i> <span>Creating account...</span>';

            // Simulate API call
            setTimeout(() => {
                signupBtn.classList.remove('loading');
                signupBtn.innerHTML = '<span>Create Account</span> <i class="fas fa-arrow-right"></i>';
                
                // Redirect or show success
                alert('Account created successfully!');
                // window.location.href = 'login.php';
            }, 2000);
        });

        // Phone formatting
        document.querySelector('input[name="phone"]').addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9+\-\s]/g, '');
        });
    </script>

</body>
</html>