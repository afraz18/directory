<!-- ============================================
     BHARAT DIRECTORY - FOOTER COMPONENT
     Mobile Friendly Version
============================================ -->

<style>
    /* ============================================
       FOOTER CSS VARIABLES
    ============================================ */
    .footer {
        --footer-bg: #0a0f1a;
        --footer-bg-secondary: #0f172a;
        --footer-accent: #f97316;
        --footer-accent-light: #fb923c;
        --footer-accent-dark: #ea580c;
        --footer-accent-gradient: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
        --footer-text: #e2e8f0;
        --footer-text-muted: #94a3b8;
        --footer-text-dim: #64748b;
        --footer-border: rgba(255, 255, 255, 0.08);
        --footer-card-bg: rgba(255, 255, 255, 0.03);
    }

    /* ============================================
       FOOTER BASE
    ============================================ */
    .footer {
        background: var(--footer-bg);
        color: var(--footer-text);
        font-family: 'Poppins', sans-serif;
        position: relative;
        overflow: hidden;
    }

    .footer *,
    .footer *::before,
    .footer *::after {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .footer::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--footer-accent-gradient);
    }

    .footer-glow {
        position: absolute;
        width: 300px;
        height: 300px;
        border-radius: 50%;
        pointer-events: none;
        opacity: 0.5;
    }

    .footer-glow-1 {
        top: -100px;
        right: -100px;
        background: radial-gradient(circle, rgba(249, 115, 22, 0.1) 0%, transparent 70%);
    }

    .footer-glow-2 {
        bottom: -100px;
        left: -100px;
        background: radial-gradient(circle, rgba(59, 130, 246, 0.05) 0%, transparent 70%);
    }

    /* ============================================
       NEWSLETTER SECTION
    ============================================ */
    .footer-newsletter {
        background: var(--footer-bg-secondary);
        padding: 3rem 1.5rem;
        position: relative;
        z-index: 1;
        border-bottom: 1px solid var(--footer-border);
    }

    .newsletter-container {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 2rem;
        flex-wrap: wrap;
    }

    .newsletter-content {
        flex: 1;
        min-width: 280px;
    }

    .newsletter-icon {
        width: 55px;
        height: 55px;
        background: var(--footer-accent-gradient);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
        box-shadow: 0 6px 20px rgba(249, 115, 22, 0.3);
    }

    .newsletter-icon i {
        font-size: 1.35rem;
        color: #fff;
    }

    .newsletter-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        background: rgba(249, 115, 22, 0.15);
        color: var(--footer-accent-light);
        padding: 0.35rem 0.85rem;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 600;
        margin-bottom: 0.6rem;
        border: 1px solid rgba(249, 115, 22, 0.25);
    }

    .newsletter-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: #fff;
        margin-bottom: 0.5rem;
        line-height: 1.3;
    }

    .newsletter-title span {
        background: var(--footer-accent-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .newsletter-text {
        color: var(--footer-text-muted);
        font-size: 0.95rem;
        line-height: 1.6;
    }

    .newsletter-form {
        flex: 1;
        min-width: 280px;
        max-width: 500px;
    }

    .newsletter-input-group {
        display: flex;
        gap: 0.5rem;
        background: rgba(255, 255, 255, 0.05);
        padding: 0.4rem;
        border-radius: 50px;
        border: 2px solid var(--footer-border);
        transition: all 0.3s ease;
    }

    .newsletter-input-group:focus-within {
        border-color: var(--footer-accent);
        box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.15);
    }

    .newsletter-input-group input {
        flex: 1;
        min-width: 0;
        background: transparent;
        border: none;
        padding: 0.85rem 1.25rem;
        color: #fff;
        font-family: inherit;
        font-size: 0.95rem;
        outline: none;
    }

    .newsletter-input-group input::placeholder {
        color: var(--footer-text-dim);
    }

    .newsletter-btn {
        background: var(--footer-accent-gradient);
        color: #fff;
        padding: 0.85rem 1.5rem;
        border: none;
        border-radius: 50px;
        font-family: inherit;
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.4rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(249, 115, 22, 0.3);
        white-space: nowrap;
        flex-shrink: 0;
    }

    .newsletter-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 25px rgba(249, 115, 22, 0.4);
    }

    .newsletter-btn:active {
        transform: translateY(0);
    }

    .newsletter-note {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.4rem;
        margin-top: 0.85rem;
        color: var(--footer-text-dim);
        font-size: 0.8rem;
    }

    .newsletter-note i {
        color: var(--footer-accent);
        font-size: 0.75rem;
    }

    /* ============================================
       MAIN FOOTER
    ============================================ */
    .footer-main {
        padding: 3.5rem 1.5rem 2.5rem;
        position: relative;
        z-index: 1;
    }

    .footer-container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .footer-grid {
        display: grid;
        grid-template-columns: 1.5fr repeat(4, 1fr);
        gap: 2.5rem;
    }

    /* ============================================
       FOOTER BRAND
    ============================================ */
    .footer-brand {
        padding-right: 1.5rem;
    }

    .footer-logo {
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1.25rem;
        text-decoration: none;
    }

    .footer-logo-icon {
        width: 50px;
        height: 50px;
        background: var(--footer-accent-gradient);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.35rem;
        color: #fff;
        box-shadow: 0 6px 20px rgba(249, 115, 22, 0.35);
        transition: transform 0.3s ease;
        flex-shrink: 0;
    }

    .footer-logo:hover .footer-logo-icon {
        transform: rotate(-5deg) scale(1.05);
    }

    .footer-logo-text {
        display: flex;
        flex-direction: column;
    }

    .footer-logo-name {
        font-size: 1.35rem;
        font-weight: 800;
        color: #fff;
        line-height: 1.2;
    }

    .footer-logo-tagline {
        font-size: 0.75rem;
        color: var(--footer-accent-light);
        font-weight: 500;
    }

    .footer-brand-desc {
        color: var(--footer-text-muted);
        font-size: 0.9rem;
        line-height: 1.7;
        margin-bottom: 1.5rem;
    }

    /* Contact */
    .footer-contact {
        margin-bottom: 1.5rem;
    }

    .footer-contact-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 0.75rem;
        color: var(--footer-text-muted);
        font-size: 0.9rem;
        transition: color 0.3s ease;
    }

    .footer-contact-item:hover {
        color: #fff;
    }

    .footer-contact-icon {
        width: 38px;
        height: 38px;
        background: var(--footer-card-bg);
        border: 1px solid var(--footer-border);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--footer-accent);
        font-size: 0.9rem;
        transition: all 0.3s ease;
        flex-shrink: 0;
    }

    .footer-contact-item:hover .footer-contact-icon {
        background: var(--footer-accent-gradient);
        color: #fff;
        border-color: transparent;
    }

    .footer-contact-item a {
        color: inherit;
        text-decoration: none;
    }

    /* Social */
    .footer-social {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .footer-social-link {
        width: 40px;
        height: 40px;
        background: var(--footer-card-bg);
        border: 1px solid var(--footer-border);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--footer-text-muted);
        font-size: 1rem;
        text-decoration: none;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .footer-social-link::before {
        content: '';
        position: absolute;
        inset: 0;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .footer-social-link.facebook::before { background: #1877f2; }
    .footer-social-link.twitter::before { background: #1da1f2; }
    .footer-social-link.instagram::before { background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888); }
    .footer-social-link.linkedin::before { background: #0a66c2; }
    .footer-social-link.youtube::before { background: #ff0000; }
    .footer-social-link.whatsapp::before { background: #25d366; }

    .footer-social-link i {
        position: relative;
        z-index: 1;
        transition: all 0.3s ease;
    }

    .footer-social-link:hover {
        border-color: transparent;
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
    }

    .footer-social-link:hover::before {
        opacity: 1;
    }

    .footer-social-link:hover i {
        color: #fff;
    }

    /* ============================================
       FOOTER COLUMNS
    ============================================ */
    .footer-column {
        min-width: 0;
    }

    .footer-column-title {
        font-size: 1rem;
        font-weight: 600;
        color: #fff;
        margin-bottom: 1.25rem;
        position: relative;
        padding-bottom: 0.75rem;
    }

    .footer-column-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 28px;
        height: 3px;
        background: var(--footer-accent-gradient);
        border-radius: 3px;
    }

    .footer-links {
        list-style: none;
    }

    .footer-links li {
        margin-bottom: 0.65rem;
    }

    .footer-links a {
        color: var(--footer-text-muted);
        text-decoration: none;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
    }

    .footer-links a:hover {
        color: #fff;
        padding-left: 5px;
    }

    .footer-links a i {
        font-size: 0.7rem;
        color: var(--footer-accent);
        opacity: 0.8;
    }

    .link-badge {
        display: inline-block;
        background: var(--footer-accent-gradient);
        color: #fff;
        padding: 0.15rem 0.5rem;
        border-radius: 20px;
        font-size: 0.6rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        margin-left: 0.35rem;
    }

    .link-badge.new {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }

    .link-badge.hot {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    }

    /* ============================================
       FOOTER EXTRA - CITIES & APP
    ============================================ */
    .footer-extra {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
        margin-top: 2.5rem;
        padding-top: 2.5rem;
        border-top: 1px solid var(--footer-border);
    }

    .footer-cities,
    .footer-app {
        background: var(--footer-card-bg);
        border: 1px solid var(--footer-border);
        border-radius: 14px;
        padding: 1.5rem;
    }

    .footer-cities-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .footer-cities-title {
        font-size: 0.95rem;
        font-weight: 600;
        color: #fff;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .footer-cities-title i {
        color: var(--footer-accent);
    }

    .footer-cities-link {
        color: var(--footer-accent);
        text-decoration: none;
        font-size: 0.8rem;
        font-weight: 500;
        transition: color 0.3s ease;
    }

    .footer-cities-link:hover {
        color: var(--footer-accent-light);
    }

    .footer-cities-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .city-tag {
        background: rgba(255, 255, 255, 0.05);
        color: var(--footer-text-muted);
        padding: 0.4rem 0.85rem;
        border-radius: 20px;
        font-size: 0.8rem;
        text-decoration: none;
        border: 1px solid var(--footer-border);
        transition: all 0.3s ease;
    }

    .city-tag:hover {
        background: var(--footer-accent-gradient);
        color: #fff;
        border-color: transparent;
        transform: translateY(-2px);
    }

    /* App Download */
    .footer-app-header {
        display: flex;
        align-items: center;
        gap: 0.85rem;
        margin-bottom: 1rem;
    }

    .footer-app-icon {
        width: 45px;
        height: 45px;
        background: var(--footer-accent-gradient);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        color: #fff;
        flex-shrink: 0;
    }

    .footer-app-title {
        font-size: 1rem;
        font-weight: 600;
        color: #fff;
        margin-bottom: 0.15rem;
    }

    .footer-app-text {
        color: var(--footer-text-muted);
        font-size: 0.8rem;
    }

    .app-buttons {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .app-btn {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid var(--footer-border);
        padding: 0.6rem 1rem;
        border-radius: 10px;
        text-decoration: none;
        transition: all 0.3s ease;
        flex: 1;
        min-width: 130px;
    }

    .app-btn:hover {
        background: rgba(255, 255, 255, 0.12);
        border-color: var(--footer-accent);
        transform: translateY(-2px);
    }

    .app-btn i {
        font-size: 1.5rem;
        color: #fff;
    }

    .app-btn-text small {
        display: block;
        font-size: 0.65rem;
        color: var(--footer-text-dim);
        line-height: 1.2;
    }

    .app-btn-text span {
        font-size: 0.85rem;
        font-weight: 600;
        color: #fff;
    }

    /* ============================================
       FOOTER BOTTOM
    ============================================ */
    .footer-bottom {
        border-top: 1px solid var(--footer-border);
        padding: 1.5rem;
        background: rgba(0, 0, 0, 0.2);
    }

    .footer-bottom-container {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .footer-copyright {
        color: var(--footer-text-dim);
        font-size: 0.85rem;
    }

    .footer-copyright a {
        color: var(--footer-accent);
        text-decoration: none;
        font-weight: 600;
    }

    .footer-copyright .heart {
        color: #ef4444;
        display: inline-block;
        animation: heartbeat 1.5s ease infinite;
    }

    @keyframes heartbeat {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.15); }
    }

    .footer-bottom-links {
        display: flex;
        gap: 1.25rem;
        flex-wrap: wrap;
    }

    .footer-bottom-links a {
        color: var(--footer-text-dim);
        text-decoration: none;
        font-size: 0.85rem;
        transition: color 0.3s ease;
    }

    .footer-bottom-links a:hover {
        color: var(--footer-accent);
    }

    .footer-payments {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .footer-payments-label {
        color: var(--footer-text-dim);
        font-size: 0.8rem;
    }

    .payment-icons {
        display: flex;
        gap: 0.4rem;
    }

    .payment-icon {
        width: 40px;
        height: 25px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
        color: var(--footer-text-muted);
        transition: all 0.3s ease;
    }

    .payment-icon:hover {
        background: rgba(255, 255, 255, 0.15);
        transform: translateY(-2px);
    }

    /* ============================================
       BACK TO TOP
    ============================================ */
    .back-to-top {
        position: fixed;
        bottom: 1.5rem;
        right: 1.5rem;
        width: 50px;
        height: 50px;
        background: var(--footer-accent-gradient);
        border: none;
        border-radius: 50%;
        color: #fff;
        font-size: 1.15rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 20px rgba(249, 115, 22, 0.4);
        opacity: 0;
        visibility: hidden;
        transform: translateY(20px);
        transition: all 0.4s ease;
        z-index: 1000;
    }

    .back-to-top.visible {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .back-to-top:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 30px rgba(249, 115, 22, 0.5);
    }

    /* ============================================
       TOAST
    ============================================ */
    .footer-toast {
        position: fixed;
        bottom: 80px;
        left: 50%;
        transform: translateX(-50%) translateY(20px);
        background: #1e293b;
        color: #fff;
        padding: 0.9rem 1.5rem;
        border-radius: 12px;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        z-index: 10001;
        box-shadow: 0 10px 40px rgba(0,0,0,0.3);
        animation: toastSlideIn 0.4s ease forwards;
        font-size: 0.9rem;
        max-width: 90%;
    }

    .footer-toast-success {
        border-left: 4px solid #10b981;
    }

    .footer-toast-success i {
        color: #10b981;
    }

    .footer-toast-error {
        border-left: 4px solid #ef4444;
    }

    .footer-toast-error i {
        color: #ef4444;
    }

    @keyframes toastSlideIn {
        to { transform: translateX(-50%) translateY(0); }
    }

    @keyframes toastSlideOut {
        to { transform: translateX(-50%) translateY(20px); opacity: 0; }
    }

    /* ============================================
       MOBILE ACCORDION FOR COLUMNS
    ============================================ */
    .footer-column-toggle {
        display: none;
    }

    /* ============================================
       RESPONSIVE - DESKTOP LARGE
    ============================================ */
    @media (max-width: 1200px) {
        .footer-grid {
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
        }

        .footer-brand {
            grid-column: 1 / -1;
            padding-right: 0;
            text-align: center;
            padding-bottom: 2rem;
            border-bottom: 1px solid var(--footer-border);
            margin-bottom: 0.5rem;
        }

        .footer-logo {
            justify-content: center;
        }

        .footer-brand-desc {
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }

        .footer-contact {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 1rem;
        }

        .footer-contact-item {
            margin-bottom: 0;
        }

        .footer-social {
            justify-content: center;
        }
    }

    /* ============================================
       RESPONSIVE - TABLET
    ============================================ */
    @media (max-width: 992px) {
        .newsletter-container {
            flex-direction: column;
            text-align: center;
        }

        .newsletter-icon {
            margin-left: auto;
            margin-right: auto;
        }

        .newsletter-form {
            width: 100%;
            max-width: 450px;
        }

        .footer-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 2rem;
        }

        .footer-column {
            text-align: center;
        }

        .footer-column-title::after {
            left: 50%;
            transform: translateX(-50%);
        }

        .footer-links a:hover {
            padding-left: 0;
        }
    }

    /* ============================================
       RESPONSIVE - MOBILE
    ============================================ */
    @media (max-width: 768px) {
        .footer-newsletter {
            padding: 2.5rem 1rem;
        }

        .newsletter-title {
            font-size: 1.5rem;
        }

        .newsletter-text {
            font-size: 0.9rem;
        }

        .newsletter-input-group {
            flex-direction: column;
            border-radius: 16px;
            padding: 0.75rem;
            gap: 0.75rem;
        }

        .newsletter-input-group input {
            text-align: center;
            padding: 0.9rem;
        }

        .newsletter-btn {
            width: 100%;
            justify-content: center;
            padding: 0.9rem;
        }

        .footer-main {
            padding: 2.5rem 1rem 2rem;
        }

        .footer-grid {
            grid-template-columns: 1fr;
            gap: 0;
        }

        .footer-brand {
            padding-bottom: 1.5rem;
            margin-bottom: 0;
        }

        .footer-brand-desc {
            font-size: 0.85rem;
        }

        /* Accordion Style for Mobile */
        .footer-column {
            border-bottom: 1px solid var(--footer-border);
            padding: 1rem 0;
            text-align: left;
        }

        .footer-column:last-child {
            border-bottom: none;
        }

        .footer-column-title {
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            margin-bottom: 0;
            padding-bottom: 0;
            user-select: none;
        }

        .footer-column-title::after {
            display: none;
        }

        .footer-column-toggle {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
            background: var(--footer-card-bg);
            border-radius: 50%;
            color: var(--footer-accent);
            font-size: 0.75rem;
            transition: all 0.3s ease;
        }

        .footer-column.active .footer-column-toggle {
            transform: rotate(180deg);
            background: var(--footer-accent);
            color: #fff;
        }

        .footer-links {
            max-height: 0;
            overflow: hidden;
            transition: all 0.4s ease;
            padding-top: 0;
        }

        .footer-column.active .footer-links {
            max-height: 300px;
            padding-top: 1rem;
        }

        .footer-links a:hover {
            padding-left: 0;
        }

        /* Extra Sections */
        .footer-extra {
            grid-template-columns: 1fr;
            gap: 1rem;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
        }

        .footer-cities,
        .footer-app {
            padding: 1.25rem;
        }

        .footer-cities-grid {
            justify-content: flex-start;
        }

        .city-tag {
            font-size: 0.75rem;
            padding: 0.35rem 0.7rem;
        }

        .app-buttons {
            flex-direction: column;
        }

        .app-btn {
            min-width: 100%;
        }

        /* Footer Bottom */
        .footer-bottom {
            padding: 1.25rem 1rem;
        }

        .footer-bottom-container {
            flex-direction: column;
            text-align: center;
            gap: 1rem;
        }

        .footer-copyright {
            font-size: 0.8rem;
            order: 3;
        }

        .footer-bottom-links {
            justify-content: center;
            gap: 1rem;
            order: 1;
        }

        .footer-bottom-links a {
            font-size: 0.8rem;
        }

        .footer-payments {
            flex-direction: column;
            gap: 0.5rem;
            order: 2;
        }

        .back-to-top {
            width: 45px;
            height: 45px;
            bottom: 1rem;
            right: 1rem;
            font-size: 1rem;
        }
    }

    /* ============================================
       RESPONSIVE - SMALL MOBILE
    ============================================ */
    @media (max-width: 480px) {
        .newsletter-title {
            font-size: 1.3rem;
        }

        .footer-logo-icon {
            width: 42px;
            height: 42px;
            font-size: 1.15rem;
        }

        .footer-logo-name {
            font-size: 1.15rem;
        }

        .footer-contact-item {
            font-size: 0.85rem;
        }

        .footer-contact-icon {
            width: 34px;
            height: 34px;
            font-size: 0.85rem;
        }

        .footer-social-link {
            width: 36px;
            height: 36px;
            font-size: 0.9rem;
        }

        .footer-bottom-links {
            gap: 0.75rem;
        }

        .payment-icon {
            width: 35px;
            height: 22px;
            font-size: 0.8rem;
        }

        .footer-toast {
            font-size: 0.85rem;
            padding: 0.75rem 1rem;
        }
    }

    /* ============================================
       TOUCH DEVICE OPTIMIZATIONS
    ============================================ */
    @media (hover: none) and (pointer: coarse) {
        .footer-social-link:hover {
            transform: none;
        }

        .city-tag:hover {
            transform: none;
        }

        .app-btn:hover {
            transform: none;
        }

        .newsletter-btn:hover {
            transform: none;
        }

        .back-to-top:hover {
            transform: none;
        }
    }
</style>

<!-- ============================================
     FOOTER HTML
============================================ -->
<footer class="footer" id="footer">
    <!-- Decorative Glows -->
    <div class="footer-glow footer-glow-1"></div>
    <div class="footer-glow footer-glow-2"></div>

    <!-- Newsletter -->
    <section class="footer-newsletter">
        <div class="newsletter-container">
            <div class="newsletter-content">
                <div class="newsletter-icon">
                    <i class="fas fa-envelope-open-text"></i>
                </div>
                <span class="newsletter-badge">
                    <i class="fas fa-bell"></i>
                    Stay Updated
                </span>
                <h3 class="newsletter-title">Subscribe to Our <span>Newsletter</span></h3>
                <p class="newsletter-text">Get the latest business listings and exclusive offers in your inbox.</p>
            </div>
            
            <form class="newsletter-form" id="newsletterForm">
                <div class="newsletter-input-group">
                    <input 
                        type="email" 
                        name="email" 
                        placeholder="Enter your email address" 
                        required
                        autocomplete="email"
                    >
                    <button type="submit" class="newsletter-btn">
                        <i class="fas fa-paper-plane"></i>
                        <span>Subscribe</span>
                    </button>
                </div>
                <p class="newsletter-note">
                    <i class="fas fa-lock"></i>
                    We respect your privacy. Unsubscribe anytime.
                </p>
            </form>
        </div>
    </section>

    <!-- Main Footer -->
    <div class="footer-main">
        <div class="footer-container">
            <div class="footer-grid">
                
                <!-- Brand -->
                <div class="footer-brand">
                    <a href="index.php" class="footer-logo">
                        <div class="footer-logo-icon">
                            <i class="fas fa-building"></i>
                        </div>
                        <div class="footer-logo-text">
                            <span class="footer-logo-name">Bharat Directory</span>
                            <span class="footer-logo-tagline">India's #1 Business Directory</span>
                        </div>
                    </a>
                    
                    <p class="footer-brand-desc">
                        Discover and connect with millions of local businesses across India. Your trusted companion for finding the best services.
                    </p>
                    
                    <div class="footer-contact">
                        <div class="footer-contact-item">
                            <span class="footer-contact-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </span>
                            <span>Vapi, Gujarat, India</span>
                        </div>
                        <div class="footer-contact-item">
                            <span class="footer-contact-icon">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <a href="mailto:info@bharatdirectory.com">info@bharatdirectory.com</a>
                        </div>
                        <div class="footer-contact-item">
                            <span class="footer-contact-icon">
                                <i class="fas fa-phone-alt"></i>
                            </span>
                            <a href="tel:+919876543210">+91 98765 43210</a>
                        </div>
                    </div>
                    
                    <div class="footer-social">
                        <a href="#" class="footer-social-link facebook" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="footer-social-link x" title="Twitter"><i class="fab fa-x"></i></a>
                        <a href="#" class="footer-social-link instagram" title="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="footer-social-link whatsapp" title="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="footer-column" data-accordion>
                    <h4 class="footer-column-title">
                        Quick Links
                        <span class="footer-column-toggle"><i class="fas fa-chevron-down"></i></span>
                    </h4>
                    <ul class="footer-links">
                        <li><a href="about.php">About Us</a></li>
                        <li><a href="how-it-works.php">How It Works</a></li>
                        <li><a href="pricing.php">Pricing Plans</a></li>
                        <li><a href="blog.php">Blog</a></li>
                        <li><a href="careers.php">Careers <span class="link-badge new">Hiring</span></a></li>
                    </ul>
                </div>

                <!-- For Business -->
                <div class="footer-column" data-accordion>
                    <h4 class="footer-column-title">
                        For Business
                        <span class="footer-column-toggle"><i class="fas fa-chevron-down"></i></span>
                    </h4>
                    <ul class="footer-links">
                        <li><a href="add_business.php">Add Business <span class="link-badge">Free</span></a></li>
                        <li><a href="dashboard.php">Dashboard</a></li>
                        <li><a href="premium.php">Premium <span class="link-badge hot">Hot</span></a></li>
                        <li><a href="advertise.php">Advertising</a></li>
                        <li><a href="partners.php">Partners</a></li>
                    </ul>
                </div>

                <!-- Categories -->
                <div class="footer-column" data-accordion>
                    <h4 class="footer-column-title">
                        Categories
                        <span class="footer-column-toggle"><i class="fas fa-chevron-down"></i></span>
                    </h4>
                    <ul class="footer-links">
                        <li><a href="#"><i class="fas fa-utensils"></i> Restaurants</a></li>
                        <li><a href="#"><i class="fas fa-hotel"></i> Hotels</a></li>
                        <li><a href="#"><i class="fas fa-hospital"></i> Hospitals</a></li>
                        <li><a href="#"><i class="fas fa-laptop-code"></i> IT Companies</a></li>
                        <li><a href="categories.php"><i class="fas fa-th-large"></i> View All</a></li>
                    </ul>
                </div>

                <!-- Support -->
                <div class="footer-column" data-accordion>
                    <h4 class="footer-column-title">
                        Support
                        <span class="footer-column-toggle"><i class="fas fa-chevron-down"></i></span>
                    </h4>
                    <ul class="footer-links">
                        <li><a href="help.php">Help Center</a></li>
                        <li><a href="contact.php">Contact Us</a></li>
                        <li><a href="faq.php">FAQs</a></li>
                        <li><a href="feedback.php">Feedback</a></li>
                        <li><a href="report.php">Report Issue</a></li>
                    </ul>
                </div>

            </div>   
        </div>
    </div>

    <!-- Footer Bottom -->
    <div class="footer-bottom">
        <div class="footer-bottom-container">
            <p class="footer-copyright">
                © 2025 <a href="index.php">Bharat Directory</a>. All Rights are Reserved 
            </p>
            
            <div class="footer-bottom-links">
                <a href="privacy.php">Privacy</a>
                <a href="terms.php">Terms</a>
                <a href="cookies.php">Cookies</a>
                <a href="sitemap.php">Sitemap</a>
            </div>

            <div class="footer-payments">
                <span class="footer-payments-label">We Accept:</span>
                <div class="payment-icons">
                    <span class="payment-icon"><i class="fab fa-cc-visa"></i></span>
                    <span class="payment-icon"><i class="fab fa-cc-mastercard"></i></span>
                    <span class="payment-icon"><i class="fab fa-cc-paypal"></i></span>
                    <span class="payment-icon"><i class="fab fa-google-pay"></i></span>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Back to Top -->
<button class="back-to-top" id="backToTop" aria-label="Back to top">
    <i class="fas fa-chevron-up"></i>
</button>

<!-- JavaScript -->
<script>
(function() {
    'use strict';

    document.addEventListener('DOMContentLoaded', function() {
        initBackToTop();
        initNewsletter();
        initMobileAccordion();
    });

    /**
     * Back to Top
     */
    function initBackToTop() {
        const btn = document.getElementById('backToTop');
        if (!btn) return;

        let ticking = false;

        function updateButton() {
            if (window.pageYOffset > 400) {
                btn.classList.add('visible');
            } else {
                btn.classList.remove('visible');
            }
            ticking = false;
        }

        window.addEventListener('scroll', function() {
            if (!ticking) {
                requestAnimationFrame(updateButton);
                ticking = true;
            }
        });

        btn.addEventListener('click', function() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    /**
     * Newsletter Form
     */
    function initNewsletter() {
        const form = document.getElementById('newsletterForm');
        if (!form) return;

        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const input = this.querySelector('input[name="email"]');
            const btn = this.querySelector('.newsletter-btn');
            const email = input.value.trim();

            if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                showToast('Please enter a valid email', 'error');
                input.focus();
                return;
            }

            const originalHTML = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Subscribing...';
            btn.disabled = true;

            setTimeout(function() {
                showToast('🎉 Thank you for subscribing!', 'success');
                input.value = '';
                btn.innerHTML = originalHTML;
                btn.disabled = false;
            }, 1500);
        });
    }

    /**
     * Mobile Accordion
     */
    function initMobileAccordion() {
        const columns = document.querySelectorAll('.footer-column[data-accordion]');

        columns.forEach(function(column) {
            const title = column.querySelector('.footer-column-title');

            title.addEventListener('click', function() {
                if (window.innerWidth > 768) return;

                // Close others
                columns.forEach(function(c) {
                    if (c !== column) {
                        c.classList.remove('active');
                    }
                });

                // Toggle current
                column.classList.toggle('active');
            });
        });

        // Reset on resize
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                columns.forEach(function(c) {
                    c.classList.remove('active');
                });
            }
        });
    }

    /**
     * Toast Notification
     */
    function showToast(message, type) {
        const existing = document.querySelector('.footer-toast');
        if (existing) existing.remove();

        const toast = document.createElement('div');
        toast.className = 'footer-toast footer-toast-' + type;
        toast.innerHTML = '<i class="fas fa-' + (type === 'success' ? 'check-circle' : 'exclamation-circle') + '"></i><span>' + message + '</span>';
        document.body.appendChild(toast);

        setTimeout(function() {
            toast.style.animation = 'toastSlideOut 0.4s ease forwards';
            setTimeout(function() { toast.remove(); }, 400);
        }, 4000);
    }

})();
</script>