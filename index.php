<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link rel="icon" type="image/png" href="assets/icon.png">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>InventSmart</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
  <title>InventSmart Digital | Smart Inventory System for Small Business</title>
    <meta name="description" content="InventSmart Digital offers a simple, powerful, and cloud-based inventory system designed for small businesses and startups in Malaysia. Manage stock, track sales, and grow your business efficiently.">
    <meta name="keywords" content="inventory system, digital inventory, stock management software, inventory management, inventsmart, inventory, Malaysia">
    <meta name="author" content="InventSmart Digital">
    <meta name="robots" content="index, follow">
    <meta property="og:title" content="InventSmart Digital | Smart Inventory System">
    <meta property="og:description" content="Digital inventory system for small business and startups in Malaysia.">
    <meta property="og:url" content="https://inventsmartdigital.com/">
    <meta property="og:type" content="website">
    <meta property="og:image" content="https://inventsmartdigital.com/assets/logo.png">
    <meta name="geo.region" content="MY-04">
    <meta name="geo.placename" content="Bandaraya Melaka, Malaysia">
    <meta name="geo.position" content="2.1896;102.2501">
    <meta name="ICBM" content="2.1896, 102.2501">

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
      font-size: 40px;
      color: #333;
    }
    .content p {
      font-size: 18px;
      color: #555;
    }

    /* Slideshow */
    .slideshow {
      width: 100%;
      height: 750px;
      margin: 0;
      overflow: hidden;
      position: relative;
    }
    .slide {
      position: relative;
      width: 100%;
      height: 100%;
      display: none;
    }
    .slide.active {
      display: block;
    }
    .slide img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .slide::after {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0,0,0,0.4); /* adjust darkness level */
      z-index: 1;
    }

    /* Make sure captions are above overlay 
    .caption {
      position: absolute;
      bottom: 20px;
      left: 15%;
      transform: translateX(-20px);
      color: white;
      font-size: 70px;
      z-index: 2; 
      -webkit-text-stroke: 0.5px black;
      text-shadow: 2px 2px 4px rgba(0,0,0,0.7);
    }*/

    /* Caption text */
    .caption {
      position: absolute;
      bottom: 20px;
      left: 15%;
      transform: translateX(-20px);
      background: none;
      color: white;
      padding: 120px 25px;
      border-radius: 8px;
      font-size: 70px;
      z-index: 2;
      -webkit-text-stroke: 0.5px black;
      text-shadow: 2px 2px 4px rgba(0,0,0,0.7);
      opacity: 0;
      animation: fadeSlide 1s ease forwards;
    }
    @keyframes fadeSlide {
      from { opacity: 0; transform: translateX(-50px); }
      to { opacity: 1; transform: translateX(0); }
    }

    /* Description text */
    .desc-text {
      margin: 40px auto;
      max-width: 800px;
      padding: 20px;
      text-align: center;
      color: #333;
      font-size: 40px;
      line-height: 1.6;
    }

    /* Image + Text Section */
    .image-text-section, .image-left-section {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 40px;
      max-width: 1200px;
      margin: 50px auto;
      padding: 20px;
    }
    .text-side, .text-right {
      flex: 1;
    }
    .text-side h2, .text-right h2 {
      font-size: 28px;
      margin-bottom: 15px;
      text-align: center;
      color: #222;
    }

    /* short orange line */
    .short-line {
      width: 60px;
      height: 3px;
      background: #ff9800;
      margin: 15px auto;  /* centers the line */
      border-radius: 2px;
    }

    .text-side p, .text-right p {
      font-size: 18px;
      text-align: center;
      line-height: 1.6;
      color: #444;
    }
    .text-right { text-align: right; }

    .image-side, .image-left {
      flex: 3;
    }
    .image-side img, .image-left img {
      width: 100%;
      max-width: 800px;
      border-radius: 12px;
      animation: fadeInUp 1.5s ease forwards;
    }

    .text-side a.btn-findout {
      display: inline-block;
      margin-top: 20px;   /* space below paragraph */
      padding: 12px 24px;
      background: #ff6b35;
      color: #fff;
      font-size: 16px;
      font-weight: 600;
      text-decoration: none;
      border-radius: 30px;
      transition: all 0.3s ease;
    }

    .text-side a.btn-findout:hover {
      background: #ff884d;
      transform: translateY(-3px);
      box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }

    .text-side, .text-right .btn-container {
      text-align: center; /* centers only the button */
    }

    .text-right a.btn-findout {
      display: inline-block;
      margin-top: 20px;   /* space below paragraph */
      padding: 12px 24px;
      background: #ff6b35;
      color: #fff;
      font-size: 16px;
      font-weight: 600;
      text-decoration: none;
      border-radius: 30px;
      transition: all 0.3s ease;
    }

    .text-right a.btn-findout:hover {
      background: #ff884d;
      transform: translateY(-3px);
      box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }

    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }

    /* ===== Word-by-word animation ===== */
    .word {
      opacity: 0;
      display: inline-block;
      transform: translateY(20px);
    }
    .word.visible {
      animation: wordFade 0.6s forwards;
    }
    @keyframes wordFade {
      to { opacity: 1; transform: translateY(0); }
    }

    .features {
      text-align: center;
      padding: 60px 20px;
      background: #f8f9fb;
    }

    .features h2 {
      font-size: 28px;
      font-weight: 700;
      margin-bottom: 40px;
    }

    .features span {
      color: #ff6b35; /* highlight color */
    }

    .feature-cards {
      display: flex;
      justify-content: center;
      gap: 30px;
      flex-wrap: wrap;
    }

    .card {
      position: relative;
      width: 250px;
      height: 250px;
      border-radius: 12px;
      overflow: hidden;
      cursor: pointer;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
    }

    .card-overlay {
      position: absolute;
      bottom: 0;
      left: 0;
      right: 0;
      background: rgba(0,0,0,0.6);
      color: #fff;
      padding: 20px;
      text-align: center;
      
      transition: transform 0.3s ease, background 0.3s ease;
      z-index: 1;
    }

    .card-overlay h3 {
      font-size: 19px;
      font-weight: 600;
      margin: 5px;
    }

    .card-overlay p {
      font-size: 14px;
      margin: 10px;
      line-height: 1.4em;
      opacity: 0;          
      max-height: 0;       
      overflow: hidden;    
      transform: translateY(20px);
      transition: opacity 0.8s ease, max-height 0.8s ease, transform 0.8s ease;
    }

    .card:hover {
      transform: translateY(-8px);
      box-shadow: 0 10px 20px rgba(0,0,0,0.25);
    }

    .card:hover .card-overlay {
      transform: translateY(0);
      background: rgba(0,0,0,0.75);
    }

    .card:hover .card-overlay p {
      opacity: 1;         
      max-height: 200px;
      transform: translateY(0);
    }


    /* Decorative Line */

    .decorative-line {
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 30px 0;
    }

    .decorative-line::before,
    .decorative-line::after {
      content: "";
      flex: 1;
      height: 1px;
      background: #ccc; /* grey line */
    }

    .decorative-line span {
      width: 40px;   /* length of orange bar */
      height: 6px;   /* thickness of orange bar */
      background: #ff9800; /* orange */
      border-radius: 3px;
      margin: 0 10px;
    }



    .footer {
      background: #2c2c2c; /* dark grey */
      color: #fff;
      padding: 50px 20px 20px;
      font-family: 'Poppins', sans-serif;
    }

    .footer-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 30px;
      max-width: 1200px;
      margin: 0 auto;
    }

    .footer-column h3 {
      font-size: 16px;
      margin-bottom: 15px;
      font-weight: 600;
      border-bottom: 2px solid #ff9800; /* short orange underline */
      display: inline-block;
      padding-bottom: 5px;
    }

    .footer-column ul {
      list-style: none;
      padding: 0;
    }

    .footer-column ul li {
      margin: 8px 0;
    }

    .footer-column ul li a {
      color: #bbb;
      text-decoration: none;
      transition: color 0.3s ease;
    }

    .footer-column ul li a:hover {
      color: #ff9800; /* highlight on hover */
    }

    .footer-bottom {
      text-align: center;
      margin-top: 30px;
      padding-top: 15px;
      border-top: 1px solid rgba(255,255,255,0.1);
      font-size: 14px;
      color: #aaa;
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
      <li><a href="features.php">Features</a>
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


  <!-- ===== Slideshow ===== -->
  <div class="slideshow">
    <div class="slide active">
      <img src="assets/image 1.jpg">
      <div class="caption">Design your catalog</div>
    </div>
    <div class="slide">
      <img src="assets/image 2.jpg">
      <div class="caption">Create your<br>own database</div>
    </div>
    <div class="slide">
      <img src="assets/image 3.png">
      <div class="caption">Create your <br>first website</div>
    </div>
    <div class="slide">
      <img src="assets/image 4.jpg">
      <div class="caption">Manage your <br>inventory easily</div>
    </div>

    <div class="dots">
      <span class="dot active"></span>
      <span class="dot"></span>
      <span class="dot"></span>
      <span class="dot"></span>
    </div>
  </div>

  <!-- ===== Page Content ===== -->
  <div class="content">
    <h1>Handle your business easily!</h1>
    <p>Modern, interactive, and aesthetic design with a smooth sliding menu.</p>
  </div>

  <!-- ===== Section with picture and text ===== -->
  <div class="image-text-section">
    <div class="text-side">
      <h2>Start Up</h2>
      <div class="short-line"></div>
      <p>
        started with a simple idea: to create something meaningful and 
        impactful. Today, our team is dedicated to delivering high-quality 
        services that make a difference.
      </p>
      <div class="btn-container">
        <a href="#about" class="btn-findout">Find Out More</a>
      </div>
    </div>
    <div class="image-side">
      <img src="assets/image 5.png" alt="image" class="fade-in">
    </div>
  </div>

  <div class="image-left-section">
    <div class="image-left">
      <img src="assets/left-pic.png" alt="image" class="fade-in">
    </div>
    <div class="text-right">
      <h2>Interactive</h2>
      <div class="short-line"></div>
      <p>
        allows users to actively engage and participate with its content instead of just reading or viewing it. 
        It responds to user actions like clicking buttons, filling forms or dragging elements
        to create a more dynamic and personalized experience.
      </p>
      <div class="btn-container">
        <a href="#about" class="btn-findout">Find Out More</a>
      </div>
    </div>
  </div>

  <!-- ===== Scripts ===== -->
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

    // Slideshow
    let index = 0;
    const slides = document.querySelectorAll(".slide");
    const dots = document.querySelectorAll(".dot");

    function showSlide(n) {
      slides.forEach((slide, i) => {
        slide.classList.remove("active");
        dots[i].classList.remove("active");
      });
      slides[n].classList.add("active");
      dots[n].classList.add("active");
      index = n;
    }
    function showNextSlide() {
      let nextIndex = (index + 1) % slides.length;
      showSlide(nextIndex);
    }
    setInterval(showNextSlide, 3000);
    dots.forEach((dot, i) => {
      dot.addEventListener("click", () => showSlide(i));
    });

    // Word-by-word animation (on scroll)
    function animateTextOnScroll(selector) {
      const element = document.querySelector(selector);
      if (!element) return;
      const text = element.innerText;
      const words = text.split(" ");
      element.innerHTML = "";

      words.forEach((word, i) => {
        const span = document.createElement("span");
        span.innerText = word + " ";
        span.classList.add("word");
        span.style.animationDelay = `${i * 0.2}s`;
        element.appendChild(span);
      
        element.appendChild(document.createTextNode(" "));
  });
      const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            element.querySelectorAll(".word").forEach(span => {
              span.classList.add("visible");
            });
            observer.unobserve(element);
          }
        });
      }, { threshold: 0.3 });

      observer.observe(element);
    }
    

    document.addEventListener("DOMContentLoaded", () => {
      animateTextOnScroll(".text-side p");
      animateTextOnScroll(".text-right p");
    });
  </script>

  <section class="features">
    <h2>Why choose <span>InventSmart?</span></h2>
    <div class="decorative-line">
      <span></span>
    </div>

    <div class="feature-cards">
      
      <div class="card">
        <img src="assets/webbased.jpeg" alt="100% Web-Based">
        <div class="card-overlay">
          <h3>100% Web-Based</h3>
        </div>
      </div>
      
      <div class="card">
        <img src="assets/fees.png" alt="No additional cost per use">
        <div class="card-overlay">
          <h3>No additional cost</h3>
        </div>
      </div>
      
      <div class="card">
        <img src="assets/training.jpeg" alt="Trainig provided">
        <div class="card-overlay">
          <h3>Training provided</h3>
          <p>Weekly function upgrades<br>New feature updates<br>Customer feature feedback</p>
        </div>
      </div>

    </div>
  </section>


<footer class="footer">
  <div class="footer-container">

    <!-- Company Info -->
    <div class="footer-column">
      <h3>InventSmart Digital</h3>
      <p>
        <strong>RS Unggul Resources</strong><br>
        Digital inventory system for small businesses and startups in Malaysia.<br>
        Manage stock, track sales, and grow efficiently.
      </p>
      <p><strong>Location:</strong> 30, Kg. Tengah, Bakri, 84000 Muar, Johor</p>
      <p><strong>Service Area:</strong> Bandaraya Melaka, Malaysia</p>
      <p><strong>Email:</strong> support@inventsmartdigital.com</p>
      <p><strong>Phone:</strong> +6012-248 4047 (Jehan)</p>
    </div>

    <!-- Quick Links -->
    <div class="footer-column">
      <h3>Quick Links</h3>
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="catalogue.php">Catalogue</a></li>
        <li><a href="promotion.php">Promotion</a></li>
        <li><a href="new_arrival.php">New Arrival</a></li>
        <li><a href="infaq.php">Infaq</a></li>
        <li><a href="login.php">Login</a></li>
      </ul>
    </div>

    <!-- Support -->
    <div class="footer-column">
      <h3>Support</h3>
      <ul>
        <li><a href="privacy-policy.php">Privacy Policy</a></li>
        <li><a href="terms.php">Terms of Service</a></li>
        <li><a href="contact.php">Contact Us</a></li>
        <li><a href="faq.php">FAQ</a></li>
      </ul>
    </div>

    <!-- Google Map -->
    <div class="footer-column">
      <h3>Find Us</h3>
      <iframe 
        src="https://www.google.com/maps?q=Bandaraya+Melaka,+Malaysia&output=embed"
        width="100%" height="180" style="border:0; border-radius:8px;"
        allowfullscreen="" loading="lazy">
      </iframe>
    </div>

  </div>

  <div class="footer-bottom">
    <p>© 2025 InventSmart Digital (RS Unggul Resources). All rights reserved.</p>
  </div>

  <!-- JSON-LD Schema for SEO -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "Organization",
    "name": "InventSmart Digital",
    "url": "https://inventsmartdigital.com",
    "logo": "https://inventsmartdigital.com/assets/logo.png",
    "email": "support@inventsmartdigital.com",
    "telephone": "+60122484047",
    "address": {
      "@type": "PostalAddress",
      "streetAddress": "30, Kg. Tengah, Bakri",
      "addressLocality": "Muar",
      "postalCode": "84000",
      "addressRegion": "Johor",
      "addressCountry": "MY"
    },
    "sameAs": [
      "https://facebook.com/inventsmartdigital",
      "https://instagram.com/inventsmartdigital",
      "https://linkedin.com/company/inventsmartdigital"
    ]
  }
  </script>
</footer>


</body>
</html>
