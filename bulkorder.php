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

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: haveacc.php"); // Redirect to login if not logged in
    exit;
}

// Retrieve the user ID from the session
$user_id = $_SESSION['user_id'];

// Get the product details in the bulk shopping cart for the logged-in user
$stmt = $pdo->prepare('SELECT bulk_cart_id, product_id, product, unit_price, roll_price FROM bulk_shopping_cart WHERE customer_id = :user_id');
$stmt->execute(['user_id' => $user_id]);
$bulk_items = $stmt->fetchAll(PDO::FETCH_ASSOC);


$bulk_colors = []; // Initialize the array
foreach ($bulk_items as $bulk) {
    $stmtColors = $pdo->prepare('SELECT color_id, color_name FROM product_colors WHERE product_id = :product_id');
    $stmtColors->execute(['product_id' => $bulk['product_id']]);
    $colors = $stmtColors->fetchAll(PDO::FETCH_ASSOC);

    if (empty($colors)) {
        error_log("No colors found for product_id: " . $bulk['product_id']);
    }

    $bulk_colors[$bulk['product_id']] = $colors;
}

if (isset($_POST['remove'])) {
    // Get the bulk_cart_id from the form
    $bulk_cart_id = $_POST['bulk_cart_id'];

    // Prepare and execute the query to remove the item from the cart
    $stmt = $pdo->prepare('DELETE FROM bulk_shopping_cart WHERE bulk_cart_id = :bulk_cart_id');
    $stmt->execute(['bulk_cart_id' => $bulk_cart_id]);

    // Optionally, redirect to refresh the page
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// Fetch shipping address from the database
$profile_data = [];
$stmt = $pdo->prepare('SELECT firstname, lastname, email, phone, gender, birthdate, address, subdivision,
barangay, postal, city, place FROM users_credentials WHERE id = ?');
$stmt->execute([$user_id]);
$profile_data = $stmt->fetch(PDO::FETCH_ASSOC);
$customer_name = $profile_data['firstname'] . ' ' . $profile_data['lastname'];
$address = $profile_data['address'] . ', ' . $profile_data['subdivision'] . ', ' . $profile_data['barangay'] . ', ' . $profile_data['city'] . ', ' . $profile_data['place'];


?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous"
    />
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"
    ></script>
    <link rel="icon" href="/Assets/images/sndlogo.png" type="logo" />
    <link rel="stylesheet"/>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"
    />
    <title>S&D Fabrics</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Kumbh+Sans:wght@100..900&family=Playfair+Display+SC:ital,wght@0,400;0,700;0,900;1,400;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap');

/* General Styles */
body {
    background: url(/Assets/images/bgLogin.png) rgba(0, 0, 0, 0.3);
    background-blend-mode: multiply;
    background-position: center;
    background-size: cover;
    background-repeat:repeat-y;
    min-height: 100vh;
    overflow-y: auto;
    margin: 0;
    padding: 150px 0 0; /* Add top padding for fixed header */
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

.navbar-toggler-icon {
    background-image: url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba(30, 30, 30, 1)' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
}

.input-group-text, .form-control {
    background-color: #f1e8d9;
    border: 1px solid #d9b65d;
    border-radius: 10px;
}

.form-control {
    border-radius: 0 10px 10px 0;
    text-align: left;
}

h1, h3 {
    font-family: "Playfair Display SC", serif;
    font-size: 40px;
    color: #1e1e1e;
}

.header-container {
    position: fixed;
    top: 60px;
    left: 0;
    right: 0;
    z-index: 999;
    background-color: #b6b3ae;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    border-radius: 10px;
}

.card {
    background-color: transparent;
    margin: 0;
    text-align: center;
    border-radius: 10px;
}

.table-bordered {
    border-radius: 10px;
    overflow: hidden;
}

.custom-padding {
    padding-top: 30px;
}

/* Account Dropdown Styling */
.navbar .dropdown-menu {
    border-radius: 11px;
    padding: 0;
    min-width: 150px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
}

.navbar .dropdown-item {
    padding: 10px 16px;
    font-size: 14px;
    color: #1e1e1e;
    transition: background-color 0.3s;
}

.navbar .dropdown-item:hover {
    background-color: #f1e8d9;
}

.dropdown-item.text-danger {
    color: #dc3545;
    font-weight: bold;
}

.dropdown-divider {
    margin: 0;
}

/* PAYMENT AND DELIVERY OPTION Styles */
.payment-delivery-options {
    background-color: #f1e8d9;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.payment-delivery-options h3 {
    font-size: 24px;
    font-weight: 700;
}

.form-label {
    font-weight: 600;
}

.form-select,
.form-control {
    border-radius: 8px;
    font-size: 16px;
    padding: 8px 12px;
}

.delivery-method {
    margin-top: 20px;
}

.delivery-method .form-check {
    display: flex;
    align-items: center;
    margin-right: 20px;
}

.form-check-input {
    margin-right: 10px;
}

.form-check-label {
    font-weight: 500;
    font-size: 14px;
}

/* Product Details */
.product-container {
    display: flex;
    gap: 3rem;
    flex-wrap: wrap;
}

.product-details,
.details {
    background-color: #f1e8d9;
    padding: 1.5rem;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.product-details-section {
    background-color: #ddceb4;
}

.product-details h2 {
    font-family: 'Playfair Display SC', serif;
    font-size: 28px;
    color: #333;
    margin-bottom: 1rem;
}

.product-details p {
    font-size: 16px;
    color: #555;
}

.price {
    font-weight: bold;
    font-size: 20px;
    color: #e044a5;
}

.colors {
    margin-top: 20px;
}

.color-controls .color-row {
    margin-bottom: 10px;
}

.color-row .color-swatch {
    width: 20px;
    height: 20px;
    margin-right: 10px;
    border-radius: 50%;
}

.form-control,
.form-select {
    border-radius: 8px;
    font-size: 16px;
    padding: 8px 12px;
}

.color-quantity {
    width: 60px;
    text-align: center;
    margin-right: 10px;
}

.decrement,
.increment {
    background-color: #f1e8d9;
    border: 1px solid #d9b65d;
}

.decrement:hover,
.increment:hover {
    background-color: #d9b65d;
    color: white;
}

.details h3 {
    font-size: 24px;
    font-weight: bold;
    color: #333;
    margin-bottom: 1rem;
}

.details p {
    font-size: 16px;
    color: #555;
}

.subtotal {
    background-color: #f9f9f9;
    padding: 1rem;
    border-radius: 8px;
    margin-top: 1rem;
}

.subtotal .total {
    color: #e044a5;
    font-weight: bold;
    font-size: 18px;
}

/* Button Styles */
.order-btn,
.contact-btn {
    padding: 1rem 1.5rem; /* Increased padding for a more uniform look */
    font-size: 18px; /* Slightly larger font size for better readability */
    font-weight: bold;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    width: 100%; /* Ensures buttons take full width of the parent container */
}

.order-btn {
    background-color: #19583b;
}

.order-btn:hover {
    background-color: #238f4f;
    color: white;
}

.contact-btn {
    background-color: #c9a46b;
    color: white;
}

.contact-btn:hover {
    background-color: #b68958;
}

/* Responsive Adjustment for Smaller Screens */
@media (max-width: 767px) {
    .order-btn,
    .contact-btn {
        padding: 1rem; /* Ensure appropriate padding on smaller screens */
        font-size: 16px; /* Adjust font size for smaller screens */
    }
}


.btn {
    padding: 4px 12px;
    font-size: 14px;
    border-radius: 4px;
}

.btn-secondary {
    background-color: #6c757d;
    color: #fff;
    border: 1px solid #6c757d;
}

.btn-secondary:hover {
    background-color: #5a6268;
    border-color: #545b62;
}

/* Enhanced Color Section Styling */
.colors {
    padding: 1.5rem;
    background-color: #f9f9f9;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.colors p {
    font-size: 18px;
    color: #444;
    margin-bottom: 1rem;
}

.color-controls {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.color-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 8px;
    background-color: #fff;
}

.color-row .color-swatch {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    margin-right: 20px;
}

.color-quantity {
    width: 80px;
    height: 30px;
    font-size: 14px;
    text-align: center;
    border-radius: 5px;
}

.decrement,
.increment {
    padding: 5px 10px;
    border-radius: 5px;
    font-size: 18px;
    background-color: #ddd;
}

.decrement:hover,
.increment:hover {
    background-color: #ccc;
    cursor: pointer;
}

.rolls {
    display: flex;
    align-items: center;
    background-color: #f1e8d9; /* Light background color for visibility */
    padding: 10px;
    border-radius: 8px;
    border: 1px solid #dcaa2e;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Optional shadow */
}

.quantity-container {
    display: flex;
    align-items: center;
}

#rolls-value {
    width: 60px;
    border: 1px solid #d9b65d; /* Border for visibility */
    outline: none;
    text-align: center;
    background-color: #fff; /* Ensure input field background is visible */
}

#yards-value {
    width: 60px;
    border: 1px solid #d9b65d; /* Border for visibility */
    outline: none;
    text-align: center;
    background-color: #fff; /* Ensure input field background is visible */
}

#rolls-value:focus {
    border-color: #e044a5; /* Highlight input field on focus */
}

#yards-value:focus {
    border-color: #e044a5; /* Highlight input field on focus */
}

.remove-item {
    display: flex;        /* Enable Flexbox */
    justify-content: flex-end; /* Align children (the button) to the right */
    margin-right: 5px;
}


</style>
  </head>
  <body class="vh-100">
    <!-- Navbar -->
    <!-- Navbar -->
    <nav
      class="navbar navbar-expand-lg navbar-dark"
      style="
        background-color: #f1e8d9;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
      "
    >
      <div
        class="container-fluid d-flex justify-content-between align-items-center"
      >
        <a class="navbar-brand fs-4" href="homepage.php">
          <img src="Assets/sndlogo.png" width="70px" alt="Logo" />
        </a>

        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarTogglerDemo01"
          aria-controls="navbarTogglerDemo01"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
          <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link nav-link-black" href="#">
                <img src="/Assets/svg(icons)/notifications.svg" alt="notif" />
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link nav-link-black" href="#">
                <img src="/Assets/svg(icons)/inbox.svg" alt="inbox" />
              </a>
            </li>

            <!-- New Account Dropdown Menu -->
            <li class="nav-item dropdown">
              <a
                class="nav-link nav-link-black dropdown-toggle"
                href="#"
                id="accountDropdown"
                role="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"
              >
                <img
                  src="/Assets/svg(icons)/account_circle.svg"
                  alt="account"
                />
              </a>
              <ul
                class="dropdown-menu dropdown-menu-end"
                aria-labelledby="accountDropdown"
              >
                <li>
                  <a
                    class="dropdown-item"
                    href="/pages/myAccountPage/myPurchase.html"
                    >My Account</a
                  >
                </li>
                <li>
                  <hr class="dropdown-divider" />
                </li>
                <li>
                  <a class="dropdown-item text-danger" href="#">Logout</a>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Checkout Content -->
    <div class="header-container">
      <div class="card text-center">
        <div class="card-body">
          <h1 class="mb-0 custom-padding">BULK ORDER</h1>
        </div>
      </div>
    </div>

    <!-- Payment and Delivery Option Content -->
    <section class="delivery-page container my-5">
      <div class="payment-delivery-options shadow p-4 mb-5">
        <h3 class="text-center mb-4">PAYMENT AND DELIVERY OPTION</h3>
        <div class="row g-3">
          <!-- PAYMENT METHOD -->
          <div class="col-md-6">
            <label class="form-label">PAYMENT METHOD:</label>
            <select class="form-select shadow-sm" id="payment-option">
              <option selected>CASH ON DELIVERY</option>
              <option value="gcash">GCash</option>
              <option value="maya">Maya</option>
            </select>
          </div>
          <!-- SELECTED DATE -->
          <div class="col-md-6">
            <label class="form-label">SELECT PREFFERED DELIVERY DATE:</label>
            <input
              type="text"
              class="form-control shadow-sm"
              placeholder="MM/DD/YYYY"
            />
          </div>
        </div>

        <!-- DELIVERY METHOD -->
        <div class="delivery-method mt-4">
            <label class="form-label">DELIVERY METHOD:</label>
            <div class="d-flex flex-wrap justify-content-around mt-2">
                    <div class="form-check">
                    <input
                        type="radio"
                        id="pickUp"
                        name="deliveryMethod"
                        class="form-check-input"
                        checked
                    />
                    <label for="pickUp" class="form-check-label"
                        >PICK UP IN STORE</label>
                    </div>
                    <div class="form-check">
                    <input
                        type="radio"
                        id="lbc"
                        name="deliveryMethod"
                        class="form-check-input"
                    />
                    <label for="lbc" class="form-check-label">WILL CONTACT SELLER FIRST</label>
                    </div>
            </div>
        </div>
      </div>

<div class="container my-3">
    <div class="row">
    <!-- Product Details -->
        <div class="col-lg-6 col-md-12">
            <?php foreach ($bulk_items as $bulk): ?>
            <div class="product-details border rounded shadow-sm p-3 d-flex flex-column" style="margin-bottom: 15px">
                <h2 class="text-dark mb-3"><?php echo htmlspecialchars($bulk['product']); ?></h2>
                <p class="mb-3">
                <span class="font-weight-bold text-muted">PRICE: </span>
                <span class="price text-success"><?php echo htmlspecialchars($bulk['unit_price']); ?></span>
                <span class="text-muted">PER YARD</span><br>
                </p>

                <div class="rolls d-flex align-items-center mb-4">
                <span class="font-weight-bold text-muted me-3">YARDS (max. 50):</span>
                <div class="quantity-container d-flex align-items-center">
                    <input
                    type="number"
                    id="yards-value"
                    class="form-control form-control-sm text-center"
                    value="30"
                    max="50"
                    min="30"
                    style="width: 60px; border: none; outline: none; text-align: center;"
                    />
                    <span class="ms-2">YARDS</span>
                </div>
                </div>

                <p class="mb-3">
                
                    <span class="font-weight-bold text-muted">PRICE: </span>
                    <span class="price text-success"><?php echo htmlspecialchars($bulk['roll_price']); ?></span>
                    <span class="text-muted">PER ROLL</span>
                    
                </p>

                <div class="rolls d-flex align-items-center mb-4" style="margin-bottom: -50px;">
                <span class="font-weight-bold text-muted me-3">ROLLS (60 yards per roll):</span>
                <div class="quantity-container d-flex align-items-center">
                    <input
                        type="number"
                        id="rolls-value"
                        class="form-control form-control-sm text-center"
                        value="0"
                        max="10"
                        min="0"
                        style="width: 60px; border: none; outline: none; text-align: center;"
                    />
                    <span class="ms-2">ROLLS</span>
                </div>
            </div>

                <div class="selector mt-3" style="margin-bottom: 20px;">
                    <label class="form-label">Available Colors:</label>
                    <div class="color-options d-flex flex-wrap">
                        <select class="form-select shadow-sm" id="color-option-<?php echo $bulk['product_id']; ?>">
                            <?php 
                            if (isset($bulk_colors[$bulk['product_id']]) && !empty($bulk_colors[$bulk['product_id']])): 
                                foreach ($bulk_colors[$bulk['product_id']] as $color): ?>
                                    <option value="<?php echo htmlspecialchars($color['color_name']); ?>">
                                        <?php echo htmlspecialchars($color['color_name']); ?>
                                    </option>
                                <?php endforeach; 
                            else: ?>
                                <option>No colors available</option>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>

                <div class="remove-item">
                    <form method="POST" action="">
                        <input type="hidden" name="bulk_cart_id" value="<?php echo $bulk['bulk_cart_id']; ?>" />
                        <button class="order-btn btn btn-primary btn-lg w-100 mb-3" style="background-color: #901A1B; border:none; margin-right: 5px;" type="submit" name="remove">Remove</button>
                    </form>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Details Section -->
        <div class="col-lg-6 col-md-12">
            <div class="details border rounded shadow-sm p-3 d-flex flex-column">
                <h3 class="text-dark mb-3">CUSTOMER DETAILS</h3>
                <p>
                    <strong>FULL NAME:</strong>
                    <span id="full-name" class="form-control-plaintext ms-3">
                        <?php echo htmlspecialchars($profile_data['firstname'] . ' ' . $profile_data['lastname'] ?? ''); ?>
                    </span>
                </p>
                <p>
                    <strong>PHONE:</strong>
                    <span id="contact" class="form-control-plaintext ms-3">
                        <?php echo htmlspecialchars($profile_data['phone'] ?? ''); ?>
                    </span>
                </p>
                <p>
                    <strong>SHIPPING ADDRESS:</strong>
                    <span id="address" name= "address" class="form-control-plaintext ms-3">
                    <?php echo htmlspecialchars($profile_data['address'] . ' ' . $profile_data['subdivision'] . ' ' . $profile_data['barangay']
                    . ' ' . $profile_data['postal'] . ' ' . $profile_data['city'] . ' ' . $profile_data['place']); ?> 
                </p>
                <hr class="my-3" />

                <div class="subtotal p-3 rounded shadow-sm">
                    <?php 
                    // Calculate subtotal based on the product prices and quantities
                    $subtotal = 0;
                    foreach ($bulk_items as $bulk) {
                        $subtotal += $bulk['unit_price'] * 5; // Multiply by quantity, adjust as needed
                    }
                    ?>
                    <p>
                        <strong>ITEM SUBTOTAL:</strong>
                        <span class="total text-success">P <?php echo number_format($subtotal, 2); ?></span>
                    </p>
                    <p>
                        <strong>SHIPPING FEE:</strong>
                        <span class="text-warning">NOT AVAILABLE</span>
                    </p>
                    <p>
                        <strong>SUBTOTAL:</strong>
                        <span class="total text-danger">P <?php echo number_format($subtotal, 2); ?></span>
                    </p>
                </div>

                <div class="buttons mt-4">
                    <button class="order-btn btn btn-primary btn-lg w-100 mb-3">
                        START ORDER REQUEST
                    </button>
                    <button class="contact-btn btn btn-outline-primary btn-lg w-100">
                        CONTACT SUPPLIER
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

    </section>

    <script>
  
    </script>

    <script src="script.js"></script>
  </body>
</html>
