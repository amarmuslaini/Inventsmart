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

// Step 4: Example query to show some data
$stmt = $pdo->query("SELECT * FROM menu_items LIMIT 300");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Developer Dashboard | InventSmart</title>
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


  /* ===== Profile Dropdown ===== */
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

  .profile-pic:hover {
    transform: scale(1.05);
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

  /* ===== Page Container ===== */
  .container {
    max-width: 1300px;
    margin: 40px auto;
    padding: 0 20px;
  }

  .top-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
  }

  .top-bar h2 {
    color: #333;
  }

  .add-btn {
    background: #4CAF50;
    color: white;
    border: none;
    padding: 10px 18px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
  }

  .add-btn:hover {
    background: #45a049;
  }

  /* ===== Product Grid ===== */
  .product-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 25px;
  }

  .product-card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    overflow: hidden;
    transition: transform 0.2s ease;
    text-align: center;
  }

  .product-card:hover {
    transform: translateY(-5px);
  }

  .product-card img {
    width: 100%;
    height: 200px;
    object-fit: cover;
  }

  .product-info {
    padding: 15px;
  }

  .product-info h3 {
    font-size: 18px;
    color: #333;
    margin-bottom: 8px;
  }

  .product-info p {
    font-size: 14px;
    color: #666;
    height: 40px;
    overflow: hidden;
  }

  .price {
    color: #ff9800;
    font-weight: bold;
    font-size: 17px;
    margin-top: 10px;
  }

  .actions {
    margin-top: 12px;
    display: flex;
    justify-content: center;
    gap: 10px;
  }

  .btn {
    padding: 6px 12px;
    border: none;
    border-radius: 6px;
    font-weight: 600;
    cursor: pointer;
  }

  .edit-btn {
    background: #2196F3;
    color: white;
  }
  .edit-btn:hover {
    background: #1976D2;
  }

  .delete-btn {
    background: #f44336;
    color: white;
  }
  .delete-btn:hover {
    background: #d32f2f;
  }

  @media (max-width: 768px) {
    .product-grid {
      grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    }
    .product-card img {
      height: 160px;
    }
  }
</style>
</head>

<body>

<div class="navbar">
  <h1>InventSmart Dashboard</h1>
  
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

<div class="container">
  <div class="top-bar">
    <h2>Product Catalogue</h2>
    <button class="add-btn" onclick="window.location.href='add_product.php'">+ Add Product</button>
  </div>

  <div class="product-grid">
    <?php foreach ($products as $product): ?>
      <div class="product-card">
        <img src="<?= htmlspecialchars($product['image_path']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
        <div class="product-info">
          <h3><?= htmlspecialchars($product['name']) ?></h3>
          <p><?= htmlspecialchars($product['description']) ?></p>
          <div class="price">RM <?= number_format($product['price'], 2) ?></div>
        </div>
        <div class="actions">
          <button class="btn edit-btn" onclick="window.location.href='inventory.php?id=<?= $product['id'] ?>'">Edit</button>
          <button class="btn delete-btn" onclick="deleteProduct(<?= $product['id'] ?>)">Delete</button>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<script>
    
    const boxes = document.querySelectorAll(".product-box");
const productDetails = document.getElementById("productDetails");
const similarGrid = document.getElementById("similarGrid");

boxes.forEach(box => {
  box.addEventListener("click", () => {
    const data = box.dataset;

    productDetails.innerHTML = `
      <h2>${data.name}</h2>
      <table>
        <tr><td>ID</td><td id="id">${data.id}</td></tr>
        <tr><td>Category ID</td><td id="category">${data.category}</td></tr>
        <tr><td>Name</td><td contenteditable="false" id="name">${data.name}</td></tr>
        <tr><td>Price (RM)</td><td contenteditable="false" id="price">${data.price}</td></tr>
        <tr><td>Cost (RM)</td><td contenteditable="false" id="cost">${data.cost}</td></tr>
        <tr><td>Barcode</td><td contenteditable="false" id="barcode">${data.barcode}</td></tr>
        <tr><td>Stocks</td><td contenteditable="false" id="stocks">${data.stocks}</td></tr>
        <tr><td>Receive Date</td><td contenteditable="false" id="rd">${data.rd}</td></tr>
        <tr><td>Expired Date</td><td contenteditable="false" id="exp">${data.exp}</td></tr>
        <tr><td>Supplier</td><td contenteditable="false" id="supplier">${data.supplier}</td></tr>
      </table>

      <div class="action-buttons">
        <button id="editBtn">Edit</button>
        <button id="saveBtn" style="display:none;">Save</button>
        <button id="cancelBtn" style="display:none;">Cancel</button>
      </div>
    `;

    const editableFields = [
      "name", "price", "cost", "barcode", "stocks",
      "rd", "exp", "supplier", "category"
    ].map(id => document.getElementById(id));

    const editBtn = document.getElementById("editBtn");
    const saveBtn = document.getElementById("saveBtn");
    const cancelBtn = document.getElementById("cancelBtn");

    const original = {};
    editableFields.forEach(el => original[el.id] = el.textContent);

    editBtn.onclick = () => {
      editableFields.forEach(el => {
        el.contentEditable = true;
        el.style.borderBottom = "1px dashed orange";
      });
      editBtn.style.display = "none";
      saveBtn.style.display = "inline-block";
      cancelBtn.style.display = "inline-block";
    };

    cancelBtn.onclick = () => {
      editableFields.forEach(el => {
        el.textContent = original[el.id];
        el.contentEditable = false;
        el.style.borderBottom = "none";
      });
      editBtn.style.display = "inline-block";
      saveBtn.style.display = "none";
      cancelBtn.style.display = "none";
    };

    saveBtn.onclick = async () => {
      const formData = new FormData();
      formData.append("id", data.id);
      editableFields.forEach(el => formData.append(el.id, el.textContent.trim()));

      try {
        const res = await fetch("update_product.php", {
          method: "POST",
          body: formData
        });
        const text = await res.text();
        alert(text);
      } catch (e) {
        alert("Failed to update product.");
      }

      editableFields.forEach(el => {
        el.contentEditable = false;
        el.style.borderBottom = "none";
      });
      editBtn.style.display = "inline-block";
      saveBtn.style.display = "none";
      cancelBtn.style.display = "none";
    };

    // Similar products preview
    similarGrid.innerHTML = "";
    for (let i = 1; i <= 3; i++) {
      const item = document.createElement("div");
      item.className = "similar-item";
      item.innerHTML = `<p>${data.name} Variant ${i}</p>`;
      similarGrid.appendChild(item);
    }
  });
});

// Profile dropdown toggle
const profilePic = document.getElementById("profilePic");
const profileMenu = document.getElementById("profileMenu");
profilePic.addEventListener("click", () => {
  profileMenu.style.display = profileMenu.style.display === "flex" ? "none" : "flex";
});
document.addEventListener("click", e => {
  if (!profilePic.contains(e.target) && !profileMenu.contains(e.target)) profileMenu.style.display = "none";
});

// === Delete Product Function ===
async function deleteProduct(id) {
  if (!confirm("Are you sure you want to delete this product?")) return;

  const fd = new FormData();
  fd.append("id", id);

  try {
    const res = await fetch("delete_product.php", {
      method: "POST",
      body: fd
    });
    const text = await res.text();
    alert(text);
    if (res.ok) location.reload();
  } catch (err) {
    alert("❌ Failed to delete product.");
    console.error(err);
  }
}


</script>

</body>
</html>
