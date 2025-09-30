<?php

header('Access-Control-Allow-Origin: http://localhost');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

file_put_contents('debug.log', 'PHP script was called at ' . date('Y-m-d H:i:s') . "\n", FILE_APPEND);
header('Content-Type: application/json');

error_reporting(E_ALL);
ini_set('display_errors', 1);

$json_data = file_get_contents('php://input');
$booking_data = json_decode($json_data, true);

// Validation
if (!$booking_data || empty($booking_data['name']) || empty($booking_data['email']) || 
    empty($booking_data['phone']) || empty($booking_data['reservation-date'])) {
    echo json_encode(['success' => false, 'message' => 'Data tidak lengkap']);
    exit;
}

try {
    $db_host = 'localhost';
    $db_name = 'kya_kya';
    $db_user = 'root';
    $db_pass = '090307';
    
    // Connect
    $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // SQL and bind parameters
    $stmt = $conn->prepare("INSERT INTO bookings (name, email, phone, people, reservation_date, 
                          reservation_time, message, created_at) 
                          VALUES (:name, :email, :phone, :people, :reservation_date, 
                          :reservation_time, :message, NOW())");
    
    $stmt->bindParam(':name', $booking_data['name']);
    $stmt->bindParam(':email', $booking_data['email']);
    $stmt->bindParam(':phone', $booking_data['phone']);
    $stmt->bindParam(':people', $booking_data['people']);
    $stmt->bindParam(':reservation_date', $booking_data['reservation-date']);
    $stmt->bindParam(':reservation_time', $booking_data['reservation-time']);
    $stmt->bindParam(':message', $booking_data['message']);
    $stmt->execute();
    echo json_encode(['success' => true]);
    
} catch(PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    exit;
}
?>