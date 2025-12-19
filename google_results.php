<?php
// =============================================
// BHARAT DIRECTORY - SEARCH RESULTS PAGE
// Database First, Then Google API with Auto-Save
// =============================================

// Error reporting (remove in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session
session_start();

// API Key
$API_KEY = "mykey"; // ⚠️ Change this

// Database Connection
$host = "localhost";
$dbname = "directory"; // ⚠️ Change this
$db_username = "root";
$db_password = "";

$conn = new mysqli($host, $db_username, $db_password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get search parameters
$q = trim($_GET['q'] ?? '');
$pagetoken = $_GET['pagetoken'] ?? '';
$type = $_GET['type'] ?? '';
$location = trim($_GET['location'] ?? '');
$sort = $_GET['sort'] ?? 'relevance';
$rating = $_GET['rating'] ?? '';
$open_now = $_GET['open_now'] ?? '';
$price = $_GET['price'] ?? '';

// Redirect if no query
if (empty($q)) {
    header("Location: index.php");
    exit;
}

// Initialize variables
$results = [];
$nextPage = "";
$status = "OK";
$dataSource = "database";

// =============================================
// STEP 1: CHECK DATABASE FIRST
// =============================================
if ($pagetoken == "") {
    $searchTerm = "%" . $conn->real_escape_string($q) . "%";
    
    $dbQuery = "SELECT * FROM places WHERE (name LIKE ? OR types LIKE ? OR address LIKE ?)";
    $params = [$searchTerm, $searchTerm, $searchTerm];
    $types_str = "sss";
    
    if (!empty($location)) {
        $locationTerm = "%" . $conn->real_escape_string($location) . "%";
        $dbQuery .= " AND address LIKE ?";
        $params[] = $locationTerm;
        $types_str .= "s";
    }
    
    if (!empty($rating)) {
        $dbQuery .= " AND rating >= ?";
        $params[] = floatval($rating);
        $types_str .= "d";
    }
    
    // Sorting
    if ($sort === 'rating') {
        $dbQuery .= " ORDER BY rating DESC";
    } elseif ($sort === 'reviews') {
        $dbQuery .= " ORDER BY user_ratings_total DESC";
    } else {
        $dbQuery .= " ORDER BY rating DESC, user_ratings_total DESC";
    }
    
    $dbQuery .= " LIMIT 20";
    
    $stmt = $conn->prepare($dbQuery);
    
    if ($stmt) {
        $stmt->bind_param($types_str, ...$params);
        $stmt->execute();
        $dbResult = $stmt->get_result();
        
        while ($row = $dbResult->fetch_assoc()) {
            $results[] = [
                'place_id' => $row['place_id'],
                'name' => $row['name'],
                'formatted_address' => $row['address'],
                'geometry' => [
                    'location' => [
                        'lat' => floatval($row['lat']),
                        'lng' => floatval($row['lng'])
                    ]
                ],
                'rating' => floatval($row['rating']),
                'user_ratings_total' => intval($row['user_ratings_total']),
                'price_level' => intval($row['price_level']),
                'types' => !empty($row['types']) ? explode(",", $row['types']) : [],
                'photos' => !empty($row['photo_reference']) ? [['photo_reference' => $row['photo_reference']]] : [],
                'opening_hours' => ['open_now' => null],
                'from_db' => true
            ];
        }
        $stmt->close();
    }
}

// =============================================
// STEP 2: IF NO DATABASE RESULTS OR PAGINATION, CALL API
// =============================================
if (empty($results) || $pagetoken != "") {
    $dataSource = "api";
    
    // Build API URL
    $queryString = $q;
    if (!empty($location)) {
        $queryString .= " in " . $location;
    }
    if (!empty($type)) {
        $queryString .= " " . $type;
    }
    
    $apiUrl = "https://maps.googleapis.com/maps/api/place/textsearch/json?";
    $apiUrl .= "query=" . urlencode($queryString);
    $apiUrl .= "&key=" . $API_KEY;
    $apiUrl .= "&region=in";
    
    if ($open_now === 'true') {
        $apiUrl .= "&opennow=true";
    }
    
    if ($pagetoken != "") {
        $apiUrl .= "&pagetoken=" . urlencode($pagetoken);
        sleep(2); // Required delay for page token
    }
    
    // Fetch from API
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $apiUrl,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_USERAGENT => 'Mozilla/5.0'
    ]);
    
    $response = curl_exec($ch);
    $curlError = curl_error($ch);
    curl_close($ch);
    
    if ($curlError) {
        $status = "CURL_ERROR";
        $results = [];
    } else {
        $data = json_decode($response, true);
        
        $results = $data["results"] ?? [];
        $nextPage = $data["next_page_token"] ?? "";
        $status = $data["status"] ?? "ERROR";
        
        // Auto-save to database
        if (!empty($results) && $status === 'OK') {
            saveToDatabase($conn, $results, $q);
        }
    }
    
    // Apply filters to API results
    if (!empty($rating) && !empty($results)) {
        $results = array_filter($results, function($item) use ($rating) {
            return isset($item['rating']) && $item['rating'] >= floatval($rating);
        });
        $results = array_values($results);
    }
    
    if ($price !== '' && !empty($results)) {
        $results = array_filter($results, function($item) use ($price) {
            return isset($item['price_level']) && $item['price_level'] <= intval($price);
        });
        $results = array_values($results);
    }
    
    // Sort results
    if ($sort === 'rating' && !empty($results)) {
        usort($results, function($a, $b) {
            return ($b['rating'] ?? 0) <=> ($a['rating'] ?? 0);
        });
    } elseif ($sort === 'reviews' && !empty($results)) {
        usort($results, function($a, $b) {
            return ($b['user_ratings_total'] ?? 0) <=> ($a['user_ratings_total'] ?? 0);
        });
    }
}

$totalResults = count($results);

// =============================================
// AUTO SAVE FUNCTION
// =============================================
function saveToDatabase($conn, $places, $searchQuery) {
    $stmt = $conn->prepare("INSERT IGNORE INTO places 
        (place_id, name, address, lat, lng, rating, user_ratings_total, price_level, types, photo_reference, search_query) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    if (!$stmt) {
        return false;
    }
    
    foreach ($places as $place) {
        $place_id = $place['place_id'] ?? '';
        $name = $place['name'] ?? '';
        $address = $place['formatted_address'] ?? '';
        $lat = $place['geometry']['location']['lat'] ?? 0;
        $lng = $place['geometry']['location']['lng'] ?? 0;
        $rating = $place['rating'] ?? 0;
        $user_ratings_total = $place['user_ratings_total'] ?? 0;
        $price_level = $place['price_level'] ?? 0;
        $types = implode(",", $place['types'] ?? []);
        
        $photo_reference = '';
        if (isset($place['photos'][0]['photo_reference'])) {
            $photo_reference = $place['photos'][0]['photo_reference'];
        }
        
        $stmt->bind_param("sssdddiisss",
            $place_id,
            $name,
            $address,
            $lat,
            $lng,
            $rating,
            $user_ratings_total,
            $price_level,
            $types,
            $photo_reference,
            $searchQuery
        );
        
        $stmt->execute();
    }
    
    $stmt->close();
    return true;
}

// =============================================
// HELPER FUNCTIONS
// =============================================
function getPhotoUrl($photos, $apiKey, $maxWidth = 400) {
    if (!empty($photos[0]['photo_reference'])) {
        return "https://maps.googleapis.com/maps/api/place/photo?maxwidth={$maxWidth}&photoreference=" . $photos[0]['photo_reference'] . "&key={$apiKey}";
    }
    return "https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=400&h=300&fit=crop";
}

function getTypeIcon($types) {
    $iconMap = [
        'restaurant' => 'fa-utensils',
        'food' => 'fa-utensils',
        'cafe' => 'fa-coffee',
        'hotel' => 'fa-hotel',
        'lodging' => 'fa-bed',
        'hospital' => 'fa-hospital',
        'doctor' => 'fa-user-md',
        'health' => 'fa-heartbeat',
        'school' => 'fa-graduation-cap',
        'university' => 'fa-university',
        'store' => 'fa-store',
        'shopping_mall' => 'fa-shopping-bag',
        'gym' => 'fa-dumbbell',
        'spa' => 'fa-spa',
        'beauty_salon' => 'fa-cut',
        'car_dealer' => 'fa-car',
        'gas_station' => 'fa-gas-pump',
        'bank' => 'fa-university',
        'atm' => 'fa-credit-card',
        'pharmacy' => 'fa-pills',
        'lawyer' => 'fa-balance-scale',
        'real_estate_agency' => 'fa-home',
        'electronics_store' => 'fa-laptop',
        'movie_theater' => 'fa-film',
        'bar' => 'fa-glass-martini-alt',
        'night_club' => 'fa-music',
        'park' => 'fa-tree',
        'museum' => 'fa-landmark',
        'airport' => 'fa-plane',
        'train_station' => 'fa-train',
        'bus_station' => 'fa-bus',
    ];
    
    if (!empty($types) && is_array($types)) {
        foreach ($types as $type) {
            if (isset($iconMap[$type])) {
                return $iconMap[$type];
            }
        }
    }
    return 'fa-building';
}

function formatType($types) {
    if (empty($types) || !is_array($types)) return 'Business';
    
    $excludeTypes = ['point_of_interest', 'establishment', 'premise', 'political', 'locality', 'sublocality'];
    
    foreach ($types as $type) {
        if (!in_array($type, $excludeTypes)) {
            return ucwords(str_replace('_', ' ', $type));
        }
    }
    return 'Business';
}

function getPriceLevel($level) {
    $prices = ['Free', '₹', '₹₹', '₹₹₹', '₹₹₹₹'];
    return $prices[$level] ?? '';
}

function truncateText($text, $length = 100) {
    if (strlen($text) <= $length) return $text;
    return substr($text, 0, $length) . '...';
}

// Close database connection at end
// $conn->close(); // We'll close after HTML
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search: <?= htmlspecialchars($q) ?><?= $location ? ' in ' . htmlspecialchars($location) : '' ?> - Bharat Directory</title>
    <meta name="description" content="Find <?= htmlspecialchars($q) ?> businesses on Bharat Directory - India's leading business directory.">
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
            --primary-gradient: linear-gradient(135deg, #ff6b35, #e55a2b);
            --secondary: #138808;
            --secondary-light: #1ba50d;
            --secondary-gradient: linear-gradient(135deg, #138808, #1ba50d);
            --accent: #000080;
            --accent-light: #1a1a9e;
            --dark: #1a1a2e;
            --dark-light: #16213e;
            --gray-900: #1e293b;
            --gray-800: #1e293b;
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
            --success-light: #d1fae5;
            --warning: #f59e0b;
            --warning-light: #fef3c7;
            --danger: #ef4444;
            --danger-light: #fee2e2;
            --info: #3b82f6;
            --info-light: #dbeafe;
            --shadow-xs: 0 1px 2px rgba(0, 0, 0, 0.05);
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.1);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            --shadow-2xl: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            --shadow-primary: 0 10px 40px rgba(255, 107, 53, 0.3);
            --transition-fast: all 0.15s ease;
            --transition: all 0.3s ease;
            --transition-slow: all 0.5s ease;
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 16px;
            --radius-xl: 20px;
            --radius-2xl: 24px;
            --radius-3xl: 32px;
            --radius-full: 9999px;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: var(--gray-700);
            background: var(--light);
            line-height: 1.6;
            overflow-x: hidden;
        }

        a {
            text-decoration: none;
            color: inherit;
            transition: var(--transition);
        }

        ul {
            list-style: none;
        }

        img {
            max-width: 100%;
            height: auto;
        }

        button, input, select, textarea {
            font-family: inherit;
        }

        /* ========================================
           SEARCH HEADER
        ======================================== */
        .search-header {
            background: linear-gradient(135deg, var(--dark) 0%, var(--dark-light) 50%, #1e3a5f 100%);
            padding: 100px 5% 50px;
            position: relative;
            overflow: hidden;
        }

        .search-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 80%;
            height: 200%;
            background: radial-gradient(ellipse, rgba(255, 107, 53, 0.15) 0%, transparent 70%);
            pointer-events: none;
        }

        .search-header::after {
            content: '';
            position: absolute;
            bottom: -50%;
            left: -20%;
            width: 60%;
            height: 150%;
            background: radial-gradient(ellipse, rgba(19, 136, 8, 0.1) 0%, transparent 70%);
            pointer-events: none;
        }

        .search-header-container {
            max-width: 1400px;
            margin: 0 auto;
            position: relative;
            z-index: 2;
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
            font-size: 14px;
            flex-wrap: wrap;
        }

        .breadcrumb a {
            color: rgba(255, 255, 255, 0.7);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .breadcrumb a:hover {
            color: var(--white);
        }

        .breadcrumb-separator {
            color: rgba(255, 255, 255, 0.3);
            font-size: 10px;
        }

        .breadcrumb-current {
            color: var(--primary);
            font-weight: 500;
        }

        .search-header-title {
            font-size: 36px;
            font-weight: 800;
            color: var(--white);
            margin-bottom: 10px;
            line-height: 1.2;
        }

        .search-header-title .highlight {
            color: var(--primary);
        }

        .search-header-subtitle {
            color: rgba(255, 255, 255, 0.8);
            font-size: 16px;
            margin-bottom: 30px;
        }

        .search-header-subtitle strong {
            color: var(--white);
            font-weight: 700;
        }

        /* Main Search Box */
        .search-box-main {
            background: var(--white);
            border-radius: var(--radius-2xl);
            padding: 8px;
            display: flex;
            align-items: center;
            box-shadow: 0 25px 80px rgba(0, 0, 0, 0.3);
            max-width: 900px;
        }

        .search-input-group {
            flex: 1;
            display: flex;
            align-items: center;
            padding: 12px 20px;
            gap: 12px;
            min-width: 0;
        }

        .search-input-group i {
            color: var(--gray-400);
            font-size: 18px;
            flex-shrink: 0;
        }

        .search-input-group input {
            border: none;
            outline: none;
            font-size: 16px;
            width: 100%;
            color: var(--gray-800);
            background: transparent;
        }

        .search-input-group input::placeholder {
            color: var(--gray-400);
        }

        .search-divider {
            width: 1px;
            height: 40px;
            background: var(--gray-200);
            flex-shrink: 0;
        }

        .search-btn-main {
            background: var(--primary-gradient);
            color: var(--white);
            border: none;
            padding: 16px 32px;
            border-radius: var(--radius-xl);
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: var(--transition);
            white-space: nowrap;
            flex-shrink: 0;
        }

        .search-btn-main:hover {
            transform: scale(1.02);
            box-shadow: var(--shadow-primary);
        }

        /* Quick Search Tags */
        .quick-search-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    margin-top: 25px;
}

/* 🔥 Perfect cylindrical tag */
.quick-tag {
    display: inline-flex;
    align-items: center;
    gap: 8px;

    padding: 12px 26px;                 /* pill height & width */
    border-radius: 9999px;              /* true capsule */

    background: rgba(255, 255, 255, 0.12);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.25);

    color: var(--white);
    font-size: 14px;
    font-weight: 600;
    white-space: nowrap;

    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.25);
    transition: all 0.3s ease;
}

/* Hover = premium interaction */
.quick-tag:hover {
    background: var(--white);
    color: var(--primary);
    border-color: var(--white);

    transform: translateY(-3px);
    box-shadow: 0 14px 35px rgba(255, 255, 255, 0.35);
}

/* Optional active press effect */
.quick-tag:active {
    transform: scale(0.96);
}

/* Icon inside tag */
.quick-tag i {
    font-size: 12px;
    opacity: 0.9;
}


        /* ========================================
           MAIN CONTENT LAYOUT
        ======================================== */
        .main-wrapper {
            max-width: 1500px;
            margin: 0 auto;
            padding: 40px 5%;
            display: flex;
            gap: 35px;
        }

        /* ========================================
           SIDEBAR FILTERS
        ======================================== */
        .sidebar {
            width: 300px;
            flex-shrink: 0;
        }

        .sidebar-sticky {
            position: sticky;
            top: 90px;
        }

        .filter-card {
            background: var(--white);
            border-radius: var(--radius-xl);
            padding: 25px;
            box-shadow: var(--shadow-lg);
            margin-bottom: 25px;
        }

        .filter-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .filter-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--dark);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .filter-title i {
            color: var(--primary);
        }

        .filter-clear {
            font-size: 13px;
            color: var(--primary);
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
        }

        .filter-clear:hover {
            text-decoration: underline;
        }

        .filter-section {
            margin-bottom: 25px;
            padding-bottom: 25px;
            border-bottom: 1px solid var(--gray-100);
        }

        .filter-section:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }

        .filter-section-title {
            font-size: 14px;
            font-weight: 700;
            color: var(--gray-700);
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .filter-section-title i {
            color: var(--gray-400);
            font-size: 14px;
        }

        .filter-options {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .filter-option {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 15px;
            border-radius: var(--radius-md);
            cursor: pointer;
            transition: var(--transition);
            border: 2px solid transparent;
            position: relative;
        }

        .filter-option:hover {
            background: var(--gray-50);
        }

        .filter-option.active {
            background: rgba(255, 107, 53, 0.08);
            border-color: var(--primary);
        }

        .filter-option input {
            display: none;
        }

        .filter-checkbox,
        .filter-radio {
            width: 20px;
            height: 20px;
            border: 2px solid var(--gray-300);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
            flex-shrink: 0;
        }

        .filter-radio {
            border-radius: var(--radius-full);
        }

        .filter-option.active .filter-checkbox,
        .filter-option.active .filter-radio {
            background: var(--primary);
            border-color: var(--primary);
        }

        .filter-option.active .filter-checkbox::after,
        .filter-option.active .filter-radio::after {
            content: '\f00c';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            color: var(--white);
            font-size: 10px;
        }

        .filter-option-content {
            flex: 1;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .filter-option-label {
            font-size: 14px;
            color: var(--gray-700);
            font-weight: 500;
        }

        .filter-option-count {
            font-size: 12px;
            color: var(--gray-400);
            background: var(--gray-100);
            padding: 2px 8px;
            border-radius: var(--radius-full);
        }

        /* Rating Stars Filter */
        .rating-option {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .rating-option i {
            color: var(--warning);
            font-size: 14px;
        }

        .rating-option span {
            font-size: 14px;
            color: var(--gray-600);
            margin-left: 5px;
        }

        /* Price Level Filter */
        .price-options {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
        }

        .price-option {
            padding: 12px;
            text-align: center;
            border: 2px solid var(--gray-200);
            border-radius: var(--radius-md);
            cursor: pointer;
            transition: var(--transition);
            font-weight: 600;
            color: var(--gray-500);
        }

        .price-option:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        .price-option.active {
            background: var(--primary);
            border-color: var(--primary);
            color: var(--white);
        }

        /* Apply Filters Button */
        .filter-apply-btn {
            width: 100%;
            padding: 16px;
            background: var(--primary-gradient);
            color: var(--white);
            border: none;
            border-radius: var(--radius-lg);
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .filter-apply-btn:hover {
            box-shadow: var(--shadow-primary);
            transform: translateY(-2px);
        }

        /* Popular Searches Card */
        .popular-card {
            background: linear-gradient(135deg, var(--dark) 0%, var(--dark-light) 100%);
            border-radius: var(--radius-xl);
            padding: 25px;
            color: var(--white);
        }

        .popular-title {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .popular-title i {
            color: var(--primary);
        }

        .popular-links {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .popular-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 15px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: var(--radius-md);
            transition: var(--transition);
            color: rgba(255, 255, 255, 0.9);
            font-size: 14px;
        }

        .popular-link:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateX(5px);
        }

        .popular-link i {
            color: var(--primary);
            width: 20px;
            text-align: center;
        }

        /* ========================================
           RESULTS SECTION
        ======================================== */
        .results-section {
            flex: 1;
            min-width: 0;
        }

        /* Results Header */
        .results-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            flex-wrap: wrap;
            gap: 20px;
        }

        .results-info {
            display: flex;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .results-count {
            font-size: 16px;
            color: var(--gray-600);
        }

        .results-count strong {
            color: var(--dark);
            font-weight: 700;
        }

        .results-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;

    padding: 7px 18px;          /* more horizontal padding = cylinder */
    border-radius: 9999px;      /* 🔥 true pill shape */
    
    font-size: 12px;
    font-weight: 600;
    line-height: 1;
    white-space: nowrap;
}

.results-badge.success {
    background: rgba(16, 185, 129, 0.12);
    color: #10b981;
    border: 1px solid rgba(16, 185, 129, 0.35);
}

.results-badge.warning {
    background: rgba(245, 158, 11, 0.12);
    color: #f59e0b;
    border: 1px solid rgba(245, 158, 11, 0.35);
}

.results-badge i {
    font-size: 13px;
}


        /* Mobile Filter Toggle */
        .mobile-filter-toggle {
            display: none;
            align-items: center;
            gap: 8px;
            padding: 12px 20px;
            background: var(--white);
            border: 2px solid var(--gray-200);
            border-radius: var(--radius-lg);
            font-size: 14px;
            font-weight: 600;
            color: var(--gray-700);
            cursor: pointer;
        }

        .mobile-filter-toggle i {
            color: var(--primary);
        }

        /* View Toggle */
        .view-toggle {
            display: flex;
            background: var(--white);
            border-radius: var(--radius-lg);
            padding: 4px;
            box-shadow: var(--shadow-sm);
        }

        .view-btn {
            width: 44px;
            height: 40px;
            border: none;
            background: transparent;
            color: var(--gray-400);
            cursor: pointer;
            border-radius: var(--radius-md);
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }

        .view-btn.active {
            background: var(--primary);
            color: var(--white);
        }

        .view-btn:hover:not(.active) {
            color: var(--gray-600);
            background: var(--gray-100);
        }

        /* Sort Dropdown */
        .sort-dropdown {
            position: relative;
        }

        .sort-trigger {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 18px;
            background: var(--white);
            border: 2px solid var(--gray-200);
            border-radius: var(--radius-lg);
            font-size: 14px;
            font-weight: 500;
            color: var(--gray-700);
            cursor: pointer;
            transition: var(--transition);
            min-width: 180px;
        }

        .sort-trigger:hover {
            border-color: var(--primary);
        }

        .sort-trigger i:last-child {
            margin-left: auto;
            font-size: 12px;
            transition: var(--transition);
        }

        .sort-dropdown.active .sort-trigger i:last-child {
            transform: rotate(180deg);
        }

        .sort-menu {
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            background: var(--white);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-xl);
            min-width: 220px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: var(--transition);
            z-index: 100;
            overflow: hidden;
        }

        .sort-dropdown.active .sort-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .sort-option {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 18px;
            font-size: 14px;
            color: var(--gray-600);
            cursor: pointer;
            transition: var(--transition);
        }

        .sort-option:hover {
            background: var(--gray-100);
        }

        .sort-option.active {
            background: rgba(255, 107, 53, 0.1);
            color: var(--primary);
        }

        .sort-option i {
            width: 20px;
            color: var(--gray-400);
        }

        .sort-option.active i {
            color: var(--primary);
        }

        /* ========================================
           RESULTS GRID
        ======================================== */
        .results-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
            gap: 25px;
        }

        .results-grid.list-view {
            grid-template-columns: 1fr;
        }

        /* ========================================
           BUSINESS CARD - GRID
        ======================================== */
        .business-card {
            background: var(--white);
            border-radius: var(--radius-xl);
            overflow: hidden;
            box-shadow: var(--shadow-md);
            transition: var(--transition);
            position: relative;
        }

        .business-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-2xl);
        }

        .card-image {
            position: relative;
            height: 200px;
            overflow: hidden;
        }

        .card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
        }

        .business-card:hover .card-image img {
            transform: scale(1.1);
        }

        .card-image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(180deg, rgba(0,0,0,0) 50%, rgba(0,0,0,0.6) 100%);
            pointer-events: none;
        }

        .card-badges {
            position: absolute;
            top: 15px;
            left: 15px;
            right: 15px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            z-index: 2;
        }

        .card-badges-left {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .card-badge {
            padding: 6px 12px;
            border-radius: var(--radius-full);
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .card-badge.open {
    display: inline-flex;
    align-items: center;
    gap: 6px;

    padding: 6px 14px;
    border-radius: 9999px;              /* true cylinder */

    background: linear-gradient(
        135deg,
        var(--success),
        #059669
    );
    color: var(--white);

    font-size: 12px;
    font-weight: 600;
    white-space: nowrap;

    box-shadow:
        0 6px 18px rgba(16, 185, 129, 0.35),
        inset 0 1px 0 rgba(255, 255, 255, 0.25);
}


        .card-badge.closed {
            background: var(--danger);
            color: var(--white);
        }

        .card-badge.verified {
            background: var(--white);
            color: var(--success);
        }

        .card-badge.featured {
            background: var(--warning);
            color: var(--white);
        }

        .card-favorite {
            width: 40px;
            height: 40px;
            background: var(--white);
            border-radius: var(--radius-full);
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: var(--shadow-md);
            transition: var(--transition);
            flex-shrink: 0;
        }

        .card-favorite:hover {
            transform: scale(1.1);
        }

        .card-favorite i {
            font-size: 16px;
            color: var(--danger);
            transition: var(--transition);
        }

        .card-favorite.active i {
            font-weight: 900;
        }

        .card-category-tag {
            position: absolute;
            bottom: 15px;
            left: 15px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 8px 16px;
            border-radius: var(--radius-full);
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            font-weight: 600;
            color: var(--gray-700);
            z-index: 2;
        }

        .card-category-tag i {
            color: var(--primary);
        }

        .card-content {
            padding: 25px;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 12px;
            gap: 15px;
        }

        .card-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--dark);
            line-height: 1.3;
            margin: 0;
            flex: 1;
        }

        .card-title a:hover {
            color: var(--primary);
        }

        .card-price {
            background: var(--gray-100);
            padding: 5px 10px;
            border-radius: var(--radius-sm);
            font-size: 13px;
            font-weight: 700;
            color: var(--secondary);
            flex-shrink: 0;
        }

        .card-rating {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
        }

        .card-stars {
            display: flex;
            gap: 2px;
        }

        .card-stars i {
            font-size: 14px;
            color: var(--warning);
        }

        .card-stars i.empty {
            color: var(--gray-300);
        }

        .card-rating-score {
            font-size: 16px;
            font-weight: 700;
            color: var(--dark);
        }

        .card-rating-count {
            font-size: 13px;
            color: var(--gray-500);
        }

        .card-address {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            font-size: 14px;
            color: var(--gray-600);
            margin-bottom: 15px;
            line-height: 1.5;
        }

        .card-address i {
            color: var(--primary);
            margin-top: 3px;
            flex-shrink: 0;
        }

        .card-description {
            font-size: 14px;
            color: var(--gray-500);
            line-height: 1.6;
            margin-bottom: 15px;
            display: none;
        }

        .results-grid.list-view .card-description {
            display: block;
        }

        .card-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 20px;
        }

        .card-tag {
            background: var(--gray-100);
            padding: 6px 12px;
            border-radius: var(--radius-full);
            font-size: 12px;
            color: var(--gray-600);
            transition: var(--transition);
        }

        .card-tag:hover {
            background: var(--primary);
            color: var(--white);
        }

        .card-actions {
            display: flex;
            gap: 10px;
            padding-top: 20px;
            border-top: 1px solid var(--gray-100);
        }

        .card-btn {
            flex: 1;
            padding: 12px 16px;
            border: none;
            border-radius: var(--radius-md);
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
        }

        .card-btn.primary {
            background: var(--primary-gradient);
            color: var(--white);
        }

        .card-btn.primary:hover {
            box-shadow: var(--shadow-primary);
            transform: translateY(-2px);
        }

        .card-btn.secondary {
            background: var(--gray-100);
            color: var(--gray-700);
        }

        .card-btn.secondary:hover {
            background: var(--gray-200);
        }

        .card-btn.icon-only {
            flex: 0 0 auto;
            width: 44px;
            padding: 0;
        }

        /* ========================================
           BUSINESS CARD - LIST VIEW
        ======================================== */
        .results-grid.list-view .business-card {
            display: grid;
            grid-template-columns: 300px 1fr;
        }

        .results-grid.list-view .card-image {
            height: 100%;
            min-height: 280px;
        }

        .results-grid.list-view .card-content {
            display: flex;
            flex-direction: column;
        }

        .results-grid.list-view .card-actions {
            margin-top: auto;
        }

        /* ========================================
           NO RESULTS
        ======================================== */
        .no-results {
            text-align: center;
            padding: 80px 40px;
            background: var(--white);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-md);
        }

        .no-results-icon {
            width: 140px;
            height: 140px;
            background: var(--gray-100);
            border-radius: var(--radius-full);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
        }

        .no-results-icon i {
            font-size: 60px;
            color: var(--gray-300);
        }

        .no-results h2 {
            font-size: 28px;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 15px;
        }

        .no-results p {
            color: var(--gray-500);
            font-size: 16px;
            margin-bottom: 30px;
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
        }

        .no-results-suggestions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            justify-content: center;
            margin-top: 30px;
        }

        .suggestion-btn {
            padding: 12px 24px;
            background: var(--gray-100);
            border: none;
            border-radius: var(--radius-full);
            font-size: 14px;
            font-weight: 500;
            color: var(--gray-700);
            cursor: pointer;
            transition: var(--transition);
        }

        .suggestion-btn:hover {
            background: var(--primary);
            color: var(--white);
        }

        /* ========================================
           LOAD MORE
        ======================================== */
        .load-more-section {
            text-align: center;
            margin-top: 50px;
        }

        .load-more-btn {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            padding: 18px 50px;
            background: var(--white);
            border: 2px solid var(--primary);
            border-radius: var(--radius-xl);
            color: var(--primary);
            font-size: 16px;
            font-weight: 100;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
        }

        .load-more-btn:hover {
            background: var(--primary);
            color: var(--white);
            box-shadow: var(--shadow-primary);
        }

        .load-more-btn i {
            font-size: 18px;
            transition: var(--transition);
        }

        .load-more-btn:hover i {
            animation: rotate 1s linear infinite;
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        /* ========================================
           MAP VIEW TOGGLE (Fixed)
        ======================================== */
        .map-toggle-btn {
    position: fixed;
    bottom: 30px;
    left: 50%;
    transform: translateX(-50%);

    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 12px;

    padding: 16px 34px;                 /* pill height & width */
    border-radius: 9999px;              /* true cylinder */

    background: linear-gradient(
        135deg,
        var(--dark),
        var(--dark-light)
    );
    color: var(--white);
    font-weight: 600;
    font-size: 15px;
    text-decoration: none;
    white-space: nowrap;

    box-shadow:
        0 10px 35px rgba(0, 0, 0, 0.35),
        inset 0 1px 0 rgba(255, 255, 255, 0.15);

    z-index: 100;
    transition: all 0.3s ease;
}

/* Hover = floating premium feel */
.map-toggle-btn:hover {
    background: linear-gradient(
        135deg,
        var(--primary),
        var(--primary-dark)
    );
    transform: translateX(-50%) translateY(-4px);
    box-shadow: 0 18px 45px rgba(255, 107, 53, 0.45);
}

/* Click feedback */
.map-toggle-btn:active {
    transform: translateX(-50%) scale(0.96);
}

/* Icon styling */
.map-toggle-btn i {
    font-size: 16px;
}


        /* ========================================
           FOOTER
        ======================================== */
        .footer {
            background: var(--dark);
            margin-top: 80px;
        }

        .footer-main {
            padding: 80px 5% 50px;
        }

        .footer-container {
            max-width: 1400px;
            margin: 0 auto;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 1.6fr repeat(4, 1fr);
            gap: 50px;
        }

        .footer-brand p {
            color: rgba(255, 255, 255, 0.6);
            font-size: 14px;
            line-height: 1.8;
            margin: 20px 0 25px;
        }

        .footer-social {
            display: flex;
            gap: 12px;
        }

        .footer-social a {
            width: 44px;
            height: 44px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-size: 18px;
            transition: var(--transition);
        }

        .footer-social a:hover {
            background: var(--primary);
            transform: translateY(-3px);
        }

        .footer-column h4 {
            color: var(--white);
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 25px;
            position: relative;
            padding-bottom: 15px;
        }

        .footer-column h4::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 40px;
            height: 3px;
            background: var(--primary);
            border-radius: 3px;
        }

        .footer-column ul li {
            margin-bottom: 14px;
        }

        .footer-column ul li a {
            color: rgba(255, 255, 255, 0.6);
            font-size: 14px;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .footer-column ul li a:hover {
            color: var(--white);
            padding-left: 5px;
        }

        .footer-column ul li a i {
            font-size: 10px;
            opacity: 0;
            transition: var(--transition);
        }

        .footer-column ul li a:hover i {
            opacity: 1;
        }

        .footer-contact li {
            display: flex;
            align-items: flex-start;
            gap: 15px;
            margin-bottom: 20px !important;
        }

        .footer-contact li i {
            color: var(--primary);
            font-size: 18px;
            margin-top: 3px;
            opacity: 1 !important;
        }

        .footer-contact li span,
        .footer-contact li a {
            color: rgba(255, 255, 255, 0.6);
            font-size: 14px;
            line-height: 1.6;
        }

        .footer-contact li a:hover {
            color: var(--white);
            padding-left: 0;
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding: 25px 5%;
        }

        .footer-bottom-content {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .footer-bottom p {
            color: rgba(255, 255, 255, 0.5);
            font-size: 14px;
        }

        .footer-bottom p i {
            color: var(--danger);
        }

        .footer-bottom-links {
            display: flex;
            gap: 30px;
        }

        .footer-bottom-links a {
            color: rgba(255, 255, 255, 0.5);
            font-size: 14px;
            transition: var(--transition);
        }

        .footer-bottom-links a:hover {
            color: var(--white);
        }

        /* ========================================
           BACK TO TOP
        ======================================== */
        .back-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            background: var(--primary-gradient);
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-size: 18px;
            box-shadow: var(--shadow-primary);
            opacity: 0;
            visibility: hidden;
            transition: var(--transition);
            z-index: 999;
            text-decoration: none;
        }

        .back-to-top.visible {
            opacity: 1;
            visibility: visible;
        }

        .back-to-top:hover {
            transform: translateY(-5px);
        }

        /* ========================================
           RESPONSIVE
        ======================================== */
        @media (max-width: 1200px) {
            .main-wrapper {
                gap: 25px;
            }

            .sidebar {
                width: 280px;
            }

            .results-grid {
                grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            }

            .results-grid.list-view .business-card {
                grid-template-columns: 260px 1fr;
            }

            .footer-grid {
                grid-template-columns: repeat(3, 1fr);
            }

            .footer-brand {
                grid-column: span 3;
                margin-bottom: 20px;
            }
        }

        @media (max-width: 1024px) {
            .nav-center {
                display: none;
            }

            .nav-buttons {
                display: none;
            }

            .menu-toggle {
                display: flex;
            }

            .main-wrapper {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                display: none;
            }

            .sidebar.mobile-visible {
                display: block;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                z-index: 1002;
                background: var(--white);
                overflow-y: auto;
                padding: 80px 20px 30px;
            }

            .mobile-filter-toggle {
                display: flex;
            }

            .results-grid.list-view .business-card {
                grid-template-columns: 1fr;
            }

            .results-grid.list-view .card-image {
                height: 200px;
                min-height: 200px;
            }

            .footer-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .footer-brand {
                grid-column: span 2;
            }

            .map-toggle-btn {
                bottom: 20px;
                padding: 14px 24px;
                font-size: 14px;
            }
        }

        @media (max-width: 768px) {
            .search-header {
                padding: 90px 5% 40px;
            }

            .search-header-title {
                font-size: 28px;
            }

            .search-box-main {
                flex-direction: column;
                padding: 15px;
                border-radius: var(--radius-xl);
            }

            .search-input-group {
                width: 100%;
                padding: 12px 15px;
            }

            .search-divider {
                width: 100%;
                height: 1px;
            }

            .search-btn-main {
                width: 100%;
                justify-content: center;
                border-radius: var(--radius-lg);
            }

            .quick-search-tags {
                justify-content: center;
            }

            .results-header {
                flex-direction: column;
                align-items: stretch;
            }

            .results-controls {
                justify-content: space-between;
            }

            .sort-trigger {
                min-width: 150px;
            }

            .results-grid {
                grid-template-columns: 1fr;
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

            .footer-bottom-links {
                flex-wrap: wrap;
                justify-content: center;
            }

            .map-toggle-btn {
                display: none;
            }
        }

        @media (max-width: 480px) {
            .navbar {
                padding: 10px 4%;
            }

            .logo-icon {
                width: 40px;
                height: 40px;
                font-size: 18px;
            }

            .logo-main {
                font-size: 20px;
            }

            .search-header {
                padding: 85px 4% 30px;
            }

            .search-header-title {
                font-size: 24px;
            }

            .main-wrapper {
                padding: 25px 4%;
            }

            .card-content {
                padding: 20px;
            }

            .card-title {
                font-size: 16px;
            }

            .card-actions {
                flex-wrap: wrap;
            }

            .card-btn {
                padding: 10px 12px;
                font-size: 12px;
            }

            .no-results {
                padding: 50px 25px;
            }

            .no-results-icon {
                width: 100px;
                height: 100px;
            }

            .no-results-icon i {
                font-size: 40px;
            }

            .no-results h2 {
                font-size: 22px;
            }

            .back-to-top {
                width: 45px;
                height: 45px;
                bottom: 20px;
                right: 20px;
            }
        }

        /* Mobile Sidebar Close */
        .sidebar-mobile-header {
            display: none;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            border-bottom: 1px solid var(--gray-200);
            margin: -80px -20px 20px;
            background: var(--white);
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .sidebar.mobile-visible .sidebar-mobile-header {
            display: flex;
        }

        .sidebar-mobile-header h3 {
            font-size: 18px;
            font-weight: 700;
            color: var(--dark);
        }

        .sidebar-close {
            width: 40px;
            height: 40px;
            border: none;
            background: var(--gray-100);
            border-radius: var(--radius-full);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 16px;
            color: var(--gray-600);
        }

        .sidebar-close:hover {
            background: var(--gray-200);
        }
    </style>
</head>
<body>

    <?php include 'header.php';?>


    <!-- SEARCH HEADER -->
    <section class="search-header">
        <div class="search-header-container">
            <nav class="breadcrumb">
                <a href="index.php"><i class="fas fa-home"></i> Home</a>
                <i class="fas fa-chevron-right breadcrumb-separator"></i>
                <span class="breadcrumb-current">Search Results</span>
            </nav>

            <h1 class="search-header-title">
                Results for "<span class="highlight"><?= htmlspecialchars($q) ?></span>"
                <?php if ($location): ?>
                in <span class="highlight"><?= htmlspecialchars($location) ?></span>
                <?php endif; ?>
            </h1>

            <p class="search-header-subtitle">
                <?php if ($totalResults > 0): ?>
                Found <strong><?= number_format($totalResults) ?></strong> businesses matching your search
                <?php else: ?>
                No businesses found for your search. Try different keywords.
                <?php endif; ?>
            </p>

            <form class="search-box-main" action="google_results.php" method="GET">
                <div class="search-input-group">
                    <i class="fas fa-search"></i>
                    <input type="text" name="q" placeholder="Search businesses, services, products..." value="<?= htmlspecialchars($q) ?>" required>
                </div>
                <div class="search-divider"></div>
                <div class="search-input-group">
                    <i class="fas fa-map-marker-alt"></i>
                    <input type="text" name="location" placeholder="City, State or ZIP code" value="<?= htmlspecialchars($location) ?>">
                </div>
                <button type="submit" class="search-btn-main">
                    <i class="fas fa-search"></i>
                    Search
                </button>
            </form>

            <div class="quick-search-tags">
                <a href="google_results.php?q=restaurants" class="quick-tag">
                    <i class="fas fa-utensils"></i> Restaurants
                </a>
                <a href="google_results.php?q=hotels" class="quick-tag">
                    <i class="fas fa-hotel"></i> Hotels
                </a>
                <a href="google_results.php?q=hospitals" class="quick-tag">
                    <i class="fas fa-hospital"></i> Hospitals
                </a>
                <a href="google_results.php?q=shopping" class="quick-tag">
                    <i class="fas fa-shopping-bag"></i> Shopping
                </a>
                <a href="google_results.php?q=gym" class="quick-tag">
                    <i class="fas fa-dumbbell"></i> Gyms
                </a>
            </div>
        </div>
    </section>

    <!-- MAIN CONTENT -->
    <div class="main-wrapper">
        <!-- SIDEBAR -->
        <aside class="sidebar" id="filterSidebar">
            <div class="sidebar-sticky">
                <!-- Mobile Header -->
                <div class="sidebar-mobile-header">
                    <h3>Filters</h3>
                    <button class="sidebar-close" id="sidebarClose">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div class="filter-card">
                    <div class="filter-header">
                        <h3 class="filter-title">
                            <i class="fas fa-sliders-h"></i>
                            Filters
                        </h3>
                        <span class="filter-clear" onclick="clearAllFilters()">Clear All</span>
                    </div>

                    <form id="filterForm" action="google_results.php" method="GET">
                        <input type="hidden" name="q" value="<?= htmlspecialchars($q) ?>">
                        <input type="hidden" name="location" value="<?= htmlspecialchars($location) ?>">

                        <!-- Rating Filter -->
                        <div class="filter-section">
                            <h4 class="filter-section-title">
                                <i class="fas fa-star"></i>
                                Rating
                            </h4>
                            <div class="filter-options">
                                <?php
                                $ratingOptions = [
                                    '4.5' => '4.5 & up',
                                    '4' => '4.0 & up',
                                    '3.5' => '3.5 & up',
                                    '3' => '3.0 & up',
                                ];
                                foreach ($ratingOptions as $value => $label):
                                    $isActive = ($rating == $value);
                                ?>
                                <label class="filter-option <?= $isActive ? 'active' : '' ?>">
                                    <input type="radio" name="rating" value="<?= $value ?>" <?= $isActive ? 'checked' : '' ?>>
                                    <span class="filter-radio"></span>
                                    <div class="filter-option-content">
                                        <div class="rating-option">
                                            <?php
                                            $stars = floor(floatval($value));
                                            $halfStar = (floatval($value) - $stars) >= 0.5;
                                            for ($i = 0; $i < $stars; $i++) echo '<i class="fas fa-star"></i>';
                                            if ($halfStar) echo '<i class="fas fa-star-half-alt"></i>';
                                            ?>
                                            <span><?= $label ?></span>
                                        </div>
                                    </div>
                                </label>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- Availability Filter -->
                        <div class="filter-section">
                            <h4 class="filter-section-title">
                                <i class="fas fa-clock"></i>
                                Availability
                            </h4>
                            <div class="filter-options">
                                <label class="filter-option <?= $open_now == 'true' ? 'active' : '' ?>">
                                    <input type="checkbox" name="open_now" value="true" <?= $open_now == 'true' ? 'checked' : '' ?>>
                                    <span class="filter-checkbox"></span>
                                    <div class="filter-option-content">
                                        <span class="filter-option-label">Open Now</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Sort Filter -->
                        <div class="filter-section">
                            <h4 class="filter-section-title">
                                <i class="fas fa-sort"></i>
                                Sort By
                            </h4>
                            <div class="filter-options">
                                <?php
                                $sortOptions = [
                                    'relevance' => 'Most Relevant',
                                    'rating' => 'Highest Rated',
                                    'reviews' => 'Most Reviews',
                                ];
                                foreach ($sortOptions as $value => $label):
                                    $isActive = ($sort == $value);
                                ?>
                                <label class="filter-option <?= $isActive ? 'active' : '' ?>">
                                    <input type="radio" name="sort" value="<?= $value ?>" <?= $isActive ? 'checked' : '' ?>>
                                    <span class="filter-radio"></span>
                                    <div class="filter-option-content">
                                        <span class="filter-option-label"><?= $label ?></span>
                                    </div>
                                </label>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- Category Filter -->
                        <div class="filter-section">
                            <h4 class="filter-section-title">
                                <i class="fas fa-th-large"></i>
                                Category
                            </h4>
                            <div class="filter-options">
                                <?php
                                $categories = [
                                    'restaurant' => 'Restaurants',
                                    'hotel' => 'Hotels',
                                    'hospital' => 'Healthcare',
                                    'shopping' => 'Shopping',
                                    'education' => 'Education',
                                    'gym' => 'Fitness',
                                ];
                                foreach ($categories as $value => $label):
                                    $isActive = ($type == $value);
                                ?>
                                <label class="filter-option <?= $isActive ? 'active' : '' ?>">
                                    <input type="radio" name="type" value="<?= $value ?>" <?= $isActive ? 'checked' : '' ?>>
                                    <span class="filter-radio"></span>
                                    <div class="filter-option-content">
                                        <span class="filter-option-label"><?= $label ?></span>
                                    </div>
                                </label>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <button type="submit" class="filter-apply-btn">
                            <i class="fas fa-check"></i>
                            Apply Filters
                        </button>
                    </form>
                </div>

                <!-- Popular Searches -->
                <div class="popular-card">
                    <h4 class="popular-title">
                        <i class="fas fa-fire"></i>
                        Popular Searches
                    </h4>
                    <div class="popular-links">
                        <a href="google_results.php?q=restaurants" class="popular-link">
                            <i class="fas fa-utensils"></i>
                            Restaurants
                        </a>
                        <a href="google_results.php?q=hotels" class="popular-link">
                            <i class="fas fa-hotel"></i>
                            Hotels
                        </a>
                        <a href="google_results.php?q=hospitals" class="popular-link">
                            <i class="fas fa-hospital"></i>
                            Hospitals
                        </a>
                        <a href="google_results.php?q=shopping+mall" class="popular-link">
                            <i class="fas fa-shopping-bag"></i>
                            Shopping Malls
                        </a>
                        <a href="google_results.php?q=gym" class="popular-link">
                            <i class="fas fa-dumbbell"></i>
                            Gyms
                        </a>
                    </div>
                </div>
            </div>
        </aside>

        <!-- RESULTS SECTION -->
        <section class="results-section">
            <!-- Results Header -->
            <div class="results-header">
                <div class="results-info">
                    <span class="results-count">
                        Showing <strong><?= number_format($totalResults) ?></strong> results
                    </span>
                    <?php if ($status === 'OK'): ?>
                    <span class="results-badge success">
                        <i class="fas fa-check-circle"></i>
                        Verified Results
                    </span>
                    <?php elseif ($status !== 'ZERO_RESULTS'): ?>
                    <span class="results-badge warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        <?= htmlspecialchars($status) ?>
                    </span>
                    <?php endif; ?>
                </div>

                <div class="results-controls">
                    <!-- Mobile Filter Toggle -->
                    <button class="mobile-filter-toggle" id="mobileFilterToggle">
                        <i class="fas fa-filter"></i>
                        Filters
                    </button>

                    <!-- View Toggle -->
                    <div class="view-toggle">
                        <button class="view-btn active" data-view="grid" title="Grid View">
                            <i class="fas fa-th-large"></i>
                        </button>
                        <button class="view-btn" data-view="list" title="List View">
                            <i class="fas fa-list"></i>
                        </button>
                    </div>

                    <!-- Sort Dropdown -->
                    <div class="sort-dropdown" id="sortDropdown">
                        <button type="button" class="sort-trigger">
                            <i class="fas fa-sort-amount-down"></i>
                            <span>Sort By</span>
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <div class="sort-menu">
                            <div class="sort-option <?= $sort == 'relevance' ? 'active' : '' ?>" data-sort="relevance">
                                <i class="fas fa-fire"></i>
                                Most Relevant
                            </div>
                            <div class="sort-option <?= $sort == 'rating' ? 'active' : '' ?>" data-sort="rating">
                                <i class="fas fa-star"></i>
                                Highest Rated
                            </div>
                            <div class="sort-option <?= $sort == 'reviews' ? 'active' : '' ?>" data-sort="reviews">
                                <i class="fas fa-comments"></i>
                                Most Reviews
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php if (!empty($results)): ?>
            <!-- Results Grid -->
            <div class="results-grid" id="resultsGrid">
                <?php foreach ($results as $index => $business): ?>
                <?php
                    $photo = getPhotoUrl($business['photos'] ?? [], $API_KEY);
                    $businessRating = $business['rating'] ?? 0;
                    $totalRatings = $business['user_ratings_total'] ?? 0;
                    $priceLevel = $business['price_level'] ?? null;
                    $isOpen = $business['opening_hours']['open_now'] ?? null;
                    $types = $business['types'] ?? [];
                    $typeIcon = getTypeIcon($types);
                    $formattedType = formatType($types);
                    
                    $fullStars = floor($businessRating);
                    $halfStar = ($businessRating - $fullStars) >= 0.5;
                    $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
                ?>
                <article class="business-card" data-index="<?= $index ?>">
                    <div class="card-image">
                        <img src="<?= htmlspecialchars($photo) ?>" alt="<?= htmlspecialchars($business['name']) ?>" loading="lazy">
                        <div class="card-image-overlay"></div>
                        <div class="card-badges">
                            <div class="card-badges-left">
                                <?php if ($isOpen === true): ?>
                                <span class="card-badge open">
                                    <i class="fas fa-clock"></i> Open
                                </span>
                                <?php elseif ($isOpen === false): ?>
                                <span class="card-badge closed">
                                    <i class="fas fa-clock"></i> Closed
                                </span>
                                <?php endif; ?>
                                <?php if ($businessRating >= 4.5): ?>
                                <span class="card-badge verified">
                                    <i class="fas fa-check-circle"></i> Top Rated
                                </span>
                                <?php endif; ?>
                            </div>
                            <button class="card-favorite" title="Add to favorites">
                                <i class="far fa-heart"></i>
                            </button>
                        </div>
                        <div class="card-category-tag">
                            <i class="fas <?= $typeIcon ?>"></i>
                            <?= htmlspecialchars($formattedType) ?>
                        </div>
                    </div>

                    <div class="card-content">
                        <div class="card-header">
                            <h3 class="card-title">
                                <a href="place_details.php?place_id=<?= urlencode($business['place_id']) ?>">
                                    <?= htmlspecialchars($business['name']) ?>
                                </a>
                            </h3>
                            <?php if ($priceLevel !== null): ?>
                            <span class="card-price"><?= getPriceLevel($priceLevel) ?></span>
                            <?php endif; ?>
                        </div>

                        <?php if ($businessRating > 0): ?>
                        <div class="card-rating">
                            <div class="card-stars">
                                <?php for ($i = 0; $i < $fullStars; $i++): ?>
                                <i class="fas fa-star"></i>
                                <?php endfor; ?>
                                <?php if ($halfStar): ?>
                                <i class="fas fa-star-half-alt"></i>
                                <?php endif; ?>
                                <?php for ($i = 0; $i < $emptyStars; $i++): ?>
                                <i class="fas fa-star empty"></i>
                                <?php endfor; ?>
                            </div>
                            <span class="card-rating-score"><?= number_format($businessRating, 1) ?></span>
                            <span class="card-rating-count">(<?= number_format($totalRatings) ?>)</span>
                        </div>
                        <?php endif; ?>

                        <div class="card-address">
                            <i class="fas fa-map-marker-alt"></i>
                            <span><?= htmlspecialchars($business['formatted_address'] ?? 'Address not available') ?></span>
                        </div>

                        <p class="card-description">
                            <?= htmlspecialchars($business['name']) ?> is a popular <?= strtolower($formattedType) ?>. 
                            <?php if ($businessRating >= 4): ?>
                            Highly rated by customers with excellent service.
                            <?php else: ?>
                            Visit for a great experience.
                            <?php endif; ?>
                        </p>

                        <?php if (count($types) > 1): ?>
                        <div class="card-tags">
                            <?php 
                            $displayTypes = array_slice($types, 0, 3);
                            foreach ($displayTypes as $t): 
                                if (!in_array($t, ['point_of_interest', 'establishment'])):
                            ?>
                            <span class="card-tag"><?= ucwords(str_replace('_', ' ', $t)) ?></span>
                            <?php 
                                endif;
                            endforeach; 
                            ?>
                        </div>
                        <?php endif; ?>

                        <div class="card-actions">
                            <a href="place_details.php?place_id=<?= urlencode($business['place_id']) ?>" class="card-btn primary">
                                <i class="fas fa-eye"></i>
                                View Details
                            </a>
                            <a href="https://www.google.com/maps/dir/?api=1&destination_place_id=<?= urlencode($business['place_id']) ?>" target="_blank" class="card-btn secondary">
                                <i class="fas fa-directions"></i>
                                Directions
                            </a>
                            <button class="card-btn secondary icon-only" title="Share">
                                <i class="fas fa-share-alt"></i>
                            </button>
                        </div>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>
            <div class="card-actions">
    <a href="place_details.php?place_id=<?= urlencode($business['place_id']) ?>" class="card-btn primary">
        <i class="fas fa-eye"></i>
        View Details
    </a>
    <a href="https://www.google.com/maps/dir/?api=1&destination_place_id=<?= urlencode($business['place_id']) ?>" target="_blank" class="card-btn secondary">
        <i class="fas fa-directions"></i>
        Directions
    </a>

            <!-- Load More -->
            <?php if ($nextPage): ?>
            <div class="load-more-section">
                <a href="google_results.php?q=<?= urlencode($q) ?>&location=<?= urlencode($location) ?>&pagetoken=<?= urlencode($nextPage) ?>&sort=<?= urlencode($sort) ?>&rating=<?= urlencode($rating) ?>&open_now=<?= urlencode($open_now) ?>&type=<?= urlencode($type) ?>" class="load-more-btn">
                    <i class="fas fa-sync-alt"></i>
                    Load More Results
                </a>
            </div>
            <?php endif; ?>

            <?php else: ?>
            <!-- No Results -->
            <div class="no-results">
                <div class="no-results-icon">
                    <i class="fas fa-search"></i>
                </div>
                <h2>No Results Found</h2>
                <p>We couldn't find any businesses matching "<strong><?= htmlspecialchars($q) ?></strong>". Try a different search or browse popular categories.</p>
                <a href="index.php" class="btn btn-primary btn-lg">
                    <i class="fas fa-home"></i>
                    Back to Home
                </a>
                <div class="no-results-suggestions">
                    <button class="suggestion-btn" onclick="location.href='google_results.php?q=restaurants'">Restaurants</button>
                    <button class="suggestion-btn" onclick="location.href='google_results.php?q=hotels'">Hotels</button>
                    <button class="suggestion-btn" onclick="location.href='google_results.php?q=hospitals'">Hospitals</button>
                    <button class="suggestion-btn" onclick="location.href='google_results.php?q=shopping'">Shopping</button>
                    <button class="suggestion-btn" onclick="location.href='google_results.php?q=gym'">Gyms</button>
                </div>
            </div>
            <?php endif; ?>
        </section>
    </div>

    <!-- Map View Toggle -->
    <a href="map_view.php?q=<?= urlencode($q) ?>&location=<?= urlencode($location) ?>" class="map-toggle-btn">
        <i class="fas fa-map-marked-alt"></i>
        View on Map
    </a>

    <!-- FOOTER -->
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
        const menuToggle = document.getElementById('menuToggle');
        const mobileMenu = document.getElementById('mobileMenu');
        const mobileMenuOverlay = document.getElementById('mobileMenuOverlay');
        const mobileMenuClose = document.getElementById('mobileMenuClose');
        const backToTop = document.getElementById('backToTop');
        const sortDropdown = document.getElementById('sortDropdown');
        const resultsGrid = document.getElementById('resultsGrid');
        const viewBtns = document.querySelectorAll('.view-btn');
        const filterSidebar = document.getElementById('filterSidebar');
        const mobileFilterToggle = document.getElementById('mobileFilterToggle');
        const sidebarClose = document.getElementById('sidebarClose');
        const filterOptions = document.querySelectorAll('.filter-option');
        const favoriteBtns = document.querySelectorAll('.card-favorite');

        // ========================================
        // MOBILE MENU
        // ========================================
        function openMobileMenu() {
            mobileMenu.classList.add('active');
            mobileMenuOverlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeMobileMenu() {
            mobileMenu.classList.remove('active');
            mobileMenuOverlay.classList.remove('active');
            document.body.style.overflow = '';
        }

        menuToggle?.addEventListener('click', openMobileMenu);
        mobileMenuClose?.addEventListener('click', closeMobileMenu);
        mobileMenuOverlay?.addEventListener('click', closeMobileMenu);

        // ========================================
        // MOBILE FILTER SIDEBAR
        // ========================================
        function openFilterSidebar() {
            filterSidebar.classList.add('mobile-visible');
            document.body.style.overflow = 'hidden';
        }

        function closeFilterSidebar() {
            filterSidebar.classList.remove('mobile-visible');
            document.body.style.overflow = '';
        }

        mobileFilterToggle?.addEventListener('click', openFilterSidebar);
        sidebarClose?.addEventListener('click', closeFilterSidebar);

        // ========================================
        // BACK TO TOP
        // ========================================
        function handleBackToTop() {
            if (window.scrollY > 500) {
                backToTop.classList.add('visible');
            } else {
                backToTop.classList.remove('visible');
            }
        }

        window.addEventListener('scroll', handleBackToTop);

        backToTop?.addEventListener('click', (e) => {
            e.preventDefault();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        // ========================================
        // SORT DROPDOWN
        // ========================================
        sortDropdown?.querySelector('.sort-trigger')?.addEventListener('click', () => {
            sortDropdown.classList.toggle('active');
        });

        document.addEventListener('click', (e) => {
            if (!sortDropdown?.contains(e.target)) {
                sortDropdown?.classList.remove('active');
            }
        });

        sortDropdown?.querySelectorAll('.sort-option').forEach(option => {
            option.addEventListener('click', () => {
                const sortValue = option.dataset.sort;
                const url = new URL(window.location.href);
                url.searchParams.set('sort', sortValue);
                window.location.href = url.toString();
            });
        });

        // ========================================
        // VIEW TOGGLE
        // ========================================
        viewBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                viewBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                
                const view = btn.dataset.view;
                if (view === 'list') {
                    resultsGrid?.classList.add('list-view');
                } else {
                    resultsGrid?.classList.remove('list-view');
                }

                localStorage.setItem('viewPreference', view);
            });
        });

        // Load saved view
        const savedView = localStorage.getItem('viewPreference');
        if (savedView) {
            viewBtns.forEach(btn => {
                btn.classList.remove('active');
                if (btn.dataset.view === savedView) {
                    btn.classList.add('active');
                    if (savedView === 'list') {
                        resultsGrid?.classList.add('list-view');
                    }
                }
            });
        }

        // ========================================
        // FILTER OPTIONS
        // ========================================
        filterOptions.forEach(option => {
            option.addEventListener('click', function() {
                const input = this.querySelector('input');
                if (!input) return;

                if (input.type === 'radio') {
                    const name = input.name;
                    document.querySelectorAll(`input[name="${name}"]`).forEach(inp => {
                        inp.closest('.filter-option')?.classList.remove('active');
                    });
                    input.checked = true;
                    this.classList.add('active');
                } else if (input.type === 'checkbox') {
                    input.checked = !input.checked;
                    this.classList.toggle('active', input.checked);
                }
            });
        });

        // ========================================
        // CLEAR FILTERS
        // ========================================
        function clearAllFilters() {
            const url = new URL(window.location.href);
            const q = url.searchParams.get('q');
            const location = url.searchParams.get('location');
            
            let newUrl = 'google_results.php?q=' + encodeURIComponent(q || '');
            if (location) {
                newUrl += '&location=' + encodeURIComponent(location);
            }
            window.location.href = newUrl;
        }

        // ========================================
        // FAVORITE BUTTONS
        // ========================================
        favoriteBtns.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const icon = this.querySelector('i');
                icon.classList.toggle('far');
                icon.classList.toggle('fas');
                this.classList.toggle('active');
                
                this.style.transform = 'scale(1.2)';
                setTimeout(() => {
                    this.style.transform = '';
                }, 200);
            });
        });

        // ========================================
        // SHARE BUTTONS
        // ========================================
        document.querySelectorAll('.card-btn.icon-only').forEach(btn => {
            btn.addEventListener('click', async function(e) {
                e.preventDefault();
                
                const card = this.closest('.business-card');
                const title = card.querySelector('.card-title').textContent.trim();
                const url = card.querySelector('.card-btn.primary')?.href || window.location.href;

                if (navigator.share) {
                    try {
                        await navigator.share({
                            title: title,
                            text: `Check out ${title} on Bharat Directory`,
                            url: url
                        });
                    } catch (err) {
                        console.log('Share cancelled');
                    }
                } else {
                    navigator.clipboard.writeText(url);
                    alert('Link copied to clipboard!');
                }
            });
        });
        // ========================================
        // SCROLL ANIMATIONS
        // ========================================
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }, index * 50);
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        document.querySelectorAll('.business-card').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(30px)';
            card.style.transition = 'all 0.5s ease';
            observer.observe(card);
        });

        // ========================================
        // INITIALIZE
        // ========================================
        handleBackToTop();
    </script>
</body>
</html>