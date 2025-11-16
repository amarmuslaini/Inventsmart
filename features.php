<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Features | InventSmart</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: #f4f6f9;
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
    .menu ul { list-style: none; padding: 0; margin: 0; }
    .menu ul li { margin: 35px 0; position: relative; }
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
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0,0,0,0.3);
      display: none;
      z-index: 500;
    }
    .overlay.active { display: block; }
    .content {
      padding: 160px 20px;
      text-align: center;
      margin-left: 370px;
      margin-right: 40px;
    }
    .content h1 {
      font-size: 40px;
      color: #000;
    }
    .content p {
      font-size: 20px;
      color: #333;
      text-align: left;
      margin: 20px 100px;
      line-height: 1.8;
    }
    .decorative-line {
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 60px 0;
    }
    .decorative-line::before,
    .decorative-line::after {
      content: "";
      flex: 1;
      height: 1px;
      background: #ccc;
    }
    .decorative-line span {
      width: 40px;
      height: 6px;
      background: #ff9800;
      border-radius: 3px;
      margin: 0 10px;
    }
    .side-panel {
      position: fixed;
      top: 80px;
      left: 40px;
      height: calc(100% - 80px);
      width: 330px;
      background: #f4f6f9;
      border-right: 1px solid #ddd;
      border-radius: 12px;
      display: flex;
      flex-direction: column;
      justify-content: flex-start;
      z-index: 900;
    }
    .side-buttons {
      margin-top: 20px;
      margin-left: 20px;
      display: flex;
      flex-direction: column;
      align-items: flex-end;
    }
    .side-buttons a {
      display: flex;
      align-items: center;
      gap: 8px;
      padding: 30px 18px;
      font-size: 18px;
      font-weight: bold;
      color: #333;
      text-decoration: none;
      border-bottom: 1px solid #ddd;
      width: 60%;
      transition: all 0.3s ease;
    }
    .side-buttons a img {
      width: 30px;
      height: 30px;
      object-fit: contain;
    }
    .side-buttons a:hover {
      background: #fff;
      color: #ff9800;
    }
    .side-buttons a.active {
      background: #fff;
      color: #ff9800;
    }

    /* === Interactive Feature Cards === */
    .feature-card {
      background: #fff;
      padding: 30px;
      margin: 20px auto;
      border-radius: 15px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.08);
      max-width: 800px;
      text-align: left;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      cursor: pointer;
    }
    .feature-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 12px 30px rgba(0,0,0,0.12);
    }
    .feature-card i {
      font-size: 40px;
      color: #ff9800;
      margin-bottom: 10px;
    }
    .feature-card h2 {
      font-size: 26px;
      color: #333;
    }
    .feature-card p {
      font-size: 18px;
      color: #555;
      margin-top: 10px;
    }
    
    /* Login Button at bottom of menu */
    .login-btn {
      margin-top: auto; /* push to bottom */
      padding: 20px;
      text-align: center;
    }
    
    .login-btn a {
      display: block;
      background: #ff9800;
      color: #fff;
      font-weight: bold;
      text-decoration: none;
      padding: 12px;
      border-radius: 8px;
      transition: background 0.3s;
    }
    
    .login-btn a:hover {
      background: #e68900;
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <div class="navbar">
    <div class="hamburger" id="hamburger">
      <div></div>
      <div></div>
      <div></div>
    </div>
    <div class="logo">InventSmart</div>
  </div>

  <div class="overlay" id="overlay"></div>

  <!-- Sidebar -->
  <div class="menu" id="menu">
    <ul>
      <li><a href="index.php">Home</a></li>
      <li><a href="services.php">Services</a></li>
      <li><a href="features.php">Features</a></li>
      <li><a href="aboutUs.php">About Us</a></li>
      <div class="login-btn">
        <a href="login.php">Login</a>
      </div>
    </ul>
  </div>

  <!-- Content -->
  <div class="content">
    <div class="content-section">
      <h1>Features</h1>
      <div class="decorative-line"><span></span></div>

      <div class="feature-card">
        <i class="fas fa-desktop"></i>
        <h2>Modern UI</h2>
        <p>InventSmart is designed with a clean, elegant, and intuitive interface that makes navigation effortless. From dashboards to stock management pages — every screen is built for speed and simplicity.  
        <br><br><b>✨ Interactive Tip:</b> Hover over buttons and cards to see soft transitions and highlights that guide your actions naturally.</p>
      </div>

      <div class="feature-card">
        <i class="fas fa-mobile-alt"></i>
        <h2>Responsive Design</h2>
        <p>Your business doesn’t stop when you leave your desk — and neither does InventSmart. Our system automatically adapts to any device, whether you’re on a phone, tablet, or PC.  
        <br><br><b>📱 Try it:</b> Resize this window or rotate your phone — everything adjusts seamlessly!</p>
      </div>

      <div class="feature-card">
        <i class="fas fa-magic"></i>
        <h2>Animations & Transitions</h2>
        <p>Subtle motion and visual feedback create a smooth, dynamic experience without slowing you down.  
        Buttons, popups, and data charts move naturally, helping users feel connected and confident while managing inventory.  
        <br><br><b>🎨 Try this:</b> Hover or click around — notice how every element responds with motion or color feedback.</p>
      </div>
    </div>
  </div>

  <!-- Side Panel -->
  <div class="side-panel">
    <div class="side-buttons">
      <a href="#" class="active"><img src="assets/logo1.png" alt="logo1"> MODERN UI</a>
      <a href="#"><img src="assets/logo2.png" alt="logo2"> RESPONSIVE</a>
      <a href="#"><img src="assets/logo3.png" alt="logo3"> ANIMATIONS</a>
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

    const sections = document.querySelectorAll('.feature-card');
    const sideLinks = document.querySelectorAll('.side-buttons a');

    sideLinks.forEach((link, index) => {
      link.addEventListener('click', (e) => {
        e.preventDefault();
        sections.forEach(sec => sec.style.display = 'none');
        sections[index].style.display = 'block';
        sideLinks.forEach(b => b.classList.remove('active'));
        link.classList.add('active');
      });
    });
    sections.forEach((sec, i) => sec.style.display = i === 0 ? 'block' : 'none');
  </script>
</body>
</html>
