<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bharat Directory - Discover Local Businesses</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #f97316;
            --primary-dark: #ea580c;
            --dark: #0f172a;
            --text-dark: #1e293b;
            --text-gray: #64748b;
            --white: #ffffff;
            --border: #e2e8f0;
            --bg-light: #f8fafc;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--bg-light);
            min-height: 200vh;
        }

        /* ============================================
           SIMPLE NAVBAR
        ============================================ */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            background: var(--white);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 1.25rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Logo */
        .logo {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #f97316, #ea580c);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-icon i {
            font-size: 1.1rem;
            color: var(--white);
        }

        .logo-text {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--text-dark);
        }

        .logo-text span {
            color: var(--primary);
        }

        /* Desktop Nav Links */
        .nav-links {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            list-style: none;
        }

        .nav-links a {
            padding: 0.5rem 1rem;
            color: var(--text-gray);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .nav-links a:hover,
        .nav-links a.active {
            color: var(--primary);
            background: rgba(249, 115, 22, 0.08);
        }

        /* Nav Buttons */
        .nav-buttons {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.9rem;
            text-decoration: none;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
        }

        .btn-outline {
            color: var(--text-gray);
            border: 1.5px solid var(--border);
            background: transparent;
        }

        .btn-outline:hover {
            color: var(--primary);
            border-color: var(--primary);
        }

        .btn-primary {
            background: var(--primary);
            color: var(--white);
        }

        .btn-primary:hover {
            background: var(--primary-dark);
        }

        /* Hamburger Menu */
        .menu-toggle {
            display: none;
            width: 40px;
            height: 40px;
            border-radius: 8px;
            background: var(--bg-light);
            border: none;
            cursor: pointer;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        .menu-toggle span {
            display: block;
            width: 20px;
            height: 2px;
            background: var(--text-dark);
            border-radius: 2px;
            transition: all 0.3s ease;
        }

        .menu-toggle.active span:nth-child(1) {
            transform: rotate(45deg) translate(5px, 5px);
        }

        .menu-toggle.active span:nth-child(2) {
            opacity: 0;
        }

        .menu-toggle.active span:nth-child(3) {
            transform: rotate(-45deg) translate(5px, -5px);
        }

        /* ============================================
           MOBILE MENU
        ============================================ */
        .mobile-menu {
            display: none;
            position: fixed;
            top: 62px;
            left: 0;
            right: 0;
            bottom: 0;
            background: var(--white);
            padding: 1rem;
            overflow-y: auto;
            transform: translateX(100%);
            transition: transform 0.3s ease;
        }

        .mobile-menu.active {
            transform: translateX(0);
        }

        .mobile-menu ul {
            list-style: none;
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
            transition: all 0.2s ease;
        }

        .mobile-menu ul a i {
            width: 20px;
            color: var(--primary);
            text-align: center;
        }

        .mobile-menu ul a:hover,
        .mobile-menu ul a.active {
            color: var(--primary);
            background: rgba(249, 115, 22, 0.05);
        }

        /* Mobile Menu Buttons */
        .mobile-buttons {
            display: flex;
            gap: 0.75rem;
            padding: 1.5rem 1rem;
            margin-top: 1rem;
            border-top: 1px solid var(--border);
        }

        .mobile-buttons .btn {
            flex: 1;
            justify-content: center;
            padding: 0.85rem;
        }

        /* ============================================
           RESPONSIVE
        ============================================ */
        @media (max-width: 900px) {
            .nav-links,
            .nav-buttons {
                display: none;
            }

            .menu-toggle,
            .mobile-menu {
                display: flex;
            }

            .mobile-menu {
                display: block;
            }
        }

        @media (max-width: 480px) {
            .nav-container {
                padding: 0.6rem 1rem;
            }

            .logo-icon {
                width: 36px;
                height: 36px;
            }

            .logo-text {
                font-size: 1.1rem;
            }

            .mobile-menu {
                top: 56px;
            }
        }

        /* ============================================
           DEMO CONTENT
        ============================================ */
        .demo-hero {
            margin-top: 62px;
            height: 60vh;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: #fff;
            padding: 2rem;
        }

        .demo-hero h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .demo-hero p {
            color: #94a3b8;
            font-size: 1.1rem;
        }

        @media (max-width: 480px) {
            .demo-hero {
                margin-top: 56px;
            }
            .demo-hero h1 {
                font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>

    <!-- Simple Navbar -->
    <nav class="navbar">
        <div class="nav-container">
            <!-- Logo -->
            <a href="index.php" class="logo">
                <div class="logo-icon">
                    <i class="fas fa-building"></i>
                </div>
                <span class="logo-text">Bharat<span>Directory</span></span>
            </a>

            <!-- Desktop Nav Links -->
            <ul class="nav-links">
                <li><a href="index.php" class="active">Home</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="categories.php">Categories</a></li>
                <li><a href="businesses.php">Businesses</a></li>
                <li><a href="blog.php">Blog</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>

            <!-- Desktop Buttons -->
            <div class="nav-buttons">
                <a href="login.php" class="btn btn-outline">
                    <i class="fas fa-user"></i>
                    Sign In
                </a>
                <a href="add_business.php" class="btn btn-primary">
                    <i class="fas fa-plus"></i>
                    Add Business
                </a>
            </div>

            <!-- Mobile Menu Toggle -->
            <button class="menu-toggle" id="menuToggle" aria-label="Menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>

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
    </nav>


    <!-- JavaScript -->
    <script>
        const menuToggle = document.getElementById('menuToggle');
        const mobileMenu = document.getElementById('mobileMenu');

        menuToggle.addEventListener('click', function() {
            this.classList.toggle('active');
            mobileMenu.classList.toggle('active');
            document.body.style.overflow = mobileMenu.classList.contains('active') ? 'hidden' : '';
        });

        // Close menu when clicking a link
        document.querySelectorAll('.mobile-menu a').forEach(link => {
            link.addEventListener('click', () => {
                menuToggle.classList.remove('active');
                mobileMenu.classList.remove('active');
                document.body.style.overflow = '';
            });
        });

        // Close on escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && mobileMenu.classList.contains('active')) {
                menuToggle.classList.remove('active');
                mobileMenu.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
    </script>

</body>
</html>