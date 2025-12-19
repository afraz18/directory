
    <style>
        /* ============================================
           CSS RESET & VARIABLES
        ============================================ */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #f97316;
            --primary-dark: #ea580c;
            --primary-light: #fb923c;
            --primary-gradient: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            
            --dark: #0f172a;
            --dark-light: #1e293b;
            --dark-gradient: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            
            --white: #ffffff;
            --gray-50: #f8fafc;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gray-300: #cbd5e1;
            --gray-400: #94a3b8;
            --gray-500: #64748b;
            --gray-600: #475569;
            --gray-700: #334155;
            --gray-800: #1e293b;
            
            --success: #10b981;
            --success-light: #d1fae5;
            --error: #ef4444;
            --warning: #f59e0b;
            
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.08);
            --shadow-md: 0 4px 15px rgba(0,0,0,0.1);
            --shadow-lg: 0 10px 30px rgba(0,0,0,0.15);
            --shadow-orange: 0 4px 20px rgba(249, 115, 22, 0.3);
            
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 16px;
            --radius-xl: 24px;
            --radius-full: 50px;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--gray-50);
            color: var(--gray-800);
            min-height: 100vh;
            line-height: 1.6;
        }
        /* ============================================
           HERO SECTION
        ============================================ */
        .hero {
            background: var(--dark-gradient);
            padding: 8rem 2rem 4rem;
            text-align: center;
            color: var(--white);
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: -100px;
            right: -100px;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(249, 115, 22, 0.15) 0%, transparent 70%);
            border-radius: 50%;
        }

        .hero::after {
            content: '';
            position: absolute;
            bottom: -150px;
            left: -150px;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.08) 0%, transparent 70%);
            border-radius: 50%;
        }

        .hero-content {
            position: relative;
            z-index: 1;
            max-width: 700px;
            margin: 0 auto;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(249, 115, 22, 0.15);
            color: #fbbf24;
            padding: 0.6rem 1.5rem;
            border-radius: var(--radius-full);
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 1.25rem;
            border: 1px solid rgba(251, 191, 36, 0.25);
            backdrop-filter: blur(10px);
        }

        .hero-badge i {
            font-size: 1rem;
        }

        .hero h1 {
            font-size: 2.75rem;
            font-weight: 800;
            margin-bottom: 1rem;
            line-height: 1.2;
            letter-spacing: -0.5px;
        }

        .hero h1 span {
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero p {
            font-size: 1.15rem;
            color: var(--gray-300);
            margin-bottom: 2rem;
        }

        .hero-features {
            display: flex;
            justify-content: center;
            gap: 2rem;
            flex-wrap: wrap;
        }

        .hero-feature {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--gray-300);
            font-size: 0.95rem;
        }

        .hero-feature i {
            color: var(--success);
            font-size: 1rem;
        }

        /* ============================================
           MAIN CONTAINER
        ============================================ */
        .main-container {
            max-width: 1000px;
            margin: -3rem auto 0;
            padding: 0 1.5rem 3rem;
            position: relative;
            z-index: 10;
        }

        /* ============================================
           ALERTS
        ============================================ */
        .alert {
            padding: 1.25rem 1.5rem;
            border-radius: var(--radius-lg);
            margin-bottom: 1.5rem;
            display: none;
            align-items: center;
            gap: 1rem;
            animation: slideDown 0.4s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: var(--white);
            box-shadow: 0 4px 20px rgba(16, 185, 129, 0.25);
        }

        .alert-error {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: var(--white);
            box-shadow: 0 4px 20px rgba(239, 68, 68, 0.25);
        }

        .alert i {
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .alert-content strong {
            display: block;
            font-weight: 600;
            margin-bottom: 0.15rem;
        }

        .alert-content span {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .alert-close {
            margin-left: auto;
            background: none;
            border: none;
            color: var(--white);
            cursor: pointer;
            padding: 0.5rem;
            opacity: 0.7;
            transition: opacity 0.3s;
        }

        .alert-close:hover {
            opacity: 1;
        }

        /* ============================================
           FORM CARD
        ============================================ */
        .form-card {
            background: var(--white);
            border-radius: var(--radius-xl);
            padding: 2.5rem;
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--gray-100);
        }

        .form-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .form-header-icon {
            width: 70px;
            height: 70px;
            background: var(--primary-gradient);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.25rem;
            box-shadow: var(--shadow-orange);
        }

        .form-header-icon i {
            font-size: 1.75rem;
            color: var(--white);
        }

        .form-header h2 {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--gray-800);
            margin-bottom: 0.5rem;
        }

        .form-header p {
            color: var(--gray-500);
            font-size: 1rem;
        }

        /* ============================================
           FORM SECTIONS
        ============================================ */
        .form-section {
            margin-bottom: 2rem;
        }

        .form-section:last-child {
            margin-bottom: 0;
        }

        .section-title {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid var(--gray-100);
        }

        .section-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, rgba(249, 115, 22, 0.1) 0%, rgba(234, 88, 12, 0.15) 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .section-icon i {
            font-size: 1rem;
            color: var(--primary);
        }

        .section-title h3 {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--gray-800);
        }

        /* ============================================
           FORM GRID
        ============================================ */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }

        .form-group {
            position: relative;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        /* ============================================
           FORM LABELS
        ============================================ */
        .form-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.6rem;
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--gray-700);
        }

        .form-label i {
            color: var(--primary);
            font-size: 0.85rem;
            width: 18px;
        }

        .form-label .required {
            color: var(--error);
            font-weight: 700;
        }

        .form-label .optional {
            color: var(--gray-400);
            font-weight: 400;
            font-size: 0.8rem;
            margin-left: auto;
        }

        /* ============================================
           FORM INPUTS
        ============================================ */
        .form-input,
        .form-select {
            width: 100%;
            padding: 0.9rem 1rem;
            border: 2px solid var(--gray-200);
            border-radius: var(--radius-md);
            font-family: inherit;
            font-size: 0.95rem;
            color: var(--gray-800);
            background: var(--gray-50);
            transition: all 0.3s ease;
        }

        .form-input::placeholder {
            color: var(--gray-400);
        }

        .form-input:hover,
        .form-select:hover {
            border-color: var(--gray-300);
        }

        .form-input:focus,
        .form-select:focus {
            outline: none;
            border-color: var(--primary);
            background: var(--white);
            box-shadow: 0 0 0 4px rgba(249, 115, 22, 0.1);
        }

        .form-select {
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2394a3b8'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 1.25rem;
            padding-right: 3rem;
        }

        .form-hint {
            display: flex;
            align-items: center;
            gap: 0.35rem;
            margin-top: 0.4rem;
            font-size: 0.8rem;
            color: var(--gray-400);
        }

        .form-hint i {
            font-size: 0.7rem;
        }

        /* Input with Icon */
        .input-icon-wrapper {
            position: relative;
        }

        .input-icon-wrapper .form-input {
            padding-left: 2.75rem;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-400);
            font-size: 0.95rem;
            pointer-events: none;
            transition: color 0.3s ease;
        }

        .input-icon-wrapper .form-input:focus + .input-icon,
        .input-icon-wrapper .form-input:not(:placeholder-shown) + .input-icon {
            color: var(--primary);
        }

        /* ============================================
           SUBMIT SECTION
        ============================================ */
        .submit-section {
            margin-top: 2.5rem;
            padding-top: 2rem;
            border-top: 2px solid var(--gray-100);
            text-align: center;
        }

        .submit-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            background: var(--primary-gradient);
            color: var(--white);
            padding: 1.1rem 3rem;
            border: none;
            border-radius: var(--radius-full);
            font-family: inherit;
            font-size: 1.05rem;
            font-weight: 600;
            cursor: pointer;
            box-shadow: var(--shadow-orange);
            transition: all 0.3s ease;
            min-width: 250px;
        }

        .submit-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(249, 115, 22, 0.4);
        }

        .submit-btn:active {
            transform: translateY(-1px);
        }

        .submit-btn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }

        .submit-btn i {
            font-size: 1rem;
            transition: transform 0.3s ease;
        }

        .submit-btn:hover i {
            transform: translateX(3px);
        }

        .submit-btn.loading i {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .submit-note {
            margin-top: 1rem;
            font-size: 0.85rem;
            color: var(--gray-400);
        }

        .submit-note i {
            color: var(--success);
            margin-right: 0.35rem;
        }
        /* ============================================
           RESPONSIVE STYLES
        ============================================ */
        @media (max-width: 1024px) {
            .footer-main {
                grid-template-columns: repeat(2, 1fr);
            }

            .footer-brand {
                grid-column: 1 / -1;
                text-align: center;
                padding-right: 0;
            }

            .footer-logo {
                justify-content: center;
            }

            .footer-social {
                justify-content: center;
            }
        }

        @media (max-width: 900px) {
            .menu-toggle {
                display: flex;
            }

            .mobile-overlay {
                display: block;
            }

            .nav-links {
                position: fixed;
                top: 0;
                right: -100%;
                width: 280px;
                height: 100vh;
                background: var(--white);
                flex-direction: column;
                align-items: stretch;
                padding: 100px 1.5rem 2rem;
                gap: 0.5rem;
                box-shadow: -10px 0 40px rgba(0, 0, 0, 0.1);
                transition: right 0.4s ease;
                overflow-y: auto;
                z-index: 1000;
            }

            .nav-links.active {
                right: 0;
            }

            .nav-links li a {
                color: var(--gray-800) !important;
                padding: 1rem 1.25rem;
                font-size: 1rem;
                border-radius: 10px;
            }

            .nav-links li a:hover {
                background: rgba(249, 115, 22, 0.08) !important;
                color: var(--primary) !important;
            }

            .nav-buttons {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                background: var(--white);
                padding: 1rem 1.5rem;
                box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.1);
                z-index: 1001;
                transform: translateY(100%);
                transition: transform 0.4s ease;
            }

            .nav-buttons.active {
                transform: translateY(0);
            }

            .nav-buttons .btn {
                flex: 1;
                justify-content: center;
            }

            .btn-ghost {
                color: var(--gray-500) !important;
                background: transparent !important;
                border: 1px solid var(--gray-200) !important;
            }
        }

        @media (max-width: 768px) {
            .hero {
                padding: 7rem 1.5rem 4rem;
            }

            .hero h1 {
                font-size: 2rem;
            }

            .hero p {
                font-size: 1rem;
            }

            .hero-features {
                gap: 1rem;
            }

            .hero-feature {
                font-size: 0.85rem;
            }

            .main-container {
                padding: 0 1rem 2rem;
                margin-top: -2rem;
            }

            .form-card {
                padding: 1.75rem;
                border-radius: var(--radius-lg);
            }

            .form-header-icon {
                width: 60px;
                height: 60px;
            }

            .form-header h2 {
                font-size: 1.5rem;
            }

            .form-grid {
                grid-template-columns: 1fr;
                gap: 1.25rem;
            }

            .submit-btn {
                width: 100%;
                padding: 1rem 2rem;
            }

            .footer-main {
                grid-template-columns: 1fr;
                padding: 3rem 1.5rem 2rem;
                gap: 2rem;
                text-align: center;
            }

            .footer-column h4::after {
                left: 50%;
                transform: translateX(-50%);
            }

            .footer-links a:hover {
                padding-left: 0;
            }

            .footer-bottom-content {
                flex-direction: column;
                text-align: center;
            }

            .footer-bottom-links {
                justify-content: center;
            }
        }

        @media (max-width: 480px) {
            .navbar {
                padding: 0.85rem 1rem;
            }

            .logo-icon {
                width: 40px;
                height: 40px;
            }

            .logo-text {
                font-size: 1.2rem;
            }

            .hero {
                padding: 6rem 1rem 3rem;
            }

            .hero h1 {
                font-size: 1.65rem;
            }

            .hero-badge {
                font-size: 0.8rem;
                padding: 0.5rem 1rem;
            }

            .form-card {
                padding: 1.25rem;
            }

            .section-title {
                flex-wrap: wrap;
            }

            .form-input,
            .form-select {
                padding: 0.85rem;
                font-size: 0.9rem;
            }
        }

        /* Error Alert */
.error-alert {
    background: linear-gradient(135deg, #fff5f5 0%, #fed7d7 100%);
    border: 1px solid #fc8181;
    border-left: 4px solid #e53e3e;
    border-radius: 15px;
    padding: 20px;
    margin-bottom: 30px;
    display: flex;
    gap: 15px;
    align-items: flex-start;
    position: relative;
    animation: slideIn 0.3s ease;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.error-alert .alert-icon {
    width: 50px;
    height: 50px;
    background: #e53e3e;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 22px;
    flex-shrink: 0;
}

.error-alert .alert-content {
    flex: 1;
}

.error-alert .alert-content h4 {
    color: #c53030;
    font-size: 16px;
    margin-bottom: 10px;
}

.error-alert .alert-content ul {
    list-style: none;
    margin: 0;
    padding: 0;
}

.error-alert .alert-content li {
    color: #c53030;
    font-size: 14px;
    padding: 5px 0;
    display: flex;
    align-items: center;
    gap: 8px;
}

.error-alert .alert-content li i {
    font-size: 12px;
}

.error-alert .alert-close {
    position: absolute;
    top: 15px;
    right: 15px;
    background: none;
    border: none;
    color: #c53030;
    font-size: 18px;
    cursor: pointer;
    opacity: 0.7;
    transition: opacity 0.3s;
}

.error-alert .alert-close:hover {
    opacity: 1;
}

/* Success Alert */
.success-alert {
    background: linear-gradient(135deg, #f0fff4 0%, #c6f6d5 100%);
    border: 1px solid #68d391;
    border-left: 4px solid #38a169;
    border-radius: 15px;
    padding: 20px;
    margin-bottom: 30px;
    display: flex;
    gap: 15px;
    align-items: center;
    animation: slideIn 0.3s ease;
}

.success-alert .alert-icon {
    width: 50px;
    height: 50px;
    background: #38a169;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 22px;
    flex-shrink: 0;
}

.success-alert .alert-content h4 {
    color: #276749;
    font-size: 16px;
    margin-bottom: 5px;
}

.success-alert .alert-content p {
    color: #2f855a;
    font-size: 14px;
    margin: 0;
}
    </style>
<body>

   <?php include 'header.php';?>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <div class="hero-badge">
                <i class="fas fa-rocket"></i>
                List Your Business in 60 Seconds
            </div>
            <h1>Add Your Business to <span>Bharat Directory</span></h1>
            <p>Join thousands of businesses and reach millions of potential customers across India</p>
            
            <div class="hero-features">
                <div class="hero-feature">
                    <i class="fas fa-check-circle"></i>
                    <span>100% Free</span>
                </div>
                <div class="hero-feature">
                    <i class="fas fa-check-circle"></i>
                    <span>Instant Listing</span>
                </div>
                <div class="hero-feature">
                    <i class="fas fa-check-circle"></i>
                    <span>Verified Badge</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Container -->
    <div class="main-container">

        <!-- Success Alert -->
        <div class="alert alert-success" id="successAlert">
            <i class="fas fa-check-circle"></i>
            <div class="alert-content">
                <strong>Success!</strong>
                <span>Your business has been submitted successfully. We'll review and publish it shortly.</span>
            </div>
            <button class="alert-close" onclick="closeAlert('successAlert')">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Error Alert -->
        <div class="alert alert-error" id="errorAlert">
            <i class="fas fa-exclamation-circle"></i>
            <div class="alert-content">
                <strong>Error!</strong>
                <span>Something went wrong. Please try again.</span>
            </div>
            <button class="alert-close" onclick="closeAlert('errorAlert')">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Form Card -->
        <div class="form-card">
            <div class="form-header">
                <div class="form-header-icon">
                    <i class="fas fa-store"></i>
                </div>
                <h2>Business Registration</h2>
                <p>Fill in the details below to list your business</p>
            </div>
<!-- Success Alert (Hidden by default) -->
<div class="success-alert" id="successAlert" style="display: none;">
    <div class="alert-icon">
        <i class="fas fa-check"></i>
    </div>
    <div class="alert-content">
        <h4>🎉 Business Submitted Successfully!</h4>
        <p>Thank you! Your business listing is under review. We'll notify you once it's approved.</p>
    </div>
</div>
            <form id="addBusinessForm" method="POST" action="submit_business.php">
                
                <!-- Personal Information -->
                <div class="form-section">
                    <div class="section-title">
                        <div class="section-icon">
                            <i class="fas fa-user"></i>
                        </div>
                        <h3>Personal Information</h3>
                    </div>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-user"></i>
                                Full Name
                                <span class="required">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="full_name" 
                                class="form-input" 
                                placeholder="Enter your full name"
                                required
                            >
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-envelope"></i>
                                Email Address
                                <span class="required">*</span>
                            </label>
                            <input 
                                type="email" 
                                name="email" 
                                class="form-input" 
                                placeholder="your@email.com"
                                required
                            >
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-phone"></i>
                                Phone Number
                                <span class="required">*</span>
                            </label>
                            <input 
                                type="tel" 
                                name="phone" 
                                class="form-input" 
                                placeholder="+91 98765 43210"
                                required
                            >
                        </div>
                    </div>
                </div>

                <!-- Business Information -->
                <div class="form-section">
                    <div class="section-title">
                        <div class="section-icon">
                            <i class="fas fa-building"></i>
                        </div>
                        <h3>Business Information</h3>
                    </div>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-store"></i>
                                Business Name
                                <span class="required">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="business_name" 
                                class="form-input" 
                                placeholder="Enter business name"
                                required
                            >
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-tags"></i>
                                Category
                                <span class="required">*</span>
                            </label>
                            <select name="category" class="form-select" required>
                                <option value="">Select Category</option>
                                <option value="Restaurants & Food">🍽️ Restaurants & Food</option>
                                <option value="Retail & Shopping">🛍️ Retail & Shopping</option>
                                <option value="Healthcare & Medical">🏥 Healthcare & Medical</option>
                                <option value="Education & Training">📚 Education & Training</option>
                                <option value="Automotive & Vehicles">🚗 Automotive & Vehicles</option>
                                <option value="Real Estate & Property">🏢 Real Estate & Property</option>
                                <option value="Technology & IT">💻 Technology & IT</option>
                                <option value="Professional Services">⚙️ Professional Services</option>
                                <option value="Manufacturing">🏭 Manufacturing</option>
                                <option value="Hospitality & Tourism">🏨 Hospitality & Tourism</option>
                                <option value="Beauty & Wellness">💄 Beauty & Wellness</option>
                                <option value="Finance & Banking">💰 Finance & Banking</option>
                                <option value="Construction">🏗️ Construction</option>
                                <option value="Entertainment & Events">🎭 Entertainment & Events</option>
                                <option value="Agriculture & Farming">🌾 Agriculture & Farming</option>
                            </select>
                        </div>

                        <div class="form-group full-width">
                            <label class="form-label">
                                <i class="fas fa-map-marker-alt"></i>
                                Business Address
                                <span class="required">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="business_place" 
                                class="form-input" 
                                placeholder="Shop No., Building Name, Street, Area"
                                required
                            >
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-city"></i>
                                City
                                <span class="required">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="city" 
                                class="form-input" 
                                placeholder="Enter city"
                                required
                            >
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-map"></i>
                                State
                                <span class="required">*</span>
                            </label>
                            <select name="state" class="form-select" required>
                                <option value="">Select State</option>
                                <option value="Andhra Pradesh">Andhra Pradesh</option>
                                <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                                <option value="Assam">Assam</option>
                                <option value="Bihar">Bihar</option>
                                <option value="Chhattisgarh">Chhattisgarh</option>
                                <option value="Delhi">Delhi</option>
                                <option value="Goa">Goa</option>
                                <option value="Gujarat">Gujarat</option>
                                <option value="Dadra and Nagar Haveli">Dadra and Nagar Haveli</option>
                                <option value="Daman and Diu">Daman and Diu</option>
                                <option value="Haryana">Haryana</option>
                                <option value="Himachal Pradesh">Himachal Pradesh</option>
                                <option value="Jharkhand">Jharkhand</option>
                                <option value="Karnataka">Karnataka</option>
                                <option value="Kerala">Kerala</option>
                                <option value="Madhya Pradesh">Madhya Pradesh</option>
                                <option value="Maharashtra">Maharashtra</option>
                                <option value="Manipur">Manipur</option>
                                <option value="Meghalaya">Meghalaya</option>
                                <option value="Mizoram">Mizoram</option>
                                <option value="Nagaland">Nagaland</option>
                                <option value="Odisha">Odisha</option>
                                <option value="Punjab">Punjab</option>
                                <option value="Rajasthan">Rajasthan</option>
                                <option value="Sikkim">Sikkim</option>
                                <option value="Tamil Nadu">Tamil Nadu</option>
                                <option value="Telangana">Telangana</option>
                                <option value="Tripura">Tripura</option>
                                <option value="Uttar Pradesh">Uttar Pradesh</option>
                                <option value="Uttarakhand">Uttarakhand</option>
                                <option value="West Bengal">West Bengal</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-map-pin"></i>
                                Pincode
                                <span class="required">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="pincode" 
                                class="form-input" 
                                placeholder="6-digit pincode"
                                maxlength="6"
                                required
                            >
                            <div class="form-hint">
                                <i class="fas fa-info-circle"></i>
                                Enter 6-digit pincode (e.g., 110001)
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-globe"></i>
                                Website
                                <span class="optional">(Optional)</span>
                            </label>
                            <input 
                                type="url" 
                                name="website" 
                                class="form-input" 
                                placeholder="https://www.yourbusiness.com"
                            >
                        </div>
                    </div>
                </div>

                <!-- Submit Section -->
                <div class="submit-section">
                    <button type="submit" class="submit-btn" id="submitBtn">
                        <span>Submit Business</span>
                        <i class="fas fa-arrow-right"></i>
                    </button>
                    <p class="submit-note">
                        <i class="fas fa-shield-alt"></i>
                        Your information is secure and will not be shared
                    </p>
                </div>

            </form>
        </div>

    </div>

    <!-- Footer -->
    <?php include 'footer.php';?>

    <!-- JavaScript -->
    <script>
        /**
         * ============================================
         * BHARAT DIRECTORY - ADD BUSINESS PAGE SCRIPTS
         * ============================================
         */
/**
 * Show Success Alert
 */
function showAlert(alertId) {
    const alert = document.getElementById(alertId);
    if (alert) {
        alert.style.display = 'flex';
        
        // Auto hide after 5 seconds
        setTimeout(() => {
            alert.style.display = 'none';
        }, 5000);
    }
}
        (function() {
            'use strict';

            // Elements
            const navbar = document.getElementById('navbar');
            const menuToggle = document.getElementById('menuToggle');
            const navLinks = document.getElementById('navLinks');
            const navButtons = document.getElementById('navButtons');
            const mobileOverlay = document.getElementById('mobileOverlay');
            const form = document.getElementById('addBusinessForm');
            const submitBtn = document.getElementById('submitBtn');

            // Mobile Menu State
            let isMenuOpen = false;

            /**
             * Navbar Scroll Effect
             */
            function handleScroll() {
                if (window.scrollY > 50) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            }

            /**
             * Toggle Mobile Menu
             */
            function toggleMobileMenu() {
                isMenuOpen = !isMenuOpen;
                menuToggle.classList.toggle('active', isMenuOpen);
                navLinks.classList.toggle('active', isMenuOpen);
                navButtons.classList.toggle('active', isMenuOpen);
                mobileOverlay.classList.toggle('active', isMenuOpen);
                document.body.style.overflow = isMenuOpen ? 'hidden' : '';
            }

            /**
             * Close Mobile Menu
             */
            function closeMobileMenu() {
                if (!isMenuOpen) return;
                isMenuOpen = false;
                menuToggle.classList.remove('active');
                navLinks.classList.remove('active');
                navButtons.classList.remove('active');
                mobileOverlay.classList.remove('active');
                document.body.style.overflow = '';
            }

            /**
             * Form Submission
             */
            /**
 * Form Submission - REAL DATABASE SAVE
 */
async function handleFormSubmit(e) {
    e.preventDefault();

    // Validate form
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }

    // Show loading state
    submitBtn.disabled = true;
    submitBtn.classList.add('loading');
    submitBtn.innerHTML = '<span>Submitting...</span><i class="fas fa-spinner fa-spin"></i>';

    // Get form data
    const formData = new FormData(form);

    try {
        // Send to PHP
        const response = await fetch('submit_business.php', {
            method: 'POST',
            body: formData
        });

        const result = await response.json();

        if (result.status === 'success') {
            // Show success alert
            showAlert('successAlert');

            // Reset form
            form.reset();

            // Scroll to top
            window.scrollTo({ top: 0, behavior: 'smooth' });

            // Optional: Redirect to thank you page after 2 seconds
            setTimeout(() => {
                window.location.href = 'thank_you.php?id=' + result.business_id;
            }, 2000);

        } else {
            // Show errors
            showErrors(result.errors);
        }

    } catch (error) {
        console.error('Error:', error);
        showErrorAlert('Something went wrong. Please try again.');
    } finally {
        // Reset button
        submitBtn.disabled = false;
        submitBtn.classList.remove('loading');
        submitBtn.innerHTML = '<span>Submit Business</span><i class="fas fa-arrow-right"></i>';
    }
}

/**
 * Show Errors
 */
function showErrors(errors) {
    // Remove existing error alert
    const existingAlert = document.querySelector('.error-alert');
    if (existingAlert) existingAlert.remove();

    // Create error HTML
    let html = `
        <div class="error-alert" id="errorAlert">
            <div class="alert-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="alert-content">
                <h4>Please fix the following errors:</h4>
                <ul>
                    ${errors.map(e => `<li><i class="fas fa-times-circle"></i> ${e}</li>`).join('')}
                </ul>
            </div>
            <button class="alert-close" onclick="this.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;

    // Insert before form
    form.insertAdjacentHTML('beforebegin', html);

    // Scroll to errors
    document.querySelector('.error-alert').scrollIntoView({ 
        behavior: 'smooth', 
        block: 'center' 
    });

    // Auto remove after 10 seconds
    setTimeout(() => {
        const alert = document.getElementById('errorAlert');
        if (alert) alert.remove();
    }, 10000);
}

/**
 * Show Single Error Alert
 */
function showErrorAlert(message) {
    showErrors([message]);
}

            /**
             * Show Alert
             */
            function showAlert(alertId) {
                const alert = document.getElementById(alertId);
                if (alert) {
                    alert.style.display = 'flex';
                    
                    // Auto hide after 5 seconds
                    setTimeout(() => {
                        closeAlert(alertId);
                    }, 5000);
                }
            }

            /**
             * Close Alert
             */
            window.closeAlert = function(alertId) {
                const alert = document.getElementById(alertId);
                if (alert) {
                    alert.style.animation = 'slideUp 0.3s ease forwards';
                    setTimeout(() => {
                        alert.style.display = 'none';
                        alert.style.animation = '';
                    }, 300);
                }
            };

            /**
             * Input Validations
             */
            function setupInputValidations() {
                // Pincode - only 6 digits
                const pincodeInput = document.querySelector('input[name="pincode"]');
                if (pincodeInput) {
                    pincodeInput.addEventListener('input', function() {
                        this.value = this.value.replace(/[^0-9]/g, '').substring(0, 6);
                    });
                }

                // Phone - format
                const phoneInput = document.querySelector('input[name="phone"]');
                if (phoneInput) {
                    phoneInput.addEventListener('input', function() {
                        this.value = this.value.replace(/[^0-9+\-\s]/g, '');
                    });
                }

                // Auto-capitalize names
                const nameInputs = document.querySelectorAll('input[name="full_name"], input[name="business_name"], input[name="city"]');
                nameInputs.forEach(input => {
                    input.addEventListener('blur', function() {
                        if (this.value) {
                            this.value = this.value.split(' ')
                                .map(word => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase())
                                .join(' ');
                        }
                    });
                });
            }

            /**
             * Event Listeners
             */
            window.addEventListener('scroll', handleScroll);
            menuToggle.addEventListener('click', toggleMobileMenu);
            mobileOverlay.addEventListener('click', closeMobileMenu);
            form.addEventListener('submit', handleFormSubmit);

            // Close menu on nav link click
            navLinks.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', () => {
                    if (window.innerWidth <= 900) {
                        closeMobileMenu();
                    }
                });
            });

            // Handle window resize
            window.addEventListener('resize', () => {
                if (window.innerWidth > 900 && isMenuOpen) {
                    closeMobileMenu();
                }
            });

            // Handle escape key
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && isMenuOpen) {
                    closeMobileMenu();
                }
            });

            // Initialize
            handleScroll();
            setupInputValidations();

            // Add slide up animation
            const style = document.createElement('style');
            style.textContent = `
                @keyframes slideUp {
                    to {
                        opacity: 0;
                        transform: translateY(-10px);
                    }
                }
            `;
            document.head.appendChild(style);

        })();
    </script>
