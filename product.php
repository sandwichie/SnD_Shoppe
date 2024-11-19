<?php
session_start();

$servername = "localhost";
$dbname = "db_sdshoppe";
$username = "root";  
$password = "";  

try {  
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

 //Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: haveacc.php"); // Redirect to login if not logged in
    exit;
}

// Access user information from the session
$user_id = $_SESSION['user_id'];
$user_email = $_SESSION['user_email'];

$product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;

// Query to get the main product details
$stmt = $pdo->prepare('SELECT product_name, price, quantity, product_descript FROM products WHERE product_id = :product_id');
$stmt->execute(['product_id' => $product_id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

// Query to get the product colors 
$stmtColors = $pdo->prepare('SELECT product_pic, color_name FROM product_colors WHERE product_id = :product_id');
$stmtColors->execute(['product_id' => $product_id]);
$product_colors = $stmtColors->fetchAll(PDO::FETCH_ASSOC);

$stmtUser = $pdo->prepare('SELECT lastname, firstname FROM users_credentials WHERE id = :user_id');
$stmtUser->execute(['user_id' => $user_id]);
$user = $stmtUser->fetch(PDO::FETCH_ASSOC);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cart'])) {
    $quantity = isset($_POST['qty']) ? intval($_POST['qty']) : 1;
    $color = isset($_POST['color']) ? $_POST['color'] : '';
    $total_price = $product['price'] * $quantity;

    // Insert into shopping_cart table
    $stmt = $pdo->prepare("INSERT INTO shopping_cart (product_id, product, unit_price, quantity, customer_id, lastname, firstname, color, total_price) 
                           VALUES (:product_id, :product_name, :price, :quantity, :customer_id, :lastname, :firstname, :color, :total_price)");
    $stmt->execute([
        ':product_id' => $product_id,
        ':product_name' => $product['product_name'],
        ':price' => $product['price'],
        ':quantity' => $quantity,
        ':customer_id' => $user_id,
        ':lastname' => $user['lastname'],
        ':firstname' => $user['firstname'],
        ':color' => $color,
        ':total_price' => $total_price
    ]);

    // Redirect to cart page after adding to cart
    header("Location: cart.php");
    
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnreview'])) {
    $title = htmlspecialchars($_POST['title']);
    $description = htmlspecialchars($_POST['description']);
    $rating = intval($_POST['rating']);
    $product_id = $_GET['product_id'];

    if (empty($title) || empty($rating)) {
        $_SESSION['error'] = "Title and rating are required.";
        header("Location: product.php?product_id=$product_id");
        exit();
    }

    try {
        $stmt1 = $pdo->prepare("INSERT INTO product_ratings (product_id, rating, title, description, date)
                               VALUES (:product_id, :rating, :title, :description, CURDATE())");
        $stmt1->execute([
            ':product_id' => $product_id,
            ':rating' => $rating,
            ':title' => $title,
            ':description' => $description,
        ]);
        $_SESSION['success'] = "Review submitted successfully!";
    } catch (PDOException $e) {
        $_SESSION['error'] = "Failed to submit review: " . $e->getMessage();
    }

    header("Location: product.php?product_id=$product_id");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="icon" href="Assets/sndlogo.png" type="logo">
    <link rel="stylesheet" >
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>S&D Fabrics</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Kumbh+Sans:wght@100..900&family=Playfair+Display+SC:ital,wght@0,400;0,700;0,900;1,400;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap');

body {
    background: url(Assets/bgLogin.png) rgba(0, 0, 0, 0.3);
    background-blend-mode: multiply;
    background-position: center;
    background-size: cover;
    background-repeat: no-repeat;
    min-height: 100vh; 
    overflow-y: auto; 
    margin: 0; 
    padding: 0; 
}

.navbar {
    position: fixed; 
    top: 0; 
    left: 0; 
    right: 0; 
    z-index: 1000; 
    background-color: #f1e8d9; 
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15); 
}

.nav-link-black {
    color: #1e1e1e !important;
}

.nav-link-black:hover {
    color: #e044a5;
}


/* Hamburger icon color */
.navbar-toggler-icon {
    background-image: url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba(30, 30, 30, 1)' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
}

.search-bar {
    max-width: 300px; 
    width: 100%; 
}

.input-group-text {
    background-color: #f1e8d9; 
    border: 1px solid #d9b65d; 
    border-radius: 20px 0 0 20px; 
}

.form-control {
    border: 1px solid #d9b65d;
    border-radius: 0 20px 20px 0; 
    text-align: center; 
}

h1{
    font-family: "Playfair Display SC", serif;
    font-size: 50px;
    color: #1e1e1e;
}

h2, p, h6 {
    font-family: "Playfair Display", serif;
}

button {
    font-family: "Playfair Display SC", serif;
}

/* Account Dropdown Styling */
.navbar .dropdown-menu {
    border-radius: 8px;
    padding: 0;
    min-width: 150px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
}

/* Account Dropdown Styling */
.navbar .dropdown-menu {
    border-radius: 11px; 
    padding: 0;
    min-width: 150px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    overflow: hidden; 
}

/* Dropdown Item Styling */
.navbar .dropdown-item {
    padding: 10px 16px;
    font-size: 14px;
    color: #1e1e1e;
    transition: background-color 0.3s;
}

/* Hover Effect with Matching Border Radius */
.navbar .dropdown-item:hover {
    background-color: #f1e8d9;
    border-radius: 0;
}

/* Logout Text */
.dropdown-item.text-danger {
    color: #dc3545;
    font-weight: bold;
}

/* Dropdown Divider */
.dropdown-divider {
    margin: 0;
}

/* Product Card Styling */
.product-container {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 5vh;
    padding: 20px;
    box-sizing: border-box;
}

.product-card {
    margin-top: 100px;
    max-width: 800px;
    width: 100%;
    background-color: #f1e8d9;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    padding: 20px;
    position: relative; 
}

.btn-close {
    position: absolute; 
    top: 10px; 
    right: 10px; 
    background: transparent; 
    border: none; 
    font-size: 20px;
    color: #8f2828; 
    cursor: pointer; 
    z-index: 1; 
}

.btn-close:hover {
    color: #e044a5; /* Optional hover color */
}

.product-image img {
    max-width: 100%;
    height: auto;
    border-radius: 2px;
    position: relative;

}

/* Prev and Next Buttons Positioned Center on Image Sides */
.button-container {
    position: absolute;
    top: 40%;
    width: 100%;
    display: flex;
    justify-content: space-between;
    transform: translateY(-50%);
    box-sizing: border-box;
    z-index: 1;
}

.button-container {
    position: relative; /* Positioning for the button container */
}

/* Style for buttons */
.button-container .btn {
    border-radius: 8px; 
    padding: 12px 10px; 
    font-weight: bold; 
    font-size: 14px; 
    transition: background-color 0.3s, transform 0.2s;
    position: absolute; 
    top: 50%; 
    transform: translateY(-570%); 
}

/* Specific styling for prev and next buttons */
#prev-button {
    left: 0; 
}

#next-button {
    right: 0; 
}

/* Optional: Add margins to adjust spacing between buttons */
.button-container .btn {
    margin: 7px; 
}

.button-container .btn:hover {
    background-color: #dcaa2e;
}

/* Example CSS */
.button-container .btn i {
    color: #fff; 
}

.btn-secondary {
    background-color: #a2a2a2;
    color: #000; 
}

.btn-primary {
    background-color: #d9b65d;
    color: #fff; 
}

/* Align buttons to left and right of image */
.button-container .btn-prev {
    position: absolute;
    left: 0; 
}

.button-container .btn-next {
    position: absolute;
    right: 0; 
}

/* Price Styling */
.price-tag {
    color: #a70000;
    font-weight: bold;
    font-size: 20px;
}

.quantity-select,
.color-options .color-btn {
    border-radius: 10px;
    border: 1px solid #1e1e1e;
    background-color: #f1e8d9;
    padding: 5px 10px;
    margin: 5px;
    cursor: pointer;
    font-weight: bold;
}

.color-btn:hover {
    background-color: #e5d6c0;
}

.total-price {
    font-size: 22px;
    font-weight: bold;
    color: #a70000;
}

.btn-custom {
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 20px;
    border: 1px solid #1e1e1e;
    background-color: #d9b65d;
    padding: 10px 20px;
    margin: 10px 5px;
    cursor: pointer;
    font-weight: bold;
}

.btn-custom:hover {
    background-color: #dcc07a;
}

.color-swatch {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    margin-right: 5px;
}

.counter-qty {
    margin-top: 15px;
}

.qty {
    display: flex;
	flex-wrap: wrap;
	justify-content: center;
	text-align: center;
}

.qty input {
    text-align: center;
    width: 20%;
}

/* For Chrome, Edge, Safari */
input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button { 
    -webkit-appearance: none; 
    margin: 0; 
}

.qty button {
    width: auto; 
    height: auto;
	color: #1e1e1e;
	font-size: 10px;
    background-color: #dcc07a;
}

.qty label {
    margin-right: 10px;
}

.details {
    background-color: #FFF9E9;
    border: 1px solid #1e1e1e;
    width: 96%;
    margin-left: 15px;
    margin-right: 20px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    margin-top: 15px;
    padding-top: 10px;
    padding: 20px;
    padding-bottom: 5px;
}

.details p {
    text-align: justify;
    font-size: 15px;
}

.details h2 {
    font-size: 20px;
    font-weight: bold;
}

.reviews {
    background-color: #FFF9E9;
    border: 1px solid #1e1e1e;
    width: 96%;
    margin-left: 15px;
    margin-right: 20px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    margin-top: 20px;
    padding-top: 10px;
    padding: 20px;
    padding-bottom: 5px;
    height: fit-content;
}
.heading h2 {
    font-size: 20px;
    font-weight: bold;
}

.review-filter {
    display: flex;
    background-color: #dcc07a;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    border: 1px solid #000000;
    height: 60%;
}

.total-reviews {
    width: 20%;
    padding: 10px;
    height: auto;
    justify-content: center; /* Aligns horizontally */
    align-items: center; /* Aligns vertically */
    font-size: 15px;
    
}

.total-reviews h3 {
    font-size: 25px;
    margin-top: 15px;
}

.star-container {
    display: flex;
    width: 80%;
    gap: 10px;
    justify-content: center; /* Aligns horizontally */
    align-items: center; /* Aligns vertically */
    padding: 10px;
}

.stars {
    border: 1px solid #000000;
    background-color: #B5A888;
    max-width: 500px;
    margin-top: 20px;
}

.stars i, .stars a{
    font-size: 12px;
    padding: 2px;
    color: #1e1e1e;
    text-decoration: none;
}

.stars a:hover {
    text-decoration: underline;
}

.review-header {
    display: flex;
    font-family: "Playfair Display", serif;
    margin-top: 20px;
}

.review-header h3 {
    font-size: 20px;
    font-weight: bold;
    width: 87%;
}

/* Button used to open the contact form - fixed at the bottom of the page */
.open-button {
    background-color: #dcc07a;
    font-family: "Playfair Display", serif;
    border: 1px solid #000000;
    text-decoration: none;
    padding: 3px;
    color: #1e1e1e;
    width: 100px;
    text-align: center;
}

/* The popup form - hidden by default */
.form-popup {
  display: none;
  position: fixed;
  top: 55%;
  left: 50%;
  transform: translate(-50%, -50%);
  border: 3px solid #f1f1f1;
  z-index: 1000; /* Higher z-index than the overlay */
  background-color: white;
  padding: 10px;
  border-radius: 8px;
  max-width: 700px;
  width: 100%;
  opacity: 0;
  transition: opacity 0.3s ease, transform 0.3s ease;
  height: 520px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15); 
    row-gap: 5px;
}

.form-popup h1 {
    font-size: 30px;
    font-weight: bold;
    color: #dcaa2e;
    justify-self: center;
    text-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
}

.form-popup button {
    background-color: #dcc07a;
    font-family: "Playfair Display", serif;
    border: 1px solid #000000;
    text-decoration: none;
    padding: 3px;
    color: #1e1e1e;
    text-align: center;
}

.review-label {
    display: block; /* Ensures the label takes up the full width */
    text-align: center; /* Centers the text horizontally */
    font-size: 16px; /* Adjust font size as needed */
    margin-bottom: 10px; /* Add spacing below the label */
    font-weight: bold; /* Optional: make it bold */
    color: #333; /* Optional: customize the text color */
}

.product-rev {
    color: #dcaa2e;
    font-weight: bold;
}

/* Overlay to dim the background */
.overlay {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  z-index: 999; /* Lower than the popup */
  opacity: 0;
  transition: opacity 0.3s ease;
}

/* Show popup and overlay */
.form-popup.show {
  display: block;
  opacity: 1;
}

.overlay.show {
  display: block;
  opacity: 1;
}

/* Add styles to the form container */
.form-container {
  max-height: 100%;
  overflow-y: auto; /* Enable vertical scrolling */
  padding: 10px;
  background-color: white;
  box-sizing: border-box; /* Include padding in width/height */
}

/* Full-width input fields */
.form-container input[type=text], 
.form-container .box {
  width: 100%;
  padding: 15px;
  margin: 3% 0 22px 0;
  border: none;
  background: #f1f1f1;
  box-sizing: border-box; /* Include padding in width/height */
  resize: none; /* Disable resizing for textareas */
}

.box {
    width: 100%;
    padding: 15px;
    border: none;
    background: #f1f1f1;
    box-sizing: border-box; /* Include padding in width/height */
    resize: none; /* Disable resizing for textareas */
}

/* When the inputs get focus, do something */
.form-container input[type=text]:focus, .box:focus {
  background-color: #ddd;
  outline: none;
}





/* Media Queries */
@media (max-width: 768px) {
    .product-card {
        padding: 15px;
    }

    .product-image,
    .product-details {
        flex: 1 1 100%;
        text-align: center;
    }

    .color-options {
        justify-content: center;
    }

    .btn-custom {
        flex: 1;
        margin: 5px;
    }

    .quantity-select {
        width: 100%;
    }
}

@media (max-width: 576px) {
    .price-tag {
        font-size: 18px;
    }

    .total-price {
        font-size: 20px;
    }

    .color-swatch {
        width: 25px;
        height: 25px;
    }
}
        </style>
</head>
<body class="vh-100">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <a class="navbar-brand fs-4" href="homepage.php">
                <img src="Assets/sndlogo.png" width="70px" alt="Logo"/>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                <div class="mx-auto d-flex justify-content-center flex-grow-1">
                    <form class="search-bar" role="search">
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">
                                <i class="bi bi-search search-icon"></i>
                            </span>
                            <input class="form-control" type="search" placeholder="Search..." aria-label="Search" aria-describedby="basic-addon1">
                        </div>
                    </form>
                </div>

                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link nav-link-black active" aria-current="page" href="#">
                            <img src="Assets/svg(icons)/shopping_cart.svg" alt="cart">
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-black" href="#">
                            <img src="Assets/svg(icons)/notifications.svg" alt="notif">
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-black" href="#">
                            <img src="Assets/svg(icons)/inbox.svg" alt="inbox">
                        </a>
                    </li>

                    <!-- Account Dropdown Menu -->
                    <li class="nav-item dropdown">
                        <a class="nav-link nav-link-black dropdown-toggle" href="#" id="accountDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="Assets/svg(icons)/account_circle.svg" alt="account">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="accountDropdown">
                            <li><a class="dropdown-item" href="accountSettings.php">Account & Security</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="haveacc.php">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="product-container">
        <div class="product-card row">
            <button class="btn-close" onclick="window.location.href='homepage.php';" aria-label="Close">✖</button>
            <!-- Image Section -->
            <div class="col-md-6 product-image text-center">
                <img alt="Product Image" class="img-fluid" style="width: 100%;">
                <script>
                    // Pass the available colors to JavaScript
                    let colors = <?= json_encode(array_column($product_colors, 'product_pic')) ?>;
                </script>    

                <div class="mt-3">
                    <div class="button-container">
                        <button class="btn btn-secondary" onclick="prevColor()">
                            <i class="fas fa-arrow-left"></i> <!-- Left Arrow -->
                        </button>
                        <button id="next-button" class="btn btn-primary" onclick="nextColor()">
                            <i class="fas fa-arrow-right"></i> <!-- Right Arrow -->
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Product Details Section -->
            <div class="col-md-6 product-details">
                <h1><?= htmlspecialchars($product['product_name']) ?></h1>
                <p>Price: <span class="price-tag"><?= htmlspecialchars($product['price']) ?></span> per yard</p>
                <p>Available Stocks: <span><?= htmlspecialchars($product['quantity']) ?> Yards</span></p>

                <!-- Color Options Section -->
                <h6>Available Colors:</h6>
                    <div class="color-options d-flex flex-wrap justify-content-center">
                        <?php foreach ($product_colors as $index => $color): ?>
                            <button class="color-btn" onclick="changeColor(<?= $index ?>)">
                                <?= htmlspecialchars($color['color_name']) ?>
                                <img src="<?= htmlspecialchars($color['product_pic']) ?>" alt="<?= htmlspecialchars($color['color_name']) ?>" class="color-swatch">
                            </button>
                        <?php endforeach; ?>
                    </div>

                <!-- Counter Section -->
                <form method="POST" action="">
                <input type="hidden" name="color" value="">
                <div class="counter-qty">
                        <p class="qty">
                            <label for="qty">Quantity:</label>
                            <button class="qtyminus" aria-hidden="true">&minus;</button>
                            <input type="number" name="qty" id="qty" min="1" max="100" step="1" value="1">
                            <button class="qtyplus" aria-hidden="true">&plus;</button>
                        </p>		
                </div>
            
                <div class="button-group d-flex flex-wrap justify-content-center">
                    <button type="submit" class="btn-custom" name="cart">
                        <img src="Assets/svg(icons)/shopping_cart.svg" alt="cart"> Add To Cart
                    </button>
                
                </form>
                    <button class="btn-custom buy-now">Buy Now</button>
                    </div>
                </form>
                </div>
                
                <div class="details">
                    <h2>Product Description</h2>
                    <p><?= htmlspecialchars($product['product_descript']) ?></p>
                    <p>🛒: All products are available and onhand.</p>
                    <p>🚚: Ships every Sunday but you can but you can place your order any day of the week to secure your favorite designs.</p>
                    <p>📱: If you have any questions, please message us!</p>
                </div>

                <div class="reviews">
                    <div class="heading">
                        <h2>Product Ratings</h2>
                    </div>
                    
                    <div class="review-filter">
                        <div class="total-reviews">
                            <h3><i class="fas fa-star"></i></h3>
                            <p>total 0 reviews</p>
                        </div>
                        <div class="star-container"> 
                            <p class="stars">
                                <a href="#">5 Star
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                </a>
                            </p>
                            <p class="stars">
                                <a href="#">4 Star
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                </a>
                            </p>
                            <p class="stars">
                                <a href="#">3 Star
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                
                                </a>
                            </p>
                            <p class="stars">
                                <a href="#">2 Star
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                
                                </a>
                            </p>
                            <p class="stars">
                                <a href="#">1 Star
                                <i class="fas fa-star"></i>
                                
                                </a>
                            </p>
                        </div>
                    </div>
                
                    <div class="review-header">
                        <h3>User Reviews</h3>
                        <button class="open-button" onclick="openForm()">Add Review</button>
                        <!-- Add a background overlay -->
                        <div id="overlay" class="overlay"></div>
                            <!-- The popup form -->
                            <div class="form-popup" id="myForm">
                                <form action="" method="POST" class="form-container">
                                    <h1>Add Review</h1>

                                    <label for="title" class="review-label">
                                        Review Product: <span class="product-rev"><?= htmlspecialchars($product['product_name']) ?></span>
                                    </label>

                                    <label for="title">Review Title *</label>
                                    <input type="text" placeholder="Enter Title" name="title" required />

                                    <label for="descript">Review Description</label>
                                    <textarea name="description" class="box" placeholder="Enter Review Description" maxlength="1000" cols="5" rows="3"></textarea>

                                    <label class="descript">Review Rating <span>*</span></label>
                                    <select name="rating" class="box" required>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>

                                    <div class="buttons">
                                        <button type="button" class="cancelbtn" onclick="closeForm()">Cancel</button>
                                        <button type="submit" name="btnreview" class="btnReview">Submit Review</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <script>   

let currentColorIndex = 0;

// Function to change the product image based on the selected color
function changeColor(index) {
    currentColorIndex = index;
    const productImage = document.querySelector(".product-image img");
    const colorInput = document.querySelector("input[name='color']"); // Hidden input for color
    if (productImage) {
        productImage.src = colors[index];
        productImage.onerror = function () {
            console.error("Failed to load image:", colors[index]);
            productImage.src = "Assets/fallback.jpg"; // Fallback image in case of error
        };
    }
    // Update hidden color input with the selected color name
    colorInput.value = document.querySelectorAll(".color-btn")[index].textContent.trim();
}

// Functions for previous and next buttons
function prevColor() {
    currentColorIndex = (currentColorIndex - 1 + colors.length) % colors.length;
    changeColor(currentColorIndex);
}

function nextColor() {
    currentColorIndex = (currentColorIndex + 1) % colors.length;
    changeColor(currentColorIndex);
}

// Initial display of the first color
window.onload = function () {
    changeColor(currentColorIndex);
};

// Add event listener for keydown events
document.addEventListener("keydown", function (event) {
    if (event.key === "ArrowLeft") {
        prevColor(); // Go to previous color
    } else if (event.key === "ArrowRight") {
        nextColor(); // Go to next color
    }
});

/*
* @Adilade Input Quantity Increment
* 
* Free to use - No warranty
*/

var input = document.querySelector('#qty');
var btnminus = document.querySelector('.qtyminus');
var btnplus = document.querySelector('.qtyplus');

if (input !== undefined && btnminus !== undefined && btnplus !== undefined && input !== null && btnminus !== null && btnplus !== null) {
	
	var min = Number(input.getAttribute('min'));
	var max = Number(input.getAttribute('max'));
	var step = Number(input.getAttribute('step'));

	function qtyminus(e) {
		var current = Number(input.value);
		var newval = (current - step);
		if(newval < min) {
			newval = min;
		} else if(newval > max) {
			newval = max;
		} 
		input.value = Number(newval);
		e.preventDefault();
	}

	function qtyplus(e) {
		var current = Number(input.value);
		var newval = (current + step);
		if(newval > max) newval = max;
		input.value = Number(newval);
		e.preventDefault();
	}
		
	btnminus.addEventListener('click', qtyminus);
	btnplus.addEventListener('click', qtyplus);
  
} // End if test

function openForm() {
  document.getElementById("myForm").classList.add("show");
  document.getElementById("overlay").classList.add("show");
}

function closeForm() {
  document.getElementById("myForm").classList.remove("show");
  document.getElementById("overlay").classList.remove("show");
}

    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
