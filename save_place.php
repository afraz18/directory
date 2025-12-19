<?php
// save_place.php

$host = "localhost";
$dbname = "directory";
$username = "root";
$password = "";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "DB Connection failed"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

if (!$data || !isset($data['place_id'])) {
    echo json_encode(["status" => "error", "message" => "No data received"]);
    exit;
}

$stmt = $conn->prepare("INSERT IGNORE INTO places 
    (place_id, name, address, lat, lng, rating, user_ratings_total, price_level, types, photo_reference, search_query) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

$stmt->bind_param("sssdddiisss", 
    $data['place_id'],
    $data['name'],
    $data['address'],
    $data['lat'],
    $data['lng'],
    $data['rating'],
    $data['user_ratings_total'],
    $data['price_level'],
    $data['types'],
    $data['photo_reference'],
    $data['search_query']
);

if ($stmt->execute()) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => $stmt->error]);
}

$stmt->close();
$conn->close();
?>