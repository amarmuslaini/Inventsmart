<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


session_start();

// Redirect if not logged in
if (!isset($_SESSION["user_email"])) {
    header("Location: login.php");
    exit();
}

// Load user’s database credentials
$dbName = $_SESSION["db_name"];
$dbUser = $_SESSION["db_username"];
$dbPass = $_SESSION["db_password"];

try {
    $pdo = new PDO("mysql:host=localhost;dbname=$dbName;charset=utf8mb4", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Failed to connect to user database: " . $e->getMessage());

}

$message = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name        = trim($_POST["name"]);
    $price       = trim($_POST["price"]);
    $cost        = trim($_POST["cost"]);
    $barcode = !empty($_POST["barcode"]) ? trim($_POST["barcode"]) : null;
    $categoryid = trim($_POST["categoryid"]);
    $stocks      = trim($_POST["stocks"]);
    $supplier    = trim($_POST["supplier"]);

    // Optional: Handle image upload
    $image_path = "";
    if (!empty($_FILES["image"]["name"])) {
        $targetDir = "assets/image";
        if (!is_dir($targetDir)) mkdir($targetDir);
        $fileName = time() . "_" . basename($_FILES["image"]["name"]);
        $targetFile = $targetDir . $fileName;
        move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile);
        $image_path = $targetFile;
    }

    $stmt = $pdo->prepare("INSERT INTO menu_items (name, price, cost, barcode, categoryid, stocks, supplier, image_path)
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$name, $price, $cost, $barcode, $categoryid, $stocks, $supplier, $image_path]);

    header("Location: dashboard.php?added=1");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add Product | InventSmart</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<style>
body {
  font-family: 'Poppins', sans-serif;
  background: #f8f9fc;
  margin: 0;
}
.container {
  max-width: 600px;
  margin: 60px auto;
  background: #fff;
  padding: 30px;
  border-radius: 12px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}
h2 {
  text-align: center;
  color: #333;
  margin-bottom: 20px;
}
form label {
  display: block;
  margin-bottom: 5px;
  color: #333;
  font-weight: 600;
}
form input, form textarea, form select {
  width: 100%;
  padding: 10px;
  margin-bottom: 15px;
  border: 1px solid #ccc;
  border-radius: 8px;
  font-family: inherit;
}
button {
  background: #ff9800;
  color: white;
  border: none;
  padding: 10px 20px;
  border-radius: 8px;
  font-weight: 600;
  cursor: pointer;
  width: 100%;
}
button:hover {
  background: #e68900;
}
.back-link {
  display: block;
  text-align: center;
  margin-top: 15px;
  color: #555;
  text-decoration: none;
}
.back-link:hover {
  color: #ff9800;
}
</style>
</head>

<body>
<div class="container">
  <h2>Add New Product</h2>

  <form method="POST" enctype="multipart/form-data">
    <label>Product Name</label>
    <input type="text" name="name" required>

    <label>Price (RM)</label>
    <input type="number" name="price" step="0.01" required>

    <label>Cost (RM)</label>
    <input type="number" name="cost" step="0.01">

    <label>Barcode</label>
    <input type="text" name="barcode">

    <label>Category ID</label>
    <input type="number" name="categoryid">

    <label>Stocks</label>
    <input type="number" name="stocks">

    <label>Supplier</label>
    <input type="text" name="supplier">

    <label>Image</label>
    <input type="file" name="image" accept="image/*">

    <button type="submit">Add Product</button>
  </form>

  <a class="back-link" href="dashboard.php">← Back to Dashboard</a>
</div>
</body>
</html>
