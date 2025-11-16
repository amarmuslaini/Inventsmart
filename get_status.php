<?php
session_start();
if (!isset($_SESSION['user_email'])) {
    http_response_code(403);
    echo json_encode(["error" => "Unauthorized"]);
    exit();
}

// Load user-specific DB
$dbName = $_SESSION["db_name"];
$dbUser = $_SESSION["db_username"];
$dbPass = $_SESSION["db_password"];

try {
    $pdo = new PDO("mysql:host=localhost;dbname=$dbName;charset=utf8mb4", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "DB connection failed"]);
    exit();
}

$id = $_GET['id'] ?? null;
if (!$id) {
    http_response_code(400);
    echo json_encode(["error" => "Missing product ID"]);
    exit();
}

// ✅ Correct column name here:
$stmt = $pdo->prepare("SELECT product_status FROM menu_items WHERE id = ?");
$stmt->execute([$id]);
$status = $stmt->fetchColumn();

if ($status === false) {
    echo json_encode(1); // default value
} else {
    echo json_encode((int)$status);
}
?>
