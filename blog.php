<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - Bharat Directory | Latest News & Updates</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* ============================================
           CSS VARIABLES
        ============================================ */
        :root {
            --primary: #f97316;
            --primary-dark: #ea580c;
            --primary-light: #fdba74;
            --bg-white: #ffffff;
            --bg-gray: #f8fafc;
            --bg-dark: #1e293b;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --text-muted: #94a3b8;
            --text-white: #ffffff;
            --border-light: #e2e8f0;
            --shadow-sm: 0 1px 2px rgba(0,0,0,0.05);
            --shadow-md: 0 4px 6px -1px rgba(0,0,0,0.1);
            --shadow-lg: 0 10px 15px -3px rgba(0,0,0,0.1);
            --shadow-xl: 0 20px 25px -5px rgba(0,0,0,0.1);
            --shadow-orange: 0 10px 40px rgba(249, 115, 22, 0.3);
            --radius-sm: 0.375rem;
            --radius-md: 0.5rem;
            --radius-lg: 0.75rem;
            --radius-xl: 1rem;
            --radius-2xl: 1.5rem;
            --radius-full: 9999px;
            --transition: 0.3s ease;
        }

        /* ============================================
           RESET & BASE
        ============================================ */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--bg-gray);
            color: var(--text-primary);
            line-height: 1.6;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        img {
            max-width: 100%;
            height: auto;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        /* ============================================
           BLOG HERO SECTION
        ============================================ */
        .blog-hero {
            height: 100vh;
            background: linear-gradient(100deg, #0f172a 0%, #1e293b 70%);
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: #fff;
            padding: 2rem;
        }

        .blog-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 80%, rgba(249, 115, 22, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(249, 115, 22, 0.1) 0%, transparent 50%);
        }

        .blog-hero-content {
            position: relative;
            z-index: 1;
            text-align: center;
        }

        .blog-hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(249, 115, 22, 0.2);
            color: var(--primary-light);
            padding: 0.5rem 1rem;
            border-radius: var(--radius-full);
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 1.5rem;
        }

        .blog-hero-title {
            font-size: 3rem;
            font-weight: 800;
            color: var(--text-white);
            margin-bottom: 1rem;
        }

        .blog-hero-title span {
            color: var(--primary);
        }

        .blog-hero-subtitle {
            font-size: 1.15rem;
            color: var(--text-muted);
            max-width: 600px;
            margin: 0 auto 2rem;
        }

        /* Blog Search */
        .blog-search {
            max-width: 500px;
            margin: 0 auto;
            position: relative;
        }

        .blog-search input {
            width: 100%;
            padding: 1rem 1.5rem;
            padding-right: 3.5rem;
            border: none;
            border-radius: var(--radius-full);
            font-size: 1rem;
            background: var(--bg-white);
            box-shadow: var(--shadow-xl);
        }

        .blog-search input:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.2), var(--shadow-xl);
        }

        .blog-search button {
            position: absolute;
            right: 0.5rem;
            top: 50%;
            transform: translateY(-50%);
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border: none;
            border-radius: var(--radius-full);
            color: var(--text-white);
            cursor: pointer;
            transition: all var(--transition);
        }

        .blog-search button:hover {
            transform: translateY(-50%) scale(1.05);
        }

        /* ============================================
           BLOG CATEGORIES
        ============================================ */
        .blog-categories {
            background: var(--bg-white);
            padding: 1.5rem 0;
            border-bottom: 1px solid var(--border-light);
            position: sticky;
            top: 70px;
            z-index: 100;
        }

        .categories-wrapper {
            display: flex;
            align-items: center;
            gap: 1rem;
            overflow-x: auto;
            padding-bottom: 0.5rem;
            scrollbar-width: none;
        }

        .categories-wrapper::-webkit-scrollbar {
            display: none;
        }

        .category-tab {
            padding: 0.6rem 1.25rem;
            border-radius: var(--radius-full);
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--text-secondary);
            background: var(--bg-gray);
            white-space: nowrap;
            cursor: pointer;
            transition: all var(--transition);
            border: none;
        }

        .category-tab:hover {
            color: var(--primary);
            background: rgba(249, 115, 22, 0.1);
        }

        .category-tab.active {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: var(--text-white);
            box-shadow: var(--shadow-orange);
        }

        /* ============================================
           BLOG MAIN CONTENT
        ============================================ */
        .blog-section {
            padding: 3rem 0;
        }

        .blog-layout {
            display: grid;
            grid-template-columns: 1fr 350px;
            gap: 2rem;
        }

        /* ============================================
           FEATURED POST
        ============================================ */
        .featured-post {
            background: var(--bg-white);
            border-radius: var(--radius-2xl);
            overflow: hidden;
            box-shadow: var(--shadow-lg);
            margin-bottom: 2rem;
            transition: all var(--transition);
        }

        .featured-post:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-xl);
        }

        .featured-image {
            position: relative;
            height: 350px;
            overflow: hidden;
        }

        .featured-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform var(--transition);
        }

        .featured-post:hover .featured-image img {
            transform: scale(1.05);
        }

        .featured-badge {
            position: absolute;
            top: 1rem;
            left: 1rem;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: var(--text-white);
            padding: 0.4rem 1rem;
            border-radius: var(--radius-full);
            font-size: 0.8rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .featured-category {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: var(--bg-white);
            color: var(--primary);
            padding: 0.4rem 1rem;
            border-radius: var(--radius-full);
            font-size: 0.8rem;
            font-weight: 600;
        }

        .featured-content {
            padding: 1.5rem;
        }

        .post-meta {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 0.75rem;
            flex-wrap: wrap;
        }

        .post-meta-item {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.85rem;
            color: var(--text-secondary);
        }

        .post-meta-item i {
            color: var(--primary);
        }

        .featured-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.75rem;
            line-height: 1.4;
            transition: color var(--transition);
        }

        .featured-title:hover {
            color: var(--primary);
        }

        .featured-excerpt {
            color: var(--text-secondary);
            line-height: 1.7;
            margin-bottom: 1.25rem;
        }

        .featured-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .author-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .author-avatar {
            width: 45px;
            height: 45px;
            border-radius: var(--radius-full);
            object-fit: cover;
            border: 2px solid var(--border-light);
        }

        .author-name {
            font-weight: 600;
            color: var(--text-primary);
            font-size: 0.9rem;
        }

        .author-role {
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        .read-more-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--primary);
            font-weight: 600;
            font-size: 0.9rem;
            transition: all var(--transition);
        }

        .read-more-btn:hover {
            gap: 0.75rem;
        }

        /* ============================================
           BLOG POSTS GRID
        ============================================ */
        .posts-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }

        .post-card {
            background: var(--bg-white);
            border-radius: var(--radius-xl);
            overflow: hidden;
            box-shadow: var(--shadow-md);
            transition: all var(--transition);
        }

        .post-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .post-image {
            position: relative;
            height: 180px;
            overflow: hidden;
        }

        .post-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform var(--transition);
        }

        .post-card:hover .post-image img {
            transform: scale(1.05);
        }

        .post-category {
            position: absolute;
            top: 0.75rem;
            left: 0.75rem;
            background: var(--bg-white);
            color: var(--primary);
            padding: 0.3rem 0.75rem;
            border-radius: var(--radius-full);
            font-size: 0.75rem;
            font-weight: 600;
        }

        .post-content {
            padding: 1.25rem;
        }

        .post-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            transition: color var(--transition);
        }

        .post-title:hover {
            color: var(--primary);
        }

        .post-excerpt {
            font-size: 0.9rem;
            color: var(--text-secondary);
            line-height: 1.6;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            margin-bottom: 1rem;
        }

        .post-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 1rem;
            border-top: 1px solid var(--border-light);
        }

        .post-date {
            font-size: 0.8rem;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .post-date i {
            color: var(--primary);
        }

        .post-read-time {
            font-size: 0.8rem;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        /* ============================================
           SIDEBAR
        ============================================ */
        .sidebar {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .sidebar-widget {
            background: var(--bg-white);
            border-radius: var(--radius-xl);
            padding: 1.5rem;
            box-shadow: var(--shadow-md);
        }

        .widget-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .widget-title i {
            color: var(--primary);
        }

        /* Popular Posts Widget */
        .popular-posts {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .popular-post-item {
            display: flex;
            gap: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border-light);
            transition: all var(--transition);
        }

        .popular-post-item:last-child {
            padding-bottom: 0;
            border-bottom: none;
        }

        .popular-post-item:hover .popular-post-title {
            color: var(--primary);
        }

        .popular-post-image {
            width: 70px;
            height: 70px;
            border-radius: var(--radius-md);
            object-fit: cover;
            flex-shrink: 0;
        }

        .popular-post-content {
            flex: 1;
        }

        .popular-post-title {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text-primary);
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            margin-bottom: 0.4rem;
            transition: color var(--transition);
        }

        .popular-post-date {
            font-size: 0.75rem;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        /* Tags Widget */
        .tags-cloud {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .tag-item {
            padding: 0.4rem 0.9rem;
            background: var(--bg-gray);
            color: var(--text-secondary);
            border-radius: var(--radius-full);
            font-size: 0.8rem;
            font-weight: 500;
            transition: all var(--transition);
            cursor: pointer;
        }

        .tag-item:hover {
            background: var(--primary);
            color: var(--text-white);
        }

        /* Newsletter Widget */
        .newsletter-widget {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: var(--text-white);
        }

        .newsletter-widget .widget-title {
            color: var(--text-white);
        }

        .newsletter-widget .widget-title i {
            color: var(--text-white);
        }

        .newsletter-text {
            font-size: 0.9rem;
            opacity: 0.9;
            margin-bottom: 1rem;
            line-height: 1.6;
        }

        .newsletter-form {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .newsletter-input {
            padding: 0.9rem 1rem;
            border: none;
            border-radius: var(--radius-md);
            font-size: 0.9rem;
            background: rgba(255,255,255,0.95);
        }

        .newsletter-input:focus {
            outline: none;
        }

        .newsletter-btn {
            padding: 0.9rem;
            background: var(--bg-dark);
            color: var(--text-white);
            border: none;
            border-radius: var(--radius-md);
            font-weight: 600;
            cursor: pointer;
            transition: all var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .newsletter-btn:hover {
            background: var(--text-primary);
        }

        /* Social Widget */
        .social-links {
            display: flex;
            gap: 0.75rem;
        }

        .social-link {
            width: 45px;
            height: 45px;
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-white);
            font-size: 1.1rem;
            transition: all var(--transition);
        }

        .social-link.facebook {
            background: #1877f2;
        }

        .social-link.twitter {
            background: #010202ff;
        }

        .social-link.instagram {
            background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888);
        }

        .social-link.youtube {
            background: #ff0000;
        }

        .social-link:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
        }

        /* ============================================
           PAGINATION
        ============================================ */
        .pagination {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid var(--border-light);
        }

        .page-btn {
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: var(--radius-md);
            font-weight: 600;
            color: var(--text-secondary);
            background: var(--bg-white);
            border: 1px solid var(--border-light);
            cursor: pointer;
            transition: all var(--transition);
        }

        .page-btn:hover {
            color: var(--primary);
            border-color: var(--primary);
        }

        .page-btn.active {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: var(--text-white);
            border-color: transparent;
            box-shadow: var(--shadow-orange);
        }

        .page-btn.nav-arrow {
            background: var(--bg-gray);
            border: none;
        }

        .page-btn.nav-arrow:hover {
            background: var(--primary);
            color: var(--text-white);
        }
        /* ============================================
           BACK TO TOP
        ============================================ */
        .back-to-top {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border-radius: var(--radius-full);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-white);
            font-size: 1.25rem;
            box-shadow: var(--shadow-orange);
            z-index: 999;
            opacity: 0;
            visibility: hidden;
            transform: translateY(20px);
            transition: all var(--transition);
            cursor: pointer;
            border: none;
        }

        .back-to-top.visible {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .back-to-top:hover {
            transform: translateY(-5px);
        }

        /* ============================================
           RESPONSIVE DESIGN
        ============================================ */
        @media (max-width: 1200px) {
            .blog-layout {
                grid-template-columns: 1fr 300px;
            }
        }

        @media (max-width: 992px) {
            .nav-links {
                display: none;
            }

            .mobile-toggle {
                display: block;
            }

            .blog-hero-title {
                font-size: 2.5rem;
            }

            .blog-layout {
                grid-template-columns: 1fr;
            }

            .sidebar {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
            }

            .footer-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .container {
                padding: 0 1rem;
            }

            .blog-hero {
                padding: 6rem 0 3rem;
            }

            .blog-hero-title {
                font-size: 2rem;
            }

            .blog-hero-subtitle {
                font-size: 1rem;
            }

            .posts-grid {
                grid-template-columns: 1fr;
            }

            .sidebar {
                grid-template-columns: 1fr;
            }

            .featured-image {
                height: 250px;
            }

            .featured-title {
                font-size: 1.25rem;
            }

            .footer-grid {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            .footer-bottom {
                flex-direction: column;
                text-align: center;
            }
        }

        @media (max-width: 480px) {
            .blog-hero-title {
                font-size: 1.75rem;
            }

            .blog-categories {
                top: 60px;
            }

            .category-tab {
                padding: 0.5rem 1rem;
                font-size: 0.8rem;
            }

            .featured-image {
                height: 200px;
            }

            .post-image {
                height: 150px;
            }

            .pagination {
                flex-wrap: wrap;
            }

            .page-btn {
                width: 40px;
                height: 40px;
            }

            .back-to-top {
                width: 45px;
                height: 45px;
                bottom: 1.5rem;
                right: 1.5rem;
            }
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: var(--bg-gray);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-dark);
        }
    </style>
</head>
<body>

    <!-- ============================================
         HEADER
    ============================================ -->
    <?php include 'header.php';?>

    <!-- ============================================
         BLOG HERO
    ============================================ -->
    <section class="blog-hero">
        <div class="container">
            <div class="blog-hero-content">
                <div class="blog-hero-badge">
                    <i class="fas fa-newspaper"></i>
                    Our Blog
                </div>
                <h1 class="blog-hero-title">Latest <span>News</span> & Updates</h1>
                <p class="blog-hero-subtitle">
                    Stay updated with the latest business trends, tips, and insights from across India
                </p>
                <div class="blog-search">
                    <input type="text" placeholder="Search articles...">
                    <button><i class="fas fa-search"></i></button>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================
         BLOG CATEGORIES
    ============================================ -->
    <div class="blog-categories">
        <div class="container">
            <div class="categories-wrapper">
                <button class="category-tab active">All Posts</button>
                <button class="category-tab">Business Tips</button>
                <button class="category-tab">Marketing</button>
                <button class="category-tab">Technology</button>
                <button class="category-tab">Startup Stories</button>
                <button class="category-tab">Industry News</button>
                <button class="category-tab">Success Stories</button>
                <button class="category-tab">Guides</button>
            </div>
        </div>
    </div>

    <!-- ============================================
         BLOG MAIN CONTENT
    ============================================ -->
    <section class="blog-section">
        <div class="container">
            <div class="blog-layout">
                <!-- Main Content -->
                <main class="blog-main">
                    <!-- Featured Post -->
                    <article class="featured-post">
                        <div class="featured-image">
                            <img src="https://images.unsplash.com/photo-1556761175-4b46a572b786?w=800" alt="Featured Post">
                            <span class="featured-badge"><i class="fas fa-star"></i> Featured</span>
                            <span class="featured-category">Business Tips</span>
                        </div>
                        <div class="featured-content">
                            <div class="post-meta">
                                <span class="post-meta-item">
                                    <i class="fas fa-calendar"></i>
                                    Jan 15, 2025
                                </span>
                                <span class="post-meta-item">
                                    <i class="fas fa-clock"></i>
                                    8 min read
                                </span>
                                <span class="post-meta-item">
                                    <i class="fas fa-eye"></i>
                                    2.5k views
                                </span>
                            </div>
                            <h2 class="featured-title">
                                <a href="#">10 Essential Tips to Grow Your Local Business in 2025</a>
                            </h2>
                            <p class="featured-excerpt">
                                Discover the proven strategies that successful local businesses are using to thrive in the digital age. From leveraging online directories to building customer loyalty, learn how to take your business to the next level.
                            </p>
                            <div class="featured-footer">
                                <div class="author-info">
                                    <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=100" alt="Author" class="author-avatar">
                                    <div>
                                        <div class="author-name">Rajesh Kumar</div>
                                        <div class="author-role">Business Expert</div>
                                    </div>
                                </div>
                                <a href="#" class="read-more-btn">
                                    Read More <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </article>

                    <!-- Posts Grid -->
                    <div class="posts-grid">
                        <!-- Post 1 -->
                        <article class="post-card">
                            <div class="post-image">
                                <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=500" alt="Post">
                                <span class="post-category">Marketing</span>
                            </div>
                            <div class="post-content">
                                <h3 class="post-title">
                                    <a href="#">How to Create an Effective Digital Marketing Strategy</a>
                                </h3>
                                <p class="post-excerpt">
                                    Learn the key components of a successful digital marketing strategy that drives real results.
                                </p>
                                <div class="post-footer">
                                    <span class="post-date">
                                        <i class="fas fa-calendar"></i>
                                        Jan 12, 2025
                                    </span>
                                    <span class="post-read-time">
                                        <i class="fas fa-clock"></i>
                                        5 min
                                    </span>
                                </div>
                            </div>
                        </article>

                        <!-- Post 2 -->
                        <article class="post-card">
                            <div class="post-image">
                                <img src="https://images.unsplash.com/photo-1519389950473-47ba0277781c?w=500" alt="Post">
                                <span class="post-category">Technology</span>
                            </div>
                            <div class="post-content">
                                <h3 class="post-title">
                                    <a href="#">Top 5 Tech Tools Every Small Business Needs</a>
                                </h3>
                                <p class="post-excerpt">
                                    Discover the essential technology tools that can help streamline your business operations.
                                </p>
                                <div class="post-footer">
                                    <span class="post-date">
                                        <i class="fas fa-calendar"></i>
                                        Jan 10, 2025
                                    </span>
                                    <span class="post-read-time">
                                        <i class="fas fa-clock"></i>
                                        6 min
                                    </span>
                                </div>
                            </div>
                        </article>

                        <!-- Post 3 -->
                        <article class="post-card">
                            <div class="post-image">
                                <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=500" alt="Post">
                                <span class="post-category">Startup Stories</span>
                            </div>
                            <div class="post-content">
                                <h3 class="post-title">
                                    <a href="#">From Garage to Glory: A Mumbai Startup's Journey</a>
                                </h3>
                                <p class="post-excerpt">
                                    An inspiring story of how a small startup grew into a successful enterprise in just 3 years.
                                </p>
                                <div class="post-footer">
                                    <span class="post-date">
                                        <i class="fas fa-calendar"></i>
                                        Jan 8, 2025
                                    </span>
                                    <span class="post-read-time">
                                        <i class="fas fa-clock"></i>
                                        7 min
                                    </span>
                                </div>
                            </div>
                        </article>

                        <!-- Post 4 -->
                        <article class="post-card">
                            <div class="post-image">
                                <img src="https://images.unsplash.com/photo-1553877522-43269d4ea984?w=500" alt="Post">
                                <span class="post-category">Business Tips</span>
                            </div>
                            <div class="post-content">
                                <h3 class="post-title">
                                    <a href="#">Customer Retention Strategies That Actually Work</a>
                                </h3>
                                <p class="post-excerpt">
                                    Keep your customers coming back with these proven retention strategies and techniques.
                                </p>
                                <div class="post-footer">
                                    <span class="post-date">
                                        <i class="fas fa-calendar"></i>
                                        Jan 5, 2025
                                    </span>
                                    <span class="post-read-time">
                                        <i class="fas fa-clock"></i>
                                        4 min
                                    </span>
                                </div>
                            </div>
                        </article>

                        <!-- Post 5 -->
                        <article class="post-card">
                            <div class="post-image">
                                <img src="https://images.unsplash.com/photo-1542744173-8e7e53415bb0?w=500" alt="Post">
                                <span class="post-category">Industry News</span>
                            </div>
                            <div class="post-content">
                                <h3 class="post-title">
                                    <a href="#">E-commerce Trends to Watch in 2025</a>
                                </h3>
                                <p class="post-excerpt">
                                    Stay ahead of the curve with these emerging e-commerce trends shaping the future of retail.
                                </p>
                                <div class="post-footer">
                                    <span class="post-date">
                                        <i class="fas fa-calendar"></i>
                                        Jan 3, 2025
                                    </span>
                                    <span class="post-read-time">
                                        <i class="fas fa-clock"></i>
                                        6 min
                                    </span>
                                </div>
                            </div>
                        </article>

                        <!-- Post 6 -->
                        <article class="post-card">
                            <div class="post-image">
                                <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?w=500" alt="Post">
                                <span class="post-category">Guides</span>
                            </div>
                            <div class="post-content">
                                <h3 class="post-title">
                                    <a href="#">Complete Guide to Getting Listed on Bharat Directory</a>
                                </h3>
                                <p class="post-excerpt">
                                    A step-by-step guide to creating an effective business listing that attracts customers.
                                </p>
                                <div class="post-footer">
                                    <span class="post-date">
                                        <i class="fas fa-calendar"></i>
                                        Jan 1, 2025
                                    </span>
                                    <span class="post-read-time">
                                        <i class="fas fa-clock"></i>
                                        10 min
                                    </span>
                                </div>
                            </div>
                        </article>
                    </div>

                    <!-- Pagination -->
                    <div class="pagination">
                        <button class="page-btn nav-arrow"><i class="fas fa-chevron-left"></i></button>
                        <button class="page-btn active">1</button>
                        <button class="page-btn">2</button>
                        <button class="page-btn">3</button>
                        <button class="page-btn">4</button>
                        <button class="page-btn">5</button>
                        <button class="page-btn nav-arrow"><i class="fas fa-chevron-right"></i></button>
                    </div>
                </main>

                <!-- Sidebar -->
                <aside class="sidebar">
                    <!-- Popular Posts -->
                    <div class="sidebar-widget">
                        <h3 class="widget-title">
                            <i class="fas fa-fire"></i>
                            Popular Posts
                        </h3>
                        <div class="popular-posts">
                            <a href="#" class="popular-post-item">
                                <img src="https://images.unsplash.com/photo-1556761175-4b46a572b786?w=200" alt="Post" class="popular-post-image">
                                <div class="popular-post-content">
                                    <h4 class="popular-post-title">10 Essential Tips to Grow Your Local Business</h4>
                                    <span class="popular-post-date">
                                        <i class="fas fa-calendar"></i>
                                        Jan 15, 2025
                                    </span>
                                </div>
                            </a>
                            <a href="#" class="popular-post-item">
                                <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=200" alt="Post" class="popular-post-image">
                                <div class="popular-post-content">
                                    <h4 class="popular-post-title">Digital Marketing Strategy Guide</h4>
                                    <span class="popular-post-date">
                                        <i class="fas fa-calendar"></i>
                                        Jan 12, 2025
                                    </span>
                                </div>
                            </a>
                            <a href="#" class="popular-post-item">
                                <img src="https://images.unsplash.com/photo-1519389950473-47ba0277781c?w=200" alt="Post" class="popular-post-image">
                                <div class="popular-post-content">
                                    <h4 class="popular-post-title">Top 5 Tech Tools for Small Business</h4>
                                    <span class="popular-post-date">
                                        <i class="fas fa-calendar"></i>
                                        Jan 10, 2025
                                    </span>
                                </div>
                            </a>
                            <a href="#" class="popular-post-item">
                                <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=200" alt="Post" class="popular-post-image">
                                <div class="popular-post-content">
                                    <h4 class="popular-post-title">Mumbai Startup Success Story</h4>
                                    <span class="popular-post-date">
                                        <i class="fas fa-calendar"></i>
                                        Jan 8, 2025
                                    </span>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- Newsletter -->
                    <div class="sidebar-widget newsletter-widget">
                        <h3 class="widget-title">
                            <i class="fas fa-envelope"></i>
                            Newsletter
                        </h3>
                        <p class="newsletter-text">
                            Subscribe to our newsletter and get the latest updates directly in your inbox.
                        </p>
                        <form class="newsletter-form">
                            <input type="email" class="newsletter-input" placeholder="Enter your email">
                            <button type="submit" class="newsletter-btn">
                                <i class="fas fa-paper-plane"></i>
                                Subscribe
                            </button>
                        </form>
                    </div>

                    <!-- Tags -->
                    <div class="sidebar-widget">
                        <h3 class="widget-title">
                            <i class="fas fa-tags"></i>
                            Popular Tags
                        </h3>
                        <div class="tags-cloud">
                            <span class="tag-item">Business</span>
                            <span class="tag-item">Marketing</span>
                            <span class="tag-item">Startup</span>
                            <span class="tag-item">Technology</span>
                            <span class="tag-item">Growth</span>
                            <span class="tag-item">Tips</span>
                            <span class="tag-item">Success</span>
                            <span class="tag-item">Strategy</span>
                            <span class="tag-item">SEO</span>
                            <span class="tag-item">Social Media</span>
                        </div>
                    </div>

                    <!-- Social Links -->
                    <div class="sidebar-widget">
                        <h3 class="widget-title">
                            <i class="fas fa-share-alt"></i>
                            Follow Us
                        </h3>
                        <div class="social-links">
                            <a href="#" class="social-link facebook"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="social-link twitter"><i class="fab fa-x"></i></a>
                            <a href="#" class="social-link instagram"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="social-link youtube"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    <!-- ============================================
         FOOTER
    ============================================ -->
    <?php include 'footer.php';?>

    <!-- Back to Top -->
    <button class="back-to-top" id="backToTop">
        <i class="fas fa-arrow-up"></i>
    </button>

    <script>
        // Back to Top Button
        const backToTop = document.getElementById('backToTop');
        
        window.addEventListener('scroll', () => {
            if (window.scrollY > 300) {
                backToTop.classList.add('visible');
            } else {
                backToTop.classList.remove('visible');
            }
        });

        backToTop.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        // Category Tabs
        const categoryTabs = document.querySelectorAll('.category-tab');
        
        categoryTabs.forEach(tab => {
            tab.addEventListener('click', () => {
                categoryTabs.forEach(t => t.classList.remove('active'));
                tab.classList.add('active');
            });
        });

        // Pagination
        const pageBtns = document.querySelectorAll('.page-btn:not(.nav-arrow)');
        
        pageBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                pageBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
            });
        });
    </script>

</body>
</html>