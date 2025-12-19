<?php
/**
 * ============================================
 * BHARAT DIRECTORY - OPTIMIZED INDEX PAGE
 * Fast Loading with Database Caching
 * ============================================
 */

// Start output buffering
ob_start();

// Start session for any flash messages
session_start();

// Include API key
require_once 'key.php';

// ============================================
// DATABASE CONNECTION
// ============================================
$host = "localhost";
$dbname = "directory";  // Change this
$db_username = "root";       // Change this
$db_password = "";           // Change this

$conn = new mysqli($host, $db_username, $db_password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ============================================
// CACHING FUNCTIONS
// ============================================

/**
 * Get cached data or fetch from API
 */
function getCachedData($conn, $cacheKey, $callback, $expireMinutes = 60) {
    // Check cache first
    $stmt = $conn->prepare("SELECT cache_data FROM api_cache WHERE cache_key = ? AND expires_at > NOW()");
    if (!$stmt) {
        return $callback();
    }
    
    $stmt->bind_param("s", $cacheKey);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $stmt->close();
        return json_decode($row['cache_data'], true);
    }
    $stmt->close();
    
    // Not in cache, fetch fresh data
    $data = $callback();
    
    if (empty($data)) {
        return $data;
    }
    
    // Calculate expiry time
    $expiresAt = date('Y-m-d H:i:s', strtotime("+{$expireMinutes} minutes"));
    $createdAt = date('Y-m-d H:i:s');
    
    // Save to cache
    $cacheData = json_encode($data);
    $stmt = $conn->prepare("INSERT INTO api_cache (cache_key, cache_data, created_at, expires_at) 
                            VALUES (?, ?, ?, ?)
                            ON DUPLICATE KEY UPDATE 
                            cache_data = VALUES(cache_data), 
                            expires_at = VALUES(expires_at)");
    if ($stmt) {
        $stmt->bind_param("ssss", $cacheKey, $cacheData, $createdAt, $expiresAt);
        $stmt->execute();
        $stmt->close();
    }
    
    return $data;
}

/**
 * Fetch from Google Places API
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
        CURLOPT_TIMEOUT => 10,
        CURLOPT_CONNECTTIMEOUT => 5
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
 * Truncate text safely
 */
function truncateText($text, $length = 50) {
    if (strlen($text) <= $length) {
        return $text;
    }
    return substr($text, 0, $length) . '...';
}

// ============================================
// STATIC DATA (NO API CALLS NEEDED)
// ============================================

// Categories with static counts
$categories = [
    ['name' => 'Restaurants', 'icon' => 'fa-utensils', 'query' => 'restaurants', 'color' => '#ef4444', 'count' => '15,000+'],
    ['name' => 'Hotels', 'icon' => 'fa-hotel', 'query' => 'hotels', 'color' => '#8b5cf6', 'count' => '8,500+'],
    ['name' => 'Hospitals', 'icon' => 'fa-hospital', 'query' => 'hospitals', 'color' => '#10b981', 'count' => '5,200+'],
    ['name' => 'IT Companies', 'icon' => 'fa-laptop-code', 'query' => 'IT companies', 'color' => '#3b82f6', 'count' => '12,000+'],
    ['name' => 'Chemical Industries', 'icon' => 'fa-flask', 'query' => 'chemical industries', 'color' => '#f59e0b', 'count' => '3,800+'],
    ['name' => 'Pharma Companies', 'icon' => 'fa-pills', 'query' => 'pharmaceutical companies', 'color' => '#ec4899', 'count' => '4,500+'],
    ['name' => 'Manufacturing', 'icon' => 'fa-industry', 'query' => 'manufacturing units', 'color' => '#6366f1', 'count' => '9,200+'],
    ['name' => 'Automobile', 'icon' => 'fa-car', 'query' => 'automobile services', 'color' => '#14b8a6', 'count' => '7,100+']
];

// Industries
$industries = [
    ['name' => 'IT Industry', 'query' => 'IT companies software Bangalore', 'icon' => 'fa-laptop-code'],
    ['name' => 'Chemical Industry', 'query' => 'chemical industries Gujarat', 'icon' => 'fa-flask'],
    ['name' => 'Pharmaceutical', 'query' => 'pharmaceutical companies Hyderabad', 'icon' => 'fa-pills'],
    ['name' => 'Manufacturing', 'query' => 'manufacturing industries Pune', 'icon' => 'fa-industry'],
    ['name' => 'Automobile', 'query' => 'automobile companies Chennai', 'icon' => 'fa-car']
];

// Testimonials (Static)
$testimonials = [
    [
        'name' => 'Rajesh Kumar Sharma',
        'role' => 'Business Owner, Delhi',
        'image' => 'https://randomuser.me/api/portraits/men/32.jpg',
        'text' => 'Bharat Directory helped my electronics shop reach thousands of customers. Best decision for my business!',
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
        'text' => 'The visibility we got through Bharat Directory is unmatched. Our client inquiries doubled!',
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

// Statistics (Static)
$stats = [
    ['number' => '50,000+', 'label' => 'Businesses Listed', 'icon' => 'fa-building'],
    ['number' => '1M+', 'label' => 'Monthly Searches', 'icon' => 'fa-search'],
    ['number' => '500+', 'label' => 'Cities Covered', 'icon' => 'fa-map-marker-alt'],
    ['number' => '4.8/5', 'label' => 'User Rating', 'icon' => 'fa-star']
];

// Popular searches
$popularSearches = [
    ['text' => 'Restaurants in Mumbai', 'query' => 'restaurants', 'location' => 'Mumbai'],
    ['text' => 'IT Companies Bangalore', 'query' => 'IT companies', 'location' => 'Bangalore'],
    ['text' => 'Hospitals in Delhi', 'query' => 'hospitals', 'location' => 'Delhi'],
    ['text' => 'Hotels in Goa', 'query' => 'hotels', 'location' => 'Goa'],
    ['text' => 'Chemical Industries Vapi', 'query' => 'chemical industries', 'location' => 'Vapi']
];

// ============================================
// FETCH DATA WITH CACHING (Only 1 API call)
// ============================================

// Featured businesses - cached for 2 hours
$featuredBusinesses = getCachedData($conn, 'featured_businesses_v2', function() {
    return fetchGooglePlaces('top rated businesses India', 8);
}, 120);

// Close database connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Bharat Directory - India's leading business directory. Find restaurants, hotels, hospitals, IT companies, manufacturing units and more across India.">
    <meta name="keywords" content="business directory, india, local business, restaurants, hotels, hospitals, IT companies">
    <meta name="author" content="Bharat Directory">
    <meta name="robots" content="index, follow">
    
    <!-- Open Graph -->
    <meta property="og:title" content="Bharat Directory - India's Premier Business Directory">
    <meta property="og:description" content="Find and connect with businesses across India.">
    <meta property="og:type" content="website">
    
    <title>Bharat Directory - India's Premier Business Directory | Find Local Businesses</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="favicon.png">
    
    <!-- Preconnect for faster loading -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://maps.googleapis.com">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        /* ============================================
           CSS VARIABLES & RESET
        ============================================ */
        :root {
            --primary: #f97316;
            --primary-dark: #ea580c;
            --primary-light: #fb923c;
            --secondary: #1e293b;
            --secondary-dark: #0f172a;
            --bg-light: #f8fafc;
            --bg-white: #ffffff;
            --bg-gray: #f1f5f9;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --text-muted: #94a3b8;
            --text-white: #ffffff;
            --text-light: #cbd5e1;
            --border-light: #e2e8f0;
            --accent-yellow: #fbbf24;
            --accent-green: #10b981;
            --accent-red: #ef4444;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.08);
            --shadow-md: 0 4px 15px rgba(0,0,0,0.1);
            --shadow-lg: 0 10px 40px rgba(0,0,0,0.12);
            --shadow-xl: 0 20px 60px rgba(0,0,0,0.15);
            --shadow-orange: 0 4px 20px rgba(249, 115, 22, 0.35);
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 16px;
            --radius-xl: 24px;
            --radius-pill: 50px;
            --radius-full: 50%;
            --transition: 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
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
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
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

        /* ============================================
           HERO SECTION
        ============================================ */
        .hero {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
            overflow: hidden;
        }

        /* Animated Background */
        .hero-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 80%, rgba(249, 115, 22, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(139, 92, 246, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(16, 185, 129, 0.08) 0%, transparent 40%);
            animation: bgPulse 10s ease-in-out infinite;
        }

        @keyframes bgPulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }

        /* Floating Elements */
        .hero-shapes {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            pointer-events: none;
        }

        .shape {
            position: absolute;
            border-radius: 50%;
            opacity: 0.1;
            animation: float 20s infinite;
        }

        .shape-1 {
            width: 300px;
            height: 300px;
            background: var(--primary);
            top: -150px;
            right: -100px;
            animation-delay: 0s;
        }

        .shape-2 {
            width: 200px;
            height: 200px;
            background: #8b5cf6;
            bottom: -100px;
            left: -50px;
            animation-delay: -5s;
        }

        .shape-3 {
            width: 150px;
            height: 150px;
            background: #10b981;
            top: 50%;
            right: 10%;
            animation-delay: -10s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            25% { transform: translateY(-20px) rotate(5deg); }
            50% { transform: translateY(0) rotate(0deg); }
            75% { transform: translateY(20px) rotate(-5deg); }
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, rgba(15, 23, 42, 0.3) 0%, rgba(15, 23, 42, 0.7) 100%);
        }

        .hero-content {
            position: relative;
            z-index: 10;
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
            background: linear-gradient(135deg, #f97316 0%, #fb923c 100%);
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
            transition: all var(--transition);
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
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
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
            transition: all var(--transition);
            box-shadow: var(--shadow-orange);
        }

        .search-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(249, 115, 22, 0.4);
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
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
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
            transition: all var(--transition);
            border: 1px solid rgba(255,255,255,0.1);
        }

        .popular-tag:hover {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
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
            z-index: 10;
        }

        .scroll-indicator a {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
            color: var(--text-light);
            text-decoration: none;
            font-size: 0.85rem;
            opacity: 0.7;
            transition: opacity var(--transition);
        }

        .scroll-indicator a:hover {
            opacity: 1;
        }

        .scroll-indicator i {
            font-size: 1.5rem;
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(10px); }
        }

        /* ============================================
   STATISTICS SECTION - MOBILE OPTIMIZED
============================================ */
.stats-section {
    background: var(--bg-white);
    padding: 2.5rem 0;
    margin-top: -2rem;
    position: relative;
    z-index: 20;
    border-radius: 1.5rem 1.5rem 0 0;
    box-shadow: 0 -10px 40px rgba(0,0,0,0.1);
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1rem;
}

.stat-card {
    text-align: center;
    padding: 1rem 0.5rem;
    transition: transform 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-5px);
}

.stat-icon {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, rgba(249, 115, 22, 0.1) 0%, rgba(234, 88, 12, 0.15) 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 0.5rem;
}

.stat-icon i {
    font-size: 1.25rem;
    color: var(--primary);
}

.stat-number {
    font-size: 1.5rem;
    font-weight: 800;
    color: var(--text-primary);
    margin-bottom: 0.15rem;
    line-height: 1.2;
}

.stat-label {
    font-size: 0.75rem;
    color: var(--text-secondary);
    line-height: 1.3;
}

/* Tablet */
@media (max-width: 992px) {
    .stats-grid {
        grid-template-columns: repeat(4, 1fr);
        gap: 0.75rem;
    }
    
    .stat-icon {
        width: 45px;
        height: 45px;
    }
    
    .stat-icon i {
        font-size: 1.1rem;
    }
    
    .stat-number {
        font-size: 1.25rem;
    }
    
    .stat-label {
        font-size: 0.7rem;
    }
}

/* Mobile */
@media (max-width: 768px) {
    .stats-section {
        padding: 1.5rem 0;
        margin-top: -1.5rem;
        border-radius: 1rem 1rem 0 0;
    }
    
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem 0.5rem;
    }
    
    .stat-card {
        padding: 0.75rem 0.25rem;
    }
    
    .stat-icon {
        width: 40px;
        height: 40px;
        margin-bottom: 0.4rem;
    }
    
    .stat-icon i {
        font-size: 1rem;
    }
    
    .stat-number {
        font-size: 1.2rem;
    }
    
    .stat-label {
        font-size: 0.7rem;
    }
}

/* Small Mobile */
@media (max-width: 480px) {
    .stats-section {
        padding: 1.25rem 0;
    }
    
    .stats-grid {
        gap: 0.75rem 0.25rem;
    }
    
    .stat-icon {
        width: 36px;
        height: 36px;
    }
    
    .stat-icon i {
        font-size: 0.9rem;
    }
    
    .stat-number {
        font-size: 1.1rem;
    }
    
    .stat-label {
        font-size: 0.65rem;
    }
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
            transition: all var(--transition);
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
            width: 80px;
            height: 80px;
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.25rem;
            transition: transform var(--transition);
        }

        .category-card:hover .category-icon {
            transform: scale(1.1) rotate(5deg);
        }

        .category-icon i {
            font-size: 2rem;
            color: var(--text-white);
        }

        .category-name {
            font-size: 1.15rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }

        .category-count {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            background: var(--bg-gray);
            color: var(--text-secondary);
            padding: 0.4rem 1rem;
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
            transition: all var(--transition);
        }

        .business-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-lg);
        }

        .business-image {
            position: relative;
            height: 200px;
            overflow: hidden;
        }

        .business-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .business-card:hover .business-image img {
            transform: scale(1.1);
        }

        .business-badge {
            position: absolute;
            top: 1rem;
            left: 1rem;
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            color: var(--text-white);
            padding: 0.4rem 1rem;
            border-radius: var(--radius-pill);
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .business-status {
            position: absolute;
            top: 1rem;
            right: 1rem;
            padding: 0.4rem 0.85rem;
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
            padding: 1.5rem;
        }

        .business-name {
            font-size: 1.1rem;
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
            margin-bottom: 0.75rem;
        }

        .business-rating .stars {
            color: var(--accent-yellow);
            font-size: 0.9rem;
        }

        .business-rating .rating-value {
            font-weight: 600;
            color: var(--text-primary);
            font-size: 0.95rem;
        }

        .business-rating .reviews-count {
            color: var(--text-muted);
            font-size: 0.85rem;
        }

        .business-location {
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
            color: var(--text-secondary);
            font-size: 0.9rem;
            line-height: 1.5;
        }

        .business-location i {
            color: var(--primary);
            margin-top: 0.2rem;
            flex-shrink: 0;
        }

        .business-location span {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Skeleton Loading */
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
            transition: all var(--transition);
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
            font-size: 3.5rem;
            color: var(--primary);
            opacity: 0.1;
            line-height: 1;
            font-family: Georgia, serif;
        }

        .testimonial-rating {
            color: var(--accent-yellow);
            font-size: 0.95rem;
            margin-bottom: 1rem;
        }

        .testimonial-text {
            font-size: 0.95rem;
            color: var(--text-secondary);
            line-height: 1.8;
            margin-bottom: 1.5rem;
            font-style: italic;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .testimonial-avatar {
            width: 55px;
            height: 55px;
            border-radius: var(--radius-full);
            object-fit: cover;
            border: 3px solid var(--bg-gray);
        }

        .testimonial-info h4 {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.2rem;
        }

        .testimonial-info p {
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        /* ============================================
           CTA SECTION
        ============================================ */
        .cta-section {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            padding: 5rem 0;
            text-align: center;
            color: var(--text-white);
            position: relative;
            overflow: hidden;
        }

        .cta-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 50%, rgba(255,255,255,0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 50%, rgba(255,255,255,0.1) 0%, transparent 50%);
        }

        .cta-content {
            position: relative;
            z-index: 1;
            max-width: 700px;
            margin: 0 auto;
        }

        .cta-icon {
            width: 90px;
            height: 90px;
            background: rgba(255,255,255,0.15);
            border-radius: var(--radius-full);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
        }

        .cta-icon i {
            font-size: 2.5rem;
            color: var(--text-white);
        }

        .cta-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .cta-text {
            font-size: 1.15rem;
            opacity: 0.95;
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
            transition: all var(--transition);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }

        .cta-btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.2);
        }

        .cta-btn-secondary {
            background: transparent;
            color: var(--text-white);
            padding: 1rem 2.5rem;
            border: 2px solid rgba(255,255,255,0.5);
            border-radius: var(--radius-pill);
            font-weight: 600;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all var(--transition);
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
            width: 55px;
            height: 55px;
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
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
            box-shadow: 0 8px 30px rgba(249, 115, 22, 0.5);
        }

        /* ============================================
           RESPONSIVE DESIGN
        ============================================ */
        @media (max-width: 1200px) {
            .hero-title {
                font-size: 3rem;
            }

            .categories-grid,
            .business-grid,
            .testimonials-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 992px) {
            .section {
                padding: 4rem 0;
            }

            .hero-title {
                font-size: 2.5rem;
            }

            .section-title {
                font-size: 2rem;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .categories-grid,
            .business-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .testimonials-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .container {
                padding: 0 1.5rem;
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

            .stats-grid,
            .categories-grid,
            .business-grid,
            .testimonials-grid {
                grid-template-columns: 1fr;
            }

            .cta-title {
                font-size: 2rem;
            }

            .cta-buttons {
                flex-direction: column;
            }

            .cta-btn-primary,
            .cta-btn-secondary {
                width: 100%;
                justify-content: center;
            }
        }

        @media (max-width: 480px) {
            .hero-title {
                font-size: 1.75rem;
            }

            .section-title {
                font-size: 1.75rem;
            }

            .hero-badge {
                font-size: 0.8rem;
                padding: 0.5rem 1rem;
            }

            .popular-tags {
                gap: 0.4rem;
            }

            .popular-tag {
                font-size: 0.75rem;
                padding: 0.4rem 0.8rem;
            }

            .stat-number {
                font-size: 1.75rem;
            }

            .back-to-top {
                width: 50px;
                height: 50px;
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
    <?php include 'header.php'; ?>

    <!-- ============================================
         HERO SECTION
    ============================================ -->
    <section class="hero" id="home">
        <!-- Animated Background -->
        <div class="hero-bg"></div>
        
        <!-- Floating Shapes -->
        <div class="hero-shapes">
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
            <div class="shape shape-3"></div>
        </div>

        <!-- Overlay -->
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
                    <?php foreach ($popularSearches as $search): ?>
                    <a href="google_results.php?q=<?= urlencode($search['query']) ?>&location=<?= urlencode($search['location']) ?>" class="popular-tag">
                        <?= htmlspecialchars($search['text']) ?>
                    </a>
                    <?php endforeach; ?>
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

    <section class="stats-section" id="stats">
    <div class="container">
        <div class="stats-grid">
            
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-number">10K+</div>
                <div class="stat-label">Happy Customers</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-utensils"></i>
                </div>
                <div class="stat-number">500+</div>
                <div class="stat-label">Menu Items</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-truck"></i>
                </div>
                <div class="stat-number">50K+</div>
                <div class="stat-label">Orders Delivered</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-star"></i>
                </div>
                <div class="stat-number">4.9</div>
                <div class="stat-label">Average Rating</div>
            </div>
            
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
                <a href="google_results.php?q=<?= urlencode($category['query']) ?>&location=India" class="category-card">
                    <div class="category-icon" style="background: <?= $category['color'] ?>;">
                        <i class="fas <?= $category['icon'] ?>"></i>
                    </div>
                    <h3 class="category-name"><?= htmlspecialchars($category['name']) ?></h3>
                    <span class="category-count">
                        <i class="fas fa-building"></i>
                        <?= $category['count'] ?> listings
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
                        <a href="place_details.php?place_id=<?= urlencode($placeId) ?>">
                            <div class="business-image">
                                <img src="<?= htmlspecialchars($photoUrl) ?>" alt="<?= htmlspecialchars($business['name']) ?>" loading="lazy">
                                <span class="business-badge">Featured</span>
                                <?php if ($isOpen !== null): ?>
                                <span class="business-status <?= $isOpen ? 'status-open' : 'status-closed' ?>">
                                    <?= $isOpen ? 'Open Now' : 'Closed' ?>
                                </span>
                                <?php endif; ?>
                            </div>
                        </a>
                        <div class="business-content">
                            <h3 class="business-name">
                                <a href="place_details.php?place_id=<?= urlencode($placeId) ?>" style="color: inherit; text-decoration: none;">
                                    <?= htmlspecialchars($business['name']) ?>
                                </a>
                            </h3>
                            <?php if ($rating > 0): ?>
                            <div class="business-rating">
                                <span class="stars"><?= generateStars($rating) ?></span>
                                <span class="rating-value"><?= number_format($rating, 1) ?></span>
                                <span class="reviews-count">(<?= number_format($reviewsCount) ?>)</span>
                            </div>
                            <?php endif; ?>
                            <div class="business-location">
                                <i class="fas fa-map-marker-alt"></i>
                                <span><?= htmlspecialchars(truncateText($business['formatted_address'] ?? 'India', 60)) ?></span>
                            </div>
                        </div>
                    </article>
                    <?php endforeach; ?>
                <?php else: ?>
                    <!-- Skeleton Loading -->
                    <?php for ($i = 0; $i < 8; $i++): ?>
                    <div class="business-card">
                        <div class="business-image skeleton" style="height: 200px;"></div>
                        <div class="business-content">
                            <div class="skeleton" style="height: 24px; width: 80%; margin-bottom: 12px;"></div>
                            <div class="skeleton" style="height: 18px; width: 60%; margin-bottom: 12px;"></div>
                            <div class="skeleton" style="height: 16px; width: 90%;"></div>
                        </div>
                    </div>
                    <?php endfor; ?>
                <?php endif; ?>
            </div>
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
                        <?= generateStars($testimonial['rating']) ?>
                    </div>
                    <p class="testimonial-text">"<?= htmlspecialchars($testimonial['text']) ?>"</p>
                    <div class="testimonial-author">
                        <img src="<?= htmlspecialchars($testimonial['image']) ?>" alt="<?= htmlspecialchars($testimonial['name']) ?>" class="testimonial-avatar" loading="lazy">
                        <div class="testimonial-info">
                            <h4><?= htmlspecialchars($testimonial['name']) ?></h4>
                            <p><?= htmlspecialchars($testimonial['role']) ?></p>
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

    <!-- ============================================
         FOOTER
    ============================================ -->
    <?php include 'footer.php'; ?>

    <!-- Back to Top Button -->
    <button class="back-to-top" id="backToTop" aria-label="Back to top">
        <i class="fas fa-arrow-up"></i>
    </button>

    <!-- ============================================
         JAVASCRIPT
    ============================================ -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        
        // Back to Top Button
        const backToTop = document.getElementById('backToTop');
        
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 500) {
                backToTop.classList.add('visible');
            } else {
                backToTop.classList.remove('visible');
            }
        });
        
        backToTop.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
        
        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                if (href === '#') return;
                
                const target = document.querySelector(href);
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
        
        // Lazy load images
        const images = document.querySelectorAll('img[loading="lazy"]');
        
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.style.opacity = '1';
                        imageObserver.unobserve(img);
                    }
                });
            });
            
            images.forEach(function(img) {
                img.style.opacity = '0';
                img.style.transition = 'opacity 0.5s ease';
                imageObserver.observe(img);
                
                img.addEventListener('load', function() {
                    this.style.opacity = '1';
                });
            });
        }
        
        // Scroll animations for cards
        const animatedElements = document.querySelectorAll('.category-card, .business-card, .testimonial-card, .stat-card');
        
        if ('IntersectionObserver' in window) {
            const animationObserver = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry, index) {
                    if (entry.isIntersecting) {
                        setTimeout(function() {
                            entry.target.style.opacity = '1';
                            entry.target.style.transform = 'translateY(0)';
                        }, index * 100);
                        animationObserver.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1 });
            
            animatedElements.forEach(function(el) {
                el.style.opacity = '0';
                el.style.transform = 'translateY(30px)';
                el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                animationObserver.observe(el);
            });
        }
        
        // Counter animation for stats
        const statNumbers = document.querySelectorAll('.stat-number');
        
        if ('IntersectionObserver' in window) {
            const counterObserver = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        entry.target.style.animation = 'fadeInUp 0.6s ease forwards';
                        counterObserver.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.5 });
            
            statNumbers.forEach(function(num) {
                counterObserver.observe(num);
            });
        }
        
        console.log('Bharat Directory loaded successfully! 🚀');
    });
    
    // Load Google Places Autocomplete only when input is focused
    let autocompleteLoaded = false;
    
    document.getElementById('searchLocation')?.addEventListener('focus', function() {
        if (!autocompleteLoaded && typeof google === 'undefined') {
            const script = document.createElement('script');
            script.src = 'https://maps.googleapis.com/maps/api/js?key=<?= GOOGLE_PLACES_API_KEY ?>&libraries=places';
            script.onload = function() {
                new google.maps.places.Autocomplete(document.getElementById('searchLocation'), {
                    types: ['(cities)'],
                    componentRestrictions: { country: 'in' }
                });
                autocompleteLoaded = true;
            };
            document.head.appendChild(script);
        }
    }, { once: true });
    </script>

</body>
</html>
<?php 
// End output buffering and send output
ob_end_flush(); 
?>