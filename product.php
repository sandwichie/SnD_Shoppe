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
$stmt = $pdo->prepare('SELECT product_name, price, quantity FROM products WHERE product_id = :product_id');
$stmt->execute(['product_id' => $product_id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

// Query to get the product colors (assuming `product_colors` has a `product_id` column)
$stmtColors = $pdo->prepare('SELECT product_pic, color_name FROM product_colors WHERE product_id = :product_id');
$stmtColors->execute(['product_id' => $product_id]);
$product_colors = $stmtColors->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="icon" href="Assets/sndlogo.png" type="logo">
    <link rel="stylesheet" href="product.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>S&D Fabrics</title>
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
                <div class="counter-qty">
                    <form action="">
                        <p class="qty">
                            <label for="qty">Quantity:</label>
                            <button class="qtyminus" aria-hidden="true">&minus;</button>
                            <input type="number" name="qty" id="qty" min="1" max="100" step="1" value="1">
                            <button class="qtyplus" aria-hidden="true">&plus;</button>
                        </p>
                    </form>			
                </div>
            
                <!-- Action Buttons -->
                <div class="button-group d-flex flex-wrap justify-content-center">
                    <button class="btn-custom">
                        <img src="Assets/svg(icons)/shopping_cart.svg" alt="cart"> Add To Cart
                    </button>
                    <button class="btn-custom buy-now">Buy Now</button>
                </div>
            </div>
        </div>
    </div>


    <script src="product.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
