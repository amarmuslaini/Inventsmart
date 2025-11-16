<?php
session_start();

if (!isset($_SESSION["user_email"])) {
    http_response_code(403);
    echo "Access denied.";
    exit();
}

$dbName = $_SESSION["db_name"];
$dbUser = $_SESSION["db_username"];
$dbPass = $_SESSION["db_password"];

try {
    $pdo = new PDO(
        "mysql:host=localhost;dbname=$dbName;charset=utf8mb4",
        $dbUser,
        $dbPass
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    http_response_code(500);
    echo "Database connection failed: " . $e->getMessage();
    exit();
}

if (!isset($_POST["id"]) || !is_numeric($_POST["id"])) {
    http_response_code(400);
    echo "Invalid product ID.";
    exit();
}

$id = intval($_POST["id"]);

try {
    $stmt = $pdo->prepare("DELETE FROM menu_items WHERE id = ?");
    $stmt->execute([$id]);

    if ($stmt->rowCount() > 0) {
        echo "✅ Product deleted successfully.";
    } else {
        echo "⚠️ Product not found or already deleted.";
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo "❌ Error deleting product: " . $e->getMessage();
}
?>
