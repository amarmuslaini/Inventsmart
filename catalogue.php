<?php
// catalogue.php — Public Customer Catalogue

// Database credentials (replace with your actual Hostinger DB credentials)
$dbName = "u145327544_rs_db"; // your main database
$dbUser = "u145327544_rs";    // your username
$dbPass = "Inventsmart20";              // your password

try {
    $pdo = new PDO(
        "mysql:host=localhost;dbname=$dbName;charset=utf8mb4",
        $dbUser,
        $dbPass
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Failed to connect to database: " . $e->getMessage());
}

// Query: Show only products with stock > 0
$stmt = $pdo->query("SELECT * FROM menu_items WHERE stocks > 0 ORDER BY name ASC");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>InventSmart Product Catalogue</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<title>Catalogue | InventSmart Digital Inventory System</title>
<meta name="description" content="Browse product catalogue managed by InventSmart Digital's inventory software. Designed for small businesses in Malaysia.">
<meta name="keywords" content="inventory catalogue, product list, stock management, digital inventory system, inventsmart">
<meta property="og:title" content="Product Catalogue | InventSmart Digital">
<meta property="og:description" content="View your inventory and products easily using InventSmart’s digital stock system.">
<meta property="og:url" content="https://inventsmartdigital.com/catalogue.php">


<style>
  body {
    font-family: 'Poppins', sans-serif;
    background: #f8f9fc;
    margin: 0;
  }

  /* ===== Navbar ===== */
  .navbar {
    width: 96.1%;
    background: #2c2c2c;
    color: #fff;
    padding: 15px 40px;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .navbar h1 {
    color: #ff9800;
    font-size: 28px;
  }
  
  .nav-links {
    display: flex;
    gap: 25px;
    margin-right: 300px;
  }
  
  .nav-links a {
    color: #fff;
    text-decoration: none;
    font-weight: 500;
    font-size: 20px;
    transition: color 0.3s;
  }
  
  .nav-links a:hover {
    color: #ff9800;
  }

  /* ===== Page Container ===== */
  .container {
    max-width: 1300px;
    margin: 40px auto;
    padding: 0 20px;
  }

  .top-bar {
    text-align: center;
    margin-bottom: 25px;
  }

  .top-bar h2 {
    color: #333;
  }

  /* ===== Product Grid ===== */
  .product-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 25px;
  }

  .product-card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    overflow: hidden;
    transition: transform 0.2s ease;
    text-align: center;
  }

  .product-card:hover {
    transform: translateY(-5px);
  }

  .product-card img {
    width: 100%;
    height: 200px;
    object-fit: cover;
  }

  .product-info {
    padding: 15px;
  }

  .product-info h3 {
    font-size: 18px;
    color: #333;
    margin-bottom: 8px;
  }

  .product-info p {
    font-size: 14px;
    color: #666;
    height: 40px;
    overflow: hidden;
  }

  .price {
    color: #ff9800;
    font-weight: bold;
    font-size: 17px;
    margin-top: 10px;
  }

  @media (max-width: 768px) {
    .product-grid {
      grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    }
    .product-card img {
      height: 160px;
    }
  }
</style>
</head>

<body>

<div class="navbar">
  <h1>InventSmart Catalogue</h1>
  <div class="nav-links">
    <a href="catalogue.php">Catalogue</a>
    <a href="promotion.php">Promotion</a>
    <a href="new_arrival.php">New Arrival</a>
    <a href="infaq.php">Infaq</a>
  </div>
</div>

<div class="container">
  <div class="top-bar">
    <h2>Available Products</h2>
    <p>Only items currently in stock are displayed.</p>
  </div>

  <div class="product-grid">
    <?php if (count($products) > 0): ?>
      <?php foreach ($products as $product): ?>
        <div class="product-card">
          <img src="<?= htmlspecialchars($product['image_path']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
          <div class="product-info">
            <h3><?= htmlspecialchars($product['name']) ?></h3>
            <p><?= htmlspecialchars($product['description']) ?></p>
            <div class="price">RM <?= number_format($product['price'], 2) ?></div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p style="text-align:center;">No products available right now.</p>
    <?php endif; ?>
  </div>
</div>

</body>
</html>
