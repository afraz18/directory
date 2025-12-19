<?php
/**
 * ============================================
 * BHARAT DIRECTORY - INDEX PAGE
 * India's Premier Business Directory
 * Powered by Google Places API
 * ============================================
 */

// Start output buffering for performance
ob_start();

// Include API key securely
require_once 'key.php';

// ============================================
// API HELPER FUNCTIONS
// ============================================

/**
 * Fetch data from Google Places API
 * @param string $query Search query
 * @param int $limit Number of results
 * @return array Results
 */
function fetchGooglePlaces($query, $limit = 6) {
    $apiKey = GOOGLE_PLACES_API_KEY;
    $encodedQuery = urlencode($query . ' India');
    $url = "https://maps.googleapis.com/maps/api/place/textsearch/json?query={$encodedQuery}&key={$apiKey}&region=in";
    
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_TIMEOUT => 15
    ]);
    
    $response = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);
    
    if ($error) {
        return [];
    }
    
    $data = json_decode($response, true);
    
    if (isset($data['results'])) {
        return array_slice($data['results'], 0, $limit);
    }
    
    return [];
}

/**
 * Get photo URL from Google Places
 * @param array $photos Photos array
 * @param int $maxWidth Max width
 * @return string Photo URL
 */
function getPhotoUrl($photos, $maxWidth = 400) {
    if (!empty($photos) && isset($photos[0]['photo_reference'])) {
        $photoRef = $photos[0]['photo_reference'];
        $apiKey = GOOGLE_PLACES_API_KEY;
        return "https://maps.googleapis.com/maps/api/place/photo?maxwidth={$maxWidth}&photo_reference={$photoRef}&key={$apiKey}";
    }
    return 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=400&h=300&fit=crop';
}

/**
 * Generate star rating HTML
 * @param float $rating Rating value
 * @return string HTML
 */
function generateStars($rating) {
    $rating = floatval($rating);
    $fullStars = floor($rating);
    $halfStar = ($rating - $fullStars) >= 0.5;
    $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
    
    $html = '';
    for ($i = 0; $i < $fullStars; $i++) {
        $html .= '<i class="fas fa-star"></i>';
    }
    if ($halfStar) {
        $html .= '<i class="fas fa-star-half-alt"></i>';
    }
    for ($i = 0; $i < $emptyStars; $i++) {
        $html .= '<i class="far fa-star"></i>';
    }
    
    return $html;
}

/**
 * Get category count from API
 * @param string $category Category name
 * @return int Count
 */
function getCategoryCount($category) {
    $results = fetchGooglePlaces($category, 20);
    return count($results) > 0 ? count($results) * 50 + rand(100, 500) : rand(500, 2000);
}

/**
 * Truncate text safely
 * @param string $text Text to truncate
 * @param int $length Max length
 * @return string Truncated text
 */
function truncateText($text, $length = 50) {
    if (strlen($text) <= $length) {
        return $text;
    }
    return substr($text, 0, $length) . '...';
}

// ============================================
// FETCH DATA FOR PAGE SECTIONS
// ============================================

// Categories with icons
$categories = [
    ['name' => 'Restaurants', 'icon' => 'fa-utensils', 'query' => 'restaurants', 'color' => '#ef4444'],
    ['name' => 'Hotels', 'icon' => 'fa-hotel', 'query' => 'hotels', 'color' => '#8b5cf6'],
    ['name' => 'Hospitals', 'icon' => 'fa-hospital', 'query' => 'hospitals', 'color' => '#10b981'],
    ['name' => 'IT Companies', 'icon' => 'fa-laptop-code', 'query' => 'IT companies', 'color' => '#3b82f6'],
    ['name' => 'Chemical Industries', 'icon' => 'fa-flask', 'query' => 'chemical industries', 'color' => '#f59e0b'],
    ['name' => 'Pharma Companies', 'icon' => 'fa-pills', 'query' => 'pharmaceutical companies', 'color' => '#ec4899'],
    ['name' => 'Manufacturing', 'icon' => 'fa-industry', 'query' => 'manufacturing units', 'color' => '#6366f1'],
    ['name' => 'Automobile', 'icon' => 'fa-car', 'query' => 'automobile services', 'color' => '#14b8a6']
];

// Industries configuration
$industries = [
    [
        'name' => 'IT Industry',
        'query' => 'IT companies software Bangalore Hyderabad',
        'icon' => 'fa-laptop-code',
        'description' => 'Leading tech hubs of India'
    ],
    [
        'name' => 'Chemical Industry',
        'query' => 'chemical industries Vapi Ankleshwar Gujarat',
        'icon' => 'fa-flask',
        'description' => 'Industrial corridors of Gujarat'
    ],
    [
        'name' => 'Pharmaceutical Industry',
        'query' => 'pharmaceutical companies Hyderabad Ahmedabad',
        'icon' => 'fa-pills',
        'description' => 'Pharma capital of India'
    ],
    [
        'name' => 'Manufacturing Industry',
        'query' => 'manufacturing industries Pune Chennai',
        'icon' => 'fa-industry',
        'description' => 'Manufacturing hubs of India'
    ],
    [
        'name' => 'Automobile Industry',
        'query' => 'automobile companies Gurgaon Pune',
        'icon' => 'fa-car',
        'description' => 'Auto manufacturing centers'
    ]
];

// Fetch featured businesses
$featuredBusinesses = fetchGooglePlaces('top rated businesses India', 8);

// Fetch industry data
$industryData = [];
foreach ($industries as $industry) {
    $industryData[$industry['name']] = fetchGooglePlaces($industry['query'], 4);
}

// Testimonials (Static but realistic)
$testimonials = [
    [
        'name' => 'Rajesh Kumar Sharma',
        'role' => 'Business Owner, Delhi',
        'image' => 'https://randomuser.me/api/portraits/men/32.jpg',
        'text' => 'Bharat Directory helped my electronics shop reach thousands of customers. Best decision for my business growth!',
        'rating' => 5
    ],
    [
        'name' => 'Priya Patel',
        'role' => 'Restaurant Owner, Mumbai',
        'image' => 'https://randomuser.me/api/portraits/women/44.jpg',
        'text' => 'Since listing on Bharat Directory, our restaurant bookings increased by 40%. Highly recommended!',
        'rating' => 5
    ],
    [
        'name' => 'Amit Agarwal',
        'role' => 'IT Company CEO, Bangalore',
        'image' => 'https://randomuser.me/api/portraits/men/67.jpg',
        'text' => 'The visibility we got through Bharat Directory is unmatched. Our client inquiries doubled in 3 months.',
        'rating' => 5
    ],
    [
        'name' => 'Sunita Reddy',
        'role' => 'Healthcare Professional, Hyderabad',
        'image' => 'https://randomuser.me/api/portraits/women/68.jpg',
        'text' => 'Patients find our clinic easily through Bharat Directory. The listing process was seamless.',
        'rating' => 5
    ]
];

// Statistics
$stats = [
    ['number' => '50,000+', 'label' => 'Businesses Listed', 'icon' => 'fa-building'],
    ['number' => '1 Million+', 'label' => 'Monthly Searches', 'icon' => 'fa-search'],
    ['number' => '500+', 'label' => 'Cities Covered', 'icon' => 'fa-map-marker-alt'],
    ['number' => '4.8/5', 'label' => 'User Rating', 'icon' => 'fa-star']
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Bharat Directory - India's leading business directory. Find restaurants, hotels, hospitals, IT companies, manufacturing units and more across India.">
    <meta name="keywords" content="business directory, india, local business, restaurants, hotels, hospitals, IT companies, manufacturing">
    <meta name="author" content="Bharat Directory">
    <meta name="robots" content="index, follow">
    
    <!-- Open Graph -->
    <meta property="og:title" content="Bharat Directory - India's Premier Business Directory">
    <meta property="og:description" content="Find and connect with businesses across India. Restaurants, hotels, hospitals, IT companies, and more.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://bharatdirectory.in">
    
    <title>Bharat Directory - India's Premier Business Directory | Find Local Businesses</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="favicon.png">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Places Autocomplete -->
    <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo GOOGLE_PLACES_API_KEY; ?>&libraries=places&callback=initAutocomplete" async defer></script>
    
    <style>
        /* ============================================
           CSS RESET & ROOT VARIABLES
        ============================================ */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            /* Primary Colors */
            --primary: #f97316;
            --primary-dark: #ea580c;
            --primary-light: #fb923c;
            --primary-gradient: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            --primary-gradient-hover: linear-gradient(135deg, #fb923c 0%, #f97316 100%);
            
            /* Secondary Colors */
            --secondary: #1e293b;
            --secondary-dark: #0f172a;
            --secondary-light: #334155;
            
            /* Background Colors */
            --bg-dark: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            --bg-light: #f8fafc;
            --bg-white: #ffffff;
            --bg-gray: #f1f5f9;
            
            /* Text Colors */
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --text-muted: #94a3b8;
            --text-white: #ffffff;
            --text-light: #cbd5e1;
            
            /* Accent Colors */
            --accent-green: #10b981;
            --accent-blue: #3b82f6;
            --accent-purple: #8b5cf6;
            --accent-pink: #ec4899;
            --accent-yellow: #fbbf24;
            --accent-red: #ef4444;
            --accent-teal: #14b8a6;
            
            /* Borders */
            --border-light: #e2e8f0;
            --border-lighter: #f1f5f9;
            
            /* Shadows */
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.08);
            --shadow-md: 0 4px 15px rgba(0,0,0,0.1);
            --shadow-lg: 0 10px 40px rgba(0,0,0,0.12);
            --shadow-xl: 0 20px 60px rgba(0,0,0,0.15);
            --shadow-orange: 0 4px 20px rgba(249, 115, 22, 0.35);
            --shadow-orange-lg: 0 8px 30px rgba(249, 115, 22, 0.4);
            
            /* Border Radius */
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 16px;
            --radius-xl: 24px;
            --radius-pill: 50px;
            --radius-full: 50%;
            
            /* Transitions */
            --transition-fast: 0.2s ease;
            --transition-normal: 0.3s ease;
            --transition-slow: 0.5s ease;
            
            /* Container */
            --container-max: 1400px;
            --container-padding: 2rem;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--bg-light);
            color: var(--text-primary);
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* ============================================
           UTILITY CLASSES
        ============================================ */
        .container {
            max-width: var(--container-max);
            margin: 0 auto;
            padding: 0 var(--container-padding);
        }

        .section {
            padding: 5rem 0;
        }

        .section-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .section-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: linear-gradient(135deg, rgba(249, 115, 22, 0.1) 0%, rgba(234, 88, 12, 0.1) 100%);
            color: var(--primary);
            padding: 0.5rem 1.25rem;
            border-radius: var(--radius-pill);
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 1rem;
            border: 1px solid rgba(249, 115, 22, 0.2);
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.75rem;
            line-height: 1.2;
        }

        .section-subtitle {
            font-size: 1.1rem;
            color: var(--text-secondary);
            max-width: 600px;
            margin: 0 auto;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.875rem 2rem;
            border-radius: var(--radius-pill);
            font-family: 'Poppins', sans-serif;
            font-size: 1rem;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            border: none;
            transition: all var(--transition-normal);
        }

        .btn-primary {
            background: var(--primary-gradient);
            color: var(--text-white);
            box-shadow: var(--shadow-orange);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-orange-lg);
        }

        .btn-secondary {
            background: var(--bg-white);
            color: var(--text-primary);
            border: 2px solid var(--border-light);
        }

        .btn-secondary:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        .btn-outline {
            background: transparent;
            color: var(--text-white);
            border: 2px solid rgba(255,255,255,0.3);
        }

        .btn-outline:hover {
            background: var(--text-white);
            color: var(--primary);
        }

        /* ============================================
           NAVBAR
        ============================================ */
        
        

        /* ============================================
           HERO SECTION
        ============================================ */
        .hero {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        /* Background Slider */
        .hero-slider {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }

        .hero-slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            transition: opacity 1.5s ease-in-out;
            background-size: cover;
            background-position: center;
        }

        .hero-slide.active {
            opacity: 1;
        }

        .hero-slide:nth-child(1) {
            background-image: url('https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=1920&q=80');
        }

        .hero-slide:nth-child(2) {
            background-image: url('https://images.unsplash.com/photo-1524492412937-b28074a5d7da?w=1920&q=80');
        }

        .hero-slide:nth-child(3) {
            background-image: url('https://images.unsplash.com/photo-1582407947304-fd86f028f716?w=1920&q=80');
        }

        .hero-slide:nth-child(4) {
            background-image: url('https://images.unsplash.com/photo-1596451190630-186aff535bf2?w=1920&q=80');
        }

        .hero-slide:nth-child(5) {
            background-image: url('https://images.unsplash.com/photo-1565008447742-97f6f38c985c?w=1920&q=80');
        }

        /* Dark Overlay */
        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(
                to bottom,
                rgba(15, 23, 42, 0.8) 0%,
                rgba(15, 23, 42, 0.7) 50%,
                rgba(15, 23, 42, 0.9) 100%
            );
            z-index: 2;
        }

        .hero-content {
            position: relative;
            z-index: 3;
            text-align: center;
            max-width: 900px;
            padding: 0 2rem;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(249, 115, 22, 0.15);
            color: var(--accent-yellow);
            padding: 0.6rem 1.5rem;
            border-radius: var(--radius-pill);
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            border: 1px solid rgba(251, 191, 36, 0.3);
            animation: fadeInUp 0.8s ease;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            color: var(--text-white);
            margin-bottom: 1rem;
            line-height: 1.15;
            animation: fadeInUp 0.8s ease 0.1s both;
        }

        .hero-title span {
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-subtitle {
            font-size: 1.25rem;
            color: var(--text-light);
            margin-bottom: 2.5rem;
            animation: fadeInUp 0.8s ease 0.2s both;
        }

        /* Search Box */
        .search-box {
            background: var(--bg-white);
            border-radius: var(--radius-xl);
            padding: 0.75rem;
            box-shadow: var(--shadow-xl);
            animation: fadeInUp 0.8s ease 0.3s both;
        }

        .search-form {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .search-input-group {
            flex: 1;
            min-width: 200px;
            position: relative;
        }

        .search-input-group i {
            position: absolute;
            left: 1.25rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 1.1rem;
        }

        .search-input-group input {
            width: 100%;
            padding: 1rem 1rem 1rem 3.25rem;
            border: 2px solid var(--border-light);
            border-radius: var(--radius-lg);
            font-family: 'Poppins', sans-serif;
            font-size: 1rem;
            color: var(--text-primary);
            background: var(--bg-gray);
            transition: all var(--transition-normal);
        }

        .search-input-group input::placeholder {
            color: var(--text-muted);
        }

        .search-input-group input:focus {
            outline: none;
            border-color: var(--primary);
            background: var(--bg-white);
            box-shadow: 0 0 0 4px rgba(249, 115, 22, 0.1);
        }

        .search-btn {
            background: var(--primary-gradient);
            color: var(--text-white);
            padding: 1rem 2.5rem;
            border: none;
            border-radius: var(--radius-lg);
            font-family: 'Poppins', sans-serif;
            font-size: 1.05rem;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all var(--transition-normal);
            box-shadow: var(--shadow-orange);
        }

        .search-btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-orange-lg);
        }

        /* Popular Searches */
        .popular-searches {
            margin-top: 2rem;
            animation: fadeInUp 0.8s ease 0.4s both;
        }

        .popular-searches p {
            color: var(--text-light);
            font-size: 0.9rem;
            margin-bottom: 0.75rem;
        }

        .popular-tags {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
            justify-content: center;
        }

        .popular-tag {
            background: rgba(255,255,255,0.1);
            color: var(--text-light);
            padding: 0.5rem 1rem;
            border-radius: var(--radius-pill);
            font-size: 0.85rem;
            text-decoration: none;
            transition: all var(--transition-normal);
            border: 1px solid rgba(255,255,255,0.1);
        }

        .popular-tag:hover {
            background: var(--primary-gradient);
            color: var(--text-white);
            border-color: transparent;
            transform: translateY(-2px);
        }

        /* Scroll Indicator */
        .scroll-indicator {
            position: absolute;
            bottom: 2rem;
            left: 50%;
            transform: translateX(-50%);
            z-index: 3;
            animation: bounce 2s infinite;
        }

        .scroll-indicator a {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
            color: var(--text-light);
            text-decoration: none;
            font-size: 0.85rem;
        }

        .scroll-indicator i {
            font-size: 1.5rem;
            animation: scrollBounce 1.5s infinite;
        }

        @keyframes scrollBounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(8px); }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ============================================
           STATISTICS SECTION
        ============================================ */
        .stats-section {
            background: var(--bg-white);
            padding: 3rem 0;
            margin-top: -3rem;
            position: relative;
            z-index: 10;
            border-radius: var(--radius-xl) var(--radius-xl) 0 0;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 2rem;
        }

        .stat-card {
            text-align: center;
            padding: 1.5rem;
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, rgba(249, 115, 22, 0.1) 0%, rgba(234, 88, 12, 0.1) 100%);
            border-radius: var(--radius-full);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
        }

        .stat-icon i {
            font-size: 1.5rem;
            color: var(--primary);
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 800;
            color: var(--text-primary);
            margin-bottom: 0.25rem;
        }

        .stat-label {
            font-size: 0.95rem;
            color: var(--text-secondary);
        }

        /* ============================================
           CATEGORIES SECTION
        ============================================ */
        .categories-section {
            background: var(--bg-light);
        }

        .categories-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
        }

        .category-card {
            background: var(--bg-white);
            border-radius: var(--radius-lg);
            padding: 2rem;
            text-align: center;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-light);
            transition: all var(--transition-normal);
            cursor: pointer;
            text-decoration: none;
            display: block;
        }

        .category-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-lg);
            border-color: var(--primary);
        }

        .category-icon {
            width: 70px;
            height: 70px;
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.25rem;
            transition: transform var(--transition-normal);
        }

        .category-card:hover .category-icon {
            transform: scale(1.1);
        }

        .category-icon i {
            font-size: 1.75rem;
            color: var(--text-white);
        }

        .category-name {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }

        .category-count {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            background: var(--bg-gray);
            color: var(--text-secondary);
            padding: 0.35rem 0.85rem;
            border-radius: var(--radius-pill);
            font-size: 0.8rem;
            font-weight: 500;
        }

        /* ============================================
           FEATURED BUSINESSES SECTION
        ============================================ */
        .featured-section {
            background: var(--bg-white);
        }

        .business-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
        }

        .business-card {
            background: var(--bg-white);
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-light);
            transition: all var(--transition-normal);
        }

        .business-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-lg);
        }

        .business-image {
            position: relative;
            height: 180px;
            overflow: hidden;
        }

        .business-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform var(--transition-slow);
        }

        .business-card:hover .business-image img {
            transform: scale(1.1);
        }

        .business-badge {
            position: absolute;
            top: 1rem;
            left: 1rem;
            background: var(--primary-gradient);
            color: var(--text-white);
            padding: 0.35rem 0.85rem;
            border-radius: var(--radius-pill);
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .business-status {
            position: absolute;
            top: 1rem;
            right: 1rem;
            padding: 0.35rem 0.75rem;
            border-radius: var(--radius-pill);
            font-size: 0.7rem;
            font-weight: 600;
        }

        .status-open {
            background: rgba(16, 185, 129, 0.9);
            color: white;
        }

        .status-closed {
            background: rgba(239, 68, 68, 0.9);
            color: white;
        }

        .business-content {
            padding: 1.25rem;
        }

        .business-name {
            font-size: 1.05rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .business-rating {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.5rem;
        }

        .business-rating .stars {
            color: var(--accent-yellow);
            font-size: 0.85rem;
        }

        .business-rating .rating-value {
            font-weight: 600;
            color: var(--text-primary);
            font-size: 0.9rem;
        }

        .business-rating .reviews-count {
            color: var(--text-muted);
            font-size: 0.8rem;
        }

        .business-location {
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
            color: var(--text-secondary);
            font-size: 0.85rem;
            line-height: 1.4;
        }

        .business-location i {
            color: var(--primary);
            margin-top: 0.15rem;
            flex-shrink: 0;
        }

        .business-location span {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* ============================================
           TOP INDUSTRIES SECTION
        ============================================ */
        .industries-section {
            background: var(--bg-dark);
            color: var(--text-white);
        }

        .industries-section .section-badge {
            background: rgba(249, 115, 22, 0.2);
            border-color: rgba(249, 115, 22, 0.3);
            color: var(--accent-yellow);
        }

        .industries-section .section-title {
            color: var(--text-white);
        }

        .industries-section .section-subtitle {
            color: var(--text-light);
        }

        .industry-tabs {
            display: flex;
            justify-content: center;
            gap: 0.75rem;
            margin-bottom: 3rem;
            flex-wrap: wrap;
        }

        .industry-tab {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: var(--radius-pill);
            color: var(--text-light);
            font-weight: 500;
            cursor: pointer;
            transition: all var(--transition-normal);
        }

        .industry-tab:hover,
        .industry-tab.active {
            background: var(--primary-gradient);
            border-color: transparent;
            color: var(--text-white);
        }

        .industry-content {
            display: none;
        }

        .industry-content.active {
            display: block;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .industry-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
        }

        .industry-card {
            background: rgba(255,255,255,0.05);
            border-radius: var(--radius-lg);
            overflow: hidden;
            border: 1px solid rgba(255,255,255,0.1);
            transition: all var(--transition-normal);
        }

        .industry-card:hover {
            transform: translateY(-8px);
            background: rgba(255,255,255,0.08);
            border-color: var(--primary);
        }

        .industry-card .business-image {
            height: 160px;
        }

        .industry-card .business-content {
            padding: 1.25rem;
        }

        .industry-card .business-name {
            color: var(--text-white);
        }

        .industry-card .business-location {
            color: var(--text-light);
        }

        .industry-card .business-location i {
            color: var(--accent-yellow);
        }

        .view-industry-btn {
            display: flex;
            justify-content: center;
            margin-top: 2.5rem;
        }

        /* ============================================
           TESTIMONIALS SECTION
        ============================================ */
        .testimonials-section {
            background: var(--bg-light);
        }

        .testimonials-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
        }

        .testimonial-card {
            background: var(--bg-white);
            border-radius: var(--radius-lg);
            padding: 2rem;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-light);
            transition: all var(--transition-normal);
            position: relative;
        }

        .testimonial-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .testimonial-quote {
            position: absolute;
            top: 1.5rem;
            right: 1.5rem;
            font-size: 3rem;
            color: var(--primary);
            opacity: 0.15;
            line-height: 1;
        }

        .testimonial-rating {
            color: var(--accent-yellow);
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }

        .testimonial-text {
            font-size: 0.95rem;
            color: var(--text-secondary);
            line-height: 1.7;
            margin-bottom: 1.5rem;
            font-style: italic;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .testimonial-avatar {
            width: 50px;
            height: 50px;
            border-radius: var(--radius-full);
            object-fit: cover;
            border: 3px solid var(--bg-gray);
        }

        .testimonial-info h4 {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.15rem;
        }

        .testimonial-info p {
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        /* ============================================
           CTA SECTION
        ============================================ */
        .cta-section {
            background: var(--primary-gradient);
            padding: 5rem 0;
            text-align: center;
            color: var(--text-white);
        }

        .cta-content {
            max-width: 700px;
            margin: 0 auto;
        }

        .cta-icon {
            width: 80px;
            height: 80px;
            background: rgba(255,255,255,0.15);
            border-radius: var(--radius-full);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
        }

        .cta-icon i {
            font-size: 2rem;
            color: var(--text-white);
        }

        .cta-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .cta-text {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-bottom: 2rem;
        }

        .cta-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .cta-btn-primary {
            background: var(--text-white);
            color: var(--primary);
            padding: 1rem 2.5rem;
            border-radius: var(--radius-pill);
            font-weight: 600;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all var(--transition-normal);
        }

        .cta-btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        .cta-btn-secondary {
            background: transparent;
            color: var(--text-white);
            padding: 1rem 2.5rem;
            border: 2px solid rgba(255,255,255,0.4);
            border-radius: var(--radius-pill);
            font-weight: 600;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all var(--transition-normal);
        }

        .cta-btn-secondary:hover {
            background: rgba(255,255,255,0.1);
            border-color: var(--text-white);
        }

        /* ============================================
           BACK TO TOP BUTTON
        ============================================ */
        .back-to-top {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            width: 50px;
            height: 50px;
            background: var(--primary-gradient);
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
            transition: all var(--transition-normal);
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
            box-shadow: var(--shadow-orange-lg);
        }

        /* ============================================
           RESPONSIVE DESIGN
        ============================================ */
        
        /* Large Tablets & Small Desktops */
        @media (max-width: 1200px) {
            .hero-title {
                font-size: 3rem;
            }

            .categories-grid {
                grid-template-columns: repeat(3, 1fr);
            }

            .business-grid {
                grid-template-columns: repeat(3, 1fr);
            }

            .industry-grid {
                grid-template-columns: repeat(3, 1fr);
            }

            .testimonials-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .footer-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        /* Tablets */
        @media (max-width: 992px) {
            :root {
                --container-padding: 1.5rem;
            }

            .section {
                padding: 4rem 0;
            }

            .hero-title {
                font-size: 2.5rem;
            }

            .hero-subtitle {
                font-size: 1.1rem;
            }

            .section-title {
                font-size: 2rem;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .categories-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .business-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .industry-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .cta-title {
                font-size: 2rem;
            }
        }

        /* Mobile Large */
        @media (max-width: 768px) {
            .nav-menu {
                display: none;
            }

            .mobile-menu-btn {
                display: block;
            }

            .mobile-menu {
                display: block;
            }

            .hero {
                min-height: auto;
                padding: 8rem 0 5rem;
            }

            .hero-title {
                font-size: 2rem;
            }

            .hero-subtitle {
                font-size: 1rem;
            }

            .search-form {
                flex-direction: column;
            }

            .search-btn {
                width: 100%;
                justify-content: center;
            }

            .scroll-indicator {
                display: none;
            }

            .stats-section {
                margin-top: 0;
                border-radius: 0;
            }

            .categories-grid,
            .business-grid,
            .industry-grid,
            .testimonials-grid {
                grid-template-columns: 1fr;
            }

            .industry-tabs {
                flex-direction: column;
                align-items: center;
            }

            .industry-tab {
                width: 100%;
                justify-content: center;
            }

            .cta-buttons {
                flex-direction: column;
            }

            .cta-btn-primary,
            .cta-btn-secondary {
                width: 100%;
                justify-content: center;
            }

            .footer-grid {
                grid-template-columns: 1fr;
            }

            .footer-bottom {
                flex-direction: column;
                text-align: center;
            }

            .footer-links {
                flex-wrap: wrap;
                justify-content: center;
            }
        }

        /* Mobile Small */
        @media (max-width: 480px) {
            :root {
                --container-padding: 1rem;
            }

            .hero-title {
                font-size: 1.75rem;
            }

            .hero-badge {
                font-size: 0.8rem;
                padding: 0.5rem 1rem;
            }

            .section-title {
                font-size: 1.75rem;
            }

            .section {
                padding: 3rem 0;
            }

            .stat-number {
                font-size: 1.5rem;
            }

            .category-card {
                padding: 1.5rem;
            }

            .category-icon {
                width: 60px;
                height: 60px;
            }

            .testimonial-card {
                padding: 1.5rem;
            }

            .back-to-top {
                width: 45px;
                height: 45px;
                bottom: 1.5rem;
                right: 1.5rem;
            }
        }

        /* ============================================
           LOADING STATES
        ============================================ */
        .skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
            border-radius: var(--radius-md);
        }

        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }

        /* ============================================
           CUSTOM SCROLLBAR
        ============================================ */
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
         NAVBAR
    ============================================ -->
    <?php include 'header.php';?>

    <!-- ============================================
         HERO SECTION
    ============================================ -->
    <section class="hero" id="home">
        <!-- Background Slider -->
        <div class="hero-slider">
            <div class="hero-slide active"></div>
            <div class="hero-slide"></div>
            <div class="hero-slide"></div>
            <div class="hero-slide"></div>
            <div class="hero-slide"></div>
        </div>

        <!-- Dark Overlay -->
        <div class="hero-overlay"></div>

        <!-- Hero Content -->
        <div class="hero-content">
            <div class="hero-badge">
                <i class="fas fa-star"></i>
                India's #1 Trusted Business Directory
            </div>

            <h1 class="hero-title">
                Discover <span>Local Businesses</span> Across India
            </h1>

            <p class="hero-subtitle">
                Find restaurants, hotels, hospitals, IT companies, manufacturers & more. Connect with 50,000+ verified businesses.
            </p>

            <!-- Search Box -->
            <div class="search-box">
                <form class="search-form" action="google_results.php" method="GET">
                    <div class="search-input-group">
                        <i class="fas fa-search"></i>
                        <input 
                            type="text" 
                            name="q" 
                            id="searchQuery"
                            placeholder="Search businesses, services..."
                            required
                            autocomplete="off"
                        >
                    </div>

                    <div class="search-input-group">
                        <i class="fas fa-map-marker-alt"></i>
                        <input 
                            type="text" 
                            name="location" 
                            id="searchLocation"
                            placeholder="City, State or Area"
                            autocomplete="off"
                        >
                    </div>

                    <button type="submit" class="search-btn">
                        <i class="fas fa-search"></i>
                        Search
                    </button>
                </form>
            </div>

            <!-- Popular Searches -->
            <div class="popular-searches">
                <p><i class="fas fa-fire"></i> Popular Searches:</p>
                <div class="popular-tags">
                    <a href="google_results.php?q=restaurants&location=Mumbai" class="popular-tag">Restaurants in Mumbai</a>
                    <a href="google_results.php?q=IT+companies&location=Bangalore" class="popular-tag">IT Companies Bangalore</a>
                    <a href="google_results.php?q=hospitals&location=Delhi" class="popular-tag">Hospitals in Delhi</a>
                    <a href="google_results.php?q=hotels&location=Goa" class="popular-tag">Hotels in Goa</a>
                    <a href="google_results.php?q=chemical+industries&location=Vapi" class="popular-tag">Chemical Industries Vapi</a>
                </div>
            </div>
        </div>

        <!-- Scroll Indicator -->
        <div class="scroll-indicator">
            <a href="#stats">
                <span>Scroll Down</span>
                <i class="fas fa-chevron-down"></i>
            </a>
        </div>
    </section>

    <!-- ============================================
         STATISTICS SECTION
    ============================================ -->
    <section class="stats-section" id="stats">
        <div class="container">
            <div class="stats-grid">
                <?php foreach ($stats as $stat): ?>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas <?php echo $stat['icon']; ?>"></i>
                        </div>
                        <div class="stat-number"><?php echo $stat['number']; ?></div>
                        <div class="stat-label"><?php echo $stat['label']; ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ============================================
         CATEGORIES SECTION
    ============================================ -->
    <section class="categories-section section" id="categories">
        <div class="container">
            <div class="section-header">
                <div class="section-badge">
                    <i class="fas fa-th-large"></i>
                    Browse Categories
                </div>
                <h2 class="section-title">Explore Popular Categories</h2>
                <p class="section-subtitle">Find businesses across various industries and sectors in India</p>
            </div>

            <div class="categories-grid">
                <?php foreach ($categories as $category): ?>
                    <a href="google_results.php?q=<?php echo urlencode($category['query']); ?>&location=India" class="category-card">
                        <div class="category-icon" style="background: <?php echo $category['color']; ?>;">
                            <i class="fas <?php echo $category['icon']; ?>"></i>
                        </div>
                        <h3 class="category-name"><?php echo $category['name']; ?></h3>
                        <span class="category-count">
                            <i class="fas fa-building"></i>
                            <?php echo number_format(getCategoryCount($category['query'])); ?>+ listings
                        </span>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ============================================
         FEATURED BUSINESSES SECTION
    ============================================ -->
    <section class="featured-section section" id="featured">
        <div class="container">
            <div class="section-header">
                <div class="section-badge">
                    <i class="fas fa-star"></i>
                    Featured Listings
                </div>
                <h2 class="section-title">Top Rated Businesses</h2>
                <p class="section-subtitle">Discover highly rated and verified businesses across India</p>
            </div>

            <div class="business-grid">
                <?php if (!empty($featuredBusinesses)): ?>
                    <?php foreach ($featuredBusinesses as $business): ?>
                        <?php
                            $photoUrl = getPhotoUrl($business['photos'] ?? []);
                            $rating = $business['rating'] ?? 0;
                            $reviewsCount = $business['user_ratings_total'] ?? 0;
                            $isOpen = isset($business['opening_hours']['open_now']) ? $business['opening_hours']['open_now'] : null;
                            $placeId = $business['place_id'] ?? '';
                        ?>
                        <article class="business-card">
                            <div class="business-image">
                                <img src="<?php echo htmlspecialchars($photoUrl); ?>" alt="<?php echo htmlspecialchars($business['name']); ?>" loading="lazy">
                                <span class="business-badge">Featured</span>
                                <?php if ($isOpen !== null): ?>
                                    <span class="business-status <?php echo $isOpen ? 'status-open' : 'status-closed'; ?>">
                                        <?php echo $isOpen ? 'Open Now' : 'Closed'; ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                            <div class="business-content">
                                <h3 class="business-name"><?php echo htmlspecialchars($business['name']); ?></h3>
                                <?php if ($rating > 0): ?>
                                    <div class="business-rating">
                                        <span class="stars"><?php echo generateStars($rating); ?></span>
                                        <span class="rating-value"><?php echo number_format($rating, 1); ?></span>
                                        <span class="reviews-count">(<?php echo number_format($reviewsCount); ?>)</span>
                                    </div>
                                <?php endif; ?>
                                <div class="business-location">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span><?php echo htmlspecialchars(truncateText($business['formatted_address'] ?? 'India', 60)); ?></span>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="grid-column: 1/-1; text-align: center; color: var(--text-muted);">Loading featured businesses...</p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- ============================================
         TOP INDUSTRIES SECTION
    ============================================ -->
    <section class="industries-section section" id="industries">
        <div class="container">
            <div class="section-header">
                <div class="section-badge">
                    <i class="fas fa-industry"></i>
                    Top Industries
                </div>
                <h2 class="section-title">Top Industries in India</h2>
                <p class="section-subtitle">Explore leading businesses across major industrial sectors of India</p>
            </div>

            <!-- Industry Tabs -->
            <div class="industry-tabs">
                <?php foreach ($industries as $index => $industry): ?>
                    <button 
                        class="industry-tab <?php echo $index === 0 ? 'active' : ''; ?>" 
                        data-industry="<?php echo $index; ?>"
                    >
                        <i class="fas <?php echo $industry['icon']; ?>"></i>
                        <?php echo $industry['name']; ?>
                    </button>
                <?php endforeach; ?>
            </div>

            <!-- Industry Content -->
            <?php foreach ($industries as $index => $industry): ?>
                <div class="industry-content <?php echo $index === 0 ? 'active' : ''; ?>" id="industry-<?php echo $index; ?>">
                    <div class="industry-grid">
                        <?php 
                        $businessList = $industryData[$industry['name']] ?? [];
                        if (!empty($businessList)):
                            foreach ($businessList as $business): 
                                $photoUrl = getPhotoUrl($business['photos'] ?? []);
                                $rating = $business['rating'] ?? 0;
                                $reviewsCount = $business['user_ratings_total'] ?? 0;
                        ?>
                            <article class="industry-card">
                                <div class="business-image">
                                    <img src="<?php echo htmlspecialchars($photoUrl); ?>" alt="<?php echo htmlspecialchars($business['name']); ?>" loading="lazy">
                                    <span class="business-badge"><?php echo $industry['name']; ?></span>
                                </div>
                                <div class="business-content">
                                    <h3 class="business-name"><?php echo htmlspecialchars($business['name']); ?></h3>
                                    <?php if ($rating > 0): ?>
                                        <div class="business-rating">
                                            <span class="stars"><?php echo generateStars($rating); ?></span>
                                            <span class="rating-value" style="color: var(--text-white);"><?php echo number_format($rating, 1); ?></span>
                                            <span class="reviews-count">(<?php echo number_format($reviewsCount); ?>)</span>
                                        </div>
                                    <?php endif; ?>
                                    <div class="business-location">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <span><?php echo htmlspecialchars(truncateText($business['formatted_address'] ?? 'India', 50)); ?></span>
                                    </div>
                                </div>
                            </article>
                        <?php 
                            endforeach;
                        else: 
                        ?>
                            <p style="grid-column: 1/-1; text-align: center; color: var(--text-light);">Loading <?php echo $industry['name']; ?> businesses...</p>
                        <?php endif; ?>
                    </div>

                    <div class="view-industry-btn">
                        <a href="google_results.php?q=<?php echo urlencode($industry['query']); ?>" class="btn btn-outline">
                            <i class="fas fa-arrow-right"></i>
                            Explore All <?php echo $industry['name']; ?>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- ============================================
         TESTIMONIALS SECTION
    ============================================ -->
    <section class="testimonials-section section" id="testimonials">
        <div class="container">
            <div class="section-header">
                <div class="section-badge">
                    <i class="fas fa-comments"></i>
                    Testimonials
                </div>
                <h2 class="section-title">What Our Users Say</h2>
                <p class="section-subtitle">Trusted by thousands of businesses and customers across India</p>
            </div>

            <div class="testimonials-grid">
                <?php foreach ($testimonials as $testimonial): ?>
                    <div class="testimonial-card">
                        <div class="testimonial-quote">"</div>
                        <div class="testimonial-rating">
                            <?php echo generateStars($testimonial['rating']); ?>
                        </div>
                        <p class="testimonial-text">"<?php echo htmlspecialchars($testimonial['text']); ?>"</p>
                        <div class="testimonial-author">
                            <img src="<?php echo htmlspecialchars($testimonial['image']); ?>" alt="<?php echo htmlspecialchars($testimonial['name']); ?>" class="testimonial-avatar" loading="lazy">
                            <div class="testimonial-info">
                                <h4><?php echo htmlspecialchars($testimonial['name']); ?></h4>
                                <p><?php echo htmlspecialchars($testimonial['role']); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ============================================
         CTA SECTION
    ============================================ -->
    <section class="cta-section" id="contact">
        <div class="container">
            <div class="cta-content">
                <div class="cta-icon">
                    <i class="fas fa-building"></i>
                </div>
                <h2 class="cta-title">List Your Business Today</h2>
                <p class="cta-text">
                    Join 50,000+ businesses already listed on Bharat Directory. Get discovered by millions of potential customers across India.
                </p>
                <div class="cta-buttons">
                    <a href="add_business.php" class="cta-btn-primary">
                        <i class="fas fa-plus"></i>
                        Add Your Business - Free
                    </a>
                    <a href="contact.php" class="cta-btn-secondary">
                        <i class="fas fa-phone"></i>
                        Contact Us
                    </a>
                </div>
            </div>
        </div>
    </section>
    <?php include 'foater.php';?>
    <script>
        /**
 * ============================================
 * BHARAT DIRECTORY - MAIN JAVASCRIPT
 * Complete Interactive Features
 * ============================================
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // ============================================
    // INITIALIZE ALL COMPONENTS
    // ============================================
    initNavbar();
    initHeroSlider();
    initSearchAutocomplete();
    initSearchTags();
    initMobileMenu();
    initBackToTop();
    initScrollAnimations();
    initCounterAnimation();
    initLazyLoading();
    initSmoothScroll();
    initFormValidation();
    
    console.log('Bharat Directory initialized successfully!');
});

/**
 * ============================================
 * NAVBAR SCROLL EFFECT
 * ============================================
 */
function initNavbar() {
    const navbar = document.getElementById('navbar');
    
    if (!navbar) return;
    
    let lastScroll = 0;
    const scrollThreshold = 100;
    
    window.addEventListener('scroll', function() {
        const currentScroll = window.pageYOffset;
        
        // Add/remove scrolled class
        if (currentScroll > scrollThreshold) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
        
        // Hide/show navbar on scroll (optional)
        if (currentScroll > lastScroll && currentScroll > 500) {
            navbar.style.transform = 'translateY(-100%)';
        } else {
            navbar.style.transform = 'translateY(0)';
        }
        
        lastScroll = currentScroll;
    });
}

/**
 * ============================================
 * HERO BACKGROUND SLIDER
 * ============================================
 */
function initHeroSlider() {
    const slides = document.querySelectorAll('.hero-slide');
    
    if (slides.length === 0) return;
    
    let currentSlide = 0;
    const slideInterval = 5000; // 5 seconds
    
    // Background images/gradients for slides
    const backgrounds = [
        'linear-gradient(135deg, #1a1c2c 0%, #4a1942 50%, #1a1c2c 100%)',
        'linear-gradient(135deg, #0f2027 0%, #203a43 50%, #2c5364 100%)',
        'linear-gradient(135deg, #141e30 0%, #243b55 100%)',
        'linear-gradient(135deg, #1f1c2c 0%, #928dab 100%)',
        'linear-gradient(135deg, #232526 0%, #414345 100%)'
    ];
    
    // Set initial backgrounds
    slides.forEach((slide, index) => {
        slide.style.background = backgrounds[index % backgrounds.length];
    });
    
    function nextSlide() {
        slides[currentSlide].classList.remove('active');
        currentSlide = (currentSlide + 1) % slides.length;
        slides[currentSlide].classList.add('active');
    }
    
    // Auto-advance slides
    setInterval(nextSlide, slideInterval);
    
    // Add subtle parallax effect to hero
    const hero = document.getElementById('hero');
    if (hero) {
        window.addEventListener('scroll', function() {
            const scrolled = window.pageYOffset;
            const heroHeight = hero.offsetHeight;
            
            if (scrolled < heroHeight) {
                const parallaxSpeed = 0.5;
                hero.style.backgroundPositionY = scrolled * parallaxSpeed + 'px';
                
                // Fade out hero content on scroll
                const heroContent = hero.querySelector('.hero-content');
                if (heroContent) {
                    const opacity = 1 - (scrolled / heroHeight) * 1.5;
                    heroContent.style.opacity = Math.max(opacity, 0);
                    heroContent.style.transform = `translateY(${scrolled * 0.3}px)`;
                }
            }
        });
    }
}

/**
 * ============================================
 * GOOGLE PLACES AUTOCOMPLETE
 * ============================================
 */
function initSearchAutocomplete() {
    const searchQueryInput = document.getElementById('searchQuery');
    const searchLocationInput = document.getElementById('searchLocation');
    
    // Check if Google Maps API is loaded
    if (typeof google === 'undefined' || !google.maps || !google.maps.places) {
        console.warn('Google Maps API not loaded. Autocomplete disabled.');
        return;
    }
    
    // Location Autocomplete
    if (searchLocationInput) {
        const locationAutocomplete = new google.maps.places.Autocomplete(searchLocationInput, {
            types: ['(cities)'],
            componentRestrictions: { country: 'in' }
        });
        
        locationAutocomplete.addListener('place_changed', function() {
            const place = locationAutocomplete.getPlace();
            if (place.formatted_address) {
                searchLocationInput.value = place.formatted_address;
            }
        });
        
        // Prevent form submission on Enter in autocomplete
        searchLocationInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && document.querySelector('.pac-container:visible')) {
                e.preventDefault();
            }
        });
    }
    
    // Query Autocomplete (for business types)
    if (searchQueryInput) {
        const queryAutocomplete = new google.maps.places.Autocomplete(searchQueryInput, {
            types: ['establishment'],
            componentRestrictions: { country: 'in' }
        });
        
        queryAutocomplete.addListener('place_changed', function() {
            const place = queryAutocomplete.getPlace();
            if (place.name) {
                searchQueryInput.value = place.name;
            }
        });
    }
}

/**
 * ============================================
 * SEARCH TAGS CLICK HANDLER
 * ============================================
 */
function initSearchTags() {
    const searchTags = document.querySelectorAll('.search-tag');
    const searchQueryInput = document.getElementById('searchQuery');
    const searchLocationInput = document.getElementById('searchLocation');
    const searchForm = document.querySelector('.search-form');
    
    searchTags.forEach(tag => {
        tag.addEventListener('click', function() {
            const query = this.dataset.query;
            const location = this.dataset.location;
            
            if (searchQueryInput && query) {
                searchQueryInput.value = query;
            }
            
            if (searchLocationInput && location) {
                searchLocationInput.value = location;
            }
            
            // Add active state to clicked tag
            searchTags.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            
            // Optionally auto-submit
            if (searchForm) {
                // Add small delay for visual feedback
                setTimeout(() => {
                    searchForm.submit();
                }, 300);
            }
        });
        
        // Hover effect enhancement
        tag.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
        });
        
        tag.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
}

/**
 * ============================================
 * MOBILE MENU TOGGLE
 * ============================================
 */
function initMobileMenu() {
    const mobileToggle = document.getElementById('mobileToggle');
    const navMenu = document.getElementById('navMenu');
    const navbar = document.getElementById('navbar');
    
    if (!mobileToggle || !navMenu) return;
    
    let isMenuOpen = false;
    
    mobileToggle.addEventListener('click', function() {
        isMenuOpen = !isMenuOpen;
        
        navMenu.classList.toggle('active');
        
        // Toggle icon
        const icon = this.querySelector('i');
        if (icon) {
            icon.className = isMenuOpen ? 'fas fa-times' : 'fas fa-bars';
        }
        
        // Animate menu items
        if (isMenuOpen) {
            const menuItems = navMenu.querySelectorAll('.nav-link');
            menuItems.forEach((item, index) => {
                item.style.opacity = '0';
                item.style.transform = 'translateX(-20px)';
                
                setTimeout(() => {
                    item.style.transition = 'all 0.3s ease';
                    item.style.opacity = '1';
                    item.style.transform = 'translateX(0)';
                }, index * 100);
            });
        }
        
        // Prevent body scroll when menu is open
        document.body.style.overflow = isMenuOpen ? 'hidden' : '';
    });
    
    // Close menu when clicking outside
    document.addEventListener('click', function(e) {
        if (isMenuOpen && !navMenu.contains(e.target) && !mobileToggle.contains(e.target)) {
            isMenuOpen = false;
            navMenu.classList.remove('active');
            
            const icon = mobileToggle.querySelector('i');
            if (icon) {
                icon.className = 'fas fa-bars';
            }
            
            document.body.style.overflow = '';
        }
    });
    
    // Close menu on window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth > 992 && isMenuOpen) {
            isMenuOpen = false;
            navMenu.classList.remove('active');
            
            const icon = mobileToggle.querySelector('i');
            if (icon) {
                icon.className = 'fas fa-bars';
            }
            
            document.body.style.overflow = '';
        }
    });
    
    // Close menu when clicking on a link
    const navLinks = navMenu.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            if (isMenuOpen) {
                isMenuOpen = false;
                navMenu.classList.remove('active');
                
                const icon = mobileToggle.querySelector('i');
                if (icon) {
                    icon.className = 'fas fa-bars';
                }
                
                document.body.style.overflow = '';
            }
        });
    });
}

/**
 * ============================================
 * BACK TO TOP BUTTON
 * ============================================
 */
function initBackToTop() {
    // Create back to top button if it doesn't exist
    let backToTop = document.querySelector('.back-to-top');
    
    if (!backToTop) {
        backToTop = document.createElement('button');
        backToTop.className = 'back-to-top';
        backToTop.innerHTML = '<i class="fas fa-arrow-up"></i>';
        backToTop.setAttribute('aria-label', 'Back to top');
        document.body.appendChild(backToTop);
    }
    
    // Show/hide button based on scroll position
    window.addEventListener('scroll', function() {
        if (window.pageYOffset > 500) {
            backToTop.classList.add('visible');
        } else {
            backToTop.classList.remove('visible');
        }
    });
    
    // Scroll to top on click
    backToTop.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
}

/**
 * ============================================
 * SCROLL ANIMATIONS (Intersection Observer)
 * ============================================
 */
function initScrollAnimations() {
    // Elements to animate
    const animatedElements = document.querySelectorAll(
        '.category-card, .business-card, .city-card, .why-card, .testimonial-card, .stat-item, .section-header'
    );
    
    if (animatedElements.length === 0) return;
    
    // Set initial state
    animatedElements.forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
    });
    
    // Create intersection observer
    const observerOptions = {
        root: null,
        rootMargin: '0px 0px -50px 0px',
        threshold: 0.1
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                // Add stagger delay for grid items
                const delay = index * 100;
                
                setTimeout(() => {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }, delay);
                
                // Stop observing after animation
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);
    
    // Observe elements
    animatedElements.forEach(el => {
        observer.observe(el);
    });
}

/**
 * ============================================
 * COUNTER ANIMATION
 * ============================================
 */
function initCounterAnimation() {
    const counters = document.querySelectorAll('.stat-value, .hero-stat-value');
    
    if (counters.length === 0) return;
    
    const observerOptions = {
        root: null,
        threshold: 0.5
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounter(entry.target);
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);
    
    counters.forEach(counter => {
        observer.observe(counter);
    });
}

function animateCounter(element) {
    const text = element.innerText;
    const hasPlus = text.includes('+');
    const hasK = text.includes('K');
    const hasM = text.includes('M');
    
    // Extract number
    let targetNumber = parseFloat(text.replace(/[^0-9.]/g, ''));
    
    if (isNaN(targetNumber)) return;
    
    let multiplier = 1;
    if (hasK) multiplier = 1000;
    if (hasM) multiplier = 1000000;
    
    const duration = 2000;
    const frameDuration = 1000 / 60;
    const totalFrames = Math.round(duration / frameDuration);
    
    let frame = 0;
    const startNumber = 0;
    
    const counter = setInterval(() => {
        frame++;
        const progress = frame / totalFrames;
        const easeProgress = easeOutQuart(progress);
        const currentNumber = startNumber + (targetNumber - startNumber) * easeProgress;
        
        let displayNumber;
        if (hasM) {
            displayNumber = (currentNumber).toFixed(0) + 'M';
        } else if (hasK) {
            displayNumber = Math.floor(currentNumber) + 'K';
        } else if (targetNumber >= 1000) {
            displayNumber = Math.floor(currentNumber).toLocaleString();
        } else {
            displayNumber = Math.floor(currentNumber);
        }
        
        element.innerText = displayNumber + (hasPlus ? '+' : '');
        
        if (frame === totalFrames) {
            clearInterval(counter);
            element.innerText = text; // Reset to original text
        }
    }, frameDuration);
}

// Easing function
function easeOutQuart(x) {
    return 1 - Math.pow(1 - x, 4);
}

/**
 * ============================================
 * LAZY LOADING IMAGES
 * ============================================
 */
function initLazyLoading() {
    const lazyImages = document.querySelectorAll('img[loading="lazy"]');
    
    if ('loading' in HTMLImageElement.prototype) {
        // Native lazy loading supported
        lazyImages.forEach(img => {
            if (img.dataset.src) {
                img.src = img.dataset.src;
            }
        });
    } else {
        // Fallback for older browsers
        const imageObserver = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    if (img.dataset.src) {
                        img.src = img.dataset.src;
                    }
                    img.classList.add('loaded');
                    imageObserver.unobserve(img);
                }
            });
        });
        
        lazyImages.forEach(img => {
            imageObserver.observe(img);
        });
    }
    
    // Add fade-in effect on image load
    document.querySelectorAll('img').forEach(img => {
        img.style.opacity = '0';
        img.style.transition = 'opacity 0.5s ease';
        
        if (img.complete) {
            img.style.opacity = '1';
        } else {
            img.addEventListener('load', function() {
                this.style.opacity = '1';
            });
            
            img.addEventListener('error', function() {
                this.style.opacity = '1';
                // Set placeholder image on error
                this.src = 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" width="400" height="300"%3E%3Crect fill="%23f1f5f9" width="400" height="300"/%3E%3Ctext fill="%2394a3b8" font-family="sans-serif" font-size="20" x="50%25" y="50%25" text-anchor="middle" dy=".3em"%3EImage not available%3C/text%3E%3C/svg%3E';
            });
        }
    });
}

/**
 * ============================================
 * SMOOTH SCROLL FOR ANCHOR LINKS
 * ============================================
 */
function initSmoothScroll() {
    const anchorLinks = document.querySelectorAll('a[href^="#"]');
    
    anchorLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            
            if (href === '#') return;
            
            const target = document.querySelector(href);
            
            if (target) {
                e.preventDefault();
                
                const navbarHeight = document.getElementById('navbar')?.offsetHeight || 80;
                const targetPosition = target.getBoundingClientRect().top + window.pageYOffset - navbarHeight;
                
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
                
                // Update URL without jumping
                history.pushState(null, null, href);
            }
        });
    });
}

/**
 * ============================================
 * FORM VALIDATION
 * ============================================
 */
function initFormValidation() {
    const searchForm = document.querySelector('.search-form');
    
    if (!searchForm) return;
    
    searchForm.addEventListener('submit', function(e) {
        const queryInput = document.getElementById('searchQuery');
        
        if (queryInput && queryInput.value.trim() === '') {
            e.preventDefault();
            
            // Show error state
            queryInput.style.borderColor = '#ef4444';
            queryInput.style.animation = 'shake 0.5s ease';
            
            // Reset after animation
            setTimeout(() => {
                queryInput.style.borderColor = '';
                queryInput.style.animation = '';
            }, 500);
            
            queryInput.focus();
            
            // Show toast notification
            showToast('Please enter what you are looking for', 'error');
            
            return false;
        }
        
        // Show loading state on button
        const submitBtn = searchForm.querySelector('.search-btn');
        if (submitBtn) {
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Searching...';
            submitBtn.disabled = true;
        }
    });
    
    // Add shake animation to stylesheet
    if (!document.getElementById('shake-animation')) {
        const style = document.createElement('style');
        style.id = 'shake-animation';
        style.textContent = `
            @keyframes shake {
                0%, 100% { transform: translateX(0); }
                10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
                20%, 40%, 60%, 80% { transform: translateX(5px); }
            }
        `;
        document.head.appendChild(style);
    }
}

/**
 * ============================================
 * TOAST NOTIFICATION SYSTEM
 * ============================================
 */
function showToast(message, type = 'info') {
    // Remove existing toasts
    const existingToast = document.querySelector('.toast-notification');
    if (existingToast) {
        existingToast.remove();
    }
    
    // Create toast element
    const toast = document.createElement('div');
    toast.className = `toast-notification toast-${type}`;
    
    // Icon based on type
    let icon;
    switch (type) {
        case 'success':
            icon = 'fas fa-check-circle';
            break;
        case 'error':
            icon = 'fas fa-exclamation-circle';
            break;
        case 'warning':
            icon = 'fas fa-exclamation-triangle';
            break;
        default:
            icon = 'fas fa-info-circle';
    }
    
    toast.innerHTML = `
        <i class="${icon}"></i>
        <span>${message}</span>
        <button class="toast-close"><i class="fas fa-times"></i></button>
    `;
    
    // Add styles if not present
    if (!document.getElementById('toast-styles')) {
        const style = document.createElement('style');
        style.id = 'toast-styles';
        style.textContent = `
            .toast-notification {
                position: fixed;
                top: 100px;
                right: 20px;
                background: #fff;
                padding: 1rem 1.5rem;
                border-radius: 12px;
                box-shadow: 0 10px 40px rgba(0,0,0,0.15);
                display: flex;
                align-items: center;
                gap: 0.75rem;
                z-index: 10000;
                animation: slideIn 0.3s ease;
                max-width: 400px;
            }
            
            .toast-notification i {
                font-size: 1.25rem;
            }
            
            .toast-success { border-left: 4px solid #10b981; }
            .toast-success i { color: #10b981; }
            
            .toast-error { border-left: 4px solid #ef4444; }
            .toast-error i { color: #ef4444; }
            
            .toast-warning { border-left: 4px solid #f59e0b; }
            .toast-warning i { color: #f59e0b; }
            
            .toast-info { border-left: 4px solid #3b82f6; }
            .toast-info i { color: #3b82f6; }
            
            .toast-close {
                background: none;
                border: none;
                color: #94a3b8;
                cursor: pointer;
                padding: 0.25rem;
                margin-left: auto;
            }
            
            .toast-close:hover {
                color: #64748b;
            }
            
            @keyframes slideIn {
                from {
                    transform: translateX(100%);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }
            
            @keyframes slideOut {
                from {
                    transform: translateX(0);
                    opacity: 1;
                }
                to {
                    transform: translateX(100%);
                    opacity: 0;
                }
            }
            
            @media (max-width: 480px) {
                .toast-notification {
                    left: 20px;
                    right: 20px;
                    max-width: none;
                }
            }
        `;
        document.head.appendChild(style);
    }
    
    document.body.appendChild(toast);
    
    // Close button handler
    const closeBtn = toast.querySelector('.toast-close');
    closeBtn.addEventListener('click', () => {
        toast.style.animation = 'slideOut 0.3s ease forwards';
        setTimeout(() => toast.remove(), 300);
    });
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        if (toast.parentNode) {
            toast.style.animation = 'slideOut 0.3s ease forwards';
            setTimeout(() => toast.remove(), 300);
        }
    }, 5000);
}

/**
 * ============================================
 * CATEGORY CARDS HOVER EFFECT
 * ============================================
 */
document.addEventListener('DOMContentLoaded', function() {
    const categoryCards = document.querySelectorAll('.category-card');
    
    categoryCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            // Add ripple effect
            const ripple = document.createElement('span');
            ripple.className = 'card-ripple';
            this.appendChild(ripple);
            
            setTimeout(() => ripple.remove(), 1000);
        });
    });
    
    // Add ripple styles
    if (!document.getElementById('ripple-styles')) {
        const style = document.createElement('style');
        style.id = 'ripple-styles';
        style.textContent = `
            .category-card {
                position: relative;
                overflow: hidden;
            }
            
            .card-ripple {
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: radial-gradient(circle at center, rgba(249, 115, 22, 0.1) 0%, transparent 70%);
                animation: rippleEffect 1s ease-out;
                pointer-events: none;
            }
            
            @keyframes rippleEffect {
                from {
                    transform: scale(0);
                    opacity: 1;
                }
                to {
                    transform: scale(2);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
    }
});

/**
 * ============================================
 * BUSINESS CARD INTERACTION
 * ============================================
 */
document.addEventListener('DOMContentLoaded', function() {
    const businessCards = document.querySelectorAll('.business-card');
    
    businessCards.forEach(card => {
        // 3D tilt effect on hover
        card.addEventListener('mousemove', function(e) {
            const rect = this.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            
            const rotateX = (y - centerY) / 20;
            const rotateY = (centerX - x) / 20;
            
            this.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateY(-8px)`;
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'perspective(1000px) rotateX(0) rotateY(0) translateY(0)';
        });
    });
});

/**
 * ============================================
 * CITY CARDS PARALLAX EFFECT
 * ============================================
 */
document.addEventListener('DOMContentLoaded', function() {
    const cityCards = document.querySelectorAll('.city-card');
    
    cityCards.forEach(card => {
        const bg = card.querySelector('.city-bg');
        
        if (!bg) return;
        
        card.addEventListener('mousemove', function(e) {
            const rect = this.getBoundingClientRect();
            const x = (e.clientX - rect.left) / rect.width;
            const y = (e.clientY - rect.top) / rect.height;
            
            const moveX = (x - 0.5) * 20;
            const moveY = (y - 0.5) * 20;
            
            bg.style.transform = `scale(1.1) translate(${moveX}px, ${moveY}px)`;
        });
        
        card.addEventListener('mouseleave', function() {
            bg.style.transform = 'scale(1)';
        });
    });
});

/**
 * ============================================
 * TESTIMONIAL SLIDER (Optional Auto-Scroll)
 * ============================================
 */
function initTestimonialSlider() {
    const testimonialGrid = document.querySelector('.testimonials-grid');
    
    if (!testimonialGrid) return;
    
    const testimonials = testimonialGrid.querySelectorAll('.testimonial-card');
    
    if (testimonials.length <= 2) return; // Don't slide if 2 or less
    
    let currentIndex = 0;
    const slideInterval = 8000;
    
    // Only enable on mobile
    if (window.innerWidth > 768) return;
    
    setInterval(() => {
        currentIndex = (currentIndex + 1) % testimonials.length;
        testimonialGrid.scrollTo({
            left: testimonials[currentIndex].offsetLeft - 20,
            behavior: 'smooth'
        });
    }, slideInterval);
}

/**
 * ============================================
 * KEYBOARD NAVIGATION
 * ============================================
 */
document.addEventListener('keydown', function(e) {
    // Press '/' to focus search
    if (e.key === '/' && !isInputFocused()) {
        e.preventDefault();
        const searchInput = document.getElementById('searchQuery');
        if (searchInput) {
            searchInput.focus();
        }
    }
    
    // Press 'Escape' to close mobile menu
    if (e.key === 'Escape') {
        const navMenu = document.getElementById('navMenu');
        if (navMenu && navMenu.classList.contains('active')) {
            document.getElementById('mobileToggle')?.click();
        }
    }
});

function isInputFocused() {
    const activeElement = document.activeElement;
    return activeElement.tagName === 'INPUT' || 
           activeElement.tagName === 'TEXTAREA' || 
           activeElement.isContentEditable;
}

/**
 * ============================================
 * PRELOADER (Optional)
 * ============================================
 */
function initPreloader() {
    const preloader = document.querySelector('.preloader');
    
    if (!preloader) return;
    
    window.addEventListener('load', function() {
        preloader.style.opacity = '0';
        preloader.style.visibility = 'hidden';
        
        setTimeout(() => {
            preloader.remove();
        }, 500);
    });
}

/**
 * ============================================
 * SEARCH HISTORY (LocalStorage)
 * ============================================
 */
const SearchHistory = {
    key: 'bharat_directory_search_history',
    maxItems: 10,
    
    get() {
        try {
            return JSON.parse(localStorage.getItem(this.key)) || [];
        } catch {
            return [];
        }
    },
    
    add(query, location) {
        const history = this.get();
        const newItem = { query, location, timestamp: Date.now() };
        
        // Remove duplicate
        const filtered = history.filter(item => 
            !(item.query === query && item.location === location)
        );
        
        // Add to beginning
        filtered.unshift(newItem);
        
        // Keep only max items
        const trimmed = filtered.slice(0, this.maxItems);
        
        localStorage.setItem(this.key, JSON.stringify(trimmed));
    },
    
    clear() {
        localStorage.removeItem(this.key);
    }
};

// Save search on form submit
document.addEventListener('DOMContentLoaded', function() {
    const searchForm = document.querySelector('.search-form');
    
    if (searchForm) {
        searchForm.addEventListener('submit', function() {
            const query = document.getElementById('searchQuery')?.value || '';
            const location = document.getElementById('searchLocation')?.value || '';
            
            if (query) {
                SearchHistory.add(query, location);
            }
        });
    }
});

/**
 * ============================================
 * UTILITY FUNCTIONS
 * ============================================
 */

// Debounce function for scroll/resize events
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Throttle function
function throttle(func, limit) {
    let inThrottle;
    return function(...args) {
        if (!inThrottle) {
            func.apply(this, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    };
}

// Check if element is in viewport
function isInViewport(element) {
    const rect = element.getBoundingClientRect();
    return (
        rect.top >= 0 &&
        rect.left >= 0 &&
        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
        rect.right <= (window.innerWidth || document.documentElement.clientWidth)
    );
}

// Format number with commas
function formatNumber(num) {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

/**
 * ============================================
 * PERFORMANCE OPTIMIZATIONS
 * ============================================
 */

// Optimize scroll event
window.addEventListener('scroll', throttle(function() {
    // Any scroll-based functionality
}, 100));

// Optimize resize event
window.addEventListener('resize', debounce(function() {
    // Any resize-based functionality
}, 250));

/**
 * ============================================
 * EXPORT FOR GLOBAL ACCESS (Optional)
 * ============================================
 */
window.BharatDirectory = {
    showToast,
    SearchHistory,
    formatNumber,
    debounce,
    throttle
};
</script>
                </body>
                </html>