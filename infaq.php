<?php
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

// Fetch data from infaq table
$stmt = $pdo->query("SELECT no, name FROM infaq ORDER BY no ASC");
$records = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>InventSmart Infaq</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<title>Infaq Program | InventSmart Digital</title>
<meta name="description" content="InventSmart Digital supports community infaq programs by helping businesses manage donations digitally and efficiently.">
<meta name="keywords" content="infaq, charity management, donation system, inventsmart digital">
<meta property="og:title" content="Infaq Management | InventSmart Digital">
<meta property="og:description" content="Manage your infaq records digitally with InventSmart Digital.">
<meta property="og:url" content="https://inventsmartdigital.com/infaq.php">


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

  /* ===== Table Section ===== */
  .table-container {
    max-width: 800px;
    margin: 60px auto;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 3px 12px rgba(0,0,0,0.1);
    padding: 30px;
    text-align: center;
  }

  .table-container h2 {
    color: #333;
    margin-bottom: 25px;
    font-weight: 600;
  }

  table {
    width: 100%;
    border-collapse: collapse;
  }

  th, td {
    padding: 14px 18px;
    border-bottom: 1px solid #eee;
  }

  th {
    background: #ff9800;
    color: #fff;
    text-transform: uppercase;
    font-size: 14px;
    letter-spacing: 1px;
  }

  td {
    color: #333;
    font-size: 16px;
  }

  tr:hover {
    background: #f3f3f3;
    transition: 0.2s;
  }

  @media (max-width: 768px) {
    .table-container {
      width: 95%;
      padding: 20px;
    }
    th, td {
      font-size: 14px;
    }
  }
</style>
</head>

<body>

<div class="navbar">
  <h1>InventSmart Infaq</h1>
  <div class="nav-links">
    <a href="catalogue.php">Catalogue</a>
    <a href="catalogue.php">Promotion</a>
    <a href="catalogue.php">New Arrival</a>
    <a href="infaq.php">Infaq</a>
  </div>
</div>

<div class="table-container">
  <h2>Infaq List</h2>

  <?php if (count($records) > 0): ?>
  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Name</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($records as $row): ?>
      <tr>
        <td><?= htmlspecialchars($row['no']) ?></td>
        <td><?= htmlspecialchars($row['name']) ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <?php else: ?>
    <p>No records found.</p>
  <?php endif; ?>
</div>

</body>
</html>
