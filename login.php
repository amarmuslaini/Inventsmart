
<?php if (isset($_GET['message']) && $_GET['message'] === 'logout_success'): ?>
  <div style="
    background-color: #d4edda;
    color: #155724;
    padding: 10px 15px;
    border: 1px solid #c3e6cb;
    border-radius: 5px;
    margin-bottom: 15px;
    text-align: center;
  ">
    You have logged out successfully.
  </div>
<?php endif; ?>



<?php
session_start();

// Step 1: Connect to MAIN user database
try {
    $mainDB = new PDO(
        "mysql:host=localhost;dbname=u145327544_inventsmart_db",
        "u145327544_inventsmart",
        "Inventsmart20"
    );
    $mainDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Main DB connection failed: " . $e->getMessage());
}

// Step 2: Handle login form
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    $stmt = $mainDB->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user["password"])) {
        // ✅ Store info for selected user's DB
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["user_email"] = $user["email"];
        $_SESSION["db_name"] = $user["db_name"];
        $_SESSION["db_username"] = $user["db_username"];
        $_SESSION["db_password"] = "Inventsmart20"; // same for all

        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid email or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>InventSmart</title>
    <link href="https://fonts.googleapis.com/css2?family=Alike&display=swap" rel="stylesheet">
    <title>Login | InventSmart Digital</title>
        <meta name="description" content="Access your digital inventory dashboard by logging in to InventSmart Digital. Secure login for small business owners and startup users.">
        <meta name="robots" content="noindex, nofollow">

    
    <style>
        body {
          margin: 0;
          font-family: 'Poppins', sans-serif;
          background: linear-gradient(135deg, #1a1a1a, #2c2c2c);
          color: #333;
          overflow-x: hidden;
        }

        .navbar {
          width: 100%;
          height: 80px;
          background: #2c2c2c;
          display: flex;
          align-items: center;
          justify-content: center;
          box-shadow: 0 2px 10px rgba(0,0,0,0.1);
          position: fixed;
          top: 0;
          left: 0;
          z-index: 1100;
        }
        .navbar .logo {
          font-size: 26px;
          font-weight: 700;
          color: #ff9800;
          font-family: 'Montserrat', sans-serif;
        }

        .hamburger {
          position: absolute;
          left: 20px;
          top: 50%;
          transform: translateY(-50%); 
          width: 35px;
          height: 25px;
          cursor: pointer;
          z-index: 1200;
        }
        .hamburger div {
          width: 100%;
          height: 4px;
          background: #ff9800;
          margin: 6px 0;
          border-radius: 3px;
          transition: 0.4s;
        }

        .menu {
          position: fixed;
          top: 0;
          left: -300px;
          width: 300px;
          height: 100%;
          background: #222;
          color: #fff;
          padding: 80px 20px;
          box-shadow: 5px 0 15px rgba(0,0,0,0.2);
          transition: 0.5s ease;
          z-index: 1000;
        }
        .menu.active { left: 0; }

        .menu ul {
          list-style: none;
          padding: 0;
          margin: 0;
        }
        .menu ul li {
          margin: 35px 0;
          position: relative;
        }
        .menu ul li a {
          text-decoration: none;
          color: #fff;
          font-size: 18px;
          font-weight: 500;
          display: block;
          transition: color 0.3s ease;
        }
        .menu ul li a:hover { color: #ff9800; }

        .submenu {
          display: none;
          background: #333;
          border-radius: 8px;
          padding: 10px;
          margin-top: 10px;
        }
        .submenu a {
          font-size: 15px;
          color: #ccc;
          display: block;
          padding: 6px 10px;
          border-radius: 5px;
          transition: 0.3s;
        }
        .submenu a:hover {
          background: #444;
          color: #ff9800;
        }
        .menu ul li:hover .submenu {
          display: block;
          animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
          from { opacity: 0; transform: translateY(-5px); }
          to { opacity: 1; transform: translateY(0); }
        }

        .overlay {
          position: fixed;
          top: 0;
          left: 0;
          width: 100%;
          height: 100%;
          background: rgba(0,0,0,0.3);
          display: none;
          z-index: 500;
        }
        .overlay.active { display: block; }

        .guest-btn {
            position: absolute;
            right: 20px;
            top: 20px;
            background: #ff9800;
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 13px 18px;
            cursor: pointer;
            font-weight: bold;
            transition: background 0.3s ease;
        }
        .guest-btn:hover {
            background: #e68900;
        }

        .container {
            margin-top: 300px;
            display: flex;
            justify-content: center;
        }
        .login-box {
            background: #2c2c2c;
            color: white;
            padding: 30px;
            border-radius: 15px;
            border: 1px solid #000;
            width: 350px;
            text-align: left;
        }
        .login-box label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
        }
        .login-box input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 20px;
            border: none;
        }
        .btn {
            width: 100%;
            padding: 10px;
            border-radius: 10px;
            border: 0;
            cursor: pointer;
            font-weight: bold;
        }
        .btn-login {
            background: #ff9800;
            color: white;
        }
        .btn-login:hover {
            background: #e68900;
        }

        .staff-login {
            text-align: center;
            margin-bottom: 10px;
            font-size: 12px;
        }
        .error {
            color: red;
            text-align: center;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
   <div class="navbar">
        <div class="hamburger" id="hamburger">
            <div></div><div></div><div></div>
        </div>
        <div class="logo">InventSmart</div>
        <button class="guest-btn" onclick="window.location.href='guest.php'">Continue as Guest</button>
    </div>

    <div class="overlay" id="overlay"></div>

    <div class="menu" id="menu">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="services.php">Services</a></li>
            <li><a href="#">Features</a></li>
            <li><a href="aboutUs.php">About Us</a></li>
        </ul>
    </div>

    <div class="container">
        <div class="login-box">
            <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
            <form method="POST">
                <label>Email :</label>
                <input type="text" name="email" required>
                <label>Password :</label>
                <input type="password" name="password" required>

                <div class="staff-login">
                    <a href="staff_login.php">Staff login</a>
                </div>

                <button type="submit" class="btn btn-login">LOGIN</button>
            </form>
        </div>
    </div>
    
    <script>
    const hamburger = document.getElementById("hamburger");
    const menu = document.getElementById("menu");
    const overlay = document.getElementById("overlay");

    hamburger.addEventListener("click", () => {
        menu.classList.toggle("active");
        overlay.classList.toggle("active");
    });

    overlay.addEventListener("click", () => {
        menu.classList.remove("active");
        overlay.classList.remove("active");
    });
    
      const msg = document.querySelector('div[style*="logged out successfully"]');
  if (msg) {
    setTimeout(() => {
      msg.style.transition = "opacity 0.5s";
      msg.style.opacity = "0";
    }, 3000);
  }
    </script>
</body>
</html>
