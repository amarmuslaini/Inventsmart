
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);



// reports.php
session_start();
if (!isset($_SESSION['user_email'])) {
    header("Location: login.php");
    exit();
}

// Load user's database info from session
$dbName = $_SESSION["db_name"];
$dbUser = $_SESSION["db_username"];
$dbPass = $_SESSION["db_password"];

try {
    $pdo = new PDO("mysql:host=localhost;dbname=$dbName;charset=utf8mb4", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Failed to connect to user database: " . $e->getMessage());
}

// --- Fetch summary data ---
$totalProducts = $pdo->query("SELECT COUNT(*) FROM menu_items")->fetchColumn();
$totalStock = $pdo->query("SELECT SUM(stocks) FROM menu_items")->fetchColumn() ?? 0;
$totalValue = $pdo->query("SELECT SUM(cost * stocks) FROM menu_items")->fetchColumn() ?? 0;
$totalRevenue = $pdo->query("SELECT SUM(price * stocks) FROM menu_items")->fetchColumn() ?? 0;

$profit = $totalRevenue - $totalValue;

// --- Fetch low stock and near expiry ---
$lowStock = $pdo->query("SELECT * FROM menu_items WHERE stocks < 10")->fetchAll(PDO::FETCH_ASSOC);
$nearExpiry = $pdo->query("SELECT * FROM menu_items WHERE expired_date <= DATE_ADD(CURDATE(), INTERVAL 30 DAY)")->fetchAll(PDO::FETCH_ASSOC);

// --- Fetch category breakdown ---
$categoryData = $pdo->query("
  SELECT food_category, SUM(stocks) AS total 
  FROM menu_items 
  GROUP BY food_category 
  ORDER BY food_category ASC
")->fetchAll(PDO::FETCH_ASSOC);

//$categories = $pdo->query("SELECT DISTINCT food_category FROM menu_items ORDER BY CAST(food_category AS UNSIGNED) ASC")->fetchAll(PDO::FETCH_COLUMN);

// Map category numbers to names
$categoryNames = [
    1 => "Vendors",
    2 => "Traditional Local Delights",
    3 => "Beverages",
    4 => "Meat",
    5 => "Fish",
    6 => "Chicken",
    7 => "Biscuit",
    8 => "Pastry",
    9 => "Seasoning",
    10 => "Dessert",
    11 => "Others"
];

// Convert category numbers to names for the chart
$chartLabels = [];
$chartValues = [];

foreach ($categoryData as $row) {
    $catId = (int)$row['food_category'];
    $chartLabels[] = $categoryNames[$catId] ?? "Unknown";
    $chartValues[] = (int)$row['total'];
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Reports | InventSmart</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
body {
  margin: 0;
  font-family: 'Poppins', sans-serif;
  background: #f8f9fc;
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


  /* ===== Profile Dropdown ===== */
  .profile-container {
    position: relative;
    display: flex;
    align-items: center;
  }

  .profile-pic {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    cursor: pointer;
    border: 2px solid #ff9800;
    object-fit: cover;
    transition: 0.3s;
  }

  .profile-pic:hover {
    transform: scale(1.05);
  }

  .profile-menu {
    position: absolute;
    top: 55px;
    right: 0;
    background: #2c2c2c;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.3);
    overflow: hidden;
    display: none;
    flex-direction: column;
    width: 160px;
    z-index: 1000;
  }

  .profile-menu a {
    display: block;
    color: #fff;
    text-decoration: none;
    padding: 10px 15px;
    font-size: 14px;
    transition: background 0.3s;
  }

  .profile-menu a:hover {
    background: #ff9800;
  }

/* Layout */
.container {
  padding: 30px;
  display: flex;
  flex-direction: column;
  gap: 25px;
}

/* Summary cards */
.summary-cards {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 20px;
}
.card {
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 2px 5px rgba(0,0,0,0.1);
  padding: 20px;
  text-align: center;
}
.card h2 {
  color: #ff9800;
  margin: 10px 0 5px;
}
.card p {
  margin: 0;
  color: #333;
}

/* Section titles */
.section-title {
  font-size: 20px;
  font-weight: 600;
  margin: 15px 0 10px;
  color: #333;
}

/* Tables */
.table-container {
  background: #fff;
  border-radius: 10px;
  padding: 20px;
  overflow-x: auto;
  box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}
table {
  width: 100%;
  border-collapse: collapse;
  font-size: 14px;
}
th, td {
  text-align: left;
  padding: 10px;
  border-bottom: 1px solid #ddd;
}
th {
  background: #ff9800;
  color: white;
}
tr:hover {
  background: #f7f7f7;
}

/* Chart */
.chart-container {
  background: #fff;
  border-radius: 10px;
  padding: 20px;
  box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

</style>
</head>
<body>

<div class="navbar">
  <h1>InventSmart Reports</h1>
  <div class="nav-links">
    <a href="dashboard.php">Dashboard</a>
    <a href="inventory.php">Inventory</a>
    <a href="reports.php">Reports</a>
    <a href="settings.php">Settings</a>
  </div>
  <div class="profile-container">
    <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" 
         alt="Profile" class="profile-pic" id="profilePic">
    <div class="profile-menu" id="profileMenu">
      <a href="account_settings.php">Manage Account</a>
      <a href="logout.php">Logout</a>
    </div>
  </div>
</div>

<div class="container">

  <!-- Summary Cards -->
  <div class="summary-cards">
    <div class="card">
      <h2><?= $totalProducts ?></h2>
      <p>Total Products</p>
    </div>
    <div class="card">
      <h2><?= $totalStock ?></h2>
      <p>Total Items in Stock</p>
    </div>
    <div class="card">
      <h2>RM <?= number_format($totalValue, 2) ?></h2>
      <p>Total Inventory Value</p>
    </div>
    <div class="card">
      <h2>RM <?= number_format($profit, 2) ?></h2>
      <p>Estimated Profit</p>
    </div>
  </div>

  <!-- Category Breakdown Chart -->
  <div class="chart-container">
    <h3 class="section-title">Category Breakdown</h3>
    <canvas id="categoryChart" height="100"></canvas>
  </div>

  <!-- Low Stock Table -->
  <div class="table-container">
    <h3 class="section-title">Low Stock (Below 10)</h3>
    <table>
      <tr><th>ID</th><th>Name</th><th>Stocks</th><th>Price (RM)</th><th>Supplier</th></tr>
      <?php if ($lowStock): ?>
        <?php foreach ($lowStock as $item): ?>
          <tr>
            <td><?= htmlspecialchars($item['id']) ?></td>
            <td><?= htmlspecialchars($item['name']) ?></td>
            <td style="color:red; font-weight:bold;"><?= htmlspecialchars($item['stocks']) ?></td>
            <td><?= htmlspecialchars($item['price']) ?></td>
            <td><?= htmlspecialchars($item['supplier'] ?? '') ?></td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr><td colspan="5">No low stock items.</td></tr>
      <?php endif; ?>
    </table>
  </div>

  <!-- Near Expiry Table -->
  <div class="table-container">
    <h3 class="section-title">Products Near Expiry (Within 30 Days)</h3>
    <table>
      <tr><th>ID</th><th>Name</th><th>EXP Date</th><th>Supplier</th></tr>
      <?php if ($nearExpiry): ?>
        <?php foreach ($nearExpiry as $item): ?>
          <tr>
            <td><?= htmlspecialchars($item['id']) ?></td>
            <td><?= htmlspecialchars($item['name']) ?></td>
            <td style="color:#e68a00; font-weight:bold;"><?= htmlspecialchars($item['expired_date']) ?></td>
            <td><?= htmlspecialchars($item['supplier'] ?? '') ?></td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr><td colspan="4">No items near expiry.</td></tr>
      <?php endif; ?>
    </table>
  </div>

</div>

<script>
const ctx = document.getElementById('categoryChart').getContext('2d');
const categoryData = {
  labels: <?= json_encode($chartLabels) ?>,
  datasets: [{
    label: 'Total Stocks',
    data: <?= json_encode($chartValues) ?>,
    backgroundColor: ['#ff9800', '#ffb74d', '#ffe0b2', '#ffa726', '#fb8c00', '#f57c00', '#ef6c00', '#e65100', '#ffcc80', '#ffd180', '#ffe0b2'],
    borderWidth: 1
  }]
};

new Chart(ctx, {
  type: 'pie',
  data: categoryData,
});


// Profile dropdown toggle
const profilePic = document.getElementById("profilePic");
const profileMenu = document.getElementById("profileMenu");
profilePic.addEventListener("click", () => {
  profileMenu.style.display = profileMenu.style.display === "flex" ? "none" : "flex";
});
document.addEventListener("click", e => {
  if (!profilePic.contains(e.target) && !profileMenu.contains(e.target)) profileMenu.style.display = "none";
});
</script>
</body>
</html>
