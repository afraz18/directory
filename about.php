<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Bharat Directory | India's Leading Business Directory</title>
    <meta name="description" content="Learn about Bharat Directory - India's largest business directory connecting millions of customers with trusted local businesses across 500+ cities.">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <style>
        /* ========================================
           CSS RESET & VARIABLES
        ======================================== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #ff6b35;
            --primary-dark: #e55a2b;
            --primary-light: #ff8c5a;
            --secondary: #138808;
            --secondary-light: #1ba50d;
            --accent: #000080;
            --accent-light: #1a1a9e;
            --dark: #1a1a2e;
            --dark-light: #16213e;
            --gray-900: #1e293b;
            --gray-700: #334155;
            --gray-600: #475569;
            --gray-500: #64748b;
            --gray-400: #94a3b8;
            --gray-300: #cbd5e1;
            --gray-200: #e2e8f0;
            --gray-100: #f1f5f9;
            --light: #f8fafc;
            --white: #ffffff;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #3b82f6;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.08);
            --shadow-md: 0 4px 15px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 15px 40px rgba(0, 0, 0, 0.12);
            --shadow-xl: 0 25px 60px rgba(0, 0, 0, 0.15);
            --transition: all 0.3s ease;
            --transition-slow: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 16px;
            --radius-xl: 24px;
            --radius-2xl: 32px;
            --radius-full: 50%;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: var(--gray-700);
            background: var(--white);
            overflow-x: hidden;
            line-height: 1.6;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        ul {
            list-style: none;
        }

        img {
            max-width: 100%;
            height: auto;
        }

        button {
            cursor: pointer;
            font-family: inherit;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 6%;
        }
        /* ========================================
           HERO SECTION
        ======================================== */
        .hero {
            min-height: 70vh;
            background: linear-gradient(135deg, var(--dark) 0%, var(--dark-light) 50%, var(--accent) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            padding: 140px 6% 100px;
            overflow: hidden;
        }

        .hero-bg {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            overflow: hidden;
        }

        .hero-shape {
            position: absolute;
            border-radius: var(--radius-full);
            opacity: 0.1;
        }

        .shape-1 {
            width: 600px;
            height: 600px;
            background: var(--primary);
            top: -250px;
            right: -150px;
            animation: float 8s ease-in-out infinite;
        }

        .shape-2 {
            width: 450px;
            height: 450px;
            background: var(--secondary);
            bottom: -200px;
            left: -150px;
            animation: float 10s ease-in-out infinite reverse;
        }

        .shape-3 {
            width: 300px;
            height: 300px;
            background: var(--white);
            top: 30%;
            left: 20%;
            animation: float 6s ease-in-out infinite;
        }

        .shape-4 {
            width: 200px;
            height: 200px;
            background: var(--warning);
            bottom: 25%;
            right: 15%;
            animation: float 7s ease-in-out infinite reverse;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-30px) rotate(10deg); }
        }

        .hero-pattern {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: 
                linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
            background-size: 50px 50px;
        }

        .hero-content {
            position: relative;
            z-index: 10;
            text-align: center;
            max-width: 900px;
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-bottom: 25px;
            font-size: 14px;
        }

        .breadcrumb a {
            color: rgba(255, 255, 255, 0.7);
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .breadcrumb a:hover {
            color: var(--white);
        }

        .breadcrumb > i {
            color: rgba(255, 255, 255, 0.4);
            font-size: 10px;
        }

        .breadcrumb span {
            color: var(--primary);
            font-weight: 500;
        }

        .hero h1 {
            font-size: 60px;
            font-weight: 800;
            color: var(--white);
            margin-bottom: 25px;
            line-height: 1.2;
            letter-spacing: -1px;
        }

        .hero h1 span {
            background: linear-gradient(135deg, var(--primary), var(--warning));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero p {
            font-size: 20px;
            color: rgba(255, 255, 255, 0.85);
            line-height: 1.8;
            max-width: 700px;
            margin: 0 auto 35px;
        }

        .hero-buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .btn-white {
            background: var(--white);
            color: var(--primary);
        }

        .btn-white:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(255, 255, 255, 0.2);
        }

        .btn-outline-white {
            background: transparent;
            border: 2px solid rgba(255, 255, 255, 0.5);
            color: var(--white);
        }

        .btn-outline-white:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: var(--white);
        }

        /* ========================================
           SECTION STYLES
        ======================================== */
        .section {
            padding: 100px 6%;
        }

        .section-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, rgba(255, 107, 53, 0.1), rgba(19, 136, 8, 0.1));
            color: var(--primary);
            padding: 10px 24px;
            border-radius: 100px;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .section-header h2 {
            font-size: 44px;
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 18px;
            line-height: 1.2;
        }

        .section-header p {
            color: var(--gray-500);
            font-size: 18px;
            max-width: 650px;
            margin: 0 auto;
            line-height: 1.8;
        }

        /* ========================================
           ABOUT INTRO SECTION
        ======================================== */
        .about-intro {
            background: var(--white);
        }

        .about-intro-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 80px;
            align-items: center;
            max-width: 1300px;
            margin: 0 auto;
        }

        .about-intro-image {
            position: relative;
        }

        .about-intro-image img {
            width: 100%;
            border-radius: var(--radius-2xl);
            box-shadow: var(--shadow-xl);
        }

        .about-intro-image::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: var(--radius-2xl);
            top: 30px;
            left: 30px;
            z-index: -1;
            opacity: 0.3;
        }

        .experience-badge {
            position: absolute;
            bottom: -30px;
            right: -30px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: var(--white);
            padding: 30px;
            border-radius: var(--radius-xl);
            text-align: center;
            box-shadow: 0 20px 50px rgba(255, 107, 53, 0.4);
        }

        .experience-badge .number {
            font-size: 52px;
            font-weight: 800;
            line-height: 1;
            display: block;
        }

        .experience-badge .text {
            font-size: 14px;
            font-weight: 600;
            opacity: 0.9;
        }

        .about-intro-content {
            padding-left: 20px;
        }

        .about-intro-content .section-badge {
            margin-bottom: 20px;
        }

        .about-intro-content h2 {
            font-size: 42px;
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 25px;
            line-height: 1.2;
        }

        .about-intro-content h2 span {
            color: var(--primary);
        }

        .about-intro-content > p {
            color: var(--gray-600);
            font-size: 17px;
            line-height: 1.9;
            margin-bottom: 30px;
        }

        .about-features {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
            margin-bottom: 35px;
        }

        .about-feature {
            display: flex;
            align-items: flex-start;
            gap: 15px;
        }

        .about-feature-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, rgba(255, 107, 53, 0.1), rgba(255, 107, 53, 0.2));
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-size: 20px;
            flex-shrink: 0;
        }

        .about-feature-content h4 {
            font-size: 16px;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 5px;
        }

        .about-feature-content p {
            font-size: 14px;
            color: var(--gray-500);
        }

        .founder-info {
            display: flex;
            align-items: center;
            gap: 20px;
            padding-top: 30px;
            border-top: 1px solid var(--gray-200);
        }

        .founder-avatar {
            width: 70px;
            height: 70px;
            border-radius: var(--radius-full);
            object-fit: cover;
            border: 3px solid var(--primary);
        }

        .founder-details h4 {
            font-size: 18px;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 3px;
        }

        .founder-details span {
            font-size: 14px;
            color: var(--gray-500);
        }

        .founder-signature {
            margin-left: auto;
            font-family: 'Dancing Script', cursive;
            font-size: 32px;
            color: var(--primary);
            opacity: 0.8;
        }

        /* ========================================
           STATS SECTION
        ======================================== */
        .stats-section {
            background: linear-gradient(135deg, var(--dark) 0%, var(--dark-light) 100%);
            position: relative;
            overflow: hidden;
        }

        .stats-section::before {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: var(--primary);
            border-radius: var(--radius-full);
            top: -250px;
            right: -200px;
            opacity: 0.1;
        }

        .stats-section::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: var(--secondary);
            border-radius: var(--radius-full);
            bottom: -200px;
            left: -150px;
            opacity: 0.1;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 40px;
            max-width: 1200px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        .stat-card {
            text-align: center;
            padding: 40px 30px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: var(--radius-xl);
            backdrop-filter: blur(10px);
            transition: var(--transition);
        }

        .stat-card:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-10px);
        }

        .stat-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 25px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            color: var(--white);
            box-shadow: 0 15px 35px rgba(255, 107, 53, 0.3);
        }

        .stat-card:nth-child(2) .stat-icon {
            background: linear-gradient(135deg, var(--secondary), var(--secondary-light));
            box-shadow: 0 15px 35px rgba(19, 136, 8, 0.3);
        }

        .stat-card:nth-child(3) .stat-icon {
            background: linear-gradient(135deg, var(--info), #60a5fa);
            box-shadow: 0 15px 35px rgba(59, 130, 246, 0.3);
        }

        .stat-card:nth-child(4) .stat-icon {
            background: linear-gradient(135deg, var(--warning), #fbbf24);
            box-shadow: 0 15px 35px rgba(245, 158, 11, 0.3);
        }

        .stat-number {
            font-size: 48px;
            font-weight: 800;
            color: var(--white);
            line-height: 1;
            margin-bottom: 10px;
        }

        .stat-number span {
            color: var(--primary);
        }

        .stat-label {
            font-size: 16px;
            color: rgba(255, 255, 255, 0.7);
            font-weight: 500;
        }

        /* ========================================
           MISSION VISION VALUES
        ======================================== */
        .mission-section {
            background: var(--light);
        }

        .mission-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 35px;
            max-width: 1300px;
            margin: 0 auto;
        }

        .mission-card {
            background: var(--white);
            padding: 50px 40px;
            border-radius: var(--radius-2xl);
            text-align: center;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
            box-shadow: var(--shadow-md);
            border: 2px solid transparent;
        }

        .mission-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            transform: scaleX(0);
            transition: transform 0.4s ease;
        }

        .mission-card:hover::before {
            transform: scaleX(1);
        }

        .mission-card:hover {
            transform: translateY(-15px);
            box-shadow: var(--shadow-xl);
        }

        .mission-icon {
            width: 100px;
            height: 100px;
            margin: 0 auto 30px;
            border-radius: var(--radius-full);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            position: relative;
        }

        .mission-card:nth-child(1) .mission-icon {
            background: linear-gradient(135deg, rgba(255, 107, 53, 0.1), rgba(255, 107, 53, 0.2));
            color: var(--primary);
        }

        .mission-card:nth-child(2) .mission-icon {
            background: linear-gradient(135deg, rgba(19, 136, 8, 0.1), rgba(19, 136, 8, 0.2));
            color: var(--secondary);
        }

        .mission-card:nth-child(3) .mission-icon {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(59, 130, 246, 0.2));
            color: var(--info);
        }

        .mission-card h3 {
            font-size: 26px;
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 18px;
        }

        .mission-card p {
            color: var(--gray-600);
            font-size: 16px;
            line-height: 1.8;
        }

        /* ========================================
           VALUES SECTION
        ======================================== */
        .values-section {
            background: var(--white);
        }

        .values-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
            max-width: 1300px;
            margin: 0 auto;
        }

        .value-card {
            padding: 40px 30px;
            border-radius: var(--radius-xl);
            text-align: center;
            transition: var(--transition);
            border: 2px solid var(--gray-100);
            background: var(--white);
        }

        .value-card:hover {
            border-color: var(--primary);
            transform: translateY(-10px);
            box-shadow: var(--shadow-lg);
        }

        .value-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 25px;
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            transition: var(--transition);
        }

        .value-card:nth-child(1) .value-icon {
            background: #fff7ed;
            color: var(--primary);
        }

        .value-card:nth-child(2) .value-icon {
            background: #f0fdf4;
            color: var(--secondary);
        }

        .value-card:nth-child(3) .value-icon {
            background: #eff6ff;
            color: var(--info);
        }

        .value-card:nth-child(4) .value-icon {
            background: #fefce8;
            color: var(--warning);
        }

        .value-card:hover .value-icon {
            transform: scale(1.1) rotate(-5deg);
        }

        .value-card h3 {
            font-size: 20px;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 12px;
        }

        .value-card p {
            color: var(--gray-500);
            font-size: 14px;
            line-height: 1.7;
        }

        /* ========================================
           TEAM SECTION
        ======================================== */
        .team-section {
            background: var(--light);
        }

        .team-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 35px;
            max-width: 1300px;
            margin: 0 auto;
        }

        .team-card {
            background: var(--white);
            border-radius: var(--radius-2xl);
            overflow: hidden;
            box-shadow: var(--shadow-md);
            transition: var(--transition);
        }

        .team-card:hover {
            transform: translateY(-15px);
            box-shadow: var(--shadow-xl);
        }

        .team-image {
            position: relative;
            height: 300px;
            overflow: hidden;
        }

        .team-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .team-card:hover .team-image img {
            transform: scale(1.1);
        }

        .team-social {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 20px;
            background: linear-gradient(transparent, rgba(0,0,0,0.8));
            display: flex;
            justify-content: center;
            gap: 12px;
            transform: translateY(100%);
            transition: transform 0.4s ease;
        }

        .team-card:hover .team-social {
            transform: translateY(0);
        }

        .team-social a {
            width: 40px;
            height: 40px;
            background: var(--white);
            border-radius: var(--radius-full);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            transition: var(--transition);
        }

        .team-social a:hover {
            background: var(--primary);
            color: var(--white);
            transform: translateY(-3px);
        }

        .team-info {
            padding: 30px;
            text-align: center;
        }

        .team-info h3 {
            font-size: 20px;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 5px;
        }

        .team-info span {
            font-size: 14px;
            color: var(--primary);
            font-weight: 600;
        }

        /* ========================================
           TIMELINE SECTION
        ======================================== */
        .timeline-section {
            background: var(--white);
        }

        .timeline {
            max-width: 900px;
            margin: 0 auto;
            position: relative;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            width: 4px;
            height: 100%;
            background: linear-gradient(180deg, var(--primary), var(--secondary));
            border-radius: 4px;
        }

        .timeline-item {
            display: flex;
            margin-bottom: 50px;
            position: relative;
        }

        .timeline-item:nth-child(odd) {
            flex-direction: row-reverse;
        }

        .timeline-item:nth-child(odd) .timeline-content {
            text-align: right;
            padding-right: 60px;
            padding-left: 0;
        }

        .timeline-item:nth-child(even) .timeline-content {
            text-align: left;
            padding-left: 60px;
        }

        .timeline-content {
            width: 50%;
        }

        .timeline-dot {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            width: 24px;
            height: 24px;
            background: var(--white);
            border: 4px solid var(--primary);
            border-radius: var(--radius-full);
            z-index: 1;
        }

        .timeline-year {
            display: inline-block;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: var(--white);
            padding: 8px 20px;
            border-radius: 100px;
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .timeline-content h3 {
            font-size: 22px;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 10px;
        }

        .timeline-content p {
            color: var(--gray-600);
            font-size: 15px;
            line-height: 1.8;
        }

        /* ========================================
           WHY CHOOSE US SECTION
        ======================================== */
        .why-section {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 50%, #c94416 100%);
            position: relative;
            overflow: hidden;
        }

        .why-section::before {
            content: '';
            position: absolute;
            width: 600px;
            height: 600px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: var(--radius-full);
            top: -300px;
            right: -200px;
        }

        .why-section::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: var(--radius-full);
            bottom: -200px;
            left: -100px;
        }

        .why-section .section-header h2,
        .why-section .section-header p {
            color: var(--white);
        }

        .why-section .section-badge {
            background: rgba(255, 255, 255, 0.2);
            color: var(--white);
        }

        .why-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 35px;
            max-width: 1200px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        .why-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 45px 35px;
            border-radius: var(--radius-xl);
            text-align: center;
            transition: var(--transition);
        }

        .why-card:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-10px);
        }

        .why-icon {
            width: 90px;
            height: 90px;
            margin: 0 auto 25px;
            background: var(--white);
            border-radius: var(--radius-full);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 36px;
            color: var(--primary);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        }

        .why-card h3 {
            font-size: 22px;
            font-weight: 700;
            color: var(--white);
            margin-bottom: 15px;
        }

        .why-card p {
            color: rgba(255, 255, 255, 0.85);
            font-size: 15px;
            line-height: 1.8;
        }

        /* ========================================
           TESTIMONIALS SECTION
        ======================================== */
        .testimonials-section {
            background: var(--light);
        }

        .testimonials-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 35px;
            max-width: 1300px;
            margin: 0 auto;
        }

        .testimonial-card {
            background: var(--white);
            padding: 45px;
            border-radius: var(--radius-2xl);
            box-shadow: var(--shadow-md);
            transition: var(--transition);
            position: relative;
        }

        .testimonial-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-xl);
        }

        .testimonial-quote {
            font-size: 60px;
            color: var(--primary);
            opacity: 0.2;
            position: absolute;
            top: 25px;
            right: 35px;
            line-height: 1;
        }

        .testimonial-rating {
            display: flex;
            gap: 5px;
            margin-bottom: 20px;
        }

        .testimonial-rating i {
            color: var(--warning);
            font-size: 18px;
        }

        .testimonial-text {
            font-size: 16px;
            color: var(--gray-600);
            line-height: 1.9;
            margin-bottom: 30px;
            font-style: italic;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .testimonial-avatar {
            width: 65px;
            height: 65px;
            border-radius: var(--radius-full);
            object-fit: cover;
            border: 3px solid var(--primary);
        }

        .testimonial-info h4 {
            font-size: 18px;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 3px;
        }

        .testimonial-info span {
            font-size: 14px;
            color: var(--gray-500);
        }

        /* ========================================
           PARTNERS SECTION
        ======================================== */
        .partners-section {
            background: var(--white);
            padding: 80px 6%;
        }

        .partners-header {
            text-align: center;
            margin-bottom: 50px;
        }

        .partners-header p {
            font-size: 18px;
            color: var(--gray-500);
        }

        .partners-grid {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 40px;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
        }

        .partner-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 25px;
            background: var(--gray-100);
            border-radius: var(--radius-lg);
            transition: var(--transition);
            filter: grayscale(100%);
            opacity: 0.6;
        }

        .partner-logo:hover {
            filter: grayscale(0);
            opacity: 1;
            background: var(--white);
            box-shadow: var(--shadow-md);
        }

        .partner-logo img {
            max-height: 50px;
            max-width: 120px;
        }

        /* ========================================
           CTA SECTION
        ======================================== */
        .cta-section {
            padding: 120px 6%;
            background: var(--light);
        }

        .cta-box {
            max-width: 1100px;
            margin: 0 auto;
            background: linear-gradient(135deg, var(--dark), var(--dark-light));
            border-radius: var(--radius-2xl);
            padding: 80px;
            display: grid;
            grid-template-columns: 1.2fr 0.8fr;
            gap: 60px;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .cta-box::before {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: var(--primary);
            border-radius: var(--radius-full);
            top: -200px;
            right: -100px;
            opacity: 0.15;
        }

        .cta-box::after {
            content: '';
            position: absolute;
            width: 250px;
            height: 250px;
            background: var(--secondary);
            border-radius: var(--radius-full);
            bottom: -100px;
            left: -50px;
            opacity: 0.1;
        }

        .cta-content {
            position: relative;
            z-index: 1;
        }

        .cta-content h2 {
            font-size: 40px;
            font-weight: 800;
            color: var(--white);
            margin-bottom: 20px;
            line-height: 1.2;
        }

        .cta-content p {
            font-size: 18px;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 35px;
            line-height: 1.8;
        }

        .cta-buttons {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .cta-image {
            position: relative;
            z-index: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .cta-image img {
            max-width: 300px;
            filter: drop-shadow(0 30px 50px rgba(0,0,0,0.3));
        }

        .contact-list li {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 18px;
        }

        .contact-list li > i {
            color: var(--primary);
            font-size: 16px;
            margin-top: 4px;
        }

        .contact-list li span,
        .contact-list li a {
            color: rgba(255, 255, 255, 0.6);
            font-size: 14px;
            line-height: 1.6;
        }

        .contact-list li a:hover {
            color: var(--white);
            padding-left: 0;
        }

        .app-buttons {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-top: 25px;
        }

        .app-btn {
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(255, 255, 255, 0.08);
            padding: 12px 18px;
            border-radius: var(--radius-md);
            transition: var(--transition);
        }

        .app-btn:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateX(5px);
        }

        .app-btn i {
            font-size: 28px;
            color: var(--white);
        }

        .app-btn div span {
            display: block;
            font-size: 10px;
            color: rgba(255, 255, 255, 0.6);
        }

        .app-btn div strong {
            font-size: 14px;
            color: var(--white);
        }


        /* ========================================
           BACK TO TOP
        ======================================== */
        .back-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 55px;
            height: 55px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-size: 20px;
            box-shadow: 0 10px 30px rgba(255, 107, 53, 0.35);
            opacity: 0;
            visibility: hidden;
            transition: var(--transition);
            z-index: 999;
        }

        .back-to-top.visible {
            opacity: 1;
            visibility: visible;
        }

        .back-to-top:hover {
            transform: translateY(-5px);
        }

        /* ========================================
           RESPONSIVE STYLES
        ======================================== */
        @media (max-width: 1200px) {
            .about-intro-grid {
                gap: 50px;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .mission-grid {
                grid-template-columns: 1fr;
                max-width: 600px;
            }

            .values-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .team-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .why-grid {
                grid-template-columns: 1fr;
                max-width: 500px;
            }

            .testimonials-grid {
                grid-template-columns: 1fr;
                max-width: 600px;
            }

            .partners-grid {
                grid-template-columns: repeat(3, 1fr);
            }

            .cta-box {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .cta-buttons {
                justify-content: center;
            }

            .cta-image {
                display: none;
            }
        }

        @media (max-width: 1024px) {
            .nav-links,
            .nav-buttons {
                display: none;
            }

            .menu-toggle {
                display: flex;
            }

            .hero h1 {
                font-size: 45px;
            }

            .about-intro-grid {
                grid-template-columns: 1fr;
                gap: 60px;
            }

            .about-intro-content {
                padding-left: 0;
                text-align: center;
            }

            .about-features {
                justify-items: center;
            }

            .about-feature {
                text-align: left;
            }

            .founder-info {
                justify-content: center;
                flex-wrap: wrap;
            }

            .founder-signature {
                margin-left: 0;
                width: 100%;
                margin-top: 15px;
            }

            .timeline::before {
                left: 30px;
            }

            .timeline-item,
            .timeline-item:nth-child(odd) {
                flex-direction: column;
            }

            .timeline-content,
            .timeline-item:nth-child(odd) .timeline-content,
            .timeline-item:nth-child(even) .timeline-content {
                width: 100%;
                text-align: left !important;
                padding-left: 70px !important;
                padding-right: 0 !important;
            }

            .timeline-dot {
                left: 30px;
            }

            .section-header h2 {
                font-size: 36px;
            }

            .footer-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .footer-brand {
                grid-column: span 2;
            }
        }

        @media (max-width: 768px) {
            .hero {
                padding: 120px 5% 80px;
            }

            .hero h1 {
                font-size: 36px;
            }

            .hero p {
                font-size: 16px;
            }

            .hero-buttons {
                flex-direction: column;
                align-items: center;
            }

            .section {
                padding: 70px 5%;
            }

            .section-header h2 {
                font-size: 30px;
            }

            .about-intro-content h2 {
                font-size: 32px;
            }

            .experience-badge {
                position: relative;
                bottom: auto;
                right: auto;
                margin: 30px auto 0;
                display: inline-block;
            }

            .about-intro-image {
                text-align: center;
            }

            .about-intro-image::before {
                display: none;
            }

            .about-features {
                grid-template-columns: 1fr;
            }

            .stats-grid {
                grid-template-columns: 1fr;
                max-width: 350px;
                margin: 0 auto;
            }

            .values-grid {
                grid-template-columns: 1fr;
                max-width: 400px;
                margin: 0 auto;
            }

            .team-grid {
                grid-template-columns: 1fr;
                max-width: 400px;
                margin: 0 auto;
            }

            .partners-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .cta-box {
                padding: 50px 30px;
            }

            .cta-content h2 {
                font-size: 28px;
            }

            .cta-buttons {
                flex-direction: column;
            }

        @media (max-width: 480px) {
            .navbar {
                padding: 15px 5%;
            }

            .logo-icon {
                width: 42px;
                height: 42px;
                font-size: 20px;
            }

            .logo-main {
                font-size: 20px;
            }

            .logo-sub {
                font-size: 9px;
                letter-spacing: 2px;
            }

            .hero h1 {
                font-size: 30px;
            }

            .section-header h2 {
                font-size: 26px;
            }

            .about-intro-content h2 {
                font-size: 26px;
            }

            .stat-number {
                font-size: 40px;
            }

            .mission-card {
                padding: 35px 25px;
            }

            .mission-icon {
                width: 80px;
                height: 80px;
                font-size: 32px;
            }

            .mission-card h3 {
                font-size: 22px;
            }

            .timeline-content h3 {
                font-size: 18px;
            }

            .testimonial-card {
                padding: 30px;
            }

            .partners-grid {
                grid-template-columns: 1fr 1fr;
                gap: 20px;
            }

            .back-to-top {
                width: 48px;
                height: 48px;
                bottom: 20px;
                right: 20px;
                font-size: 18px;
            }
        }
    </style>
</head>
<body>
   <?php include 'header.php';?>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-bg">
            <div class="hero-shape shape-1"></div>
            <div class="hero-shape shape-2"></div>
            <div class="hero-shape shape-3"></div>
            <div class="hero-shape shape-4"></div>
            <div class="hero-pattern"></div>
        </div>
        <div class="hero-content">
            <nav class="breadcrumb">
                <a href="index.php"><i class="fas fa-home"></i> Home</a>
                <i class="fas fa-chevron-right"></i>
                <span>About Us</span>
            </nav>
            <h1>Empowering <span>Indian Businesses</span> Since 2015</h1>
            <p>We're on a mission to connect millions of customers with trusted local businesses across India. Discover our story, values, and the team behind Bharat Directory.</p>
            <div class="hero-buttons">
                <a href="#our-story" class="btn btn-lg btn-white">
                    <i class="fas fa-book-open"></i>
                    Our Story
                </a>
                <a href="#team" class="btn btn-lg btn-outline-white">
                    <i class="fas fa-users"></i>
                    Meet the Team
                </a>
            </div>
        </div>
    </section>

    <!-- About Intro Section -->
    <section class="section about-intro" id="our-story">
        <div class="about-intro-grid">
            <div class="about-intro-image">
                <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=600&h=500&fit=crop" alt="Bharat Directory Team">
                <div class="experience-badge">
                    <span class="number">9+</span>
                    <span class="text">Years of Excellence</span>
                </div>
            </div>
            <div class="about-intro-content">
                <span class="section-badge">
                    <i class="fas fa-info-circle"></i>
                    About Us
                </span>
                <h2>Building India's Largest <span>Business Network</span></h2>
                <p>Founded in 2015, Bharat Directory started with a simple yet powerful vision – to bridge the gap between local businesses and customers in India. What began as a small startup in New Delhi has now grown into India's most trusted business directory platform.</p>
                <p>Today, we serve millions of users every month, helping them discover and connect with over 50,000 verified businesses across 500+ cities in India.</p>
                
                <div class="about-features">
                    <div class="about-feature">
                        <div class="about-feature-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="about-feature-content">
                            <h4>Verified Listings</h4>
                            <p>Every business is verified</p>
                        </div>
                    </div>
                    <div class="about-feature">
                        <div class="about-feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div class="about-feature-content">
                            <h4>Trusted Platform</h4>
                            <p>1M+ monthly users</p>
                        </div>
                    </div>
                    <div class="about-feature">
                        <div class="about-feature-icon">
                            <i class="fas fa-headset"></i>
                        </div>
                        <div class="about-feature-content">
                            <h4>24/7 Support</h4>
                            <p>Always here to help</p>
                        </div>
                    </div>
                    <div class="about-feature">
                        <div class="about-feature-icon">
                            <i class="fas fa-map-marked-alt"></i>
                        </div>
                        <div class="about-feature-content">
                            <h4>Pan India Presence</h4>
                            <p>500+ cities covered</p>
                        </div>
                    </div>
                </div>

                <div class="founder-info">
                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&h=100&fit=crop" alt="Founder" class="founder-avatar">
                    <div class="founder-details">
                        <h4>Rajesh Kumar</h4>
                        <span>Founder & CEO</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="section stats-section">
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-building"></i>
                </div>
                <div class="stat-number">50<span>K+</span></div>
                <div class="stat-label">Businesses Listed</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-number">1<span>M+</span></div>
                <div class="stat-label">Monthly Visitors</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-city"></i>
                </div>
                <div class="stat-number">500<span>+</span></div>
                <div class="stat-label">Cities Covered</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-star"></i>
                </div>
                <div class="stat-number">150<span>K+</span></div>
                <div class="stat-label">Reviews & Ratings</div>
            </div>
        </div>
    </section>

    <!-- Mission Vision Values Section -->
    <section class="section mission-section">
        <div class="section-header">
            <span class="section-badge">
                <i class="fas fa-bullseye"></i>
                Our Purpose
            </span>
            <h2>Mission, Vision & Values</h2>
            <p>Guiding principles that drive everything we do at Bharat Directory</p>
        </div>
        <div class="mission-grid">
            <div class="mission-card">
                <div class="mission-icon">
                    <i class="fas fa-rocket"></i>
                </div>
                <h3>Our Mission</h3>
                <p>To empower every Indian business, from local shops to growing enterprises, by providing a powerful platform that connects them with millions of potential customers, driving growth and success.</p>
            </div>
            <div class="mission-card">
                <div class="mission-icon">
                    <i class="fas fa-eye"></i>
                </div>
                <h3>Our Vision</h3>
                <p>To become India's most trusted and comprehensive business directory, where every business has the opportunity to thrive and every customer can find exactly what they need.</p>
            </div>
            <div class="mission-card">
                <div class="mission-icon">
                    <i class="fas fa-heart"></i>
                </div>
                <h3>Our Promise</h3>
                <p>To maintain the highest standards of accuracy, transparency, and trust in every listing. We promise to continuously innovate and improve our platform for our users and partners.</p>
            </div>
        </div>
    </section>

    <!-- Values Section -->
    <section class="section values-section">
        <div class="section-header">
            <span class="section-badge">
                <i class="fas fa-gem"></i>
                Core Values
            </span>
            <h2>What We Stand For</h2>
            <p>The fundamental beliefs that shape our culture and guide our decisions</p>
        </div>
        <div class="values-grid">
            <div class="value-card">
                <div class="value-icon">
                    <i class="fas fa-handshake"></i>
                </div>
                <h3>Trust & Integrity</h3>
                <p>We build trust through transparency, honesty, and ethical business practices in everything we do.</p>
            </div>
            <div class="value-card">
                <div class="value-icon">
                    <i class="fas fa-lightbulb"></i>
                </div>
                <h3>Innovation</h3>
                <p>We continuously innovate to provide cutting-edge solutions that help businesses grow and succeed.</p>
            </div>
            <div class="value-card">
                <div class="value-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3>Customer First</h3>
                <p>Our customers are at the heart of everything we do. Their success is our success.</p>
            </div>
            <div class="value-card">
                <div class="value-icon">
                    <i class="fas fa-award"></i>
                </div>
                <h3>Excellence</h3>
                <p>We strive for excellence in every interaction, every feature, and every service we provide.</p>
            </div>
        </div>
    </section>


    <!-- Timeline Section -->
    <section class="section timeline-section">
        <div class="section-header">
            <span class="section-badge">
                <i class="fas fa-history"></i>
                Our Journey
            </span>
            <h2>Milestones & Achievements</h2>
            <p>A look back at our journey and the milestones we've achieved</p>
        </div>
        <div class="timeline">
            <div class="timeline-item">
                <div class="timeline-content">
                    <span class="timeline-year">2015</span>
                    <h3>The Beginning</h3>
                    <p>Bharat Directory was founded in New Delhi with a vision to create India's most comprehensive business directory.</p>
                </div>
                <div class="timeline-dot"></div>
            </div>
            <div class="timeline-item">
                <div class="timeline-content">
                    <span class="timeline-year">2017</span>
                    <h3>10,000 Businesses</h3>
                    <p>Reached our first major milestone with 10,000 verified business listings across 50 cities.</p>
                </div>
                <div class="timeline-dot"></div>
            </div>
            <div class="timeline-item">
                <div class="timeline-content">
                    <span class="timeline-year">2019</span>
                    <h3>Mobile App Launch</h3>
                    <p>Launched our mobile apps on iOS and Android, making it easier for users to find businesses on the go.</p>
                </div>
                <div class="timeline-dot"></div>
            </div>
            <div class="timeline-item">
                <div class="timeline-content">
                    <span class="timeline-year">2021</span>
                    <h3>1 Million Users</h3>
                    <p>Celebrated reaching 1 million monthly active users and expanded to 300+ cities across India.</p>
                </div>
                <div class="timeline-dot"></div>
            </div>
            <div class="timeline-item">
                <div class="timeline-content">
                    <span class="timeline-year">2024</span>
                    <h3>Today & Beyond</h3>
                    <p>50,000+ businesses, 500+ cities, and millions of happy customers. The journey continues!</p>
                </div>
                <div class="timeline-dot"></div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us Section -->
    <section class="section why-section">
        <div class="section-header">
            <span class="section-badge">
                <i class="fas fa-trophy"></i>
                Why Choose Us
            </span>
            <h2>What Makes Us Different</h2>
            <p>Discover the advantages of partnering with Bharat Directory</p>
        </div>
        <div class="why-grid">
            <div class="why-card">
                <div class="why-icon">
                    <i class="fas fa-search"></i>
                </div>
                <h3>Smart Search</h3>
                <p>Our advanced search algorithms help users find exactly what they're looking for in seconds, driving quality leads to your business.</p>
            </div>
            <div class="why-card">
                <div class="why-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3>Analytics & Insights</h3>
                <p>Get detailed analytics on your listing performance, customer interactions, and valuable business insights to grow smarter.</p>
            </div>
            <div class="why-card">
                <div class="why-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3>Verified & Trusted</h3>
                <p>Every business undergoes our rigorous verification process, ensuring users can trust the listings they find on our platform.</p>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="section testimonials-section">
        <div class="section-header">
            <span class="section-badge">
                <i class="fas fa-quote-left"></i>
                Testimonials
            </span>
            <h2>What Our Users Say</h2>
            <p>Real stories from businesses and customers who trust Bharat Directory</p>
        </div>
        <div class="testimonials-grid">
            <div class="testimonial-card">
                <i class="fas fa-quote-right testimonial-quote"></i>
                <div class="testimonial-rating">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p class="testimonial-text">"Bharat Directory has been a game-changer for my restaurant. We've seen a 200% increase in customer inquiries since listing with them. Highly recommended!"</p>
                <div class="testimonial-author">
                    <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?w=100&h=100&fit=crop" alt="Suresh Menon" class="testimonial-avatar">
                    <div class="testimonial-info">
                        <h4>Suresh Menon</h4>
                        <span>Restaurant Owner, Mumbai</span>
                    </div>
                </div>
            </div>
            <div class="testimonial-card">
                <i class="fas fa-quote-right testimonial-quote"></i>
                <div class="testimonial-rating">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p class="testimonial-text">"Finding reliable local services used to be so difficult. Bharat Directory makes it incredibly easy. I use it for everything from finding doctors to home services."</p>
                <div class="testimonial-author">
                    <img src="https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?w=100&h=100&fit=crop" alt="Anjali Desai" class="testimonial-avatar">
                    <div class="testimonial-info">
                        <h4>Anjali Desai</h4>
                        <span>Customer, Bangalore</span>
                    </div>
                </div>
            </div>
            <div class="testimonial-card">
                <i class="fas fa-quote-right testimonial-quote"></i>
                <div class="testimonial-rating">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
                <p class="testimonial-text">"As a small business owner, the premium listing has given us visibility we couldn't afford otherwise. The ROI has been phenomenal!"</p>
                <div class="testimonial-author">
                    <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=100&h=100&fit=crop" alt="Vikram Singh" class="testimonial-avatar">
                    <div class="testimonial-info">
                        <h4>Vikram Singh</h4>
                        <span>Shop Owner, Delhi</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Partners Section -->
    <section class="partners-section">
        <div class="partners-header">
            <p>Trusted by Leading Brands Across India</p>
        </div>
        <div class="partners-grid">
            <div class="partner-logo">
                <img src="https://via.placeholder.com/120x50?text=Partner+1" alt="Partner 1">
            </div>
            <div class="partner-logo">
                <img src="https://via.placeholder.com/120x50?text=Partner+2" alt="Partner 2">
            </div>
            <div class="partner-logo">
                <img src="https://via.placeholder.com/120x50?text=Partner+3" alt="Partner 3">
            </div>
            <div class="partner-logo">
                <img src="https://via.placeholder.com/120x50?text=Partner+4" alt="Partner 4">
            </div>
            <div class="partner-logo">
                <img src="https://via.placeholder.com/120x50?text=Partner+5" alt="Partner 5">
            </div>
            <div class="partner-logo">
                <img src="https://via.placeholder.com/120x50?text=Partner+6" alt="Partner 6">
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="cta-box">
            <div class="cta-content">
                <h2>Ready to Grow Your Business?</h2>
                <p>Join thousands of successful businesses on Bharat Directory and reach millions of potential customers across India.</p>
                <div class="cta-buttons">
                    <a href="#" class="btn btn-lg btn-primary">
                        <i class="fas fa-rocket"></i>
                        List Your Business Free
                    </a>
                    <a href="contact.html" class="btn btn-lg btn-outline">
                        <i class="fas fa-phone"></i>
                        Contact Us
                    </a>
                </div>
            </div>
            <div class="cta-image">
                <img src="https://via.placeholder.com/300x400?text=App+Preview" alt="Bharat Directory App">
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include 'footer.php';?>

    <!-- Back to Top -->
    <a href="#" class="back-to-top" id="backToTop">
        <i class="fas fa-arrow-up"></i>
    </a>

    <!-- JavaScript -->
    <script>
        // ========================================
        // DOM ELEMENTS
        // ========================================
        const navbar = document.getElementById('navbar');
        const menuToggle = document.getElementById('menuToggle');
        const mobileMenu = document.getElementById('mobileMenu');
        const backToTop = document.getElementById('backToTop');

        // ========================================
        // NAVBAR SCROLL EFFECT
        // ========================================
        function handleNavbarScroll() {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        }

        window.addEventListener('scroll', handleNavbarScroll);
        handleNavbarScroll();

        // ========================================
        // MOBILE MENU TOGGLE
        // ========================================
        menuToggle.addEventListener('click', () => {
            menuToggle.classList.toggle('active');
            mobileMenu.classList.toggle('active');
            document.body.style.overflow = mobileMenu.classList.contains('active') ? 'hidden' : '';
        });

        document.querySelectorAll('.mobile-nav-links a').forEach(link => {
            link.addEventListener('click', () => {
                menuToggle.classList.remove('active');
                mobileMenu.classList.remove('active');
                document.body.style.overflow = '';
            });
        });

        // ========================================
        // BACK TO TOP BUTTON
        // ========================================
        function handleBackToTop() {
            if (window.scrollY > 500) {
                backToTop.classList.add('visible');
            } else {
                backToTop.classList.remove('visible');
            }
        }

        window.addEventListener('scroll', handleBackToTop);

        backToTop.addEventListener('click', (e) => {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // ========================================
        // SMOOTH SCROLL FOR ANCHOR LINKS
        // ========================================
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                
                if (href !== '#') {
                    e.preventDefault();
                    const target = document.querySelector(href);
                    
                    if (target) {
                        const offsetTop = target.offsetTop - 80;
                        window.scrollTo({
                            top: offsetTop,
                            behavior: 'smooth'
                        });
                    }
                }
            });
        });

        // ========================================
        // COUNTER ANIMATION
        // ========================================
        function animateCounter(element, target, duration = 2000) {
            let start = 0;
            const increment = target / (duration / 16);
            
            function updateCounter() {
                start += increment;
                if (start < target) {
                    element.textContent = Math.floor(start).toLocaleString();
                    requestAnimationFrame(updateCounter);
                } else {
                    element.textContent = target.toLocaleString();
                }
            }
            
            updateCounter();
        }

        // ========================================
        // SCROLL REVEAL ANIMATION
        // ========================================
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                    revealObserver.unobserve(entry.target);
                }
            });
        }, observerOptions);

        const revealElements = document.querySelectorAll(
            '.stat-card, .mission-card, .value-card, .team-card, .timeline-item, .why-card, .testimonial-card, .partner-logo'
        );

        revealElements.forEach((el, index) => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = `all 0.6s ease ${index * 0.1}s`;
            revealObserver.observe(el);
        });

        // ========================================
        // STATS COUNTER ANIMATION ON SCROLL
        // ========================================
        const statsSection = document.querySelector('.stats-section');
        let statsAnimated = false;

        const statsObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !statsAnimated) {
                    statsAnimated = true;
                    
                    const statNumbers = document.querySelectorAll('.stat-number');
                    statNumbers.forEach(stat => {
                        const text = stat.textContent;
                        const match = text.match(/(\d+)/);
                        if (match) {
                            const target = parseInt(match[1]);
                            const suffix = text.replace(match[1], '').trim();
                            
                            let current = 0;
                            const increment = target / 50;
                            
                            const updateCount = () => {
                                current += increment;
                                if (current < target) {
                                    stat.innerHTML = Math.floor(current) + '<span>' + suffix + '</span>';
                                    requestAnimationFrame(updateCount);
                                } else {
                                    stat.innerHTML = target + '<span>' + suffix + '</span>';
                                }
                            };
                            
                            updateCount();
                        }
                    });
                }
            });
        }, { threshold: 0.5 });

        if (statsSection) {
            statsObserver.observe(statsSection);
        }

        // ========================================
        // INITIALIZE
        // ========================================
        window.addEventListener('load', () => {
            handleNavbarScroll();
            handleBackToTop();
            document.body.classList.add('loaded');
        });
    </script>
</body>
</html>