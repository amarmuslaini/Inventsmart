<?php
session_start();

// Step 1: Redirect if not logged in
if (!isset($_SESSION["user_email"])) {
    header("Location: login.php");
    exit();
}

// Step 2: Load user's database info from session
$dbName = $_SESSION["db_name"];
$dbUser = $_SESSION["db_username"];
$dbPass = $_SESSION["db_password"];

try {
    // Step 3: Connect to the user’s specific database
    $pdo = new PDO(
        "mysql:host=localhost;dbname=$dbName;charset=utf8mb4",
        $dbUser,
        $dbPass
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Failed to connect to user database: " . $e->getMessage());
}

// Create table if not exists
$pdo->exec("
    CREATE TABLE IF NOT EXISTS infaq (
        no INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255),
        phone_no VARCHAR(30)
    )
");

// Fetch all infaq records
$stmt = $pdo->query("SELECT * FROM infaq ORDER BY no ASC");
$records = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Infaq Management | InventSmart Developer</title>
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

  /* ===== Profile ===== */
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

  /* ===== Table Container ===== */
  .table-container {
    max-width: 900px;
    margin: 50px auto;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 3px 12px rgba(0,0,0,0.1);
    padding: 30px;
    text-align: center;
  }

  .table-container h2 {
    color: #333;
    margin-bottom: 20px;
    font-weight: 600;
  }

  table {
    width: 100%;
    border-collapse: collapse;
  }

  th, td {
    padding: 14px 16px;
    border-bottom: 1px solid #eee;
  }

  th {
    background: #ff9800;
    color: #fff;
    text-transform: uppercase;
    font-size: 14px;
  }

  td input {
    width: 95%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-family: 'Poppins', sans-serif;
    font-size: 15px;
  }

  .notify-btn {
    background: #ff9800;
    color: #fff;
    border: none;
    padding: 8px 14px;
    border-radius: 8px;
    cursor: pointer;
    font-size: 14px;
    transition: 0.2s;
  }

  .notify-btn:hover {
    background: #e58900;
  }

  .add-row-btn {
    margin-top: 20px;
    background: #2c2c2c;
    color: #fff;
    padding: 10px 16px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 15px;
  }

  .add-row-btn:hover {
    background: #3d3d3d;
  }
</style>
</head>

<body>
<div class="navbar">
  <h1>InventSmart Developer Dashboard</h1>
  <div class="nav-links">
    <a href="dashboard.php">Dashboard</a>
    <a href="inventory.php">Inventory</a>
    <a href="reports.php">Reports</a>
    <a href="infaq_dev.php">Infaq</a>
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

<div class="table-container">
  <h2>Infaq Management</h2>
  <table id="infaqTable">
    <thead>
      <tr>
        <th>No</th>
        <th>Name</th>
        <th>Phone No</th>
        <th>Email</th>
        <th>Notify</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($records as $row): ?>
      <tr data-id="<?= $row['no'] ?>">
        <td><?= htmlspecialchars($row['no']) ?></td>
        <td><input type="text" value="<?= htmlspecialchars($row['name']) ?>" class="editable" data-field="name"></td>
        <td><input type="text" value="<?= htmlspecialchars($row['phone_no']) ?>" class="editable" data-field="phone_no"></td>
        <td><input type="text" value="<?= htmlspecialchars($row['email']) ?>" class="editable" data-field="email"></td>
        <td><button class="notify-btn">Notify</button></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <button class="add-row-btn" id="addRowBtn">+ Add Row</button>
</div>

<script>
// === Profile Menu ===
const profilePic = document.getElementById("profilePic");
const profileMenu = document.getElementById("profileMenu");
profilePic.addEventListener("click", () => {
  profileMenu.style.display = profileMenu.style.display === "flex" ? "none" : "flex";
});
document.addEventListener("click", e => {
  if (!profilePic.contains(e.target) && !profileMenu.contains(e.target)) profileMenu.style.display = "none";
});

// === Save Edits Automatically ===
document.querySelectorAll(".editable").forEach(input => {
  input.addEventListener("change", async () => {
    const row = input.closest("tr");
    const id = row.dataset.id;
    const field = input.dataset.field;
    const value = input.value;

    await fetch("update_infaq.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: `id=${id}&field=${field}&value=${encodeURIComponent(value)}`
    });
  });
});

// === Add New Row ===
document.getElementById("addRowBtn").addEventListener("click", async () => {
  const res = await fetch("add_infaq.php");
  location.reload();
});

// === Notify Button ===
document.querySelectorAll(".notify-btn").forEach(btn => {
  btn.addEventListener("click", async () => {
    const row = btn.closest("tr");
    const phone = row.querySelector("input[data-field='phone_no']").value;
    const name = row.querySelector("input[data-field='name']").value;

    alert(`📩 Message sent to ${name} (${phone}):\n"We are pleased to inform you that you are eligible to receive infaq from our team. Kindly visit our physical store to redeem it."`);
  });
});
</script>

</body>
</html>
