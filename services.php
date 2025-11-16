<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>InventSmart</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
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
      left: -300px;
      width: 300px;
      height: 100%;
      background: #222;
      color: #fff;
      padding: 80px 20px;
      box-shadow: 5px 0 15px rgba(0,0,0,0.2);
      transition: 0.5s ease;
      z-index: 1000;
      display: flex;
      flex-direction: column;
    }
    .menu.active {
      left: 0;
    }
    .menu ul {
      list-style: none;
      padding: 0;
      margin: 0;
      flex-grow: 1; /* ✅ let menu items fill available space */
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

    /* ===== Content ===== */
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
      font-size: 22px;
      font-weight: bold;
      color: #000;
      text-align: left;
      margin-right: 600px;
      margin-left: 90px;
      line-height: 1.8;
    }

    .content .highlight-text {
      font-size: 18px;
      font-weight: bold;
      color: #000;
      text-align: left;
      margin: 0 120px 12px;
      display: grid;
      grid-template-columns: 200px 1fr;
      align-items: center;
    }
    .highlight-text span {
      font-size: 18px;
      font-weight: 500;
      color: #000;
      text-align: left;
      margin: 0;
    }

    .content .note-text {
      font-size: 28px;
      color: #000;
      text-align: center;
      margin: 150px 190px;
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
      background: #ccc;
    }
    .decorative-line span {
      width: 40px;
      height: 6px;
      background: #ff9800;
      border-radius: 3px;
      margin: 0 10px;
    }

    /* ===== Side Panel ===== */
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
      margin: 20px 0 40px 20px;
      display: flex;
      flex-direction: column;
      align-items: flex-end;
      flex-grow: 1;
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
      transition: all 0.3s ease;
      width: 60%;
      text-align: left;
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
    .side-buttons a.active {
      color: #ff9800;
    }

    /* ===== Cloud Solutions ===== */
    .content-section {
      padding: 60px 20px;
      text-align: center;
    }
    .content-section h1 {
      font-size: 2.5em;
      margin-bottom: 10px;
    }
    .note-text {
      font-size: 20px;
      margin: 20px 0;
      text-align: center;
      color: #333;
    }
    .note-text.extra {
      font-size: 18px;
      margin-top: 50px;
      max-width: 700px;
      margin-left: auto;
      margin-right: auto;
      line-height: 1.6;
    }
    
    
    
    /* ===== Cloud Solutions ===== */
    .content-section {
      text-align: center;
      padding: 60px 20px;
    }
    
    .decorative-line span {
      display: block;
      margin: 20px auto;
      width: 100px;
      height: 4px;
      background: orange;
    }
    
    /* Cloud Solutions note text centered */
    .content-section .note-text {
      font-size: 22px;
      max-width: 800px;
      margin: 35px auto;
      line-height: 1.6;
      text-align: center;   /* force center alignment */
    }

    
    .features-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 30px;
      margin-top: 40px;
      justify-items: stretch;
    }
    
    .feature-box {
      background: #fff;
      border: 1px solid #ddd;
      border-radius: 12px;
      padding: 25px;
      text-align: left;
      margin-left: 0;
      opacity: 0;                /* hidden at first */
      transform: translateY(30px); /* moved down */
      transition: all 0.6s ease-out;
    }
    
    .feature-box.show {
      opacity: 1;
      transform: translateY(0); /* slide up into place */
    }
    
    .feature-box h3 {
      color: #ff9800;
      margin-bottom: 10px;
    }
    
    
    .feature-box p {
      font-size: 19px;
      color: #000;
      text-align: left !important;
      word-break: normal !important;
      white-space: normal !important;
      width: 70% !important;
      display: block !important;
    }
    
    
    .feature-box:hover {
      transform: translateY(-8px) scale(1.02);
      box-shadow: 0 12px 30px rgba(0,0,0,0.15);
    }
    .feature-box.show {
      opacity: 1;
      transform: translateY(0);
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
      <li><a href="#">Services</a>
        <div class="submenu">
          <a href="#">Web Design</a>
          <a href="#">Maintenance & Support</a>
          <a href="#">Consulting</a>
          <a href="#">Cloud Solution</a>
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


   <!-- ===== Content Sections ===== -->
  <div class="content">
    <!-- === WEB DESIGN === -->
    <div class="content-section">
      <h1>Web Design</h1>
      <div class="decorative-line"><span></span></div>
      <p class="note-text">
        Transform your ideas into visually stunning, high-performing websites that engage users instantly.
      </p>

      <div class="features-grid">
        <div class="feature-box">
          <h3>Modern Interface</h3>
          <p>We design clean, minimal, and intuitive layouts that match your brand identity while keeping user experience effortless.</p>
        </div>
        <div class="feature-box">
          <h3>Interactive Prototypes</h3>
          <p>Experience your website’s flow before it goes live — preview transitions, navigation, and animations in real time.</p>
        </div>
        <div class="feature-box">
          <h3>Brand Customization</h3>
          <p>Tailor your site with custom themes, fonts, and color palettes that represent your unique brand style.</p>
        </div>
      </div>

      <p class="note-text extra">
        💡 Tip: Hover over the cards to see subtle highlights that guide user interaction naturally.
      </p>
    </div>

    <!-- === MAINTENANCE & SUPPORT === -->
    <div class="content-section">
      <h1>Maintenance & Support</h1>
      <div class="decorative-line"><span></span></div>
      <p class="note-text">
        Keep your system running smoothly with our proactive maintenance and 24/7 technical assistance.
      </p>

      <div class="features-grid">
        <div class="feature-box">
          <h3>Automatic Updates</h3>
          <p>We handle all version upgrades, patching, and security fixes automatically — so your site stays current.</p>
        </div>
        <div class="feature-box">
          <h3>Real-Time Monitoring</h3>
          <p>Our smart monitoring tools instantly detect and report downtime or performance drops for quick resolution.</p>
        </div>
        <div class="feature-box">
          <h3>Dedicated Helpdesk</h3>
          <p>Need help fast? Our support team is available via chat or email to assist with any issue — anytime, anywhere.</p>
        </div>
      </div>

      <p class="note-text extra">
        🛠 Hover to see system uptime cards pulse — showing reliability in action!
      </p>
    </div>

    <!-- === CONSULTING === -->
    <div class="content-section">
      <h1>Consulting</h1>
      <div class="decorative-line"><span></span></div>
      <p class="note-text">
        Empower your business with expert digital transformation advice. Our consultants help you plan, design, and scale efficiently.
      </p>

      <div class="features-grid">
        <div class="feature-box">
          <h3>Business Strategy</h3>
          <p>We analyze your goals, workflows, and audience to develop a digital strategy that ensures long-term success.</p>
        </div>
        <div class="feature-box">
          <h3>Technology Guidance</h3>
          <p>Get recommendations on the best tech stack and cloud tools tailored to your company’s needs.</p>
        </div>
        <div class="feature-box">
          <h3>Growth Analysis</h3>
          <p>We turn your data into insights — optimizing decisions with analytics, reporting, and KPI dashboards.</p>
        </div>
      </div>

      <p class="note-text extra">
        🤝 Scroll or hover to trigger fade-in animations that make key insights pop up naturally.
      </p>
    </div>

    <!-- === CLOUD SOLUTION === -->
    <div class="content-section">
      <h1>Cloud Solutions</h1>
      <div class="decorative-line"><span></span></div>
      <p class="note-text">
        Empower your business with scalable and secure cloud-based systems designed for reliability and speed.
      </p>

      <div class="features-grid">
        <div class="feature-box">
          <h3>Cloud Hosting</h3>
          <p>Reliable and fast hosting with flexible scalability to grow with your business.</p>
        </div>
        <div class="feature-box">
          <h3>Inventory Systems</h3>
          <p>Cloud-based inventory solutions with real-time updates and analytics.</p>
        </div>
        <div class="feature-box">
          <h3>Data Backup</h3>
          <p>Secure and automated data backup & recovery to protect your business assets.</p>
        </div>
        <div class="feature-box">
          <h3>SaaS Integration</h3>
          <p>Seamless integration with SaaS tools for a more efficient digital workflow.</p>
        </div>
      </div>

      <p class="note-text extra">
        ☁ Scroll to watch each card fade and lift as they appear — showing the flexibility and scalability of our solutions.
      </p>
    </div>
  </div>





  <!-- ===== Side Panel ===== -->
  <div class="side-panel">
    <div class="side-buttons">
      <a href="#"><img src="assets/logo5.png" alt="logo1"> WEB DESIGN</a>
      <a href="#"><img src="assets/logo6.png" alt="logo2"> MAINTENANCE <br>& SUPPORT</a>
      <a href="#"><img src="assets/logo7.png" alt="logo3"> CONSULTING</a>
      <a href="#"><img src="assets/logo7.png" alt="logo3"> CLOUD <br> SOLUTION</a>
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
    
      // Side buttons active state
      const sideButtons = document.querySelectorAll('.side-buttons a');
      sideButtons.forEach(btn => {
        btn.addEventListener('click', function() {
          sideButtons.forEach(b => b.classList.remove('active'));
          this.classList.add('active');
        });
      });
    
        // Section switching (use visibility instead of display:none)
        const sections = document.querySelectorAll('.content-section');
        sideButtons.forEach((link, index) => {
          link.addEventListener('click', (e) => {
            e.preventDefault();
            sections.forEach(sec => {
              sec.style.opacity = "0";
              sec.style.visibility = "hidden";
              sec.style.position = "absolute";
            });
            sections[index].style.opacity = "1";
            sections[index].style.visibility = "visible";
            sections[index].style.position = "relative";
          });
        });
        
        // Show only first section at start
        sections.forEach((sec, i) => {
          if (i === 0) {
            sec.style.opacity = "1";
            sec.style.visibility = "visible";
            sec.style.position = "relative";
          } else {
            sec.style.opacity = "0";
            sec.style.visibility = "hidden";
            sec.style.position = "absolute";
          }
        });

    
      // Animate feature boxes on scroll with error detection
       document.addEventListener("DOMContentLoaded", function () {
        const boxes = document.querySelectorAll(".feature-box");
    
        const observer = new IntersectionObserver(
          (entries) => {
            entries.forEach((entry) => {
              if (entry.isIntersecting) {
                entry.target.classList.add("show");
              } else {
                entry.target.classList.remove("show"); // replay when scrolling back
              }
            });
          },
          { threshold: 0.2 }
        );
    
        boxes.forEach((box) => observer.observe(box));
      });
</script>

</body>
</html>
