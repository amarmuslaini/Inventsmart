<?php
// new_arrival.php — New Arrival Catalogue

// Database credentials (replace with your actual Hostinger DB credentials)
$dbName = "u145327544_rs_db";
$dbUser = "u145327544_rs";
$dbPass = "Inventsmart20";

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

// Get new arrivals (product_status = 3)
$newArrivalsStmt = $pdo->query("SELECT * FROM menu_items WHERE product_status IN (3, 4) AND stocks > 0 ORDER BY name ASC");
$newArrivals = $newArrivalsStmt->fetchAll(PDO::FETCH_ASSOC);

// Get other products (not new arrivals)
$otherProductsStmt = $pdo->query("SELECT * FROM menu_items WHERE product_status != 3 AND stocks > 0 ORDER BY name ASC");
$otherProducts = $otherProductsStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>New Arrivals - InventSmart Catalogue</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

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

  /* Divider line */
  .divider {
    border-top: 1px solid #ccc;
    margin: 50px 0;
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
    <a href="new_arrival.php" style="color:#ff9800;">New Arrival</a>
    <a href="infaq.php">Infaq</a>
  </div>
</div>

<div class="container">
  <div class="top-bar">
    <h2>New Arrivals</h2>
    <p>Check out our latest products below!</p>
  </div>

  <?php if (count($newArrivals) > 0): ?>
    <div class="product-grid">
      <?php foreach ($newArrivals as $product): ?>
        <div class="product-card">
          <img src="<?= htmlspecialchars($product['image_path']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
          <div class="product-info">
            <h3><?= htmlspecialchars($product['name']) ?></h3>
            <p><?= htmlspecialchars($product['description']) ?></p>
            <div class="price">RM <?= number_format($product['price'], 2) ?></div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <p style="text-align:center; color:#555;">There’s no new product at this moment, please come again later.</p>
  <?php endif; ?>

  <?php if (count($otherProducts) > 0): ?>
    <div class="divider"></div>
    <div class="product-grid">
      <?php foreach ($otherProducts as $product): ?>
        <div class="product-card">
          <img src="<?= htmlspecialchars($product['image_path']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
          <div class="product-info">
            <h3><?= htmlspecialchars($product['name']) ?></h3>
            <p><?= htmlspecialchars($product['description']) ?></p>
            <div class="price">RM <?= number_format($product['price'], 2) ?></div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

</div>

</body>
</html>
