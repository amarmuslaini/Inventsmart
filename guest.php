<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link rel="icon" type="image/png" href="assets/icon.png">

  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: #f4f6f9;
      color: #333;
      overflow-x: hidden;
    }

    /* ===== Navigation Bar ===== */
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
    
     /* ===== Hamburger Button ===== */
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

    /* ===== Sidebar Menu ===== */
    .menu {
      position: fixed;
      top: 0;
      left: -300px; /* Slide from left */
      width: 300px;
      height: 100%;
      background: #222;
      color: #fff;
      padding: 80px 20px;
      box-shadow: 5px 0 15px rgba(0,0,0,0.2);
      transition: 0.5s ease;
      z-index: 1000;
    }
    .menu.active {
      left: 0;
    }

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
    .menu ul li a:hover {
      color: #ff9800;
    }

    /* ===== Submenu ===== */
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

    /* ===== Overlay Effect ===== */
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
    .overlay.active {
      display: block;
    }
    
    
     /* ===== Page Content ===== */
    .content {
      padding: 100px 20px;
      text-align: center;
    }
    .content h1 {
      font-size: 24px;
      color: #333;
    }
    .content p {
      font-size: 18px;
      color: #555;
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
    
    
    /* ===== Store Buttons Grid ===== */
.store-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); /* Up to 4 per row */
  gap: 25px;
  justify-items: center;
  margin-top: 40px;
  padding: 0 20px;
}

/* Each store button card */
.store-btn {
  width: 300px;
  height: 300px;
  background: #fff;
  border-radius: 16px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: flex-start;
  text-decoration: none;
  overflow: hidden;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.store-btn:hover {
  transform: translateY(-6px);
  box-shadow: 0 8px 18px rgba(0,0,0,0.15);
}

/* Store image area */
.store-btn img {
  width: 100%;
  height: 180px;
  object-fit: cover;
  transition: transform 0.4s ease;
  border-top-left-radius: 16px;
  border-top-right-radius: 16px;
}

.store-btn:hover img {
  transform: scale(1.05);
}

/* Store name below the image */
.store-btn span {
  display: block;
  width: 100%;
  text-align: center;
  font-weight: 600;
  font-size: 16px;
  color: #ff9800;
  padding: 10px 0;
  background: #fff;
  border-top: 1px solid #eee;
}


    
</style>

</head>
    <body>
    
       <!-- ===== Navigation Bar ===== -->
      <div class="navbar">
        <div class="hamburger" id="hamburger">
          <div></div>
          <div></div>
          <div></div>
        </div>
        <div class="logo">InventSmart</div>
      </div>
      
      
       <!-- ===== Overlay ===== -->
  <div class="overlay" id="overlay"></div>

    <!-- ===== Sidebar Menu ===== -->
  <div class="menu" id="menu">
    <ul>
      <li><a href="index.php">Home</a>
        <div class="submenu">
          <a href="#">Overview</a>
          <a href="#">Updates</a>
        </div>
      </li>
      <li><a href="services.php">Services</a>
        <div class="submenu">
          <a href="services.php">Web Design</a>
          <a href="services.php">Maintenance & Support</a>
          <a href="services.php">Consulting</a>
          <a href="services.php">Cloud Solution</a>
        </div>
      </li>
      <li><a href="#">Features</a>
        <div class="submenu">
          <a href="#">Modern UI</a>
          <a href="#">Responsive</a>
          <a href="#">Animations</a>
        </div>
      </li>
      <li><a href="aboutUs.php">About Us</a>
        <div class="submenu">
          <a href="#">Our Team</a>
          <a href="#">Careers</a>
          <a href="#">Contact</a>
        </div>
      </li>
      <!-- ✅ Login button at bottom -->
    <div class="login-btn">
      <a href="login.php">Login</a>
    </div>
    </ul>

  </div>
  
 
  
    <div class="content">
      <h1>Store Available</h1>
      <p>Choose the store and surf their products through our platform.</p>
    
      <div class="store-grid">
        <a href="catalogue.php?store=exampleStore" class="store-btn">
          <img src="assets/rslogo.png" alt="RS Unggul Resource">
          <span>RS Frozen Mart</span>
        </a>
      </div>
    </div>

      
     
    </body>
    <script>
         // Hamburger toggle
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
    
    </script>

</html>