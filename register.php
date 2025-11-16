<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// register.php

// connect to Hostinger DB
$pdo = new PDO(
    "mysql:host=mysql.hostinger.com;dbname=u145327544_inventsmart_db",
    "u145327544_inventsmart",
    "Inventsmart20"
);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname       = trim($_POST["fullname"]);
    $phone          = trim($_POST["phone"]);
    $email          = trim($_POST["email"]);
    $password       = $_POST["password"];
    $confirmPass    = $_POST["confirm_password"];
    $address        = trim($_POST["address"]);
    $companyName    = trim($_POST["company_name"]);
    $companyAddress = trim($_POST["company_address"]);

    // simple validation
    if ($password !== $confirmPass) {
        $message = "Passwords do not match!";
    } else {
        // hash password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        try {
            $stmt = $pdo->prepare("INSERT INTO users 
                (fullname, phone, email, password, address, company_name, company_address) 
                VALUES (?, ?, ?, ?, ?, ?, ?)");
            
            $stmt->execute([
                $fullname,
                $phone,
                $email,
                $hashedPassword,
                $address,
                $companyName,
                $companyAddress
            ]);

            $message = "✅ Registration successful! <a href='login.php'>Login here</a>";
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $message = "❌ Email already exists. Please use another email.";
            } else {
                $message = "❌ Error: " . $e->getMessage();
            }
        }
    }
}
?>





<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - InventSmart</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: linear-gradient(135deg, #1a1a1a, #2c2c2c);
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    }
    .register-container {
      background: #2c2c2c;
      padding: 25px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      width: 400px;
    }
    h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #ff9800;
    }
    .form-group {
      margin-bottom: 15px;
    }
    label {
      display: block;
      color: #fff;
      margin-bottom: 8px;
      font-size: 14px;
    }
    input, textarea {
      width: 95%;
      padding: 10px;
      border-radius: 5px;
      border: 1px solid #ccc;
      font-size: 14px;
    }
    button {
      width: 100%;
      background: #ff9800;
      color: #fff;
      padding: 12px;
      border: none;
      border-radius: 5px;
      font-size: 16px;
      cursor: pointer;
    }
    button:hover {
      background: #e68a00;
    }
    .message {
      margin-top: 15px;
      text-align: center;
      color: red;
      font-weight: bold;
    }
    .success {
      color: green;
    }
  </style>
</head>
<body>
  <div class="register-container">
    <h2>Create Account</h2>
    <form method="POST" action="">
      <div class="form-group">
        <label>Full Name</label>
        <input type="text" name="fullname" required>
      </div>
      <div class="form-group">
        <label>Phone No</label>
        <input type="text" name="phone" required>
      </div>
      <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" required>
      </div>
      <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" required>
      </div>
      <div class="form-group">
        <label>Confirm Password</label>
        <input type="password" name="confirm_password" required>
      </div>
      <div class="form-group">
        <label>Address</label>
        <textarea name="address" rows="2" required></textarea>
      </div>
      <div class="form-group">
        <label>Company Name</label>
        <input type="text" name="company_name">
      </div>
      <div class="form-group">
        <label>Company Address (optional)</label>
        <textarea name="company_address" rows="2"></textarea>
      </div>
      <button type="submit">Register</button>
    </form>
    <?php if ($message): ?>
      <div class="message <?php echo (strpos($message, 'successful') !== false) ? 'success' : ''; ?>">
        <?php echo $message; ?>
      </div>
    <?php endif; ?>
  </div>
</body>
</html>
