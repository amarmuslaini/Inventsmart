<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

require_once "db_config.php"; // Your existing PDO connection

$message = "";

// --- Change Password ---
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["change_password"])) {
    $current = $_POST["current_password"];
    $new = $_POST["new_password"];
    $confirm = $_POST["confirm_password"];
    $user_id = $_SESSION["user_id"] ?? 1;

    if ($new !== $confirm) {
        $message = "❌ New passwords do not match.";
    } else {
        $stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($current, $user["password"])) {
            $hash = password_hash($new, PASSWORD_DEFAULT);
            $update = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
            $update->execute([$hash, $user_id]);
            $message = "✅ Password updated successfully.";
        } else {
            $message = "❌ Incorrect current password.";
        }
    }
}

// --- Fetch Profile Info ---
$user_id = $_SESSION["user_id"] ?? 1;
$stmt = $pdo->prepare("SELECT fullname, phone, email, db_name, db_username, address, company_name, company_address FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$profile = $stmt->fetch(PDO::FETCH_ASSOC);

// ✅ Prevent errors if user not found
if (!$profile) {
    $profile = [
        "fullname" => "",
        "phone" => "",
        "email" => "",
        "db_name" => "",
        "db_username" => "",
        "address" => "",
        "company_name" => "",
        "company_address" => ""
    ];
}

// --- Database Backup (Hostinger-safe) ---
if (isset($_POST["confirm_backup"])) {
    ob_start(); // Prevent unwanted output

    $dbName = $profile["db_name"];
    $backupFile = "inventsmart_backup_" . date("Ymd_His") . ".sql";

    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    $sqlScript = "-- InventSmart Database Backup: $dbName\n-- " . date("Y-m-d H:i:s") . "\n\n";

    foreach ($tables as $table) {
        // Get table creation script
        $createTable = $pdo->query("SHOW CREATE TABLE `$table`")->fetch(PDO::FETCH_ASSOC);
        $sqlScript .= "\n\nDROP TABLE IF EXISTS `$table`;\n";
        $sqlScript .= $createTable["Create Table"] . ";\n\n";

        // Get table data
        $rows = $pdo->query("SELECT * FROM `$table`")->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rows as $row) {
            $values = array_map(function ($value) use ($pdo) {
                return $pdo->quote($value ?? '');
            }, $row);

            $sqlScript .= "INSERT INTO `$table` VALUES (" . implode(", ", $values) . ");\n";
        }
        $sqlScript .= "\n";
    }

    // Save to file
    file_put_contents($backupFile, $sqlScript);

    // Download
    header("Content-Disposition: attachment; filename=" . basename($backupFile));
    header("Content-Type: application/sql");
    readfile($backupFile);

    unlink($backupFile);
    ob_end_clean();
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Settings - InventSmart</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: "Poppins", sans-serif;
      background-color: #f5f5f5;
    }

    /* Navbar */
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
      font-size: 18px;
      transition: color 0.3s;
    }

    .nav-links a:hover {
      color: #ff9800;
    }

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
    }

    .profile-menu a:hover {
      background: #ff9800;
    }

    /* Content */
    .main {
      padding: 30px;
      max-width: 900px;
      margin: auto;
    }

    .section {
      background: white;
      border-radius: 12px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
      margin-bottom: 30px;
      padding: 20px;
    }

    .section h2 {
      color: #ff9800;
      margin-bottom: 15px;
      border-bottom: 2px solid #ff9800;
      padding-bottom: 5px;
    }

    form {
      display: flex;
      flex-direction: column;
      gap: 10px;
      max-width: 400px;
    }

    input[type="password"] {
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 6px;
      outline: none;
    }

    button {
      background-color: #ff9800;
      color: white;
      border: none;
      padding: 10px;
      border-radius: 6px;
      cursor: pointer;
      transition: 0.2s;
    }

    button:hover {
      background-color: #e68900;
    }

    table {
      border-collapse: collapse;
      width: 100%;
    }

    td {
      padding: 8px 10px;
      border-bottom: 1px solid #ddd;
    }

    td:first-child {
      font-weight: bold;
      color: #555;
      width: 200px;
    }

    .message {
      margin-top: 10px;
      font-weight: bold;
    }
  </style>
</head>
<body>

<div class="navbar">
  <h1><?= htmlspecialchars($profile["company_name"] ?: "InventSmart") ?> Settings</h1>

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
      <a href="#">Manage Account</a>
      <a href="logout.php">Logout</a>
    </div>
  </div>
</div>

<div class="main">
  <div class="section">
    <h2>Profile Information</h2>

    <table>
      <tr><td>Full Name:</td><td><?= htmlspecialchars($profile["fullname"] ?? "") ?></td></tr>
      <tr><td>Phone:</td><td><?= htmlspecialchars($profile["phone"] ?? "") ?></td></tr>
      <tr><td>Email:</td><td><?= htmlspecialchars($profile["email"] ?? "") ?></td></tr>
      <tr><td>Database Name:</td><td><?= htmlspecialchars($profile["db_name"] ?? "") ?></td></tr>
      <tr><td>Database Username:</td><td><?= htmlspecialchars($profile["db_username"] ?? "") ?></td></tr>
      <tr><td>Address:</td><td><?= htmlspecialchars($profile["address"] ?? "") ?></td></tr>
      <tr><td>Company Name:</td><td><?= htmlspecialchars($profile["company_name"] ?? "") ?></td></tr>
      <tr><td>Company Address:</td><td><?= htmlspecialchars($profile["company_address"] ?? "") ?></td></tr>
    </table>
  </div>

  <div class="section">
    <h2>Account Settings</h2>
    <form method="POST">
      <label>Current Password:</label>
      <input type="password" name="current_password" required>
      <label>New Password:</label>
      <input type="password" name="new_password" required>
      <label>Confirm New Password:</label>
      <input type="password" name="confirm_password" required>
      <button type="submit" name="change_password">Change Password</button>
      <?php if ($message): ?>
        <p class="message"><?= htmlspecialchars($message) ?></p>
      <?php endif; ?>
    </form>
  </div>

  <div class="section">
    <h2>Data Backup</h2>
    <form method="POST" onsubmit="return confirm('Are you sure you want to export the entire database?');">
      <button type="submit" name="confirm_backup">Download Backup</button>
    </form>
  </div>
</div>

<script>
const profilePic = document.getElementById("profilePic");
const profileMenu = document.getElementById("profileMenu");

profilePic.addEventListener("click", () => {
  profileMenu.style.display = profileMenu.style.display === "flex" ? "none" : "flex";
});

document.addEventListener("click", (e) => {
  if (!profilePic.contains(e.target) && !profileMenu.contains(e.target)) {
    profileMenu.style.display = "none";
  }
});
</script>

</body>
</html>
