<?php
session_start();

if (!isset($_SESSION["db_name"])) {
    die("Not logged in or session expired.");
}

$dbName = $_SESSION["db_name"];
$dbUser = $_SESSION["db_username"];
$dbPass = $_SESSION["db_password"];

try {
    $pdo = new PDO("mysql:host=localhost;dbname=$dbName;charset=utf8mb4", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// ✅ Sanitize and validate input
$id             = $_POST["id"] ?? null;
$categoryid     = $_POST["categoryid"] ?? null;
$name           = $_POST["name"] ?? null;
$price          = $_POST["price"] ?? null;
$cost           = $_POST["cost"] ?? null;
$barcode        = $_POST["barcode"] ?? null;
$stocks         = $_POST["stocks"] ?? null;
$receive_date   = $_POST["rd"] ?? $_POST["receive_date"] ?? null;
$expired_date   = $_POST["exp"] ?? $_POST["expired_date"] ?? null;
$supplier       = $_POST["supplier"] ?? null;

// Check required values
if (!$id) {
    die("Error: Missing product ID.");
}

try {
    $stmt = $pdo->prepare("
        UPDATE menu_items 
        SET 
            categoryid = :categoryid,
            name = :name,
            price = :price,
            cost = :cost,
            barcode = :barcode,
            stocks = :stocks,
            receive_date = :receive_date,
            expired_date = :expired_date,
            supplier = :supplier
        WHERE id = :id
    ");

    $stmt->execute([
        ":categoryid" => $categoryid,
        ":name" => $name,
        ":price" => $price,
        ":cost" => $cost,
        ":barcode" => $barcode,
        ":stocks" => $stocks,
        ":receive_date" => $receive_date,
        ":expired_date" => $expired_date,
        ":supplier" => $supplier,
        ":id" => $id
    ]);

    echo "✅ Product updated successfully!";
} catch (PDOException $e) {
    echo "❌ Update failed: " . $e->getMessage();
}
