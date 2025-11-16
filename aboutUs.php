<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>InventSmart</title>
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

    

    .content {
      padding: 160px 20px;
      text-align: center;
      margin-left: 370px; /* 330px panel + 40px gap */
      margin-right: 40px; /* keep equal spacing on right */
    }
    .content h1 {
      font-size: 40px;
      color: #000000ff;
    }
    .content p {
      font-size: 22px;
      font-weight: bold;
      color: #000000ff;
      text-align: left;
      margin-right: 600px;
      margin-left: 90px;
      line-height: 1.8;
    }

    .content .highlight-text {
      font-size: 18px;
      font-weight: bold;
      color: #000000ff;
      text-align: left;
      margin-right: 120px;
      margin-left: 120px;
      display: grid;               /* put label + value side by side */
      grid-template-columns: 200px 1fr; /* first col fixed, second flexible */
      align-items: center;
      margin-bottom: 12px; /* spacing between rows */;
    }

    .content a img {
      width: 500px;
      height: 175px;
    }

    .highlight-text span {
      font-size: 18px;
      font-weight: 500;
      color: #000000ff;
      text-align: left;
      margin: 0;
    }

    .content .note-text {
      font-size: 28px;
      color: #000000ff;
      text-align: center;
      margin: 150px;
      margin-left: 190px;
    }

    


    /* decorative line */
    .decorative-line {
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 110px 0;
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

    /* ===== Side Panel ===== */
    .side-panel {
    position: fixed;
    top: 80px; /* below navbar */
    left: 40px; /* space from page edge */
    height: calc(100% - 80px); /* full height minus navbar */
    width: 330px; /* wider panel */
    background: #f4f6f9; /* same as page background */
    border-right: 1px solid #ddd; /* soft separator */
    border-radius: 12px; /* rounded edges */
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    z-index: 900;
    }

    /* ===== Buttons Wrapper ===== */
    .side-buttons {
    margin-top: 20px;       /* top padding */
    margin-bottom: 40px;    /* leave space at bottom */
    margin-left: 20px;      /* leave space on the left */
    display: flex;
    flex-direction: column;
    align-items: flex-end;  /* glue to right side */
    flex-grow: 1;
    }

    /* ===== Buttons ===== */
    .side-buttons a {
    display: flex;              /* flex layout */
    align-items: center;        /* center icon + text vertically */
    justify-content: flex;  /* push content to right */
    gap: 8px;  
    padding: 30px 18px;
    font-size: 18px;
    font-weight: bold;
    color: #333;
    text-decoration: none;
    border-bottom: 1px solid #ddd;
    transition: all 0.3s ease;
    width: 60%;           /* keeps alignment neat */
    text-align: left;     /* align text to left side */
    }

    .side-buttons a img {
    width: 30px;
    height: 30px;
    object-fit: contain;
    }

    .side-buttons a:last-child {
    border-bottom: none;
    }

    .side-buttons a:hover {
    background: #fff;
    color: #ff9800;
    }

    /* keep button orange when active */
    .side-buttons a.active {
    background: #fff;  /* orange background */
    color: #ff9800;          /* white text */
    }

   


    .short-line {
      width: 200px;
      height: 1px;
      background: #ff9800;
      margin: 15px 90px;  /* centers the line */
      border-radius: 2px;
    }

   
    .team-container {
        display: flex;
        justify-content: center;   /* center horizontally */
        gap: 30px;                 /* space between images */
        margin-top: 40px;
    }

    .team-member img {
        width: 700px;
        height: 200px;
        object-fit: cover;
        border-radius: 8px;
    }

    /* Contact Us Styling */
    .contact-info {
      display: flex;
      justify-content: center;
      gap: 25px;
      margin: 30px 0;
      flex-wrap: wrap; /* responsive for small screens */
    }
    
    .contact-box {
      background: #fff;
      border: none;
      border-radius: 15px;
      padding: 30px 25px;
      width: 260px;
      text-align: center;
      box-shadow: 0 8px 20px rgba(0,0,0,0.08);
      transition: all 0.3s ease;
    }
    
    .contact-box:hover {
      transform: translateY(-8px);
      box-shadow: 0 12px 28px rgba(0,0,0,0.12);
    }
    
    .contact-box i {
      font-size: 28px;
      color: #ff9800;
      margin-bottom: 12px;
    }
    
    .contact-box h3 {
      margin-bottom: 8px;
      color: #333;
      font-size: 20px;
      font-weight: 600;
    }
    
    .contact-box p {
      font-size: 16px;
      color: #555;
      margin: 0;
    }


    .contact-form {
      margin: 40px auto;
      max-width: 600px;
      background: #fff;
      padding: 35px;
      border-radius: 15px;
      box-shadow: 0 8px 24px rgba(0,0,0,0.08);
      text-align: left;
    }
    
    .contact-form h3 {
      margin-bottom: 20px;
      text-align: center;
      color: #ff9800;
      font-size: 24px;
      font-weight: 700;
    }
    
    /* Input groups */
    .contact-form .form-group {
      position: relative;
      margin-bottom: 20px;
    }
    
    .contact-form .form-group i {
      position: absolute;
      top: 50%;
      left: 12px;
      transform: translateY(-50%);
      color: #ff9800;
      font-size: 18px;
    }
    
    .contact-form input,
    .contact-form textarea {
      width: 90%;
      padding: 14px 14px 14px 40px; /* left padding for icon */
      border: 1px solid #ddd;
      border-radius: 10px;
      font-size: 16px;
      transition: all 0.3s ease;
    }
    
    .contact-form input:focus,
    .contact-form textarea:focus {
      border-color: #ff9800;
      box-shadow: 0 0 6px rgba(255,152,0,0.3);
      outline: none;
    }
    
    .contact-form textarea {
      width: 90%;
      min-height: 130px;
      resize: vertical;
    }
    
    /* Button */
    .contact-form button {
      width: 100%;
      padding: 15px;
      background: #ff9800;
      color: white;
      font-size: 18px;
      font-weight: 600;
      border: none;
      border-radius: 10px;
      cursor: pointer;
      transition: all 0.3s ease;
    }
    
    .contact-form button:hover {
      background: #e68900;
      transform: translateY(-2px);
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

    <div class="content">
        <div class="content-section">
            <h1>About Us</h1>
        
            <div class="decorative-line">
                <span></span>
            </div>
            <p>
                Since 2025, InventSmart has focused solely on 100% cloud-based system.
                We specialize in the development and delivery of cloud system solutions
                and continue to lead the online industry.
            </p>
            <div class="short-line"></div>
            <p class="highlight-text">
                Company Name<span>InventSmart</span>
                </p>
                <div class="short-line"></div>
                <p class="highlight-text">
                Business Area<span>Cloud inventory</span>
                </p>
                <div class="short-line"></div>
                <p class="highlight-text">
                Location<span>Politeknik Melaka</span>
                </p>
                <div class="short-line"></div>
            </p>

            <p class="note-text">
                We Build InventSmart with Everything You Need to Grow.
            </p>
            <img src="assets/aboutUs.png">
        </div>
        <div class="content-section">
            <!-- MEET OUR TEAM content -->
             <h1>Meet Our Team</h1>

             <div class="decorative-line">
                <span></span>
            </div>

            <div class="team-container">
                <div class="team-member">
                <img src="assets/team.png" alt="Team 1">
                </div>
            </div>
        </div>

        <div class="content-section">
            <!-- CONTACT US content 
             <h1>Contact Us</h1>

             <div class="decorative-line">
                <span></span>
            </div>
            <div class="content-section">-->
          <!-- CONTACT US content -->
          <h1>Contact Us</h1>

          <div class="decorative-line">
            <span></span>
          </div>
          <p class="note-text" style="font-size:20px; margin:20px 0;">
            We’re here to help your business grow smarter. Reach out to us anytime!
          </p>

          <!-- Contact Info -->
            <div class="contact-info">
              <div class="contact-box">
                <i class="fas fa-envelope"></i>
                <h3>Email</h3>
                <p>inventsmartdigital@gmail.com</p>
              </div>
              <div class="contact-box">
                <i class="fas fa-phone-alt"></i>
                <h3>Phone No</h3>
                <p>011-62060134</p>
              </div>
              <div class="contact-box">
                <i class="fas fa-map-marker-alt"></i>
                <h3>Address</h3>
                <p>Muar, Johor</p>
              </div>
            </div>


          <!-- Contact Form -->
            <div class="contact-form">
              <h3>Leave Your Details</h3>
              <form>
                <div class="form-group">
                  <i class="fas fa-user"></i>
                  <input type="text" placeholder="Your Name" required>
                </div>
                <div class="form-group">
                  <i class="fas fa-envelope"></i>
                  <input type="email" placeholder="Your Email" required>
                </div>
                <div class="form-group">
                  <i class="fas fa-phone-alt"></i>
                  <input type="text" placeholder="Your Phone Number">
                </div>
                <div class="form-group">
                  <i class="fas fa-comment-dots"></i>
                  <textarea placeholder="Your Message" required></textarea>
                </div>
                <button type="submit">Send Message</button>
              </form>
            </div>

        </div>
          

        <div class="content-section">
            <!-- OUR CLIENT content -->
             <h1>Our Client</h1>

             <div class="decorative-line">
                <span></span>
            </div>
        </div>
    </div>

    

    <!-- ===== Side Button Panel (Left) ===== -->
    <div class="side-panel">
    <div class="side-buttons">
        <a href="#">
        <img src="assets/logo1.png" alt="logo1"> ABOUT US
        </a>
        <a href="#">
        <img src="assets/logo2.png" alt="logo2"> MEET OUR <br>TEAM
        </a>
        <a href="#">
        <img src="assets/logo3.png" alt="logo3"> CONTACT US
        </a>
        <a href="#">
        <img src="assets/logo4.png" alt="logo3"> OUR CLIENT
    </div>
    </div>


    

    

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

        // get all buttons
        const sideButtons = document.querySelectorAll('.side-buttons a');

        sideButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            // remove active from all
            sideButtons.forEach(b => b.classList.remove('active'));
            // add active to clicked one
            this.classList.add('active');
        });
        });


        // === Section switching ===
        const sections = document.querySelectorAll('.content-section');
        const sideLinks = document.querySelectorAll('.side-buttons a');

        sideLinks.forEach((link, index) => {
            link.addEventListener('click', (e) => {
            e.preventDefault();

            // hide all sections
            sections.forEach(sec => sec.style.display = 'none');

            // show the clicked one
            sections[index].style.display = 'block';

            // update active button
            sideLinks.forEach(b => b.classList.remove('active'));
            link.classList.add('active');
            });
        });

        // show only first section by default
        sections.forEach((sec, i) => {
            sec.style.display = i === 0 ? 'block' : 'none';
        });

    </script>
</body>