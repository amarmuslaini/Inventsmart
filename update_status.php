<?php
session_start();

// Check user authentication
if (!isset($_SESSION['user_email'])) {
    http_response_code(403);
    echo json_encode(["error" => "Unauthorized"]);
    exit;
}

header("Content-Type: application/json");

// Load DB credentials
$dbName = $_SESSION["db_name"];
$dbUser = $_SESSION["db_username"];
$dbPass = $_SESSION["db_password"];

try {
    $pdo = new PDO("mysql:host=localhost;dbname=$dbName;charset=utf8mb4", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Validate POST data
    if (isset($_POST['id']) && isset($_POST['status'])) {
        $id = intval($_POST['id']);
        $status = intval($_POST['status']);

        $stmt = $pdo->prepare("UPDATE menu_items SET product_status = ? WHERE id = ?");
        $stmt->execute([$status, $id]);

        echo json_encode(["success" => true, "message" => "Status updated successfully"]);
    } else {
        http_response_code(400);
        echo json_encode(["error" => "Invalid parameters"]);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Database error: " . $e->getMessage()]);
}
?>
