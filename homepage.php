<?php
session_start();

$servername = "localhost";
$dbname = "db_sdshoppe";
$username = "root";  
$password = "";  

try {
    // Initialize PDO connection
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


// Get the 4 most recently added products
$stmt = $pdo->prepare('SELECT product_image FROM products');
$stmt->execute();
$product = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="icon" href="Assets/sndlo.ico">
    <link rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <title>S&D Fabrics</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Kumbh+Sans:wght@100..900&family=Playfair+Display+SC:ital,wght@0,400;0,700;0,900;1,400;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap');

body {
    background-image: url(Assets/bgLogin.png);
    background-blend-mode: multiply;
    background-position: center;
    background-size: cover;
    background-repeat: no-repeat;
    min-height: 100vh; 
    overflow-y: auto; 
    margin: 0; 
    padding: 0; 
    font-family: "Playfair Display", serif;
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



/* Card background for the category section */
.category-card {
    max-height: 70vh; 
    overflow-y: auto; 
    background-color: #b6b3ae; 
    border-radius: 15px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15); 
    margin: 20px 0;
}

/* Ensure h2 is styled correctly */
h2 {
    font-family: "Playfair Display SC", serif;
    font-weight: 600;
    font-size: 32px;
    margin: 70px 0;
}

/* Category section styling */
.category-card {
    max-height: 70vh; 
    overflow-y: auto; 
    background-color: #b6b3ae;
    padding: 20px;
    border-radius: 15px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    margin: 20px 0;
}

/* Ensure categories are displayed in a single row */
.row {
    display: flex;
    justify-content: center; 
    flex-wrap: wrap; 
    gap: 10px; 
    margin: 0; 
}

/* Style for individual categories */
.category {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin: 0; 
    flex: 1 1 120px; 
    max-width: 120px; 
    text-align: center; 
}

.category img {
    width: 100px; 
    height: 100px; 
    border-radius: 50%; 
    border: 2px solid #1e1e1e; 
    object-fit: cover; 
}

.category p {
    margin-top: 3px; 
    font-weight: bold;
    font-size: 16px; 
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .category {
        flex: 1 1 80px; 
        max-width: 80px; 
    }

    .category img {
        width: 80px;
        height: 80px; 
    }

    .category p {
        font-size: 14px; 
    }
}

/* Filter button styling */
.filter-buttons {
    display: flex;
    flex-wrap: wrap; 
    gap: 10px; 
    margin-bottom: 20px;
    justify-content: center; 
}

.filter-buttons button {
    padding: 8px 12px; 
    border: none;
    background-color: #f1e8d9; 
    cursor: pointer;
    border-radius: 50px; 
    font-weight: bold;
    transition: background-color 0.3s; 
    min-width: 10px; 
    width: auto; 
    flex: 0 0 auto; 
}

/* Hover effect */
.filter-buttons button:hover {
    background-color: #ccc; 
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .filter-buttons {
        flex-direction: column; 
        gap: 8px;
        align-items: center; 
    }

    .filter-buttons button {
        width: 150px; 
        padding: 10px; 
        font-size: 14px; 
    }
}

@media (max-width: 480px) {
    .filter-buttons button {
        width: 100%; 
        max-width: 200px; 
        padding: 12px 20px; 
        font-size: 18px; 
    }
}

/* Fabric items grid */
.fabric-items {
    display: flex;
    flex-wrap: wrap; 
    justify-content: center; 
    padding: 10px;
    max-width: 1000px; 
    margin: 0 auto; 
    gap: 20px;
}

.fabric-card {
    width: 150px; 
    height: auto; 
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.fabric-content {
    display: flex;
    flex-direction: column; 
    align-items: center; 
}

.fabric-card img {
    width: 100%; 
    height: auto; 
    object-fit: cover; 
}

.fabric-card p {
    margin-top: 5px;
    font-weight: bold;
    font-size: 14px;
    text-align: center; /* Center text below image */
    color: #1e1e1e;
}


        </style>
</head>
<body class="vh-100">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #f1e8d9; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <a class="navbar-brand fs-4" href="sndLandingpage.php">
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
                        <a class="nav-link nav-link-black active" aria-current="page" href="cart.php">
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

                    <!-- New Account Dropdown Menu -->
                    <li class="nav-item dropdown">
                        <a class="nav-link nav-link-black dropdown-toggle" href="#" id="accountDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="Assets/svg(icons)/account_circle.svg" alt="account">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="accountDropdown">
                            <li>
                                <a class="dropdown-item" href="accountSettings.php">Account & Security</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item text-danger" href="haveacc.php">Logout</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Category Card -->
    <div class="category-card p-4">
        <h2 class="text-center mb-4">Category</h2> <!-- Ensure the header is directly in the card -->
        <div class="row justify-content-center">
            <div class="category col-4 col-md-2 text-center">
                <a href="https://www.facebook.com/surrealsoreaaal">
                    <img src="Assets/fabrics/Laces.jpg" alt="Lace" class="rounded-circle">
                </a>
                <p>LACES</p>
            </div>
            <div class="category col-4 col-md-2 text-center">
                <a href="#">
                    <img src="Assets/fabrics/beaded lace.jpg" alt="Beaded Lace" class="rounded-circle">
                </a>
                <p>BEADED LACE</p>
            </div>
            <div class="category col-4 col-md-2 text-center">
                <a href="#">
                    <img src="Assets/fabrics/sequins.jpg" alt="Sequins" class="rounded-circle">
                </a>
                <p>SEQUINS</p>
            </div>
            <div class="category col-4 col-md-2 text-center">
                <a href="#">
                    <img src="Assets/fabrics/silk.jpg" alt="Silk" class="rounded-circle">
                </a>
                <p>SILK</p>
            </div>
            <div class="category col-4 col-md-2 text-center">
                <a href="#">
                    <img src="Assets/fabrics/velvet.jpg" alt="Velvet" class="rounded-circle">
                </a>
                <p>VELVET</p>
            </div>
            <div class="category col-4 col-md-2 text-center">
                <a href="#">
                    <img src="Assets/fabrics/satin.png" alt="Satin" class="rounded-circle">
                </a>
                <p>SATIN</p>
            </div>
        </div>
    </div>
    
    <!-- Filter Buttons -->
    <div class="filter-buttons">
        <button>All</button>
        <button>Newest</button>
        <button>Popular</button>
        <button>Basta 1</button>
        <button>Basta 2</button>
    </div>

    <!-- Fabric Items -->
    <div class="fabric-items">
        <div class="fabric-card">
            <div class="fabric-content">
                <a href="product.html">
                    <img src="<?= htmlspecialchars($product['product_image']) ?>" alt="Fabric 1"></a>
                <p>Enchanted Lace</p>
            </div>
        </div>  

            <div class="fabric-card">
                <div class="fabric-content">
                    <a href="#"><img src="Assets/fabrics/gingham-orange.jpg" alt="Fabric 2"></a>
                    <p>Gingham Orange</p>
                </div>
            </div>

        <div class="fabric-card">
            <div class="fabric-content">
                <a href="#"><img src="Assets/fabrics/gingham-purple.jpg" alt="Fabric 3"></a>
                <p>Gingham Purple</p>
            </div>
        </div>
        <div class="fabric-card">
            <div class="fabric-content">
                <a href="#"><img src="Assets/fabrics/gingham-pink.jpg" alt="Fabric 4"></a>
                <p>Gingham Pink</p>
            </div>
        </div>
        <div class="fabric-card">
            <div class="fabric-content">
                <a href="#"><img src="Assets/fabrics/gingham-yellow.jpg" alt="Fabric 5"></a>
                <p>Gingham Yellow</p>
            </div>
        </div>
        <!-- Add more fabric cards as needed -->
    </div>
</body>
</html>
