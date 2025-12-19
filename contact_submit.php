<?php
header('Content-Type: application/json');
echo json_encode(["status"=>"success"]);
exit;


include 'config.php';

$firstName = $_POST['firstName'] ?? '';
$lastName  = $_POST['lastName'] ?? '';
$email     = $_POST['email'] ?? '';
$phone     = $_POST['phone'] ?? '';
$subject   = $_POST['subject'] ?? '';
$message   = $_POST['message'] ?? '';

$stmt = $conn->prepare("
    INSERT INTO contact_messages 
    (first_name, last_name, email, phone, subject, message) 
    VALUES (?, ?, ?, ?, ?, ?)
");

$stmt->bind_param(
    "ssssss",
    $firstName,
    $lastName,
    $email,
    $phone,
    $subject,
    $message
);

if ($stmt->execute()) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error"]);
}
