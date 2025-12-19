<?php
// =============================================
// GOOGLE PLACE DETAILS PAGE
// =============================================

$API_KEY = "mykey"; // ADD YOUR SERVER KEY

$place_id = $_GET['place_id'] ?? '';

if (!$place_id) {
    header("Location: index.php");
    exit;
}

// Fetch Place Details
$fields = "place_id,name,formatted_address,formatted_phone_number,international_phone_number,geometry,opening_hours,photos,rating,reviews,types,url,user_ratings_total,website,price_level,address_components,business_status,vicinity";

$detailsUrl = "https://maps.googleapis.com/maps/api/place/details/json?place_id=" . urlencode($place_id) . "&fields=" . urlencode($fields) . "&key=" . $API_KEY;

$response = @file_get_contents($detailsUrl);
$data = json_decode($response, true);

if ($data['status'] !== 'OK' || empty($data['result'])) {
    $error = true;
    $errorMessage = $data['status'] ?? 'Unable to fetch business details';
} else {
    $error = false;
    $place = $data['result'];
}

// Helper Functions
function getPhotoUrl($photoRef, $apiKey, $maxWidth = 800) {
    if ($photoRef) {
        return "https://maps.googleapis.com/maps/api/place/photo?maxwidth={$maxWidth}&photoreference=" . $photoRef . "&key=" . $apiKey;
    }
    return "https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=800&h=500&fit=crop";
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
        'shopping' => 'fa-shopping-bag',
        'gym' => 'fa-dumbbell',
        'spa' => 'fa-spa',
        'beauty' => 'fa-cut',
        'car' => 'fa-car',
        'gas_station' => 'fa-gas-pump',
        'bank' => 'fa-university',
        'atm' => 'fa-credit-card',
        'pharmacy' => 'fa-pills',
        'lawyer' => 'fa-balance-scale',
        'real_estate' => 'fa-home',
        'electronics' => 'fa-laptop',
        'park' => 'fa-tree',
        'movie_theater' => 'fa-film',
        'bar' => 'fa-glass-martini-alt',
    ];
    
    if ($types) {
        foreach ($types as $type) {
            if (isset($iconMap[$type])) {
                return $iconMap[$type];
            }
        }
    }
    return 'fa-building';
}

function formatType($types) {
    if (empty($types)) return 'Business';
    $excludeTypes = ['point_of_interest', 'establishment', 'premise', 'political'];
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

function getBusinessStatus($status) {
    $statuses = [
        'OPERATIONAL' => ['text' => 'Operational', 'color' => '#10b981', 'icon' => 'fa-check-circle'],
        'CLOSED_TEMPORARILY' => ['text' => 'Temporarily Closed', 'color' => '#f59e0b', 'icon' => 'fa-clock'],
        'CLOSED_PERMANENTLY' => ['text' => 'Permanently Closed', 'color' => '#ef4444', 'icon' => 'fa-times-circle'],
    ];
    return $statuses[$status] ?? ['text' => 'Unknown', 'color' => '#64748b', 'icon' => 'fa-question-circle'];
}

function timeAgo($timestamp) {
    $diff = time() - $timestamp;
    if ($diff < 60) return 'Just now';
    if ($diff < 3600) return floor($diff / 60) . ' minutes ago';
    if ($diff < 86400) return floor($diff / 3600) . ' hours ago';
    if ($diff < 604800) return floor($diff / 86400) . ' days ago';
    if ($diff < 2592000) return floor($diff / 604800) . ' weeks ago';
    if ($diff < 31536000) return floor($diff / 2592000) . ' months ago';
    return floor($diff / 31536000) . ' years ago';
}

// Extract place data if available
if (!$error) {
    $name = $place['name'] ?? 'Unknown Business';
    $address = $place['formatted_address'] ?? 'Address not available';
    $phone = $place['formatted_phone_number'] ?? null;
    $intlPhone = $place['international_phone_number'] ?? null;
    $website = $place['website'] ?? null;
    $rating = $place['rating'] ?? 0;
    $totalRatings = $place['user_ratings_total'] ?? 0;
    $priceLevel = $place['price_level'] ?? null;
    $types = $place['types'] ?? [];
    $photos = $place['photos'] ?? [];
    $reviews = $place['reviews'] ?? [];
    $hours = $place['opening_hours'] ?? null;
    $isOpen = $hours['open_now'] ?? null;
    $weekdayText = $hours['weekday_text'] ?? [];
    $googleUrl = $place['url'] ?? '#';
    $lat = $place['geometry']['location']['lat'] ?? 0;
    $lng = $place['geometry']['location']['lng'] ?? 0;
    $businessStatus = $place['business_status'] ?? 'OPERATIONAL';
    $vicinity = $place['vicinity'] ?? '';
    
    $typeIcon = getTypeIcon($types);
    $formattedType = formatType($types);
    $statusInfo = getBusinessStatus($businessStatus);
    
    // Calculate star ratings
    $fullStars = floor($rating);
    $halfStar = ($rating - $fullStars) >= 0.5;
    $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
    
    // Get city from address components
    $city = '';
    $state = '';
    if (!empty($place['address_components'])) {
        foreach ($place['address_components'] as $component) {
            if (in_array('locality', $component['types'])) {
                $city = $component['long_name'];
            }
            if (in_array('administrative_area_level_1', $component['types'])) {
                $state = $component['short_name'];
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $error ? 'Business Not Found' : htmlspecialchars($name) ?> - Bharat Directory</title>
    <meta name="description" content="<?= $error ? 'Business not found' : htmlspecialchars($name . ' - ' . $formattedType . ' in ' . $address) ?>">
    
    <!-- Open Graph -->
    <meta property="og:title" content="<?= htmlspecialchars($name ?? 'Bharat Directory') ?>">
    <meta property="og:description" content="<?= $error ? 'Business not found' : htmlspecialchars($formattedType . ' in ' . $address) ?>">
    <?php if (!$error && !empty($photos)): ?>
    <meta property="og:image" content="<?= getPhotoUrl($photos[0]['photo_reference'], $API_KEY) ?>">
    <?php endif; ?>
    
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
            background: var(--light);
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
           HERO / GALLERY SECTION
        ======================================== */
        .hero-gallery {
            padding-top: 80px;
            background: var(--dark);
        }

        .gallery-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px 6%;
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .breadcrumb a {
            color: rgba(255, 255, 255, 0.7);
            transition: var(--transition);
        }

        .breadcrumb a:hover {
            color: var(--white);
        }

        .breadcrumb i.fa-chevron-right {
            color: rgba(255, 255, 255, 0.4);
            font-size: 10px;
        }

        .breadcrumb span {
            color: var(--primary);
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 15px;
            border-radius: var(--radius-xl);
            overflow: hidden;
        }

        .gallery-main {
            position: relative;
            height: 450px;
            cursor: pointer;
            overflow: hidden;
        }

        .gallery-main img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .gallery-main:hover img {
            transform: scale(1.05);
        }

        .gallery-main-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 30px;
            background: linear-gradient(transparent, rgba(0,0,0,0.8));
        }

        .gallery-main-overlay .business-type {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            padding: 8px 16px;
            border-radius: 100px;
            color: var(--white);
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .gallery-sidebar {
            display: grid;
            grid-template-rows: 1fr 1fr;
            gap: 15px;
        }

        .gallery-thumb {
            position: relative;
            cursor: pointer;
            overflow: hidden;
        }

        .gallery-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .gallery-thumb:hover img {
            transform: scale(1.1);
        }

        .gallery-more {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-weight: 600;
            gap: 5px;
            transition: var(--transition);
        }

        .gallery-more:hover {
            background: rgba(0, 0, 0, 0.7);
        }

        .gallery-more i {
            font-size: 28px;
        }

        /* ========================================
           MAIN CONTENT
        ======================================== */
        .main-content {
            max-width: 1400px;
            margin: 0 auto;
            padding: 40px 6%;
            display: grid;
            grid-template-columns: 1fr 380px;
            gap: 40px;
        }

        /* ========================================
           BUSINESS INFO SECTION
        ======================================== */
        .business-info-section {
            min-width: 0;
        }

        .business-header-card {
            background: var(--white);
            border-radius: var(--radius-xl);
            padding: 35px;
            box-shadow: var(--shadow-md);
            margin-bottom: 30px;
        }

        .business-header-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 20px;
            margin-bottom: 25px;
        }

        .business-title-area {
            flex: 1;
        }

        .business-badges-row {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 15px;
        }

        .badge {
            padding: 6px 14px;
            border-radius: 100px;
            font-size: 12px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .badge-verified {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
        }

        .badge-status {
            background: rgba(16, 185, 129, 0.1);
        }

        .badge-open {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
        }

        .badge-closed {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger);
        }

        .badge-category {
            background: rgba(255, 107, 53, 0.1);
            color: var(--primary);
        }

        .badge-price {
            background: var(--gray-100);
            color: var(--secondary);
        }

        .business-name {
            font-size: 32px;
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 10px;
            line-height: 1.2;
        }

        .business-rating-row {
            display: flex;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .rating-stars {
            display: flex;
            gap: 3px;
        }

        .rating-stars i {
            color: var(--warning);
            font-size: 18px;
        }

        .rating-stars i.empty {
            color: var(--gray-300);
        }

        .rating-score {
            font-size: 24px;
            font-weight: 800;
            color: var(--dark);
        }

        .rating-count {
            font-size: 15px;
            color: var(--gray-500);
        }

        .rating-count a {
            color: var(--primary);
            font-weight: 600;
        }

        .rating-count a:hover {
            text-decoration: underline;
        }

        .business-actions-header {
            display: flex;
            gap: 10px;
        }

        .business-quick-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            padding-top: 25px;
            border-top: 1px solid var(--gray-100);
        }

        .quick-info-item {
            display: flex;
            align-items: flex-start;
            gap: 15px;
        }

        .quick-info-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, rgba(255, 107, 53, 0.1), rgba(255, 107, 53, 0.15));
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-size: 20px;
            flex-shrink: 0;
        }

        .quick-info-content h4 {
            font-size: 13px;
            font-weight: 600;
            color: var(--gray-500);
            margin-bottom: 4px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .quick-info-content p {
            font-size: 15px;
            font-weight: 600;
            color: var(--dark);
        }

        .quick-info-content a {
            color: var(--primary);
        }

        .quick-info-content a:hover {
            text-decoration: underline;
        }

        /* ========================================
           CONTENT CARDS
        ======================================== */
        .content-card {
            background: var(--white);
            border-radius: var(--radius-xl);
            padding: 35px;
            box-shadow: var(--shadow-md);
            margin-bottom: 30px;
        }

        .content-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 2px solid var(--gray-100);
        }

        .content-card-title {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .content-card-title i {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-size: 18px;
        }

        .content-card-title h2 {
            font-size: 22px;
            font-weight: 700;
            color: var(--dark);
        }

        /* About Section */
        .about-text {
            font-size: 16px;
            color: var(--gray-600);
            line-height: 1.9;
            margin-bottom: 25px;
        }

        .about-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .about-tag {
            background: var(--gray-100);
            padding: 8px 18px;
            border-radius: 100px;
            font-size: 14px;
            color: var(--gray-600);
            transition: var(--transition);
        }

        .about-tag:hover {
            background: var(--primary);
            color: var(--white);
        }

        /* Hours Section */
        .hours-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .hours-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            background: var(--gray-100);
            border-radius: var(--radius-md);
            transition: var(--transition);
        }

        .hours-item:hover {
            background: var(--gray-200);
        }

        .hours-item.today {
            background: linear-gradient(135deg, rgba(255, 107, 53, 0.1), rgba(255, 107, 53, 0.15));
            border: 2px solid var(--primary);
        }

        .hours-day {
            font-weight: 600;
            color: var(--dark);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .hours-day .today-badge {
            background: var(--primary);
            color: var(--white);
            padding: 3px 10px;
            border-radius: 100px;
            font-size: 10px;
            font-weight: 700;
        }

        .hours-time {
            color: var(--gray-600);
        }

        .hours-time.closed {
            color: var(--danger);
            font-weight: 600;
        }

        /* Reviews Section */
        .reviews-summary {
            display: flex;
            gap: 40px;
            margin-bottom: 30px;
            padding-bottom: 30px;
            border-bottom: 1px solid var(--gray-100);
        }

        .reviews-score-big {
            text-align: center;
        }

        .reviews-score-big .score {
            font-size: 56px;
            font-weight: 800;
            color: var(--dark);
            line-height: 1;
        }

        .reviews-score-big .stars {
            display: flex;
            justify-content: center;
            gap: 4px;
            margin: 10px 0;
        }

        .reviews-score-big .stars i {
            color: var(--warning);
            font-size: 20px;
        }

        .reviews-score-big .count {
            color: var(--gray-500);
            font-size: 14px;
        }

        .reviews-breakdown {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .breakdown-row {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .breakdown-stars {
            display: flex;
            align-items: center;
            gap: 5px;
            min-width: 60px;
            font-size: 14px;
            color: var(--gray-600);
        }

        .breakdown-stars i {
            color: var(--warning);
        }

        .breakdown-bar {
            flex: 1;
            height: 10px;
            background: var(--gray-200);
            border-radius: 10px;
            overflow: hidden;
        }

        .breakdown-bar-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--warning), #fbbf24);
            border-radius: 10px;
            transition: width 1s ease;
        }

        .breakdown-count {
            min-width: 40px;
            text-align: right;
            font-size: 14px;
            color: var(--gray-500);
        }

        .review-card {
            background: var(--gray-100);
            border-radius: var(--radius-lg);
            padding: 25px;
            margin-bottom: 20px;
            transition: var(--transition);
        }

        .review-card:hover {
            background: var(--gray-200);
        }

        .review-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
        }

        .review-author {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .review-avatar {
            width: 55px;
            height: 55px;
            border-radius: var(--radius-full);
            object-fit: cover;
            border: 3px solid var(--white);
            box-shadow: var(--shadow-sm);
        }

        .review-author-info h4 {
            font-size: 16px;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 4px;
        }

        .review-author-info span {
            font-size: 13px;
            color: var(--gray-500);
        }

        .review-rating {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .review-rating .stars {
            display: flex;
            gap: 2px;
        }

        .review-rating .stars i {
            color: var(--warning);
            font-size: 14px;
        }

        .review-rating .score {
            font-weight: 700;
            color: var(--dark);
        }

        .review-text {
            font-size: 15px;
            color: var(--gray-600);
            line-height: 1.8;
            margin-bottom: 15px;
        }

        .review-actions {
            display: flex;
            gap: 20px;
        }

        .review-action {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: var(--gray-500);
            cursor: pointer;
            transition: var(--transition);
        }

        .review-action:hover {
            color: var(--primary);
        }

        .no-reviews {
            text-align: center;
            padding: 50px 30px;
            background: var(--gray-100);
            border-radius: var(--radius-lg);
        }

        .no-reviews i {
            font-size: 50px;
            color: var(--gray-300);
            margin-bottom: 20px;
        }

        .no-reviews h3 {
            font-size: 20px;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 10px;
        }

        .no-reviews p {
            color: var(--gray-500);
            margin-bottom: 20px;
        }

        /* ========================================
           SIDEBAR
        ======================================== */
        .sidebar {
            position: sticky;
            top: 100px;
            height: fit-content;
        }

        .sidebar-card {
            background: var(--white);
            border-radius: var(--radius-xl);
            padding: 30px;
            box-shadow: var(--shadow-md);
            margin-bottom: 25px;
        }

        .sidebar-card-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar-card-title i {
            color: var(--primary);
        }

        /* Contact Card */
        .contact-item {
            display: flex;
            align-items: flex-start;
            gap: 15px;
            padding: 18px 0;
            border-bottom: 1px solid var(--gray-100);
        }

        .contact-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .contact-item:first-child {
            padding-top: 0;
        }

        .contact-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, rgba(255, 107, 53, 0.1), rgba(255, 107, 53, 0.15));
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-size: 18px;
            flex-shrink: 0;
        }

        .contact-content h4 {
            font-size: 12px;
            font-weight: 600;
            color: var(--gray-500);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }

        .contact-content p,
        .contact-content a {
            font-size: 15px;
            font-weight: 600;
            color: var(--dark);
        }

        .contact-content a {
            color: var(--primary);
        }

        .contact-content a:hover {
            text-decoration: underline;
        }

        .contact-buttons {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-top: 25px;
        }

        .contact-buttons .btn {
            width: 100%;
            justify-content: center;
        }

        /* Map Card */
        .map-container {
            border-radius: var(--radius-lg);
            overflow: hidden;
            margin-bottom: 15px;
        }

        .map-container iframe {
            display: block;
            width: 100%;
            height: 200px;
        }

        .map-address {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 15px;
        }

        .map-address i {
            color: var(--primary);
            margin-top: 3px;
        }

        .map-address p {
            font-size: 14px;
            color: var(--gray-600);
            line-height: 1.6;
        }

        .map-actions {
            display: flex;
            gap: 10px;
        }

        .map-actions .btn {
            flex: 1;
            justify-content: center;
        }

        /* Share Card */
        .share-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .share-btn {
            flex: 1;
            min-width: 60px;
            height: 50px;
            border: none;
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: var(--white);
            cursor: pointer;
            transition: var(--transition);
        }

        .share-btn:hover {
            transform: translateY(-3px);
        }

        .share-btn.facebook { background: #1877f2; }
        .share-btn.twitter { background: #1da1f2; }
        .share-btn.whatsapp { background: #25d366; }
        .share-btn.linkedin { background: #0a66c2; }
        .share-btn.copy { background: var(--gray-700); }

        /* Quick Links Card */
        .quick-links-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .quick-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px 18px;
            background: var(--gray-100);
            border-radius: var(--radius-md);
            transition: var(--transition);
        }

        .quick-link:hover {
            background: var(--gray-200);
            transform: translateX(5px);
        }

        .quick-link-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .quick-link-left i {
            color: var(--primary);
            font-size: 18px;
            width: 25px;
        }

        .quick-link-left span {
            font-weight: 600;
            color: var(--dark);
        }

        .quick-link-right i {
            color: var(--gray-400);
        }

        /* ========================================
           SIMILAR BUSINESSES SECTION
        ======================================== */
        .similar-section {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 6% 60px;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .section-header h2 {
            font-size: 28px;
            font-weight: 800;
            color: var(--dark);
        }

        .section-header a {
            color: var(--primary);
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-header a:hover {
            text-decoration: underline;
        }

        .similar-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
        }

        .similar-card {
            background: var(--white);
            border-radius: var(--radius-xl);
            overflow: hidden;
            box-shadow: var(--shadow-md);
            transition: var(--transition);
        }

        .similar-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-xl);
        }

        .similar-image {
            height: 180px;
            overflow: hidden;
        }

        .similar-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .similar-card:hover .similar-image img {
            transform: scale(1.1);
        }

        .similar-content {
            padding: 20px;
        }

        .similar-content h3 {
            font-size: 18px;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 8px;
        }

        .similar-content .rating {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 10px;
        }

        .similar-content .rating i {
            color: var(--warning);
        }

        .similar-content .rating span {
            font-weight: 600;
            color: var(--dark);
        }

        .similar-content .rating small {
            color: var(--gray-500);
        }

        .similar-content .address {
            font-size: 14px;
            color: var(--gray-500);
            display: flex;
            align-items: flex-start;
            gap: 8px;
        }

        .similar-content .address i {
            color: var(--primary);
            margin-top: 3px;
        }

        /* ========================================
           ERROR STATE
        ======================================== */
        .error-section {
            max-width: 600px;
            margin: 150px auto;
            padding: 60px;
            text-align: center;
            background: var(--white);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-lg);
        }

        .error-icon {
            width: 120px;
            height: 120px;
            background: var(--gray-100);
            border-radius: var(--radius-full);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
        }

        .error-icon i {
            font-size: 50px;
            color: var(--gray-400);
        }

        .error-section h1 {
            font-size: 28px;
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 15px;
        }

        .error-section p {
            color: var(--gray-500);
            margin-bottom: 30px;
        }

        /* ========================================
           LIGHTBOX
        ======================================== */
        .lightbox {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.95);
            z-index: 2000;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            visibility: hidden;
            transition: var(--transition);
        }

        .lightbox.active {
            opacity: 1;
            visibility: visible;
        }

        .lightbox-close {
            position: absolute;
            top: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.1);
            border: none;
            border-radius: var(--radius-full);
            color: var(--white);
            font-size: 24px;
            cursor: pointer;
            transition: var(--transition);
        }

        .lightbox-close:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .lightbox-content {
            max-width: 90%;
            max-height: 90%;
        }

        .lightbox-content img {
            max-width: 100%;
            max-height: 85vh;
            border-radius: var(--radius-lg);
        }

        .lightbox-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.1);
            border: none;
            border-radius: var(--radius-full);
            color: var(--white);
            font-size: 24px;
            cursor: pointer;
            transition: var(--transition);
        }

        .lightbox-nav:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .lightbox-prev {
            left: 30px;
        }

        .lightbox-next {
            right: 30px;
        }

        .lightbox-counter {
            position: absolute;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            color: var(--white);
            font-size: 16px;
        }

        /* ========================================
           FOOTER
        ======================================== */

        /* ========================================
           BACK TO TOP
        ======================================== */
        .back-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-size: 18px;
            box-shadow: 0 8px 25px rgba(255, 107, 53, 0.35);
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
           RESPONSIVE
        ======================================== */
        @media (max-width: 1200px) {
            .main-content {
                grid-template-columns: 1fr 320px;
            }

            .gallery-grid {
                grid-template-columns: 1fr;
            }

            .gallery-main {
                height: 350px;
            }

            .gallery-sidebar {
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

            .main-content {
                grid-template-columns: 1fr;
            }

            .sidebar {
                position: relative;
                top: 0;
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 25px;
            }

            .footer-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .gallery-main {
                height: 280px;
            }

            .business-header-top {
                flex-direction: column;
            }

            .business-actions-header {
                width: 100%;
            }

            .business-actions-header .btn {
                flex: 1;
            }

            .business-name {
                font-size: 26px;
            }

            .reviews-summary {
                flex-direction: column;
                gap: 25px;
            }

            .sidebar {
                grid-template-columns: 1fr;
            }

            .section-header {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }

            .similar-grid {
                grid-template-columns: 1fr;
            }

            .footer-grid {
                grid-template-columns: 1fr;
                gap: 30px;
            }

            .footer-bottom {
                flex-direction: column;
                text-align: center;
            }

            .footer-links {
                flex-wrap: wrap;
                justify-content: center;
            }

            .lightbox-nav {
                width: 45px;
                height: 45px;
                font-size: 18px;
            }

            .lightbox-prev {
                left: 15px;
            }

            .lightbox-next {
                right: 15px;
            }
        }

        @media (max-width: 480px) {
            .navbar {
                padding: 12px 5%;
            }

            .logo-icon {
                width: 38px;
                height: 38px;
                font-size: 16px;
            }

            .logo-main {
                font-size: 18px;
            }

            .gallery-container {
                padding: 15px 5%;
            }

            .gallery-main {
                height: 220px;
            }

            .main-content {
                padding: 25px 5%;
            }

            .business-header-card,
            .content-card,
            .sidebar-card {
                padding: 25px 20px;
            }

            .business-name {
                font-size: 22px;
            }

            .rating-score {
                font-size: 20px;
            }

            .content-card-title h2 {
                font-size: 18px;
            }

            .review-card {
                padding: 20px;
            }

            .share-btn {
                min-width: 50px;
                height: 45px;
                font-size: 16px;
            }

            .back-to-top {
                width: 45px;
                height: 45px;
                bottom: 20px;
                right: 20px;
            }
        }
    </style>
</head>
<body>

    <!-- NAVBAR -->
    <?php include 'header.php';?>

    <?php if ($error): ?>
    <!-- ERROR STATE -->
    <div class="error-section">
        <div class="error-icon">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <h1>Business Not Found</h1>
        <p>We couldn't find the business you're looking for. It may have been removed or the link is incorrect.</p>
        <a href="index.php" class="btn btn-primary btn-lg">
            <i class="fas fa-home"></i>
            Back to Home
        </a>
    </div>

    <?php else: ?>

    <!-- GALLERY SECTION -->
    <section class="hero-gallery">
        <div class="gallery-container">
            <!-- Breadcrumb -->
            <nav class="breadcrumb">
                <a href="index.php"><i class="fas fa-home"></i> Home</a>
                <i class="fas fa-chevron-right"></i>
                <a href="google_results.php?q=<?= urlencode($formattedType) ?>">
                    <?= htmlspecialchars($formattedType) ?>
                </a>
                <i class="fas fa-chevron-right"></i>
                <span><?= htmlspecialchars($name) ?></span>
            </nav>

            <!-- Photo Gallery -->
            <div class="gallery-grid">
                <div class="gallery-main" onclick="openLightbox(0)">
                    <img src="<?= getPhotoUrl($photos[0]['photo_reference'] ?? '', $API_KEY) ?>" alt="<?= htmlspecialchars($name) ?>">
                    <div class="gallery-main-overlay">
                        <div class="business-type">
                            <i class="fas <?= $typeIcon ?>"></i>
                            <?= htmlspecialchars($formattedType) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- MAIN CONTENT -->
    <div class="main-content">
        <!-- LEFT COLUMN - Business Info -->
        <div class="business-info-section">
            <!-- Business Header Card -->
            <div class="business-header-card">
                <div class="business-header-top">
                    <div class="business-title-area">
                        <div class="business-badges-row">
                            <?php if ($businessStatus === 'OPERATIONAL'): ?>
                            <span class="badge badge-verified">
                                <i class="fas fa-check-circle"></i> Verified
                            </span>
                            <?php endif; ?>
                            
                            <?php if ($isOpen === true): ?>
                            <span class="badge badge-open">
                                <i class="fas fa-clock"></i> Open Now
                            </span>
                            <?php elseif ($isOpen === false): ?>
                            <span class="badge badge-closed">
                                <i class="fas fa-clock"></i> Closed
                            </span>
                            <?php endif; ?>
                            
                            <span class="badge badge-category">
                                <i class="fas <?= $typeIcon ?>"></i> <?= htmlspecialchars($formattedType) ?>
                            </span>
                            
                            <?php if ($priceLevel !== null): ?>
                            <span class="badge badge-price">
                                <?= getPriceLevel($priceLevel) ?>
                            </span>
                            <?php endif; ?>
                        </div>
                        
                        <h1 class="business-name"><?= htmlspecialchars($name) ?></h1>
                        
                        <div class="business-rating-row">
                            <?php if ($rating > 0): ?>
                            <div class="rating-stars">
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
                            <span class="rating-score"><?= number_format($rating, 1) ?></span>
                            <span class="rating-count">
                                <a href="#reviews"><?= number_format($totalRatings) ?> reviews</a>
                            </span>
                            <?php else: ?>
                            <span class="rating-count">No reviews yet</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="business-actions-header">
                        <button class="btn btn-secondary btn-icon" id="saveBtn" title="Save">
                            <i class="far fa-bookmark"></i>
                        </button>
                        <button class="btn btn-secondary btn-icon" id="shareBtn" title="Share">
                            <i class="fas fa-share-alt"></i>
                        </button>
                    </div>
                </div>
                
                <div class="business-quick-info">
                    <div class="quick-info-item">
                        <div class="quick-info-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="quick-info-content">
                            <h4>Address</h4>
                            <p><?= htmlspecialchars($address) ?></p>
                        </div>
                    </div>
                    
                    <?php if ($phone): ?>
                    <div class="quick-info-item">
                        <div class="quick-info-icon">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div class="quick-info-content">
                            <h4>Phone</h4>
                            <p><a href="tel:<?= htmlspecialchars($intlPhone ?? $phone) ?>"><?= htmlspecialchars($phone) ?></a></p>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <?php if ($website): ?>
                    <div class="quick-info-item">
                        <div class="quick-info-icon">
                            <i class="fas fa-globe"></i>
                        </div>
                        <div class="quick-info-content">
                            <h4>Website</h4>
                            <p><a href="<?= htmlspecialchars($website) ?>" target="_blank" rel="noopener">Visit Website</a></p>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <div class="quick-info-item">
                        <div class="quick-info-icon" style="background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(16, 185, 129, 0.15)); color: var(--success);">
                            <i class="fas <?= $statusInfo['icon'] ?>"></i>
                        </div>
                        <div class="quick-info-content">
                            <h4>Status</h4>
                            <p style="color: <?= $statusInfo['color'] ?>"><?= $statusInfo['text'] ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- About Section -->
            <div class="content-card">
                <div class="content-card-header">
                    <div class="content-card-title">
                        <i class="fas fa-info-circle"></i>
                        <h2>About This Business</h2>
                    </div>
                </div>
                <p class="about-text">
                    Welcome to <strong><?= htmlspecialchars($name) ?></strong>, a trusted <?= strtolower($formattedType) ?> located in <?= htmlspecialchars($city ?: $vicinity) ?>.
                    <?php if ($rating >= 4.5): ?>
                    With an excellent rating of <?= number_format($rating, 1) ?> stars based on <?= number_format($totalRatings) ?> reviews, we are committed to providing exceptional service to all our customers.
                    <?php elseif ($rating >= 4): ?>
                    Highly rated with <?= number_format($rating, 1) ?> stars from <?= number_format($totalRatings) ?> satisfied customers.
                    <?php elseif ($rating > 0): ?>
                    Rated <?= number_format($rating, 1) ?> stars by our <?= number_format($totalRatings) ?> customers.
                    <?php else: ?>
                    We look forward to serving you and earning your valuable feedback.
                    <?php endif; ?>
                </p>
                <p class="about-text">
                    <?php if ($isOpen === true): ?>
                    We are currently <strong style="color: var(--success);">open</strong> and ready to serve you. 
                    <?php elseif ($isOpen === false): ?>
                    We are currently <strong style="color: var(--danger);">closed</strong>. Please check our opening hours below for when we'll be available next.
                    <?php endif; ?>
                    For more information, feel free to call us or visit our location at <?= htmlspecialchars($address) ?>.
                </p>
                
                <?php if (!empty($types)): ?>
                <div class="about-tags">
                    <?php 
                    $excludeTypes = ['point_of_interest', 'establishment', 'premise', 'political', 'locality', 'sublocality'];
                    foreach ($types as $type): 
                        if (!in_array($type, $excludeTypes)):
                    ?>
                    <span class="about-tag"><?= ucwords(str_replace('_', ' ', $type)) ?></span>
                    <?php 
                        endif;
                    endforeach; 
                    ?>
                </div>
                <?php endif; ?>
            </div>

            <!-- Opening Hours -->
            <?php if (!empty($weekdayText)): ?>
            <div class="content-card">
                <div class="content-card-header">
                    <div class="content-card-title">
                        <i class="fas fa-clock"></i>
                        <h2>Opening Hours</h2>
                    </div>
                    <?php if ($isOpen === true): ?>
                    <span class="badge badge-open"><i class="fas fa-door-open"></i> Open Now</span>
                    <?php elseif ($isOpen === false): ?>
                    <span class="badge badge-closed"><i class="fas fa-door-closed"></i> Closed</span>
                    <?php endif; ?>
                </div>
                <div class="hours-list">
                    <?php 
                    $daysOrder = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                    $today = date('l');
                    
                    foreach ($weekdayText as $dayHours):
                        $parts = explode(': ', $dayHours, 2);
                        $day = $parts[0] ?? '';
                        $time = $parts[1] ?? '';
                        $isToday = (strpos($day, $today) !== false);
                        $isClosed = (stripos($time, 'closed') !== false);
                    ?>
                    <div class="hours-item <?= $isToday ? 'today' : '' ?>">
                        <span class="hours-day">
                            <?= htmlspecialchars($day) ?>
                            <?php if ($isToday): ?>
                            <span class="today-badge">TODAY</span>
                            <?php endif; ?>
                        </span>
                        <span class="hours-time <?= $isClosed ? 'closed' : '' ?>">
                            <?= htmlspecialchars($time) ?>
                        </span>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Reviews Section -->
            <div class="content-card" id="reviews">
                <div class="content-card-header">
                    <div class="content-card-title">
                        <i class="fas fa-star"></i>
                        <h2>Reviews & Ratings</h2>
                    </div>
                    <a href="<?= htmlspecialchars($googleUrl) ?>" target="_blank" class="btn btn-sm btn-outline">
                        <i class="fab fa-google"></i> Write a Review
                    </a>
                </div>
                
                <?php if (!empty($reviews)): ?>
                <!-- Reviews Summary -->
                <div class="reviews-summary">
                    <div class="reviews-score-big">
                        <div class="score"><?= number_format($rating, 1) ?></div>
                        <div class="stars">
                            <?php for ($i = 0; $i < $fullStars; $i++): ?>
                            <i class="fas fa-star"></i>
                            <?php endfor; ?>
                            <?php if ($halfStar): ?>
                            <i class="fas fa-star-half-alt"></i>
                            <?php endif; ?>
                            <?php for ($i = 0; $i < $emptyStars; $i++): ?>
                            <i class="fas fa-star" style="color: var(--gray-300)"></i>
                            <?php endfor; ?>
                        </div>
                        <div class="count"><?= number_format($totalRatings) ?> reviews</div>
                    </div>
                    <div class="reviews-breakdown">
                        <?php
                        // Calculate rating distribution (simplified estimation)
                        $distribution = [5 => 60, 4 => 25, 3 => 10, 2 => 3, 1 => 2];
                        if ($rating >= 4.5) {
                            $distribution = [5 => 70, 4 => 20, 3 => 7, 2 => 2, 1 => 1];
                        } elseif ($rating >= 4) {
                            $distribution = [5 => 50, 4 => 30, 3 => 12, 2 => 5, 1 => 3];
                        } elseif ($rating >= 3) {
                            $distribution = [5 => 25, 4 => 25, 3 => 30, 2 => 12, 1 => 8];
                        }
                        
                        for ($star = 5; $star >= 1; $star--):
                            $count = round($totalRatings * $distribution[$star] / 100);
                            $percentage = $distribution[$star];
                        ?>
                        <div class="breakdown-row">
                            <div class="breakdown-stars">
                                <i class="fas fa-star"></i>
                                <?= $star ?>
                            </div>
                            <div class="breakdown-bar">
                                <div class="breakdown-bar-fill" style="width: <?= $percentage ?>%"></div>
                            </div>
                            <div class="breakdown-count"><?= number_format($count) ?></div>
                        </div>
                        <?php endfor; ?>
                    </div>
                </div>
                
                <!-- Review Cards -->
                <?php foreach ($reviews as $review): ?>
                <?php
                    $reviewRating = $review['rating'] ?? 0;
                    $authorName = $review['author_name'] ?? 'Anonymous';
                    $authorPhoto = $review['profile_photo_url'] ?? 'https://ui-avatars.com/api/?name=' . urlencode($authorName) . '&background=random';
                    $reviewText = $review['text'] ?? '';
                    $reviewTime = $review['time'] ?? 0;
                    $relativeTime = $review['relative_time_description'] ?? timeAgo($reviewTime);
                ?>
                <div class="review-card">
                    <div class="review-header">
                        <div class="review-author">
                            <img src="<?= htmlspecialchars($authorPhoto) ?>" alt="<?= htmlspecialchars($authorName) ?>" class="review-avatar">
                            <div class="review-author-info">
                                <h4><?= htmlspecialchars($authorName) ?></h4>
                                <span><?= htmlspecialchars($relativeTime) ?></span>
                            </div>
                        </div>
                        <div class="review-rating">
                            <div class="stars">
                                <?php for ($i = 0; $i < 5; $i++): ?>
                                <i class="fas fa-star" style="color: <?= $i < $reviewRating ? 'var(--warning)' : 'var(--gray-300)' ?>"></i>
                                <?php endfor; ?>
                            </div>
                            <span class="score"><?= $reviewRating ?>.0</span>
                        </div>
                    </div>
                    <?php if ($reviewText): ?>
                    <p class="review-text"><?= nl2br(htmlspecialchars($reviewText)) ?></p>
                    <?php endif; ?>
                    <div class="review-actions">
                        <span class="review-action">
                            <i class="far fa-thumbs-up"></i> Helpful
                        </span>
                        <span class="review-action">
                            <i class="far fa-flag"></i> Report
                        </span>
                    </div>
                </div>
                <?php endforeach; ?>
                
                <?php if ($totalRatings > count($reviews)): ?>
                <div style="text-align: center; margin-top: 25px;">
                    <a href="<?= htmlspecialchars($googleUrl) ?>" target="_blank" class="btn btn-outline">
                        <i class="fab fa-google"></i>
                        View All <?= number_format($totalRatings) ?> Reviews on Google
                    </a>
                </div>
                <?php endif; ?>
                
                <?php else: ?>
                <div class="no-reviews">
                    <i class="far fa-comment-dots"></i>
                    <h3>No Reviews Yet</h3>
                    <p>Be the first to share your experience!</p>
                    <a href="<?= htmlspecialchars($googleUrl) ?>" target="_blank" class="btn btn-primary">
                        <i class="fas fa-star"></i>
                        Write a Review
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- RIGHT COLUMN - Sidebar -->
        <aside class="sidebar">
            <!-- Contact Card -->
            <div class="sidebar-card">
                <h3 class="sidebar-card-title">
                    <i class="fas fa-address-card"></i>
                    Contact Information
                </h3>
                
                <?php if ($phone): ?>
                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <div class="contact-content">
                        <h4>Phone</h4>
                        <a href="tel:<?= htmlspecialchars($intlPhone ?? $phone) ?>"><?= htmlspecialchars($phone) ?></a>
                    </div>
                </div>
                <?php endif; ?>
                
                <?php if ($website): ?>
                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-globe"></i>
                    </div>
                    <div class="contact-content">
                        <h4>Website</h4>
                        <a href="<?= htmlspecialchars($website) ?>" target="_blank" rel="noopener">
                            <?= parse_url($website, PHP_URL_HOST) ?>
                        </a>
                    </div>
                </div>
                <?php endif; ?>
                
                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fab fa-google"></i>
                    </div>
                    <div class="contact-content">
                        <h4>Google Maps</h4>
                        <a href="<?= htmlspecialchars($googleUrl) ?>" target="_blank">View on Google</a>
                    </div>
                </div>
                
                <div class="contact-buttons">
                    <?php if ($phone): ?>
                    <a href="tel:<?= htmlspecialchars($intlPhone ?? $phone) ?>" class="btn btn-success btn-lg">
                        <i class="fas fa-phone-alt"></i>
                        Call Now
                    </a>
                    <?php endif; ?>
                    <a href="<?= htmlspecialchars($googleUrl) ?>" target="_blank" class="btn btn-primary">
                        <i class="fas fa-directions"></i>
                        Get Directions
                    </a>
                    <?php if ($website): ?>
                    <a href="<?= htmlspecialchars($website) ?>" target="_blank" class="btn btn-secondary">
                        <i class="fas fa-globe"></i>
                        Visit Website
                    </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Map Card -->
            <div class="sidebar-card">
                <h3 class="sidebar-card-title">
                    <i class="fas fa-map-marked-alt"></i>
                    Location
                </h3>
                <div class="map-container">
                    <iframe 
                        src="https://www.google.com/maps/embed/v1/place?key=<?= $API_KEY ?>&q=place_id:<?= urlencode($place_id) ?>"
                        allowfullscreen 
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
                <div class="map-address">
                    <i class="fas fa-map-marker-alt"></i>
                    <p><?= htmlspecialchars($address) ?></p>
                </div>
                <div class="map-actions">
                    <a href="https://www.google.com/maps/dir/?api=1&destination=<?= urlencode($address) ?>&destination_place_id=<?= urlencode($place_id) ?>" target="_blank" class="btn btn-primary">
                        <i class="fas fa-directions"></i>
                        Directions
                    </a>
                    <a href="<?= htmlspecialchars($googleUrl) ?>" target="_blank" class="btn btn-secondary">
                        <i class="fas fa-external-link-alt"></i>
                        Open Map
                    </a>
                </div>
            </div>

            <!-- Share Card -->
            <div class="sidebar-card">
                <h3 class="sidebar-card-title">
                    <i class="fas fa-share-alt"></i>
                    Share This Business
                </h3>
                <div class="share-buttons">
                    <button class="share-btn facebook" onclick="shareOn('facebook')" title="Share on Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </button>
                    <button class="share-btn twitter" onclick="shareOn('twitter')" title="Share on Twitter">
                        <i class="fab fa-twitter"></i>
                    </button>
                    <button class="share-btn whatsapp" onclick="shareOn('whatsapp')" title="Share on WhatsApp">
                        <i class="fab fa-whatsapp"></i>
                    </button>
                    <button class="share-btn linkedin" onclick="shareOn('linkedin')" title="Share on LinkedIn">
                        <i class="fab fa-linkedin-in"></i>
                    </button>
                    <button class="share-btn copy" onclick="copyLink()" title="Copy Link">
                        <i class="fas fa-link"></i>
                    </button>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="sidebar-card">
                <h3 class="sidebar-card-title">
                    <i class="fas fa-bolt"></i>
                    Quick Links
                </h3>
                <div class="quick-links-list">
                    <a href="#reviews" class="quick-link">
                        <div class="quick-link-left">
                            <i class="fas fa-star"></i>
                            <span>Reviews</span>
                        </div>
                        <i class="fas fa-chevron-right quick-link-right"></i>
                    </a>
                    <a href="<?= htmlspecialchars($googleUrl) ?>" target="_blank" class="quick-link">
                        <div class="quick-link-left">
                            <i class="fab fa-google"></i>
                            <span>Google Maps</span>
                        </div>
                        <i class="fas fa-external-link-alt quick-link-right"></i>
                    </a>
                    <a href="google_results.php?q=<?= urlencode($formattedType . ' near ' . ($city ?: $vicinity)) ?>" class="quick-link">
                        <div class="quick-link-left">
                            <i class="fas fa-search"></i>
                            <span>Similar Nearby</span>
                        </div>
                        <i class="fas fa-chevron-right quick-link-right"></i>
                    </a>
                    <a href="report.php?place_id=<?= urlencode($place_id) ?>" class="quick-link">
                        <div class="quick-link-left">
                            <i class="fas fa-flag"></i>
                            <span>Report Issue</span>
                        </div>
                        <i class="fas fa-chevron-right quick-link-right"></i>
                    </a>
                </div>
            </div>
        </aside>
    </div>

    <!-- Similar Businesses Section -->
    <section class="similar-section">
        <div class="section-header">
            <h2>Similar <?= htmlspecialchars($formattedType) ?>s Nearby</h2>
            <a href="google_results.php?q=<?= urlencode($formattedType) ?>&location=<?= urlencode($city ?: $vicinity) ?>">
                View All <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        <div class="similar-grid">
            <!-- Similar business cards would be loaded dynamically -->
            <div class="similar-card">
                <div class="similar-image">
                    <img src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=400&h=250&fit=crop" alt="Similar Business">
                </div>
                <div class="similar-content">
                    <h3>Similar Business 1</h3>
                    <div class="rating">
                        <i class="fas fa-star"></i>
                        <span>4.5</span>
                        <small>(120 reviews)</small>
                    </div>
                    <div class="address">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Nearby Location</span>
                    </div>
                </div>
            </div>
            <div class="similar-card">
                <div class="similar-image">
                    <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?w=400&h=250&fit=crop" alt="Similar Business">
                </div>
                <div class="similar-content">
                    <h3>Similar Business 2</h3>
                    <div class="rating">
                        <i class="fas fa-star"></i>
                        <span>4.3</span>
                        <small>(85 reviews)</small>
                    </div>
                    <div class="address">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Nearby Location</span>
                    </div>
                </div>
            </div>
            <div class="similar-card">
                <div class="similar-image">
                    <img src="https://images.unsplash.com/photo-1560472355-536de3962603?w=400&h=250&fit=crop" alt="Similar Business">
                </div>
                <div class="similar-content">
                    <h3>Similar Business 3</h3>
                    <div class="rating">
                        <i class="fas fa-star"></i>
                        <span>4.7</span>
                        <small>(200 reviews)</small>
                    </div>
                    <div class="address">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Nearby Location</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Lightbox -->
    <div class="lightbox" id="lightbox">
        <button class="lightbox-close" onclick="closeLightbox()">
            <i class="fas fa-times"></i>
        </button>
        <button class="lightbox-nav lightbox-prev" onclick="changeSlide(-1)">
            <i class="fas fa-chevron-left"></i>
        </button>
        <div class="lightbox-content">
            <img src="" alt="Gallery Image" id="lightboxImage">
        </div>
        <button class="lightbox-nav lightbox-next" onclick="changeSlide(1)">
            <i class="fas fa-chevron-right"></i>
        </button>
        <div class="lightbox-counter">
            <span id="currentSlide">1</span> / <span id="totalSlides"><?= count($photos) ?></span>
        </div>
    </div>

    <?php endif; ?>

    <!-- FOOTER -->
    <?php include 'footer.php';?>

    <!-- Back to Top -->
    <a href="#" class="back-to-top" id="backToTop">
        <i class="fas fa-arrow-up"></i>
    </a>

    <!-- JavaScript -->
    <script>
        // ========================================
        // BUSINESS DATA (for sharing)
        // ========================================
        const businessData = {
            name: <?= json_encode($name ?? '') ?>,
            url: window.location.href,
            address: <?= json_encode($address ?? '') ?>
        };

        // ========================================
        // PHOTO GALLERY DATA
        // ========================================
        const photos = [
            <?php foreach ($photos as $photo): ?>
            "<?= getPhotoUrl($photo['photo_reference'] ?? '', $API_KEY) ?>",
            <?php endforeach; ?>
        ];
        let currentSlideIndex = 0;

        // ========================================
        // LIGHTBOX FUNCTIONS
        // ========================================
        function openLightbox(index) {
            currentSlideIndex = index;
            updateLightbox();
            document.getElementById('lightbox').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            document.getElementById('lightbox').classList.remove('active');
            document.body.style.overflow = '';
        }

        function changeSlide(direction) {
            currentSlideIndex += direction;
            if (currentSlideIndex < 0) currentSlideIndex = photos.length - 1;
            if (currentSlideIndex >= photos.length) currentSlideIndex = 0;
            updateLightbox();
        }

        function updateLightbox() {
            document.getElementById('lightboxImage').src = photos[currentSlideIndex] || photos[0];
            document.getElementById('currentSlide').textContent = currentSlideIndex + 1;
        }

        // Keyboard navigation
        document.addEventListener('keydown', (e) => {
            if (document.getElementById('lightbox').classList.contains('active')) {
                if (e.key === 'Escape') closeLightbox();
                if (e.key === 'ArrowLeft') changeSlide(-1);
                if (e.key === 'ArrowRight') changeSlide(1);
            }
        });

        // Close lightbox on overlay click
        document.getElementById('lightbox')?.addEventListener('click', (e) => {
            if (e.target.id === 'lightbox') closeLightbox();
        });

        // ========================================
        // SHARE FUNCTIONS
        // ========================================
        function shareOn(platform) {
            const url = encodeURIComponent(businessData.url);
            const text = encodeURIComponent(`Check out ${businessData.name} on Bharat Directory!`);
            
            let shareUrl;
            switch(platform) {
                case 'facebook':
                    shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${url}`;
                    break;
                case 'twitter':
                    shareUrl = `https://twitter.com/intent/tweet?url=${url}&text=${text}`;
                    break;
                case 'whatsapp':
                    shareUrl = `https://wa.me/?text=${text}%20${url}`;
                    break;
                case 'linkedin':
                    shareUrl = `https://www.linkedin.com/sharing/share-offsite/?url=${url}`;
                    break;
            }
            
            window.open(shareUrl, '_blank', 'width=600,height=400');
        }

        function copyLink() {
            navigator.clipboard.writeText(businessData.url).then(() => {
                alert('Link copied to clipboard!');
            }).catch(() => {
                // Fallback
                const input = document.createElement('input');
                input.value = businessData.url;
                document.body.appendChild(input);
                input.select();
                document.execCommand('copy');
                document.body.removeChild(input);
                alert('Link copied to clipboard!');
            });
        }

        // Native share if available
        document.getElementById('shareBtn')?.addEventListener('click', async () => {
            if (navigator.share) {
                try {
                    await navigator.share({
                        title: businessData.name,
                        text: `Check out ${businessData.name} on Bharat Directory!`,
                        url: businessData.url
                    });
                } catch (err) {
                    console.log('Share cancelled');
                }
            } else {
                // Scroll to share buttons
                document.querySelector('.share-buttons')?.scrollIntoView({ behavior: 'smooth' });
            }
        });

        // ========================================
        // SAVE BUTTON
        // ========================================
        document.getElementById('saveBtn')?.addEventListener('click', function() {
            const icon = this.querySelector('i');
            icon.classList.toggle('far');
            icon.classList.toggle('fas');
            
            if (icon.classList.contains('fas')) {
                this.style.background = 'rgba(255, 107, 53, 0.1)';
                icon.style.color = 'var(--primary)';
                alert('Business saved to your favorites!');
            } else {
                this.style.background = '';
                icon.style.color = '';
            }
        });

        // ========================================
        // BACK TO TOP
        // ========================================
        const backToTop = document.getElementById('backToTop');

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
        // SMOOTH SCROLL
        // ========================================
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                if (href !== '#') {
                    e.preventDefault();
                    const target = document.querySelector(href);
                    if (target) {
                        const offsetTop = target.offsetTop - 100;
                        window.scrollTo({ top: offsetTop, behavior: 'smooth' });
                    }
                }
            });
        });

        // ========================================
        // ANIMATE ON SCROLL
        // ========================================
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        document.querySelectorAll('.content-card, .sidebar-card, .similar-card, .review-card').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'all 0.6s ease';
            observer.observe(el);
        });

        // ========================================
        // RATING BARS ANIMATION
        // ========================================
        const barObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.querySelectorAll('.breakdown-bar-fill').forEach(bar => {
                        const width = bar.style.width;
                        bar.style.width = '0';
                        setTimeout(() => {
                            bar.style.width = width;
                        }, 100);
                    });
                    barObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });

        const reviewsSummary = document.querySelector('.reviews-summary');
        if (reviewsSummary) {
            barObserver.observe(reviewsSummary);
        }

        // Initialize
        handleBackToTop();
    </script>
</body>
</html>