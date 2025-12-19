<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Bharat Directory | India's Leading Business Directory</title>
    <meta name="description" content="Get in touch with Bharat Directory. Contact us for business listings, support, or any inquiries.">
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

        /* ========================================
           HERO SECTION
        ======================================== */
        .hero {
            min-height: 55vh;
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
            width: 250px;
            height: 250px;
            background: var(--white);
            top: 40%;
            left: 25%;
            animation: float 6s ease-in-out infinite;
        }

        .shape-4 {
            width: 150px;
            height: 150px;
            background: var(--warning);
            bottom: 30%;
            right: 20%;
            animation: float 7s ease-in-out infinite reverse;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-30px) rotate(10deg); }
        }

        /* Grid Pattern */
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
            max-width: 800px;
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
        }

        .breadcrumb a:hover {
            color: var(--white);
        }

        .breadcrumb i {
            color: rgba(255, 255, 255, 0.4);
            font-size: 10px;
        }

        .breadcrumb span {
            color: var(--primary);
            font-weight: 500;
        }

        .hero h1 {
            font-size: 56px;
            font-weight: 800;
            color: var(--white);
            margin-bottom: 20px;
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
            font-size: 18px;
            color: rgba(255, 255, 255, 0.8);
            line-height: 1.8;
            max-width: 600px;
            margin: 0 auto;
        }

        /* ========================================
           CONTACT SECTION
        ======================================== */
        .contact-section {
            padding: 80px 6%;
            background: var(--light);
        }

        .contact-container {
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Info Cards */
        .contact-info-cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 25px;
            margin-top: -130px;
            margin-bottom: 70px;
            position: relative;
            z-index: 20;
        }

        .info-card {
            background: var(--white);
            padding: 35px 30px;
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-lg);
            display: flex;
            align-items: flex-start;
            gap: 20px;
            transition: var(--transition);
            border: 2px solid transparent;
            position: relative;
            overflow: hidden;
        }

        .info-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .info-card:hover::before {
            transform: scaleX(1);
        }

        .info-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-xl);
        }

        .info-card-icon {
            width: 65px;
            height: 65px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-size: 26px;
            flex-shrink: 0;
            box-shadow: 0 10px 25px rgba(255, 107, 53, 0.3);
        }

        .info-card:nth-child(2) .info-card-icon {
            background: linear-gradient(135deg, var(--secondary), var(--secondary-light));
            box-shadow: 0 10px 25px rgba(19, 136, 8, 0.3);
        }

        .info-card:nth-child(3) .info-card-icon {
            background: linear-gradient(135deg, var(--info), #60a5fa);
            box-shadow: 0 10px 25px rgba(59, 130, 246, 0.3);
        }

        .info-card:nth-child(4) .info-card-icon {
            background: linear-gradient(135deg, var(--accent), var(--accent-light));
            box-shadow: 0 10px 25px rgba(0, 0, 128, 0.3);
        }

        .info-card-content h3 {
            font-size: 18px;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 10px;
        }

        .info-card-content p {
            font-size: 14px;
            color: var(--gray-600);
            line-height: 1.7;
            margin-bottom: 8px;
        }

        .info-note {
            font-size: 12px;
            color: var(--success);
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .info-note i {
            font-size: 8px;
        }

        /* Contact Main Layout */
        .contact-main {
            display: grid;
            grid-template-columns: 1.2fr 0.8fr;
            gap: 40px;
        }

        /* Contact Form Wrapper */
        .contact-form-wrapper {
            background: var(--white);
            padding: 50px;
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-lg);
        }

        .form-header {
            margin-bottom: 40px;
        }

        .form-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, rgba(255, 107, 53, 0.1), rgba(19, 136, 8, 0.1));
            color: var(--primary);
            padding: 10px 20px;
            border-radius: 100px;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .form-header h2 {
            font-size: 34px;
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 12px;
        }

        .form-header p {
            color: var(--gray-500);
            font-size: 16px;
        }

        /* Form Styles */
        .contact-form {
            display: flex;
            flex-direction: column;
            gap: 25px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
        }

        .form-group {
            position: relative;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: var(--gray-700);
            margin-bottom: 10px;
        }

        .form-group label span {
            color: var(--danger);
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-wrapper i {
            position: absolute;
            left: 18px;
            color: var(--gray-400);
            font-size: 16px;
            transition: var(--transition);
            z-index: 1;
        }

        .input-wrapper input,
        .input-wrapper select,
        .input-wrapper textarea {
            width: 100%;
            padding: 16px 20px 16px 50px;
            border: 2px solid var(--gray-200);
            border-radius: var(--radius-md);
            font-size: 15px;
            font-family: inherit;
            color: var(--gray-700);
            background: var(--white);
            transition: var(--transition);
        }

        .input-wrapper input:focus,
        .input-wrapper select:focus,
        .input-wrapper textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(255, 107, 53, 0.1);
        }

        .input-wrapper:focus-within i {
            color: var(--primary);
        }

        .input-wrapper input::placeholder,
        .input-wrapper textarea::placeholder {
            color: var(--gray-400);
        }

        .input-wrapper select {
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%2394a3b8' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 18px center;
        }

        .textarea-wrapper {
            align-items: flex-start;
        }

        .textarea-wrapper i {
            top: 18px;
        }

        .textarea-wrapper textarea {
            resize: vertical;
            min-height: 150px;
        }

        .character-count {
            display: block;
            text-align: right;
            font-size: 12px;
            color: var(--gray-400);
            margin-top: 8px;
        }

        .error-message {
            display: none;
            font-size: 12px;
            color: var(--danger);
            margin-top: 6px;
            align-items: center;
            gap: 5px;
        }

        .form-group.error .error-message {
            display: flex;
        }

        .form-group.error .input-wrapper input,
        .form-group.error .input-wrapper select,
        .form-group.error .input-wrapper textarea {
            border-color: var(--danger);
        }

        .form-group.success .input-wrapper input,
        .form-group.success .input-wrapper select,
        .form-group.success .input-wrapper textarea {
            border-color: var(--success);
        }

        /* Checkbox Styles */
        .checkbox-group {
            margin-top: 10px;
        }

        .checkbox-label {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            cursor: pointer;
            font-size: 14px;
            color: var(--gray-600);
            line-height: 1.6;
        }

        .checkbox-label input {
            display: none;
        }

        .checkmark {
            width: 22px;
            height: 22px;
            border: 2px solid var(--gray-300);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: var(--transition);
            margin-top: 2px;
        }

        .checkbox-label input:checked + .checkmark {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-color: var(--primary);
        }

        .checkbox-label input:checked + .checkmark::after {
            content: '\f00c';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            color: var(--white);
            font-size: 12px;
        }

        .checkbox-label a {
            color: var(--primary);
            font-weight: 600;
        }

        .checkbox-label a:hover {
            text-decoration: underline;
        }

        /* Submit Button */
        .btn-submit {
            width: 100%;
            padding: 18px 30px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: var(--white);
            border: none;
            border-radius: var(--radius-md);
            font-size: 16px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
            margin-top: 15px;
        }

        .btn-submit::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s ease;
        }

        .btn-submit:hover::before {
            left: 100%;
        }

        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(255, 107, 53, 0.35);
        }

        .btn-submit .btn-loading {
            display: none;
        }

        .btn-submit.loading .btn-text,
        .btn-submit.loading .btn-icon {
            display: none;
        }

        .btn-submit.loading .btn-loading {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-icon {
            transition: transform 0.3s ease;
        }

        .btn-submit:hover .btn-icon {
            transform: translateX(5px);
        }

        /* ========================================
           CONTACT SIDEBAR
        ======================================== */
        .contact-sidebar {
            display: flex;
            flex-direction: column;
            gap: 30px;
        }

        /* Map Wrapper */
        .map-wrapper {
            background: var(--white);
            border-radius: var(--radius-xl);
            overflow: hidden;
            box-shadow: var(--shadow-lg);
        }

        .map-header {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 25px;
            border-bottom: 1px solid var(--gray-100);
        }

        .map-header i {
            color: var(--primary);
            font-size: 22px;
        }

        .map-header h3 {
            font-size: 18px;
            font-weight: 700;
            color: var(--dark);
        }

        .map-container {
            position: relative;
            background: var(--gray-100);
        }

        .map-container iframe {
            display: block;
            width: 100%;
            height: 280px;
        }

        .btn-directions {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 18px;
            background: var(--light);
            color: var(--primary);
            font-weight: 600;
            font-size: 15px;
            transition: var(--transition);
        }

        .btn-directions:hover {
            background: var(--primary);
            color: var(--white);
        }

        /* Social Wrapper */
        .social-wrapper {
            background: var(--white);
            padding: 30px;
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-lg);
            text-align: center;
        }

        .social-wrapper h3 {
            font-size: 20px;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 8px;
        }

        .social-wrapper p {
            color: var(--gray-500);
            font-size: 14px;
            margin-bottom: 25px;
        }

        .social-links {
            display: flex;
            justify-content: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .social-link {
            width: 52px;
            height: 52px;
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            transition: var(--transition);
        }

        .social-link.facebook { background: #e8f4fd; color: #1877f2; }
        .social-link.twitter { background: #e8f6fd; color: #1da1f2; }
        .social-link.instagram { background: #fce8f3; color: #e4405f; }
        .social-link.linkedin { background: #e8f4fd; color: #0a66c2; }
        .social-link.youtube { background: #fce8e8; color: #ff0000; }
        .social-link.whatsapp { background: #e8fce8; color: #25d366; }

        .social-link:hover {
            transform: translateY(-5px) scale(1.1);
        }

        .social-link.facebook:hover { background: #1877f2; color: var(--white); }
        .social-link.x:hover { background: #121414ff; color: var(--white); }
        .social-link.instagram:hover { background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888); color: var(--white); }
        .social-link.linkedin:hover { background: #0a66c2; color: var(--white); }
        .social-link.youtube:hover { background: #ff0000; color: var(--white); }
        .social-link.whatsapp:hover { background: #25d366; color: var(--white); }

        /* Quick Contact */
        .quick-contact {
            background: linear-gradient(135deg, var(--dark), var(--dark-light));
            padding: 35px;
            border-radius: var(--radius-xl);
            display: flex;
            align-items: center;
            gap: 20px;
            position: relative;
            overflow: hidden;
        }

        .quick-contact::before {
            content: '';
            position: absolute;
            width: 180px;
            height: 180px;
            background: var(--primary);
            border-radius: var(--radius-full);
            top: -90px;
            right: -90px;
            opacity: 0.15;
        }

        .quick-contact::after {
            content: '';
            position: absolute;
            width: 100px;
            height: 100px;
            background: var(--secondary);
            border-radius: var(--radius-full);
            bottom: -50px;
            left: -50px;
            opacity: 0.1;
        }

        .quick-contact-icon {
            width: 75px;
            height: 75px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-size: 30px;
            flex-shrink: 0;
            position: relative;
            z-index: 1;
        }

        .quick-contact-content {
            position: relative;
            z-index: 1;
        }

        .quick-contact-content h3 {
            font-size: 18px;
            font-weight: 700;
            color: var(--white);
            margin-bottom: 6px;
        }

        .quick-contact-content p {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 15px;
        }

        .quick-call {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--primary);
            font-size: 20px;
            font-weight: 700;
            transition: var(--transition);
        }

        .quick-call:hover {
            color: var(--primary-light);
        }

        /* ========================================
           FAQ SECTION
        ======================================== */
        .faq-section {
            padding: 100px 6%;
            background: var(--white);
        }

        .faq-container {
            max-width: 900px;
            margin: 0 auto;
        }

        .section-header {
            text-align: center;
            margin-bottom: 50px;
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
            font-size: 42px;
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 15px;
        }

        .section-header p {
            color: var(--gray-500);
            font-size: 18px;
        }

        .faq-grid {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .faq-item {
            background: var(--light);
            border-radius: var(--radius-lg);
            overflow: hidden;
            border: 2px solid var(--gray-200);
            transition: var(--transition);
        }

        .faq-item:hover {
            border-color: var(--primary-light);
        }

        .faq-item.active {
            border-color: var(--primary);
            box-shadow: 0 10px 30px rgba(255, 107, 53, 0.1);
        }

        .faq-question {
            width: 100%;
            padding: 25px 30px;
            background: transparent;
            border: none;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            cursor: pointer;
            text-align: left;
        }

        .faq-question span {
            font-size: 16px;
            font-weight: 600;
            color: var(--dark);
            flex: 1;
        }

        .faq-question i {
            width: 38px;
            height: 38px;
            background: var(--white);
            border-radius: var(--radius-full);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-size: 14px;
            transition: var(--transition);
            flex-shrink: 0;
            box-shadow: var(--shadow-sm);
        }

        .faq-item.active .faq-question i {
            background: var(--primary);
            color: var(--white);
            transform: rotate(45deg);
        }

        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s ease, padding 0.4s ease;
        }

        .faq-item.active .faq-answer {
            max-height: 300px;
        }

        .faq-answer p {
            padding: 0 30px 25px;
            color: var(--gray-600);
            line-height: 1.8;
            font-size: 15px;
        }

        .faq-cta {
            text-align: center;
            margin-top: 50px;
            padding: 40px;
            background: var(--light);
            border-radius: var(--radius-xl);
            border: 2px dashed var(--gray-300);
        }

        .faq-cta p {
            font-size: 18px;
            color: var(--gray-600);
            margin-bottom: 20px;
        }

        /* ========================================
           CTA SECTION
        ======================================== */
        .cta-section {
            padding: 100px 6%;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 50%, #c94416 100%);
            position: relative;
            overflow: hidden;
        }

        .cta-section::before {
            content: '';
            position: absolute;
            width: 600px;
            height: 600px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: var(--radius-full);
            top: -300px;
            right: -150px;
        }

        .cta-section::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: var(--radius-full);
            bottom: -200px;
            left: -100px;
        }

        .cta-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 60px;
            position: relative;
            z-index: 1;
        }

        .cta-content {
            flex: 1;
        }

        .cta-content h2 {
            font-size: 44px;
            font-weight: 800;
            color: var(--white);
            margin-bottom: 18px;
            line-height: 1.2;
        }

        .cta-content p {
            font-size: 18px;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 35px;
            line-height: 1.7;
            max-width: 500px;
        }

        .cta-buttons {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .btn-white {
            background: var(--white);
            color: var(--primary);
            padding: 16px 32px;
            font-weight: 700;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .btn-white:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
        }

        .btn-outline-white {
            background: transparent;
            border: 2px solid rgba(255, 255, 255, 0.5);
            color: var(--white);
            padding: 16px 32px;
            font-weight: 700;
        }

        .btn-outline-white:hover {
            background: rgba(255, 255, 255, 0.15);
            border-color: var(--white);
        }

        .cta-stats {
            display: flex;
            gap: 50px;
        }

        .cta-stat {
            text-align: center;
        }

        .cta-stat-number {
            display: block;
            font-size: 52px;
            font-weight: 800;
            color: var(--white);
            line-height: 1;
            margin-bottom: 8px;
        }

        .cta-stat-label {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.8);
            font-weight: 500;
        }

        /* ========================================
           FOOTER

        /* ========================================
           MODAL
        ======================================== */
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 2000;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            visibility: hidden;
            transition: var(--transition);
        }

        .modal.active {
            opacity: 1;
            visibility: visible;
        }

        .modal-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(5px);
        }

        .modal-content {
            position: relative;
            background: var(--white);
            padding: 50px;
            border-radius: var(--radius-xl);
            text-align: center;
            max-width: 450px;
            width: 90%;
            transform: scale(0.8) translateY(20px);
            transition: transform 0.4s ease;
        }

        .modal.active .modal-content {
            transform: scale(1) translateY(0);
        }

        .modal-icon {
            width: 100px;
            height: 100px;
            margin: 0 auto 25px;
            border-radius: var(--radius-full);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 45px;
            animation: successPop 0.5s ease;
        }

        @keyframes successPop {
            0% { transform: scale(0); }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }

        .modal-icon.success {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
        }

        .modal-content h3 {
            font-size: 28px;
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 12px;
        }

        .modal-content p {
            color: var(--gray-500);
            font-size: 16px;
            margin-bottom: 30px;
            line-height: 1.7;
        }

        .modal-content .btn {
            padding: 16px 40px;
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
            .contact-info-cards {
                grid-template-columns: repeat(2, 1fr);
            }

            .contact-main {
                grid-template-columns: 1fr;
            }

            .contact-sidebar {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 25px;
            }

            .quick-contact {
                grid-column: span 2;
            }

            .footer-grid {
                grid-template-columns: repeat(3, 1fr);
            }

            .footer-brand {
                grid-column: span 3;
                margin-bottom: 20px;
            }

            .cta-container {
                flex-direction: column;
                text-align: center;
            }

            .cta-content {
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .cta-buttons {
                justify-content: center;
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
                font-size: 42px;
            }

            .section-header h2 {
                font-size: 34px;
            }

            .footer-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .footer-brand {
                grid-column: span 2;
            }
        }

        @media (max-width: 768px) {
            .contact-info-cards {
                grid-template-columns: 1fr;
                margin-top: -80px;
            }

            .contact-form-wrapper {
                padding: 35px 25px;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .contact-sidebar {
                grid-template-columns: 1fr;
            }

            .quick-contact {
                grid-column: span 1;
            }

            .hero {
                padding: 120px 5% 80px;
            }

            .hero h1 {
                font-size: 32px;
            }

            .hero p {
                font-size: 16px;
            }

            .cta-stats {
                flex-wrap: wrap;
                justify-content: center;
                gap: 30px;
            }

            .cta-stat-number {
                font-size: 40px;
            }

            .cta-content h2 {
                font-size: 30px;
            }

            .footer-grid {
                grid-template-columns: 1fr;
                gap: 40px;
            }

            .footer-brand {
                grid-column: span 1;
            }

            .footer-bottom-content {
                flex-direction: column;
                text-align: center;
            }

            .footer-links {
                flex-wrap: wrap;
                justify-content: center;
                gap: 20px;
            }
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
                font-size: 28px;
            }

            .contact-section {
                padding: 60px 5%;
            }

            .info-card {
                flex-direction: column;
                text-align: center;
                padding: 30px 20px;
            }

            .contact-form-wrapper {
                padding: 30px 20px;
            }

            .form-header h2 {
                font-size: 26px;
            }

            .input-wrapper input,
            .input-wrapper select,
            .input-wrapper textarea {
                padding: 14px 16px 14px 45px;
                font-size: 14px;
            }

            .faq-question {
                padding: 20px;
            }

            .faq-question span {
                font-size: 14px;
            }

            .faq-answer p {
                padding: 0 20px 20px;
                font-size: 14px;
            }

            .section-header h2 {
                font-size: 28px;
            }

            .cta-section {
                padding: 60px 5%;
            }

            .cta-content h2 {
                font-size: 24px;
            }

            .cta-buttons {
                flex-direction: column;
                width: 100%;
            }

            .cta-buttons .btn {
                width: 100%;
                justify-content: center;
            }

            .modal-content {
                padding: 35px 25px;
            }

            .modal-icon {
                width: 80px;
                height: 80px;
                font-size: 35px;
            }

            .modal-content h3 {
                font-size: 22px;
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
    <!-- Navigation -->
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
                <a href="index.html"><i class="fas fa-home"></i> Home</a>
                <i class="fas fa-chevron-right"></i>
                <span>Contact Us</span>
            </nav>
            <h1>Get in <span>Touch</span></h1>
            <p>Have questions or need assistance? We're here to help! Reach out to us and our team will respond within 24 hours.</p>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact-section">
        <div class="contact-container">
            <!-- Info Cards -->
            <div class="contact-info-cards">
                <div class="info-card">
                    <div class="info-card-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="info-card-content">
                        <h3>Our Office</h3>
                        <p>Vapi Chala <br>India </p>
                    </div>
                </div>
                <div class="info-card">
                    <div class="info-card-icon">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <div class="info-card-content">
                        <h3>Phone Number</h3>
                        <p>+91900000000<br>+9190000000</p>
                        <span class="info-note"><i class="fas fa-circle"></i> Mon - Sat, 9am - 6pm</span>
                    </div>
                </div>
                <div class="info-card">
                    <div class="info-card-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="info-card-content">
                        <h3>Email Address</h3>
                        <p>info@bharatdirectory.in<br>support@bharatdirectory.in</p>
                        <span class="info-note"><i class="fas fa-circle"></i> 24/7 Online Support</span>
                    </div>
                </div>
                <div class="info-card">
                    <div class="info-card-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="info-card-content">
                        <h3>Working Hours</h3>
                        <p>Monday - Saturday<br>9:00 AM - 6:00 PM</p>
                        <span class="info-note"><i class="fas fa-circle"></i> Sunday Closed</span>
                    </div>
                </div>
            </div>

            <!-- Main Contact Content -->
            <div class="contact-main">
                <!-- Contact Form -->
                <div class="contact-form-wrapper">
                    <div class="form-header">
                        <span class="form-badge">
                            <i class="fas fa-paper-plane"></i>
                            Send Message
                        </span>
                        <h2>Drop Us a Line</h2>
                        <p>Fill out the form below and our team will get back to you within 24 hours.</p>
                    </div>
                    <form class="contact-form" id="contactForm" method="POST" action="contact_submit.php">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="firstName">First Name <span>*</span></label>
                                <div class="input-wrapper">
                                    <i class="fas fa-user"></i>
                                    <input type="text" id="firstName" name="firstName" placeholder="Enter your first name" required>
                                </div>
                                <span class="error-message" id="firstNameError"><i class="fas fa-exclamation-circle"></i> <span></span></span>
                            </div>
                            <div class="form-group">
                                <label for="lastName">Last Name <span>*</span></label>
                                <div class="input-wrapper">
                                    <i class="fas fa-user"></i>
                                    <input type="text" id="lastName" name="lastName" placeholder="Enter your last name" required>
                                </div>
                                <span class="error-message" id="lastNameError"><i class="fas fa-exclamation-circle"></i> <span></span></span>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="email">Email Address <span>*</span></label>
                                <div class="input-wrapper">
                                    <i class="fas fa-envelope"></i>
                                    <input type="email" id="email" name="email" placeholder="Enter your email address" required>
                                </div>
                                <span class="error-message" id="emailError"><i class="fas fa-exclamation-circle"></i> <span></span></span>
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone Number</label>
                                <div class="input-wrapper">
                                    <i class="fas fa-phone"></i>
                                    <input type="tel" id="phone" name="phone" placeholder="+91 98765 43210">
                                </div>
                                <span class="error-message" id="phoneError"><i class="fas fa-exclamation-circle"></i> <span></span></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="subject">Subject <span>*</span></label>
                            <div class="input-wrapper">
                                <i class="fas fa-bookmark"></i>
                                <select id="subject" name="subject" required>
                                    <option value="">Select a subject</option>
                                    <option value="general">General Inquiry</option>
                                    <option value="business">Add My Business</option>
                                    <option value="advertising">Advertising & Promotion</option>
                                    <option value="support">Technical Support</option>
                                    <option value="feedback">Feedback & Suggestions</option>
                                    <option value="partnership">Partnership Opportunities</option>
                                    <option value="complaint">Report an Issue</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <span class="error-message" id="subjectError"><i class="fas fa-exclamation-circle"></i> <span></span></span>
                        </div>
                        <div class="form-group">
                            <label for="message">Your Message <span>*</span></label>
                            <div class="input-wrapper textarea-wrapper">
                                <i class="fas fa-comment-alt"></i>
                                <textarea id="message" name="message" rows="5" placeholder="Write your message here..." required></textarea>
                            </div>
                            <span class="character-count"><span id="charCount">0</span>/500</span>
                            <span class="error-message" id="messageError"><i class="fas fa-exclamation-circle"></i> <span></span></span>
                        </div>
                        <div class="form-group checkbox-group">
                        </div>
                        <button type="submit" class="btn-submit" id="submitBtn">
                            <span class="btn-text">Send Message</span>
                            <span class="btn-loading">
                                <i class="fas fa-spinner fa-spin"></i>
                                Sending...
                            </span>
                            <i class="fas fa-arrow-right btn-icon"></i>
                        </button>
                    </method=>
                </div>

                <!-- Sidebar -->
                <div class="contact-sidebar">
                    <!-- Map -->
                    <div class="map-wrapper">
    <div class="map-header">
        <i class="fas fa-map-marked-alt"></i>
        <h3>Find Us on Map</h3>
    </div>

    <div class="map-container">
        <iframe
            src="https://www.google.com/maps?q=Vapi,+Gujarat,+India&output=embed"
            allowfullscreen
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade">
        </iframe>
    </div>

    <a href="https://www.google.com/maps?q=Vapi,+Gujarat,+India"
       target="_blank"
       class="btn-directions">
        <i class="fas fa-directions"></i>
        Get Directions
    </a>
</div>


                    <!-- Social Links -->
                    <div class="social-wrapper">
                        <h3>Connect With Us</h3>
                        <p>Follow us on social media for updates</p>
                        <div class="social-links">
                            <a href="#" class="social-link facebook" title="Facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="social-link x" title="X">
                                <i class="fab fa-x"></i>
                            </a>
                            <a href="#" class="social-link instagram" title="Instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="social-link linkedin" title="LinkedIn">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a href="#" class="social-link youtube" title="YouTube">
                                <i class="fab fa-youtube"></i>
                            </a>
                            <a href="#" class="social-link whatsapp" title="WhatsApp">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Quick Contact -->
                    <div class="quick-contact">
                        <div class="quick-contact-icon">
                            <i class="fas fa-headset"></i>
                        </div>
                        <div class="quick-contact-content">
                            <h3>Need Immediate Help?</h3>
                            <p>Our support team is available to assist you.</p>
                            <a href="tel:+911123456789" class="quick-call">
                                <i class="fas fa-phone-alt"></i>
                                +91 11 2345 6789
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq-section">
        <div class="faq-container">
            <div class="section-header">
                <span class="section-badge">
                    <i class="fas fa-question-circle"></i>
                    FAQ
                </span>
                <h2>Frequently Asked Questions</h2>
                <p>Find answers to commonly asked questions about Bharat Directory</p>
            </div>
            <div class="faq-grid">
                <div class="faq-item">
                    <button class="faq-question">
                        <span>How can I list my business on Bharat Directory?</span>
                        <i class="fas fa-plus"></i>
                    </button>
                    <div class="faq-answer">
                        <p>Listing your business is easy! Simply click on "Add Business" button, create an account, and fill in your business details. Basic listings are free, and you can upgrade to premium for additional features and better visibility.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question">
                        <span>Is it free to list my business?</span>
                        <i class="fas fa-plus"></i>
                    </button>
                    <div class="faq-answer">
                        <p>Yes! Basic business listing is completely free. We also offer premium plans starting from ₹499/month with enhanced visibility, analytics, priority support, and promotional features to help grow your business.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question">
                        <span>How long does it take for my listing to appear?</span>
                        <i class="fas fa-plus"></i>
                    </button>
                    <div class="faq-answer">
                        <p>Once you submit your business details, our team reviews the information within 24-48 hours. After approval, your listing will be live and visible to millions of users searching for businesses like yours.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question">
                        <span>Can I update my business information?</span>
                        <i class="fas fa-plus"></i>
                    </button>
                    <div class="faq-answer">
                        <p>Absolutely! You can log into your dashboard anytime to update your business hours, contact details, photos, services, and other information. Changes are reflected immediately on your listing.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question">
                        <span>How can I respond to customer reviews?</span>
                        <i class="fas fa-plus"></i>
                    </button>
                    <div class="faq-answer">
                        <p>Business owners can respond to reviews directly from their dashboard. We encourage professional and helpful responses to build trust with potential customers and improve your business reputation.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question">
                        <span>What payment methods do you accept?</span>
                        <i class="fas fa-plus"></i>
                    </button>
                    <div class="faq-answer">
                        <p>We accept all major payment methods including Credit/Debit Cards, UPI, Net Banking, and popular wallets like Paytm, PhonePe, and Google Pay. All transactions are secured with bank-level encryption.</p>
                    </div>
                </div>
            </div>
            <div class="faq-cta">
                <p>Still have questions? We're here to help!</p>
                <a href="#contactForm" class="btn btn-primary">
                    <i class="fas fa-envelope"></i>
                    Contact Our Support
                </a>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="cta-container">
            <div class="cta-content">
                <h2>Ready to Grow Your Business?</h2>
                <p>Join thousands of businesses already listed on Bharat Directory and reach millions of potential customers across India.</p>
                <div class="cta-buttons">
                    <a href="#" class="btn btn-white">
                        <i class="fas fa-rocket"></i>
                        List Your Business Free
                    </a>
                    <a href="#" class="btn btn-outline-white">
                        <i class="fas fa-play-circle"></i>
                        Watch Demo
                    </a>
                </div>
            </div>
            <div class="cta-stats">
                <div class="cta-stat">
                    <span class="cta-stat-number">50K+</span>
                    <span class="cta-stat-label">Businesses Listed</span>
                </div>
                <div class="cta-stat">
                    <span class="cta-stat-number">1M+</span>
                    <span class="cta-stat-label">Monthly Visitors</span>
                </div>
                <div class="cta-stat">
                    <span class="cta-stat-number">500+</span>
                    <span class="cta-stat-label">Cities Covered</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include 'footer.php';?>

    <!-- Success Modal -->
    <div class="modal" id="successModal">
        <div class="modal-overlay"></div>
        <div class="modal-content">
            <div class="modal-icon success">
                <i class="fas fa-check"></i>
            </div>
            <h3>Message Sent Successfully!</h3>
            <p>Thank you for contacting us. Our team will review your message and get back to you within 24 hours.</p>
            <button class="btn btn-primary" id="closeModal">
                <i class="fas fa-thumbs-up"></i>
                Got It!
            </button>
        </div>
    </div>

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
        const contactForm = document.getElementById('contactForm');
        const submitBtn = document.getElementById('submitBtn');
        const successModal = document.getElementById('successModal');
        const closeModal = document.getElementById('closeModal');
        const faqItems = document.querySelectorAll('.faq-item');
        const messageInput = document.getElementById('message');
        const charCount = document.getElementById('charCount');

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
        // CHARACTER COUNT
        // ========================================
        messageInput.addEventListener('input', () => {
            const count = messageInput.value.length;
            charCount.textContent = count;
            
            if (count > 500) {
                charCount.style.color = 'var(--danger)';
            } else if (count > 400) {
                charCount.style.color = 'var(--warning)';
            } else {
                charCount.style.color = 'var(--gray-400)';
            }
        });

        // ========================================
        // FORM VALIDATION
        // ========================================
        function validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }

        function validatePhone(phone) {
            const re = /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/;
            return phone === '' || re.test(phone.replace(/\s/g, ''));
        }

        function showError(inputId, message) {
            const formGroup = document.getElementById(inputId).closest('.form-group');
            const errorElement = document.getElementById(inputId + 'Error');
            
            formGroup.classList.add('error');
            formGroup.classList.remove('success');
            if (errorElement) {
                errorElement.querySelector('span').textContent = message;
            }
        }

        function showSuccess(inputId) {
            const formGroup = document.getElementById(inputId).closest('.form-group');
            formGroup.classList.remove('error');
            formGroup.classList.add('success');
        }

        function clearError(inputId) {
            const formGroup = document.getElementById(inputId).closest('.form-group');
            formGroup.classList.remove('error');
        }

        function validateField(field) {
            const id = field.id;
            const value = field.value.trim();
            
            switch(id) {
                case 'firstName':
                    if (value === '') {
                        showError(id, 'First name is required');
                        return false;
                    } else if (value.length < 2) {
                        showError(id, 'First name must be at least 2 characters');
                        return false;
                    }
                    showSuccess(id);
                    return true;
                    
                case 'lastName':
                    if (value === '') {
                        showError(id, 'Last name is required');
                        return false;
                    } else if (value.length < 2) {
                        showError(id, 'Last name must be at least 2 characters');
                        return false;
                    }
                    showSuccess(id);
                    return true;
                    
                case 'email':
                    if (value === '') {
                        showError(id, 'Email address is required');
                        return false;
                    } else if (!validateEmail(value)) {
                        showError(id, 'Please enter a valid email address');
                        return false;
                    }
                    showSuccess(id);
                    return true;
                    
                case 'phone':
                    if (value !== '' && !validatePhone(value)) {
                        showError(id, 'Please enter a valid phone number');
                        return false;
                    }
                    if (value !== '') showSuccess(id);
                    else clearError(id);
                    return true;
                    
                case 'subject':
                    if (value === '') {
                        showError(id, 'Please select a subject');
                        return false;
                    }
                    showSuccess(id);
                    return true;
                    
                case 'message':
                    if (value === '') {
                        showError(id, 'Message is required');
                        return false;
                    } else if (value.length < 20) {
                        showError(id, 'Message must be at least 20 characters');
                        return false;
                    } else if (value.length > 500) {
                        showError(id, 'Message cannot exceed 500 characters');
                        return false;
                    }
                    showSuccess(id);
                    return true;
                    
                case 'terms':
                    if (!field.checked) {
                        showError(id, 'You must agree to the terms');
                        return false;
                    }
                    clearError(id);
                    return true;
            }
            
            return true;
        }

        // Real-time validation
        document.querySelectorAll('.contact-form input, .contact-form select, .contact-form textarea').forEach(input => {
            input.addEventListener('blur', function() {
                validateField(this);
            });
            
            input.addEventListener('input', function() {
                if (this.closest('.form-group').classList.contains('error')) {
                    validateField(this);
                }
            });
        });

        // ========================================
        // FORM SUBMISSION
        // ========================================
        
const contactForm = document.getElementById("contactForm");
const successModal = document.getElementById("successModal");
const closeModal = document.getElementById("closeModal");
const submitBtn = document.getElementById("submitBtn");

contactForm.addEventListener("submit", function (e) {
    e.preventDefault(); // 🚫 stop page reload

    submitBtn.classList.add("loading");

    const formData = new FormData(contactForm);

    fetch("contact_submit.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        console.log(data); // 🔍 DEBUG

        if (data.status === "success") {
            // ✅ SHOW POPUP
            successModal.classList.add("active");
            document.body.style.overflow = "hidden";

            contactForm.reset();
        } else {
            alert("Failed to send message");
        }
    })
    .catch(() => {
        alert("Server error");
    })
    .finally(() => {
        submitBtn.classList.remove("loading");
    });
});

// Close popup
closeModal.onclick = () => {
    successModal.classList.remove("active");
    document.body.style.overflow = "";
};

document.querySelector(".modal-overlay").onclick = closeModal;



        // ========================================
        // MODAL
        // ========================================
        function showSuccessModal() {
            successModal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function hideSuccessModal() {
            successModal.classList.remove('active');
            document.body.style.overflow = '';
        }

        closeModal.addEventListener('click', hideSuccessModal);
        successModal.querySelector('.modal-overlay').addEventListener('click', hideSuccessModal);

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && successModal.classList.contains('active')) {
                hideSuccessModal();
            }
        });

        // ========================================
        // FAQ ACCORDION
        // ========================================
        faqItems.forEach(item => {
            const question = item.querySelector('.faq-question');
            
            question.addEventListener('click', () => {
                const isActive = item.classList.contains('active');
                
                faqItems.forEach(faq => {
                    faq.classList.remove('active');
                });
                
                if (!isActive) {
                    item.classList.add('active');
                }
            });
        });

        // ========================================
        // SMOOTH SCROLL
        // ========================================
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                
                if (href !== '#') {
                    e.preventDefault();
                    const target = document.querySelector(href);
                    
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                }
            });
        });

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

        const revealElements = document.querySelectorAll('.info-card, .faq-item, .cta-stat');

        revealElements.forEach((el, index) => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = `all 0.6s ease ${index * 0.1}s`;
            revealObserver.observe(el);
        });

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