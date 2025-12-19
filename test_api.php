<?php
/**
 * API Debug Test
 */

// Include API key
require_once 'key.php';

echo "<h1>🔍 API Debug Test</h1>";
echo "<hr>";

// Check if API key exists
echo "<h3>1. Checking API Key:</h3>";
if (defined('GOOGLE_PLACES_API_KEY')) {
    $apiKey = GOOGLE_PLACES_API_KEY;
    echo "✅ API Key found: " . substr($apiKey, 0, 10) . "..." . substr($apiKey, -5) . "<br>";
} else {
    echo "❌ API Key NOT defined!<br>";
    echo "Make sure your key.php has: <code>define('GOOGLE_PLACES_API_KEY', 'your-key-here');</code><br>";
    exit;
}

echo "<hr>";

// Check cURL
echo "<h3>2. Checking cURL:</h3>";
if (function_exists('curl_init')) {
    echo "✅ cURL is enabled<br>";
} else {
    echo "❌ cURL is NOT enabled! Enable it in php.ini<br>";
}

echo "<hr>";

// Check file_get_contents
echo "<h3>3. Checking file_get_contents:</h3>";
if (ini_get('allow_url_fopen')) {
    echo "✅ allow_url_fopen is enabled<br>";
} else {
    echo "⚠️ allow_url_fopen is disabled<br>";
}

echo "<hr>";

// Test API Call
echo "<h3>4. Testing API Call:</h3>";

$query = "restaurants India";
$url = "https://maps.googleapis.com/maps/api/place/textsearch/json?query=" . urlencode($query) . "&key=" . $apiKey;

echo "URL: <code>" . htmlspecialchars(str_replace($apiKey, 'API_KEY_HIDDEN', $url)) . "</code><br><br>";

// Try with cURL
echo "<h4>Method 1: Using cURL</h4>";

$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_SSL_VERIFYPEER => false, // Try without SSL verification
    CURLOPT_SSL_VERIFYHOST => false,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
$errno = curl_errno($ch);
curl_close($ch);

echo "HTTP Code: <strong>$httpCode</strong><br>";

if ($error) {
    echo "❌ cURL Error ($errno): $error<br>";
} else {
    echo "✅ cURL request successful<br>";
}

echo "<hr>";

// Parse response
echo "<h3>5. API Response:</h3>";

if ($response) {
    $data = json_decode($response, true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo "❌ JSON Parse Error: " . json_last_error_msg() . "<br>";
        echo "Raw Response: <pre>" . htmlspecialchars(substr($response, 0, 500)) . "</pre>";
    } else {
        echo "Status: <strong>" . ($data['status'] ?? 'Unknown') . "</strong><br>";
        
        if (isset($data['error_message'])) {
            echo "❌ Error Message: <strong style='color:red;'>" . htmlspecialchars($data['error_message']) . "</strong><br>";
        }
        
        if ($data['status'] === 'OK') {
            echo "✅ API is working!<br>";
            echo "Results found: <strong>" . count($data['results'] ?? []) . "</strong><br><br>";
            
            // Show first result
            if (!empty($data['results'][0])) {
                $first = $data['results'][0];
                echo "<strong>First Result:</strong><br>";
                echo "Name: " . htmlspecialchars($first['name']) . "<br>";
                echo "Address: " . htmlspecialchars($first['formatted_address'] ?? 'N/A') . "<br>";
                echo "Rating: " . ($first['rating'] ?? 'N/A') . "<br>";
            }
        } else {
            echo "<br><strong>Possible Issues:</strong><br>";
            
            switch ($data['status']) {
                case 'REQUEST_DENIED':
                    echo "❌ API key is invalid or Places API is not enabled<br>";
                    echo "👉 Go to <a href='https://console.cloud.google.com/apis/library/places-backend.googleapis.com' target='_blank'>Google Cloud Console</a> and enable 'Places API'<br>";
                    break;
                case 'OVER_QUERY_LIMIT':
                    echo "❌ You've exceeded your API quota<br>";
                    echo "👉 Check your billing in Google Cloud Console<br>";
                    break;
                case 'INVALID_REQUEST':
                    echo "❌ Invalid request parameters<br>";
                    break;
                case 'ZERO_RESULTS':
                    echo "⚠️ No results found for this query<br>";
                    break;
                default:
                    echo "❌ Unknown error: " . $data['status'] . "<br>";
            }
        }
    }
} else {
    echo "❌ No response received<br>";
}

echo "<hr>";

// Database Cache Check
echo "<h3>6. Database Cache Check:</h3>";

$host = "localhost";
$dbname = "directory"; // Change this
$username = "root";
$password = "";

$conn = @new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    echo "❌ Database connection failed: " . $conn->connect_error . "<br>";
} else {
    echo "✅ Database connected<br>";
    
    // Check if cache table exists
    $result = $conn->query("SHOW TABLES LIKE 'api_cache'");
    if ($result->num_rows > 0) {
        echo "✅ api_cache table exists<br>";
        
        // Check cache contents
        $cacheResult = $conn->query("SELECT COUNT(*) as count FROM api_cache");
        $row = $cacheResult->fetch_assoc();
        echo "Cached items: " . $row['count'] . "<br>";
    } else {
        echo "❌ api_cache table does not exist<br>";
        echo "Run this SQL:<br>";
        echo "<pre>CREATE TABLE api_cache (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cache_key VARCHAR(255) UNIQUE,
    cache_data LONGTEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    expires_at DATETIME NULL,
    INDEX idx_key (cache_key),
    INDEX idx_expires (expires_at)
);</pre>";
    }
    
    $conn->close();
}

echo "<hr>";
echo "<h3>✅ Debug Complete</h3>";
?>