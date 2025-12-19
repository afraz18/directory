<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bharat Directory - Discover Local Businesses</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
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
            --primary-gradient: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            --dark: #0f172a;
            --dark-light: #1e293b;
            --text-dark: #1e293b;
            --text-gray: #64748b;
            --text-light: #94a3b8;
            --white: #ffffff;
            --border: #e2e8f0;
            --bg-light: #f8fafc;
            --shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 40px rgba(0, 0, 0, 0.15);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--bg-light);
            min-height: 200vh;
        }

        /* ============================================
           NAVBAR STYLES
        ============================================ */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 2rem;
            background: transparent;
            transition: all 0.3s ease;
        }

        .navbar.scrolled {
            background: var(--white);
            box-shadow: var(--shadow);
            padding: 0.75rem 2rem;
        }

        /* Logo */
        .logo {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            text-decoration: none;
            z-index: 1001;
        }

        .logo-icon {
            width: 42px;
            height: 42px;
            background: var(--primary-gradient);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(249, 115, 22, 0.3);
            transition: transform 0.3s ease;
        }

        .logo:hover .logo-icon {
            transform: rotate(-5deg) scale(1.05);
        }

        .logo-icon i {
            font-size: 1.15rem;
            color: var(--white);
        }

        .logo-text {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--white);
            transition: color 0.3s ease;
        }

        .logo-text span {
            color: var(--primary);
        }

        .navbar.scrolled .logo-text {
            color: var(--text-dark);
        }

        /* Nav Links */
        .nav-links {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            list-style: none;
        }

        .nav-links li a {
            display: block;
            padding: 0.6rem 1rem;
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-links li a::after {
            content: '';
            position: absolute;
            bottom: 0.4rem;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 2px;
            background: var(--primary);
            border-radius: 2px;
            transition: width 0.3s ease;
        }

        .nav-links li a:hover::after,
        .nav-links li a.active::after {
            width: 20px;
        }

        .nav-links li a:hover {
            color: var(--white);
            background: rgba(255, 255, 255, 0.1);
        }

        .navbar.scrolled .nav-links li a {
            color: var(--text-gray);
        }

        .navbar.scrolled .nav-links li a:hover {
            color: var(--primary);
            background: rgba(249, 115, 22, 0.08);
        }

        .navbar.scrolled .nav-links li a::after {
            background: var(--primary);
        }

        /* Dropdown */
        .nav-dropdown {
            position: relative;
        }

        .nav-dropdown > a {
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .nav-dropdown > a i {
            font-size: 0.7rem;
            transition: transform 0.3s ease;
        }

        .nav-dropdown:hover > a i {
            transform: rotate(180deg);
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            min-width: 220px;
            background: var(--white);
            border-radius: 12px;
            box-shadow: var(--shadow-lg);
            padding: 0.75rem;
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: all 0.3s ease;
            border: 1px solid var(--border);
            list-style: none;
        }

        .nav-dropdown:hover .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(5px);
        }

        .dropdown-menu li {
            margin: 0;
        }

        .dropdown-menu li a {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            color: var(--text-gray) !important;
            border-radius: 8px;
            font-size: 0.9rem;
        }

        .dropdown-menu li a i {
            width: 20px;
            color: var(--primary);
        }

        .dropdown-menu li a:hover {
            background: rgba(249, 115, 22, 0.08) !important;
            color: var(--primary) !important;
        }

        .dropdown-menu li a::after {
            display: none;
        }

        /* Nav Buttons */
        .nav-buttons {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.6rem 1.2rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.9rem;
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-family: inherit;
        }

        .btn-ghost {
            color: rgba(255, 255, 255, 0.9);
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .btn-ghost:hover {
            background: rgba(255, 255, 255, 0.2);
            color: var(--white);
        }

        .navbar.scrolled .btn-ghost {
            color: var(--text-gray);
            background: transparent;
            border: 1px solid var(--border);
        }

        .navbar.scrolled .btn-ghost:hover {
            color: var(--primary);
            border-color: var(--primary);
            background: rgba(249, 115, 22, 0.05);
        }

        .btn-outline {
            color: var(--text-gray);
            background: transparent;
            border: 1.5px solid var(--border);
        }

        .btn-outline:hover {
            color: var(--primary);
            border-color: var(--primary);
            background: rgba(249, 115, 22, 0.05);
        }

        .btn-primary {
            background: var(--primary-gradient);
            color: var(--white);
            box-shadow: 0 4px 15px rgba(249, 115, 22, 0.35);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 25px rgba(249, 115, 22, 0.45);
        }

        /* Mobile Menu Toggle */
        .menu-toggle {
            display: none;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            gap: 5px;
            width: 40px;
            height: 40px;
            cursor: pointer;
            z-index: 1001;
            background: transparent;
            border: none;
            border-radius: 8px;
            transition: background 0.3s ease;
        }

        .menu-toggle:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .navbar.scrolled .menu-toggle:hover {
            background: rgba(0, 0, 0, 0.05);
        }

        .menu-toggle span {
            display: block;
            width: 22px;
            height: 2.5px;
            background: var(--white);
            border-radius: 3px;
            transition: all 0.3s ease;
        }

        .navbar.scrolled .menu-toggle span {
            background: var(--text-dark);
        }

        .menu-toggle.active span:nth-child(1) {
            transform: rotate(45deg) translate(5px, 5px);
        }

        .menu-toggle.active span:nth-child(2) {
            opacity: 0;
            transform: translateX(-10px);
        }

        .menu-toggle.active span:nth-child(3) {
            transform: rotate(-45deg) translate(5px, -5px);
        }

        /* Mobile Overlay */
        .mobile-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(15, 23, 42, 0.5);
            backdrop-filter: blur(4px);
            z-index: 998;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .mobile-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        /* ============================================
           MOBILE MENU
        ============================================ */
        .mobile-menu {
            display: none;
            position: fixed;
            top: 0;
            right: -100%;
            width: 280px;
            max-width: 85%;
            height: 100vh;
            background: var(--white);
            padding: 80px 0 0 0;
            overflow-y: auto;
            transition: right 0.3s ease;
            z-index: 999;
            box-shadow: -5px 0 30px rgba(0, 0, 0, 0.1);
        }

        .mobile-menu.active {
            right: 0;
        }

        .mobile-menu ul {
            list-style: none;
            padding: 1rem;
        }

        .mobile-menu ul li {
            border-bottom: 1px solid var(--border);
        }

        .mobile-menu ul li:last-child {
            border-bottom: none;
        }

        .mobile-menu ul a {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1rem;
            color: var(--text-dark);
            text-decoration: none;
            font-weight: 500;
            font-size: 1rem;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .mobile-menu ul a i {
            width: 22px;
            color: var(--primary);
            text-align: center;
            font-size: 1rem;
        }

        .mobile-menu ul a:hover,
        .mobile-menu ul a.active {
            color: var(--primary);
            background: rgba(249, 115, 22, 0.08);
        }

        /* Mobile Menu Buttons */
        .mobile-buttons {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            padding: 1.5rem 1rem;
            margin-top: auto;
            border-top: 1px solid var(--border);
        }

        .mobile-buttons .btn {
            justify-content: center;
            padding: 0.9rem;
            border-radius: 10px;
        }

        /* ============================================
           RESPONSIVE
        ============================================ */
        @media (max-width: 1024px) {
            .nav-links {
                gap: 0.25rem;
            }

            .nav-links li a {
                padding: 0.5rem 0.8rem;
                font-size: 0.9rem;
            }

            .btn {
                padding: 0.55rem 1rem;
                font-size: 0.85rem;
            }
        }

        @media (max-width: 900px) {
            .navbar {
                padding: 0.85rem 1.25rem;
            }

            .navbar.scrolled {
                padding: 0.75rem 1.25rem;
            }

            .nav-links,
            .nav-buttons {
                display: none;
            }

            .menu-toggle {
                display: flex;
            }

            .mobile-overlay,
            .mobile-menu {
                display: block;
            }
        }

        @media (max-width: 480px) {
            .navbar {
                padding: 0.75rem 1rem;
            }

            .logo-icon {
                width: 38px;
                height: 38px;
            }

            .logo-icon i {
                font-size: 1rem;
            }

            .logo-text {
                font-size: 1.15rem;
            }

            .mobile-menu {
                width: 100%;
                max-width: 100%;
            }
        }
    </style>
</head>
<body>

    <!-- Mobile Overlay -->
    <div class="mobile-overlay" id="mobileOverlay"></div>

    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobileMenu">
        <ul>
            <li><a href="index.php" class="active"><i class="fas fa-home"></i> Home</a></li>
            <li><a href="about.php"><i class="fas fa-info-circle"></i> About Us</a></li>
            <li><a href="categories.php"><i class="fas fa-th-large"></i> Categories</a></li>
            <li><a href="businesses.php"><i class="fas fa-store"></i> Businesses</a></li>
            <li><a href="blog.php"><i class="fas fa-newspaper"></i> Blog</a></li>
            <li><a href="contact.php"><i class="fas fa-envelope"></i> Contact</a></li>
        </ul>

        <div class="mobile-buttons">
            <a href="login.php" class="btn btn-outline">
                <i class="fas fa-user"></i>
                Sign In
            </a>
            <a href="add_business.php" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                Add Business
            </a>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="navbar" id="navbar">
        <!-- Logo -->
        <a href="index.php" class="logo">
            <div class="logo-icon">
                <i class="fas fa-building"></i>
            </div>
            <span class="logo-text">Bharat<span>Directory</span></span>
        </a>

        <!-- Desktop Nav Links -->
        <ul class="nav-links" id="navLinks">
            <li><a href="index.php" class="active">Home</a></li>
            <li><a href="about.php">About Us</a></li>
            
            <!-- Dropdown: Categories -->
            <li class="nav-dropdown">
                <a href="#">
                    Categories
                    <i class="fas fa-chevron-down"></i>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="#"><i class="fas fa-utensils"></i> Restaurants</a></li>
                    <li><a href="#"><i class="fas fa-hotel"></i> Hotels</a></li>
                    <li><a href="#"><i class="fas fa-hospital"></i> Hospitals</a></li>
                    <li><a href="#"><i class="fas fa-laptop-code"></i> IT Companies</a></li>
                    <li><a href="#"><i class="fas fa-industry"></i> Industries</a></li>
                    <li><a href="#"><i class="fas fa-th-large"></i> View All</a></li>
                </ul>
            </li>

            <!-- Dropdown: Businesses -->
            <li class="nav-dropdown">
                <a href="#">
                    Businesses
                    <i class="fas fa-chevron-down"></i>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="404.php"><i class="fas fa-search"></i> Search Business</a></li>
                    <li><a href="404.php"><i class="fas fa-star"></i> Top Rated</a></li>
                    <li><a href="#"><i class="fas fa-map-marker-alt"></i> Near Me</a></li>
                    <li><a href="#"><i class="fas fa-fire"></i> Popular</a></li>
                </ul>
            </li>

            <li><a href="blog.php">Blog</a></li>
            <li><a href="contact.php">Contact</a></li>
        </ul>

        <!-- Desktop Nav Buttons -->
        <div class="nav-buttons" id="navButtons">
            <a href="login.php" class="btn btn-ghost">
                <i class="fas fa-user"></i>
                Sign In
            </a>
            <a href="add_business.php" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                Add Business
            </a>
        </div>

        <!-- Mobile Menu Toggle -->
        <button class="menu-toggle" id="menuToggle" aria-label="Toggle Menu">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </nav>

    <!-- JavaScript -->
    <script>
        (function() {
            'use strict';

            // Elements
            const navbar = document.getElementById('navbar');
            const menuToggle = document.getElementById('menuToggle');
            const mobileMenu = document.getElementById('mobileMenu');
            const mobileOverlay = document.getElementById('mobileOverlay');

            // State
            let isMenuOpen = false;

            /**
             * Handle Navbar Scroll
             */
            function handleNavbarScroll() {
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
                mobileMenu.classList.toggle('active', isMenuOpen);
                mobileOverlay.classList.toggle('active', isMenuOpen);
                
                // Prevent body scroll when menu is open
                document.body.style.overflow = isMenuOpen ? 'hidden' : '';
            }

            /**
             * Close Mobile Menu
             */
            function closeMobileMenu() {
                if (!isMenuOpen) return;
                
                isMenuOpen = false;
                menuToggle.classList.remove('active');
                mobileMenu.classList.remove('active');
                mobileOverlay.classList.remove('active');
                document.body.style.overflow = '';
            }

            /**
             * Handle Window Resize
             */
            function handleResize() {
                if (window.innerWidth > 900 && isMenuOpen) {
                    closeMobileMenu();
                }
            }

            /**
             * Handle Escape Key
             */
            function handleEscapeKey(e) {
                if (e.key === 'Escape' && isMenuOpen) {
                    closeMobileMenu();
                }
            }

            // Event Listeners
            window.addEventListener('scroll', handleNavbarScroll);
            window.addEventListener('resize', handleResize);
            document.addEventListener('keydown', handleEscapeKey);

            menuToggle.addEventListener('click', toggleMobileMenu);
            mobileOverlay.addEventListener('click', closeMobileMenu);

            // Close menu when clicking nav links
            mobileMenu.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', closeMobileMenu);
            });

            // Initial scroll check
            handleNavbarScroll();

        })();
    </script>

</body>
</html>