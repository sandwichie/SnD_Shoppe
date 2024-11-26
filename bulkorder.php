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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['request_bulk'])) {
    // Retrieve form data
    $paymentMethod = $_POST['payment-option'] ?? null;
    $deliveryDate = $_POST['date'] ?? null;
    $yards = $_POST['yards'] ?? [];
    $rolls = $_POST['rolls'] ?? [];
    $colorOptions = $_POST['color_option'] ?? [];

    foreach ($_POST['yards'] as $productId => $yards) {
        $yards = isset($_POST['yards'][$productId]) ? (int)$_POST['yards'][$productId] : 0;
        $rolls = isset($_POST['rolls'][$productId]) ? (int)$_POST['rolls'][$productId] : 0;
        $color = $_POST['color_option'][$productId] ?? '';

        try {
            // Update the existing record in the database
            $stmt = $pdo->prepare("
                UPDATE bulk_shopping_cart
                SET 
                    payment_method = :payment_method,
                    delivery_date = :delivery_date,
                    delivery_method = :delivery_method,
                    yards = :yards,
                    rolls = :rolls,
                    color = :color
                WHERE product_id = :product_id
            ");
            $stmt->execute([
                ':payment_method' => $paymentMethod,
                ':delivery_date' => $deliveryDate,
                ':delivery_method' => $deliveryMethod,
                ':yards' => $yards,
                ':rolls' => $rolls,
                ':color' => $color,
                ':product_id' => $productId
            ]);
        } catch (PDOException $e) {
            // Handle SQL errors
            echo "Error updating bulk shopping cart: " . htmlspecialchars($e->getMessage());
        }
    }

    // Redirect to the cart page after the update
    
    exit;
}

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
    background: url(Assets/bgLogin.png) rgba(0, 0, 0, 0.3);
    background-blend-mode: multiply;
    background-position: center;
    background-size: cover;
    background-repeat:repeat-y;
    min-height: 100vh;
    overflow-y: auto;
    margin: 0;
    padding: 150px 0 0; /* Add top padding for fixed header */
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
    background-color: #DABC8F;
}

.home-btn {
    background-color: #6c757d;
    color: white;
    border: none;
    margin-top: 17px;
    font-weight: bold;
}

.home-btn:hover {
    background-color: #b6b3ae;
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
            <select class="form-select shadow-sm" id="payment-opt" name="payment-option">
              <option selected>Cash on Delivery (COD)</option>
              <option value="gcash">GCash</option>
              <option value="maya">Maya</option>
            </select>
          </div>

          <!-- SELECTED DATE -->
            <div class="col-md-6">
                <label class="form-label">SELECT PREFFERED DELIVERY DATE:</label>
                <input
                    type="date"
                    class="form-control shadow-sm"
                    placeholder="MM/DD/YYYY"
                    name="date"
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
                        id="pickup"
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
                        id="contact"
                        name="deliveryMethod"
                        class="form-check-input"
                    />
                    <label for="contact" class="form-check-label">CONTACT SELLER (Preferred option for COD payment method)</label>
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
                    <h2 class="text-dark mb-3" style="font-weight: bold;"><?php echo htmlspecialchars($bulk['product']); ?></h2>
                    <p>
                        <h6 style="font-size: 15px; margin-top: -23px; color:#1e1e1e; text-align: justify">Type in <span style="font-weight: bold; font-size: 20px; color: #198754;">'0'</span> in the number inputs to not order in YARDS or ROLLS.</h4>
                    </p>
                    <p class="mb-3">
                        <span class="font-weight-bold text-muted">PRICE: </span>
                        <span class="price text-success" id="price-per-yard-<?php echo $bulk['product_id']; ?>">
                            <?php echo htmlspecialchars($bulk['unit_price']); ?>
                        </span>
                        <span class="text-muted">PER YARD</span><br>
                    </p>

                    <!-- Yards Input -->
                    <div class="rolls d-flex align-items-center mb-4">
                        <span class="font-weight-bold text-muted me-3">YARDS (max. 50):</span>
                        <div class="quantity-container d-flex align-items-center">
                            <input
                                type="number"
                                id="yards-value-<?php echo $bulk['product_id']; ?>"
                                class="form-control form-control-sm text-center"
                                name="yards[<?php echo $bulk['product_id']; ?>]"
                                value="0" 
                                max="50"
                                min="30"
                                style="width: 60px; background-color: white; border: none; outline: none; text-align: center;"
                                oninput="updateSubtotal(<?php echo $bulk['product_id']; ?>)"
                            />
                            <span class="ms-2">YARDS</span>
                        </div>
                    </div>

                    <!-- Roll Price -->
                    <p class="mb-3">
                        <span class="font-weight-bold text-muted">PRICE: </span>
                        <span class="price text-success" id="price-per-roll-<?php echo $bulk['product_id']; ?>">
                            <?php echo htmlspecialchars($bulk['roll_price']); ?>
                        </span>
                        <span class="text-muted">PER ROLL</span>
                    </p>

                    <!-- Rolls Input -->
                    <div class="rolls d-flex align-items-center mb-4" style="margin-bottom: -50px;">
                        <span class="font-weight-bold text-muted me-3">ROLLS (60 yards per roll):</span>
                        <div class="quantity-container d-flex align-items-center">
                            <input
                                type="number"
                                id="rolls-value-<?php echo $bulk['product_id']; ?>"
                                name="rolls[<?php echo $bulk['product_id']; ?>]"
                                class="form-control form-control-sm text-center"
                                value="0" 
                                max="10"
                                min="0"
                                style="width: 60px; background-color: white; border: none; outline: none; text-align: center;"
                                oninput="updateSubtotal(<?php echo $bulk['product_id']; ?>)"
                            />
                            <span class="ms-2">ROLLS</span>
                        </div>
                    </div>

                    <div class="selector mt-3" style="margin-bottom: 20px;">
                        <label class="form-label">Available Colors:</label>
                        <div class="color-options d-flex flex-wrap">
                            <select class="form-select shadow-sm" id="color-option-<?php echo $bulk['product_id']; ?>" name="color_option[<?php echo $bulk['product_id']; ?>]">
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

                    <!-- Item Subtotal Display -->
                    <p>
                        <strong>ITEM SUBTOTAL:</strong>
                        <span id="subtotal-<?php echo $bulk['product_id']; ?>" style="font-weight: bold; font-size: 23px; color: #C08C3C;">P 0.00</span>
                    </p>

                    <!-- Remove Item -->
                    <div class="remove-item">
                        <form method="POST" action="">
                            <input type="hidden" name="bulk_cart_id" value="<?php echo $bulk['bulk_cart_id']; ?>" />
                            <button class="order-btn btn btn-primary btn-lg w-100 mb-3" style="background-color: #901A1B; border:none; margin-right: 5px;" type="submit" name="remove">Remove</button>
                        </form>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

        <!-- Subtotal Calculation -->
        <script>
            function updateSubtotal(productId) {
                // Get input values
                const yards = parseFloat(document.getElementById(`yards-value-${productId}`).value) || 0;
                const rolls = parseFloat(document.getElementById(`rolls-value-${productId}`).value) || 0;

                // Get prices
                const pricePerYard = parseFloat(document.getElementById(`price-per-yard-${productId}`).textContent) || 0;
                const pricePerRoll = parseFloat(document.getElementById(`price-per-roll-${productId}`).textContent) || 0;

                // Calculate subtotal
                const yardsSubtotal = yards * pricePerYard;
                const rollsSubtotal = rolls * pricePerRoll;
                const totalSubtotal = yardsSubtotal + rollsSubtotal;

                // Update subtotal display
                document.getElementById(`subtotal-${productId}`).textContent = `P ${totalSubtotal.toFixed(2)}`;
            
                // Update grand total
                updateGrandTotal();
            }

            function updateGrandTotal() {
                let grandTotal = 0;

                // Find all subtotals and sum them up
                document.querySelectorAll("[id^='subtotal-']").forEach((subtotalElement) => {
                    const subtotalText = subtotalElement.textContent.replace("P ", ""); // Remove "P " for calculation
                    const subtotalValue = parseFloat(subtotalText) || 0;
                    grandTotal += subtotalValue;
                });

                // Update grand total display
                document.getElementById("grand-total").textContent = `P ${grandTotal.toFixed(2)}`;
            }

            // Initialize subtotals and grand total on page load
            function initializeTotals() {
                const productIds = document.querySelectorAll("[id^='yards-value-']");
                productIds.forEach((input) => {
                    const productId = input.id.split("-")[2]; // Extract product ID from the element ID
                    updateSubtotal(productId);
                });
            }

            // Run initialization when the page loads
            window.onload = initializeTotals;

        </script>

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
                    <p>
                        <strong>SHIPPING FEE:</strong>
                        <span style="color: #C08C3C;">NOT AVAILABLE</span>
                    </p>
                    <p>
                        <strong>GRAND TOTAL: <span id="grand-total" class="price text-success">P 0.00</span></strong>
                    </p>
                </div>

                <div class="buttons mt-4">
                    <p>
                        <h6 style="font-size: 15px; margin-top: -20px; color:#1e1e1e; padding: 5px; text-align: justify">Please make sure all your details and selected items are correct before proceeding with the request to avoid delays or issues!</h4>
                    </p>
                    <form method="POST" action="">
                        <button class="order-btn btn btn-primary btn-lg w-100 mb-3" name=request_bulk>
                            START ORDER REQUEST
                        </button>
                    </form>
                    <button class="contact-btn btn btn-outline-primary btn-lg w-100">
                        CONTACT SELLER
                    </button>
                    <form method="POST" action="homepage.php">
                        <button class="home-btn btn btn-outline-primary btn-lg w-100">
                            RETURN TO HOMEPAGE TO ORDER MORE!
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

    </section

    <script src="script.js"></script>
  </body>
</html>
