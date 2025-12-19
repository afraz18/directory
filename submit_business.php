<?php
// =============================================
// SUBMIT BUSINESS - SAVE TO DATABASE
// =============================================

header('Content-Type: application/json');

// Database Connection
$host = "localhost";
$dbname = "directory";
$username = "root";
$password = "";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode([
        'status' => 'error',
        'errors' => ['Database connection failed. Please try again.']
    ]);
    exit;
}

// Check if POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'status' => 'error',
        'errors' => ['Invalid request method']
    ]);
    exit;
}

// =============================================
// GET & SANITIZE FORM DATA
// =============================================
$full_name = trim($_POST['full_name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$business_name = trim($_POST['business_name'] ?? '');
$category = trim($_POST['category'] ?? '');
$business_place = trim($_POST['business_place'] ?? '');
$city = trim($_POST['city'] ?? '');
$state = trim($_POST['state'] ?? '');
$pincode = trim($_POST['pincode'] ?? '');
$website = trim($_POST['website'] ?? '');

// =============================================
// VALIDATION
// =============================================
$errors = [];

// Full Name
if (empty($full_name)) {
    $errors[] = "Full name is required";
} elseif (strlen($full_name) < 3) {
    $errors[] = "Full name must be at least 3 characters";
}

// Email
if (empty($email)) {
    $errors[] = "Email address is required";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Please enter a valid email address";
}

// Phone
if (empty($phone)) {
    $errors[] = "Phone number is required";
} elseif (!preg_match('/^[0-9+\-\s()]{10,15}$/', $phone)) {
    $errors[] = "Please enter a valid phone number";
}

// Business Name
if (empty($business_name)) {
    $errors[] = "Business name is required";
} elseif (strlen($business_name) < 2) {
    $errors[] = "Business name must be at least 2 characters";
}

// Category
if (empty($category)) {
    $errors[] = "Please select a category";
}

// Business Address
if (empty($business_place)) {
    $errors[] = "Business address is required";
}

// City
if (empty($city)) {
    $errors[] = "City is required";
}

// State
if (empty($state)) {
    $errors[] = "Please select a state";
}

// Pincode
if (empty($pincode)) {
    $errors[] = "Pincode is required";
} elseif (!preg_match('/^[0-9]{6}$/', $pincode)) {
    $errors[] = "Pincode must be exactly 6 digits";
}

// Website (optional but validate if provided)
if (!empty($website)) {
    if (!filter_var($website, FILTER_VALIDATE_URL)) {
        $errors[] = "Please enter a valid website URL (include https://)";
    }
}

// =============================================
// CHECK FOR DUPLICATES
// =============================================
if (empty($errors)) {
    // Check duplicate email
    $checkEmail = $conn->prepare("SELECT id FROM businesses WHERE email = ?");
    $checkEmail->bind_param("s", $email);
    $checkEmail->execute();
    if ($checkEmail->get_result()->num_rows > 0) {
        $errors[] = "This email is already registered with another business";
    }
    $checkEmail->close();

    // Check duplicate business name in same city
    $checkBusiness = $conn->prepare("SELECT id FROM businesses WHERE business_name = ? AND city = ?");
    $checkBusiness->bind_param("ss", $business_name, $city);
    $checkBusiness->execute();
    if ($checkBusiness->get_result()->num_rows > 0) {
        $errors[] = "A business with this name already exists in {$city}";
    }
    $checkBusiness->close();
}

// =============================================
// RETURN ERRORS IF ANY
// =============================================
if (!empty($errors)) {
    echo json_encode([
        'status' => 'error',
        'errors' => $errors
    ]);
    exit;
}

// =============================================
// SAVE TO DATABASE
// =============================================
$stmt = $conn->prepare("INSERT INTO businesses 
    (full_name, email, phone, business_name, category, business_place, city, state, pincode, website, status, created_at) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending', NOW())");

$stmt->bind_param("ssssssssss",
    $full_name,
    $email,
    $phone,
    $business_name,
    $category,
    $business_place,
    $city,
    $state,
    $pincode,
    $website
);

if ($stmt->execute()) {
    $business_id = $stmt->insert_id;
    
    // Generate reference number
    $reference = 'BD' . str_pad($business_id, 6, '0', STR_PAD_LEFT);
    
    echo json_encode([
        'status' => 'success',
        'message' => 'Business submitted successfully!',
        'business_id' => $business_id,
        'reference' => $reference
    ]);
    
} else {
    echo json_encode([
        'status' => 'error',
        'errors' => ['Failed to submit business. Please try again later.']
    ]);
}

$stmt->close();
$conn->close();
?>