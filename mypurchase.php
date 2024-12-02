
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

if (!isset($_SESSION['user_id'])) {
    header("Location: haveacc.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch user profile data
$profile_data = [];
$stmt = $pdo->prepare('SELECT lastname, firstname FROM users_credentials WHERE id = :user_id');
$stmt->execute(['user_id' => $user_id]);
$profile_data = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("
    SELECT 
        od.order_num, 
        od.total_price, 
        od.sub_total, 
        od.status, 
        oi.product_name, 
        oi.color, 
        oi.quantity, 
        p.product_image
    FROM order_details od
    JOIN order_items oi ON od.order_num = oi.order_num
    JOIN products p ON oi.product_id = p.product_id
    WHERE od.customer_id = :user_id
");
$stmt->execute([':user_id' => $user_id]);
$order_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("
    SELECT 
        od.bulk_order_id, 
        od.grand_total, 
        od.status, 
        oi.product_name,
        oi.item_subtotal, 
        oi.color, 
        oi.yards, 
        oi.rolls, 
        p.product_image
    FROM bulk_order_details od
    JOIN bulk_order_items oi ON od.bulk_order_id = oi.bulk_order_id
    JOIN products p ON oi.product_id = p.product_id
    WHERE od.customer_id = :user_id
");
$stmt->execute([':user_id' => $user_id]);
$bulk_order_data = $stmt->fetchAll(PDO::FETCH_ASSOC);


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
    <link rel="stylesheet" href="css\mypurchase.css" />
    <link rel="icon" href="PIC/sndlogo.png" type="image/png" />
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"
    ></script>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"
    />
    <title>S&D Fabrics Dashboard</title>

    <style>
      body {
        font-family: "Playfair Display", serif;
      }
      .table {
        border-collapse: separate;
        border-spacing: 0 0.4rem; /* Adds spacing between rows */
        background-color: transparent;
      }

      .table thead th {
        font-size: 0.95rem;
        background-color: #B5A888;
        border: none;
      }

      .table img {
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      }

      .table-hover tbody tr:hover {
        background-color: #f1f3f5;
      }
      .badge-to-pay {
        background-color: #dcaa2e;
        color: #fff; 
      }
      .badge-to-ship {
        background-color: #a5a524; 
        color: #fff; 
      }
      .badge-to-receive {
        background-color: #6d9d2e; 
        color: #fff;
      }
      .badge-completed {
        background-color: #008253; 
        color: #fff;
      }
      .badge-cancelled {
        background-color: #B02A2B; 
        color: #fff;
      }
      .badge-other {
        background-color: #89a53c; 
        color: #fff;
      }
      .nav-tabs .nav-link {
        border-radius: 3; 
        color: #1e1e1e; 
      }
      .nav-tabs .nav-link:hover {
        color: #1e1e1e; 
        background-color: #B5A888; 
        border-bottom: 2px solid #007bff; 
      }
      .nav-tabs .nav-link.active {
        color: #1e1e1e; 
        text-decoration: underline;
        background-color: #B5A888; 
        border-bottom: 2px solid #007bff; 
      }
      .nav-tabs {
        border-bottom: none;
      }
    </style>
  </head>
  <body class="vh-100">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark main-navbar">
      <div
        class="container-fluid d-flex justify-content-between align-items-center"
      >
        <a class="navbar-brand fs-4" href="homepage.php">
          <img src="PIC/sndlogo.png" width="70px" alt="Logo" />
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

          <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a
                class="nav-link nav-link-black active"
                aria-current="page"
                href="cart.php" 
              >
                <img src="/SnD_Shoppe-main/Assets/svg(icons)/shopping_cart.svg" alt="cart" />
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link nav-link-black" href="#">
                <img src="/SnD_Shoppe-main/Assets/svg(icons)/notifications.svg" alt="notif" />
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link nav-link-black" href="#">
                <img src="/SnD_Shoppe-main/Assets/svg(icons)/inbox.svg" alt="inbox" />
              </a>
            </li>
            <!-- Account Dropdown Menu -->
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
                  src="/SnD_Shoppe-main/Assets/svg(icons)/account_circle.svg"
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
                    href="accountSettings.php"
                    >My Account</a
                  >
                </li>
                <li>
                  <hr class="dropdown-divider" />
                </li>
                <li>
                  <a class="dropdown-item text-danger" href="logout.php">Logout</a>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Sidebar -->
    <div
      class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark"
      id="sidebar"
      style="width: 250px; height: 100vh; position: fixed"
    >
      <ul class="nav nav-pills flex-column mb-auto">
        <li>
          <a href="mypurchase.php" class="nav-link custom-active" aria-current="page">
            <i class="bi bi-box-seam"></i> Orders
          </a>
        </li>
        <li>
          <a href="cart.php" class="nav-link text-white">
            <i class="bi bi-heart"></i> Saved Items
          </a>
        </li>
        <li>
          <a
            href="accountSettings.php"
            class="nav-link text-white"
          >
            <i class="bi bi-person"></i> Account Settings
          </a>
        </li>
      </ul>
    </div>

    <!-- Main Dashboard Layout with Content -->
    <div class="d-flex" style="margin-top: 96px; margin-left: 250px">
      <!-- Main Content -->
      <div class="flex-grow-1 p-4">
    <!-- Overview Card -->
      <div class="card" style="background-color: #f1e8d9">
          <div class="card-body">
              <h2 class="card-title">My Purchases</h2>
              <p class="card-text">
                  Welcome back, <span style="font-weight: bold; font-size:large;"><?php echo htmlspecialchars($profile_data['firstname']); ?></span>! Here’s a summary of your recent activities.
              </p>

            <!-- Order Status Tabs and Search Bar -->
            <div class="order-status-container">
              <!-- Tabs for Order Statuses -->
              <ul class="nav nav-tabs" id="orderStatusTabs" role="tablist">
                <li class="nav-item" role="presentation">
                  <button
                    class="nav-link active"
                    id="all-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#all"
                    type="button"
                    role="tab"
                    aria-controls="all"
                    aria-selected="true"
                    style="border: none; border-bottom: 3px solid transparent; transition: all 0.3s; font-size: 0.9rem;"
                  >
                    All
                  </button>
                </li>
                <li class="nav-item" role="presentation">
                  <button
                    class="nav-link"
                    id="to-pay-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#to-pay"
                    type="button"
                    role="tab"
                    aria-controls="to-pay"
                    aria-selected="false"
                    style="border: none; border-bottom: 3px solid transparent; transition: all 0.3s; font-size: 0.9rem;"
                  >
                    To Pay
                  </button>
                  
                </li>
                <li class="nav-item" role="presentation">
                  <button
                    class="nav-link"
                    id="to-ship-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#to-ship"
                    type="button"
                    role="tab"
                    aria-controls="to-ship"
                    aria-selected="false"
                    style="border: none; border-bottom: 3px solid transparent; transition: all 0.3s; font-size: 0.9rem;"
                  >
                    To Ship
                  </button>
                </li>
                <li class="nav-item" role="presentation">
                  <button
                    class="nav-link"
                    id="to-receive-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#to-receive"
                    type="button"
                    role="tab"
                    aria-controls="to-receive"
                    aria-selected="false"
                    style="border: none; border-bottom: 3px solid transparent; transition: all 0.3s; font-size: 0.9rem;"
                  >
                    To Receive
                  </button>
                </li>
                <li class="nav-item" role="presentation">
                  <button
                    class="nav-link"
                    id="completed-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#completed"
                    type="button"
                    role="tab"
                    aria-controls="completed"
                    aria-selected="false"
                    style="border: none; border-bottom: 3px solid transparent; transition: all 0.3s; font-size: 0.9rem;"
                  >
                    Completed
                  </button>
                </li>
                <li class="nav-item" role="presentation">
                  <button
                    class="nav-link"
                    id="cancelled-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#cancelled"
                    type="button"
                    role="tab"
                    aria-controls="cancelled"
                    aria-selected="false"
                    style="border: none; border-bottom: 3px solid transparent; transition: all 0.3s; font-size: 0.9rem;"
                  >
                    Cancelled
                  </button>
                </li>
              </ul>

              <!-- Search Bar within the Tab Section -->
              <form class="order-status-search-bar mt-3" role="search">
                <div class="input-group">
                  <span class="input-group-text" id="order-status-search-icon">
                    <i class="bi bi-search"></i>
                  </span>
                  <input
                    class="form-control"
                    type="search"
                    placeholder="Search orders..."
                    aria-label="Search orders"
                    aria-describedby="order-status-search-icon"
                  />
                </div>
              </form>
            </div>
            <!-- Tab Content -->
            <div class="tab-content" id="orderStatusTabContent">
              
              <!-- All Orders -->
              <div
                class="tab-pane fade show active"
                id="all"
                role="tabpanel"
                aria-labelledby="all-tab"
              >
              <h3 class="mt-4">Order Status</h3>
              <div class="table-responsive">
              <table class="table table-striped table-hover align-middle">
                  <thead class="table-dark">
                      <tr>
                          <th></th>
                          <th>Order Number</th>
                          <th>Product</th>
                          <th>Color</th>
                          <th>Yards</th>
                          <th>Item Subtotal</th>
                          <th>Grand Total</th>
                          <th>Status</th>
                      </tr>
                  </thead>
                  <tbody>
                      <?php 
                      $grouped_orders = [];

                      // Group orders by order number
                      foreach ($order_data as $details) {
                          $order_num = $details['order_num'];
                          if (!isset($grouped_orders[$order_num])) {
                              $grouped_orders[$order_num] = [
                                  'order_num' => $details['order_num'],
                                  'status' => $details['status'],
                                  'sub_total' => $details['sub_total'],
                                  'total_price' => $details['total_price'],
                                  'items' => []
                              ];
                          }
                          $grouped_orders[$order_num]['items'][] = $details;
                      }

                      // Display grouped orders
                      foreach ($grouped_orders as $order): ?>
                          <tr>
                              <!-- Product Image and Details -->
                              <td>
                                  <?php 
                                  $displayed_images = []; // Array to track displayed images
                                  foreach ($order['items'] as $item): 
                                      if (!in_array($item['product_image'], $displayed_images)): // Check if the image is not already displayed
                                          $displayed_images[] = $item['product_image']; // Add the image to the displayed list
                                  ?>
                                      <div>
                                        <img src="<?= htmlspecialchars($item['product_image']); ?>" alt="Product Image" class="rounded" style="width: 60px; height: 60px; object-fit: cover; margin-top: 5px; margin-bottom: 5px; margin-left: 5px;">
                                      </div>
                                  <?php 
                                      endif;
                                  endforeach; 
                                  ?>
                              </td>
                              <!-- Order Number -->
                              <td><strong><?= htmlspecialchars($order['order_num']); ?></strong></td>
                              <!-- Product Details -->
                              <td>
                                  <?php foreach ($order['items'] as $item): ?>
                                      <div>
                                          <strong><?= htmlspecialchars($item['product_name']); ?></strong>
                                      </div>
                                  <?php endforeach; ?>
                              </td>
                              <!-- Color -->
                              <td>
                                  <?php foreach ($order['items'] as $item): ?>
                                      <div>
                                          <?= htmlspecialchars($item['color']); ?>
                                      </div>
                                  <?php endforeach; ?>
                              </td>
                              <!-- Yards -->
                              <td>
                                  <?php foreach ($order['items'] as $item): ?>
                                      <div>
                                          <?= htmlspecialchars($item['quantity']); ?>
                                      </div>
                                  <?php endforeach; ?>
                              </td>
                              <!-- Subtotal -->
                              <td style="color: #dcaa2e;">₱<?= htmlspecialchars($order['sub_total']); ?></td>
                              <!-- Grand Total -->
                              <td class="text-success"><strong>₱<?= htmlspecialchars($order['total_price']); ?></strong></td>
                              <!-- Status -->
                              <td>
                                  <span class="badge 
                                      <?= $order['status'] === 'To Pay' ? 'badge-to-pay' : 
                                        ($order['status'] === 'To Ship' ? 'badge-to-ship' : 
                                        ($order['status'] === 'To Receive' ? 'badge-to-receive' : 
                                        ($order['status'] === 'Completed' ? 'badge-completed' : 
                                        ($order['status'] === 'Cancelled' ? 'badge-cancelled' : 'badge-other')))); ?>">
                                      <?= htmlspecialchars($order['status']); ?>
                                  </span>
                              </td>
                          </tr>
                      <?php endforeach; ?>
                  </tbody>
              </table>
              </div>
              <h3 class="mt-4">Bulk Order Status</h3>
              <div class="table-responsive">
                  <table class="table table-striped table-hover align-middle">
                      <thead class="table-dark">
                          <tr>
                              <th></th>
                              <th>Order Number</th>
                              <th>Product Details</th>
                              <th>Color</th>
                              <th>Yards</th>
                              <th>Rolls</th>
                              <th>Item Subtotal</th>
                              <th>Grand Total</th>
                              <th>Status</th>
                          </tr>
                      </thead>
                      <tbody>
                          <?php 
                          $grouped_bulk_orders = [];

                          // Group bulk orders by bulk_order_id
                          foreach ($bulk_order_data as $details) {
                              $bulk_order_id = $details['bulk_order_id'];
                              if (!isset($grouped_bulk_orders[$bulk_order_id])) {
                                  $grouped_bulk_orders[$bulk_order_id] = [
                                      'bulk_order_id' => $details['bulk_order_id'],
                                      'status' => $details['status'],
                                      'grand_total' => $details['item_subtotal'],
                                      'grand_total' => $details['grand_total'],
                                      'items' => []
                                  ];
                              }
                              $grouped_bulk_orders[$bulk_order_id]['items'][] = $details;
                          }

                          // Display grouped BULK ORDERS
                          foreach ($grouped_bulk_orders as $order): ?>
                              <tr>
                                  <!-- Product Images -->
                                  <td>
                                      <?php 
                                      $displayed_images = []; // Array to track displayed images
                                      foreach ($order['items'] as $item): 
                                          if (!in_array($item['product_image'], $displayed_images)): // Check if the image is not already displayed
                                              $displayed_images[] = $item['product_image']; // Add the image to the displayed list
                                      ?>
                                          <div>
                                              <img src="<?= htmlspecialchars($item['product_image']); ?>" alt="Product Image" class="rounded" style="width: 60px; height: 60px; object-fit: cover; margin-top: 5px; margin-bottom: 5px; margin-left: 5px;">
                                          </div>
                                      <?php 
                                          endif;
                                      endforeach; 
                                      ?>
                                  </td>
                                  <!-- Order Number -->
                                  <td><strong><?= htmlspecialchars($order['bulk_order_id']); ?></strong></td>
                                  <!-- Product Details -->
                                  <td>
                                      <?php foreach ($order['items'] as $item): ?>
                                          <div>
                                              <strong><?= htmlspecialchars($item['product_name']); ?></strong>
                                          </div>
                                      <?php endforeach; ?>
                                  </td>
                                  <!-- Colors -->
                                  <td>
                                      <?php foreach ($order['items'] as $item): ?>
                                          <div>
                                              <?= htmlspecialchars($item['color']); ?>
                                          </div>
                                      <?php endforeach; ?>
                                  </td>   
                                  <!-- Yards -->
                                  <td>
                                      <?php foreach ($order['items'] as $item): ?>
                                          <div>
                                              <?= htmlspecialchars($item['yards']); ?>
                                          </div>
                                      <?php endforeach; ?>
                                  </td>   
                                  <!-- Rolls -->
                                  <td>
                                      <?php foreach ($order['items'] as $item): ?>
                                          <div>
                                              <?= htmlspecialchars($item['rolls']); ?>
                                          </div>
                                      <?php endforeach; ?>
                                  </td>   
                                  <!-- Item Subtotal -->
                                  <td>
                                      <?php foreach ($order['items'] as $item): ?>
                                          <div style="color: #dcaa2e; font-weight: lighter;">
                                              <strong>₱<?= htmlspecialchars($item['item_subtotal']); ?></strong> 
                                          </div>
                                      <?php endforeach; ?>
                                  </td>
                                  <!-- Grand Total -->
                                  <td class="text-success"><strong>₱<?= htmlspecialchars($order['grand_total']); ?></strong></td>
                                  <!-- Status -->
                                  <td>
                                      <span class="badge 
                                          <?= $order['status'] === 'To Pay' ? 'badge-to-pay' : 
                                            ($order['status'] === 'To Ship' ? 'badge-to-ship' : 
                                            ($order['status'] === 'To Receive' ? 'badge-to-receive' : 
                                            ($order['status'] === 'Completed' ? 'badge-completed' : 
                                            ($order['status'] === 'Cancelled' ? 'badge-cancelled' : 'badge-other')))); ?>">
                                          <?= htmlspecialchars($order['status']); ?>
                                      </span>
                                  </td>
                              </tr>
                          <?php endforeach; ?>
                      </tbody>
                  </table>
              </div>
              </div>

              <!-- To Pay -->
              <div
                class="tab-pane fade"
                id="to-pay"
                role="tabpanel"
                aria-labelledby="to-pay-tab">
                <h3 class="mt-4">Order Status</h3>
                <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th></th>
                            <th>Order Number</th>
                            <th>Product</th>
                            <th>Color</th>
                            <th>Yards</th>
                            <th>Item Subtotal</th>
                            <th>Grand Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $grouped_orders = [];

                        // Group orders by order number
                        foreach ($order_data as $details) {
                            $order_num = $details['order_num'];
                            if (!isset($grouped_orders[$order_num])) {
                                $grouped_orders[$order_num] = [
                                    'order_num' => $details['order_num'],
                                    'status' => $details['status'],
                                    'sub_total' => $details['sub_total'],
                                    'total_price' => $details['total_price'],
                                    'items' => []
                                ];
                            }
                            $grouped_orders[$order_num]['items'][] = $details;
                        }

                        // Display grouped orders
                        foreach ($grouped_orders as $order): ?>
                          <?php if ($order['status'] === 'To Pay'): ?>
                            <tr>
                                <!-- Product Image and Details -->
                                <td>
                                    <?php 
                                    $displayed_images = []; // Array to track displayed images
                                    foreach ($order['items'] as $item): 
                                        if (!in_array($item['product_image'], $displayed_images)): // Check if the image is not already displayed
                                            $displayed_images[] = $item['product_image']; // Add the image to the displayed list
                                    ?>
                                        <div>
                                          <img src="<?= htmlspecialchars($item['product_image']); ?>" alt="Product Image" class="rounded" style="width: 60px; height: 60px; object-fit: cover; margin-top: 5px; margin-bottom: 5px; margin-left: 5px;">
                                        </div>
                                    <?php 
                                        endif;
                                    endforeach; 
                                    ?>
                                </td>
                                <!-- Order Number -->
                                <td><strong><?= htmlspecialchars($order['order_num']); ?></strong></td>
                                <!-- Product Details -->
                                <td>
                                    <?php foreach ($order['items'] as $item): ?>
                                        <div>
                                            <strong><?= htmlspecialchars($item['product_name']); ?></strong>
                                        </div>
                                    <?php endforeach; ?>
                                </td>
                                <!-- Color -->
                                <td>
                                    <?php foreach ($order['items'] as $item): ?>
                                        <div>
                                            <?= htmlspecialchars($item['color']); ?>
                                        </div>
                                    <?php endforeach; ?>
                                </td>
                                <!-- Yards -->
                                <td>
                                    <?php foreach ($order['items'] as $item): ?>
                                        <div>
                                            <?= htmlspecialchars($item['quantity']); ?>
                                        </div>
                                    <?php endforeach; ?>
                                </td>
                                <!-- Subtotal -->
                                <td style="color: #dcaa2e;">₱<?= htmlspecialchars($order['sub_total']); ?></td>
                                <!-- Grand Total -->
                                <td class="text-success"><strong>₱<?= htmlspecialchars($order['total_price']); ?></strong></td>
                                <!-- Status -->
                                <td>
                                    <span class="badge <?= htmlspecialchars('badge-' . strtolower(str_replace(' ', '-', $order['status']))); ?>">
                                        <?= htmlspecialchars($order['status']); ?>
                                    </span>
                                </td>
                            </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                </div>
                <h3 class="mt-4">Bulk Order Status</h3>
                <div class="table-responsive">
                  <table class="table table-striped table-hover align-middle">
                      <thead class="table-dark">
                          <tr>
                              <th></th>
                              <th>Order Number</th>
                              <th>Product Details</th>
                              <th>Color</th>
                              <th>Yards</th>
                              <th>Rolls</th>
                              <th>Item Subtotal</th>
                              <th>Grand Total</th>
                              <th>Status</th>
                          </tr>
                      </thead>
                      <tbody>
                          <?php 
                          $grouped_bulk_orders = [];

                          // Group bulk orders by bulk_order_id
                          foreach ($bulk_order_data as $details) {
                              $bulk_order_id = $details['bulk_order_id'];
                              if (!isset($grouped_bulk_orders[$bulk_order_id])) {
                                  $grouped_bulk_orders[$bulk_order_id] = [
                                      'bulk_order_id' => $details['bulk_order_id'],
                                      'status' => $details['status'],
                                      'grand_total' => $details['item_subtotal'],
                                      'grand_total' => $details['grand_total'],
                                      'items' => []
                                  ];
                              }
                              $grouped_bulk_orders[$bulk_order_id]['items'][] = $details;
                          }

                          // Display grouped BULK ORDERS
                          foreach ($grouped_bulk_orders as $order): ?>
                            <?php if ($order['status'] === 'To Pay'): ?>
                              <tr>
                                  <!-- Product Images -->
                                  <td>
                                      <?php 
                                      $displayed_images = []; // Array to track displayed images
                                      foreach ($order['items'] as $item): 
                                          if (!in_array($item['product_image'], $displayed_images)): // Check if the image is not already displayed
                                              $displayed_images[] = $item['product_image']; // Add the image to the displayed list
                                      ?>
                                          <div>
                                              <img src="<?= htmlspecialchars($item['product_image']); ?>" alt="Product Image" class="rounded" style="width: 60px; height: 60px; object-fit: cover; margin-top: 5px; margin-bottom: 5px; margin-left: 5px;">
                                          </div>
                                      <?php 
                                          endif;
                                      endforeach; 
                                      ?>
                                  </td>
                                  <!-- Order Number -->
                                  <td><strong><?= htmlspecialchars($order['bulk_order_id']); ?></strong></td>
                                  <!-- Product Details -->
                                  <td>
                                      <?php foreach ($order['items'] as $item): ?>
                                          <div>
                                              <strong><?= htmlspecialchars($item['product_name']); ?></strong>
                                          </div>
                                      <?php endforeach; ?>
                                  </td>
                                  <!-- Colors -->
                                  <td>
                                      <?php foreach ($order['items'] as $item): ?>
                                          <div>
                                              <?= htmlspecialchars($item['color']); ?>
                                          </div>
                                      <?php endforeach; ?>
                                  </td>   
                                  <!-- Yards -->
                                  <td>
                                      <?php foreach ($order['items'] as $item): ?>
                                          <div>
                                              <?= htmlspecialchars($item['yards']); ?>
                                          </div>
                                      <?php endforeach; ?>
                                  </td>   
                                  <!-- Rolls -->
                                  <td>
                                      <?php foreach ($order['items'] as $item): ?>
                                          <div>
                                              <?= htmlspecialchars($item['rolls']); ?>
                                          </div>
                                      <?php endforeach; ?>
                                  </td>   
                                  <!-- Item Subtotal -->
                                  <td>
                                      <?php foreach ($order['items'] as $item): ?>
                                          <div style="color: #dcaa2e; font-weight: lighter;">
                                              <strong>₱<?= htmlspecialchars($item['item_subtotal']); ?></strong> 
                                          </div>
                                      <?php endforeach; ?>
                                  </td>
                                  <!-- Grand Total -->
                                  <td class="text-success"><strong>₱<?= htmlspecialchars($order['grand_total']); ?></strong></td>
                                  <!-- Status -->
                                  <td>
                                      <span class="badge <?= htmlspecialchars('badge-' . strtolower(str_replace(' ', '-', $order['status']))); ?>">
                                          <?= htmlspecialchars($order['status']); ?>
                                      </span>
                                  </td>
                              </tr>
                              <?php endif; ?>
                          <?php endforeach; ?>
                      </tbody>
                  </table>
                </div>
              </div>
              
              <!-- To Ship -->
              <div
                class="tab-pane fade"
                id="to-ship"
                role="tabpanel"
                aria-labelledby="to-ship-tab"
              >
              <h3 class="mt-4">Order Status</h3>
                <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th></th>
                            <th>Order Number</th>
                            <th>Product</th>
                            <th>Color</th>
                            <th>Yards</th>
                            <th>Item Subtotal</th>
                            <th>Grand Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $grouped_orders = [];

                        // Group orders by order number
                        foreach ($order_data as $details) {
                            $order_num = $details['order_num'];
                            if (!isset($grouped_orders[$order_num])) {
                                $grouped_orders[$order_num] = [
                                    'order_num' => $details['order_num'],
                                    'status' => $details['status'],
                                    'sub_total' => $details['sub_total'],
                                    'total_price' => $details['total_price'],
                                    'items' => []
                                ];
                            }
                            $grouped_orders[$order_num]['items'][] = $details;
                        }

                        // Display grouped orders
                        foreach ($grouped_orders as $order): ?>
                          <?php if ($order['status'] === 'To Ship'): ?>
                            <tr>
                                <!-- Product Image and Details -->
                                <td>
                                    <?php 
                                    $displayed_images = []; // Array to track displayed images
                                    foreach ($order['items'] as $item): 
                                        if (!in_array($item['product_image'], $displayed_images)): // Check if the image is not already displayed
                                            $displayed_images[] = $item['product_image']; // Add the image to the displayed list
                                    ?>
                                        <div>
                                          <img src="<?= htmlspecialchars($item['product_image']); ?>" alt="Product Image" class="rounded" style="width: 60px; height: 60px; object-fit: cover; margin-top: 5px; margin-bottom: 5px; margin-left: 5px;">
                                        </div>
                                    <?php 
                                        endif;
                                    endforeach; 
                                    ?>
                                </td>
                                <!-- Order Number -->
                                <td><strong><?= htmlspecialchars($order['order_num']); ?></strong></td>
                                <!-- Product Details -->
                                <td>
                                    <?php foreach ($order['items'] as $item): ?>
                                        <div>
                                            <strong><?= htmlspecialchars($item['product_name']); ?></strong>
                                        </div>
                                    <?php endforeach; ?>
                                </td>
                                <!-- Color -->
                                <td>
                                    <?php foreach ($order['items'] as $item): ?>
                                        <div>
                                            <?= htmlspecialchars($item['color']); ?>
                                        </div>
                                    <?php endforeach; ?>
                                </td>
                                <!-- Yards -->
                                <td>
                                    <?php foreach ($order['items'] as $item): ?>
                                        <div>
                                            <?= htmlspecialchars($item['quantity']); ?>
                                        </div>
                                    <?php endforeach; ?>
                                </td>
                                <!-- Subtotal -->
                                <td style="color: #dcaa2e;">₱<?= htmlspecialchars($order['sub_total']); ?></td>
                                <!-- Grand Total -->
                                <td class="text-success"><strong>₱<?= htmlspecialchars($order['total_price']); ?></strong></td>
                                <!-- Status -->
                                <td>
                                    <span class="badge <?= htmlspecialchars('badge-' . strtolower(str_replace(' ', '-', $order['status']))); ?>">
                                        <?= htmlspecialchars($order['status']); ?>
                                    </span>
                                </td>
                            </tr>
                            <?php endif; ?>
                          <?php endforeach; ?>
                      </tbody>
                  </table>
                </div>
                <h3 class="mt-4">Bulk Order Status</h3>
                <div class="table-responsive">
                  <table class="table table-striped table-hover align-middle">
                      <thead class="table-dark">
                          <tr>
                              <th></th>
                              <th>Order Number</th>
                              <th>Product Details</th>
                              <th>Color</th>
                              <th>Yards</th>
                              <th>Rolls</th>
                              <th>Item Subtotal</th>
                              <th>Grand Total</th>
                              <th>Status</th>
                          </tr>
                      </thead>
                      <tbody>
                          <?php 
                          $grouped_bulk_orders = [];

                          // Group bulk orders by bulk_order_id
                          foreach ($bulk_order_data as $details) {
                              $bulk_order_id = $details['bulk_order_id'];
                              if (!isset($grouped_bulk_orders[$bulk_order_id])) {
                                  $grouped_bulk_orders[$bulk_order_id] = [
                                      'bulk_order_id' => $details['bulk_order_id'],
                                      'status' => $details['status'],
                                      'grand_total' => $details['item_subtotal'],
                                      'grand_total' => $details['grand_total'],
                                      'items' => []
                                  ];
                              }
                              $grouped_bulk_orders[$bulk_order_id]['items'][] = $details;
                          }

                          // Display grouped BULK ORDERS
                          foreach ($grouped_bulk_orders as $order): ?>
                            <?php if ($order['status'] === 'To Ship'): ?>
                              <tr>
                                  <!-- Product Images -->
                                  <td>
                                      <?php 
                                      $displayed_images = []; // Array to track displayed images
                                      foreach ($order['items'] as $item): 
                                          if (!in_array($item['product_image'], $displayed_images)): // Check if the image is not already displayed
                                              $displayed_images[] = $item['product_image']; // Add the image to the displayed list
                                      ?>
                                          <div>
                                              <img src="<?= htmlspecialchars($item['product_image']); ?>" alt="Product Image" class="rounded" style="width: 60px; height: 60px; object-fit: cover; margin-top: 5px; margin-bottom: 5px; margin-left: 5px;">
                                          </div>
                                      <?php 
                                          endif;
                                      endforeach; 
                                      ?>
                                  </td>
                                  <!-- Order Number -->
                                  <td><strong><?= htmlspecialchars($order['bulk_order_id']); ?></strong></td>
                                  <!-- Product Details -->
                                  <td>
                                      <?php foreach ($order['items'] as $item): ?>
                                          <div>
                                              <strong><?= htmlspecialchars($item['product_name']); ?></strong>
                                          </div>
                                      <?php endforeach; ?>
                                  </td>
                                  <!-- Colors -->
                                  <td>
                                      <?php foreach ($order['items'] as $item): ?>
                                          <div>
                                              <?= htmlspecialchars($item['color']); ?>
                                          </div>
                                      <?php endforeach; ?>
                                  </td>   
                                  <!-- Yards -->
                                  <td>
                                      <?php foreach ($order['items'] as $item): ?>
                                          <div>
                                              <?= htmlspecialchars($item['yards']); ?>
                                          </div>
                                      <?php endforeach; ?>
                                  </td>   
                                  <!-- Rolls -->
                                  <td>
                                      <?php foreach ($order['items'] as $item): ?>
                                          <div>
                                              <?= htmlspecialchars($item['rolls']); ?>
                                          </div>
                                      <?php endforeach; ?>
                                  </td>   
                                  <!-- Item Subtotal -->
                                  <td>
                                      <?php foreach ($order['items'] as $item): ?>
                                          <div style="color: #dcaa2e; font-weight: lighter;">
                                              <strong>₱<?= htmlspecialchars($item['item_subtotal']); ?></strong> 
                                          </div>
                                      <?php endforeach; ?>
                                  </td>
                                  <!-- Grand Total -->
                                  <td class="text-success"><strong>₱<?= htmlspecialchars($order['grand_total']); ?></strong></td>
                                  <!-- Status -->
                                  <td>
                                      <span class="badge <?= htmlspecialchars('badge-' . strtolower(str_replace(' ', '-', $order['status']))); ?>">
                                          <?= htmlspecialchars($order['status']); ?>
                                      </span>
                                  </td>
                              </tr>
                              <?php endif; ?>
                          <?php endforeach; ?>
                      </tbody>
                  </table>
                </div>
              </div>

              <!-- To Receive -->
              <div
                class="tab-pane fade"
                id="to-receive"
                role="tabpanel"
                aria-labelledby="to-receive-tab"
              >
              <h3 class="mt-4">Order Status</h3>
                <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th></th>
                            <th>Order Number</th>
                            <th>Product</th>
                            <th>Color</th>
                            <th>Yards</th>
                            <th>Item Subtotal</th>
                            <th>Grand Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $grouped_orders = [];

                        // Group orders by order number
                        foreach ($order_data as $details) {
                            $order_num = $details['order_num'];
                            if (!isset($grouped_orders[$order_num])) {
                                $grouped_orders[$order_num] = [
                                    'order_num' => $details['order_num'],
                                    'status' => $details['status'],
                                    'sub_total' => $details['sub_total'],
                                    'total_price' => $details['total_price'],
                                    'items' => []
                                ];
                            }
                            $grouped_orders[$order_num]['items'][] = $details;
                        }

                        // Display grouped orders
                        foreach ($grouped_orders as $order): ?>
                          <?php if ($order['status'] === 'To Receive'): ?>
                            <tr>
                                <!-- Product Image and Details -->
                                <td>
                                    <?php 
                                    $displayed_images = []; // Array to track displayed images
                                    foreach ($order['items'] as $item): 
                                        if (!in_array($item['product_image'], $displayed_images)): // Check if the image is not already displayed
                                            $displayed_images[] = $item['product_image']; // Add the image to the displayed list
                                    ?>
                                        <div>
                                          <img src="<?= htmlspecialchars($item['product_image']); ?>" alt="Product Image" class="rounded" style="width: 60px; height: 60px; object-fit: cover; margin-top: 5px; margin-bottom: 5px; margin-left: 5px;">
                                        </div>
                                    <?php 
                                        endif;
                                    endforeach; 
                                    ?>
                                </td>
                                <!-- Order Number -->
                                <td><strong><?= htmlspecialchars($order['order_num']); ?></strong></td>
                                <!-- Product Details -->
                                <td>
                                    <?php foreach ($order['items'] as $item): ?>
                                        <div>
                                            <strong><?= htmlspecialchars($item['product_name']); ?></strong>
                                        </div>
                                    <?php endforeach; ?>
                                </td>
                                <!-- Color -->
                                <td>
                                    <?php foreach ($order['items'] as $item): ?>
                                        <div>
                                            <?= htmlspecialchars($item['color']); ?>
                                        </div>
                                    <?php endforeach; ?>
                                </td>
                                <!-- Yards -->
                                <td>
                                    <?php foreach ($order['items'] as $item): ?>
                                        <div>
                                            <?= htmlspecialchars($item['quantity']); ?>
                                        </div>
                                    <?php endforeach; ?>
                                </td>
                                <!-- Subtotal -->
                                <td style="color: #dcaa2e;">₱<?= htmlspecialchars($order['sub_total']); ?></td>
                                <!-- Grand Total -->
                                <td class="text-success"><strong>₱<?= htmlspecialchars($order['total_price']); ?></strong></td>
                                <!-- Status -->
                                <td>
                                    <span class="badge <?= htmlspecialchars('badge-' . strtolower(str_replace(' ', '-', $order['status']))); ?>">
                                        <?= htmlspecialchars($order['status']); ?>
                                    </span>
                                </td>
                            </tr>
                            <?php endif; ?>
                          <?php endforeach; ?>
                      </tbody>
                  </table>
                </div>
                <h3 class="mt-4">Bulk Order Status</h3>
                <div class="table-responsive">
                  <table class="table table-striped table-hover align-middle">
                      <thead class="table-dark">
                          <tr>
                              <th></th>
                              <th>Order Number</th>
                              <th>Product Details</th>
                              <th>Color</th>
                              <th>Yards</th>
                              <th>Rolls</th>
                              <th>Item Subtotal</th>
                              <th>Grand Total</th>
                              <th>Status</th>
                          </tr>
                      </thead>
                      <tbody>
                          <?php 
                          $grouped_bulk_orders = [];

                          // Group bulk orders by bulk_order_id
                          foreach ($bulk_order_data as $details) {
                              $bulk_order_id = $details['bulk_order_id'];
                              if (!isset($grouped_bulk_orders[$bulk_order_id])) {
                                  $grouped_bulk_orders[$bulk_order_id] = [
                                      'bulk_order_id' => $details['bulk_order_id'],
                                      'status' => $details['status'],
                                      'grand_total' => $details['item_subtotal'],
                                      'grand_total' => $details['grand_total'],
                                      'items' => []
                                  ];
                              }
                              $grouped_bulk_orders[$bulk_order_id]['items'][] = $details;
                          }

                          // Display grouped BULK ORDERS
                          foreach ($grouped_bulk_orders as $order): ?>
                            <?php if ($order['status'] === 'To Receive'): ?>
                              <tr>
                                  <!-- Product Images -->
                                  <td>
                                      <?php 
                                      $displayed_images = []; // Array to track displayed images
                                      foreach ($order['items'] as $item): 
                                          if (!in_array($item['product_image'], $displayed_images)): // Check if the image is not already displayed
                                              $displayed_images[] = $item['product_image']; // Add the image to the displayed list
                                      ?>
                                          <div>
                                              <img src="<?= htmlspecialchars($item['product_image']); ?>" alt="Product Image" class="rounded" style="width: 60px; height: 60px; object-fit: cover; margin-top: 5px; margin-bottom: 5px; margin-left: 5px;">
                                          </div>
                                      <?php 
                                          endif;
                                      endforeach; 
                                      ?>
                                  </td>
                                  <!-- Order Number -->
                                  <td><strong><?= htmlspecialchars($order['bulk_order_id']); ?></strong></td>
                                  <!-- Product Details -->
                                  <td>
                                      <?php foreach ($order['items'] as $item): ?>
                                          <div>
                                              <strong><?= htmlspecialchars($item['product_name']); ?></strong>
                                          </div>
                                      <?php endforeach; ?>
                                  </td>
                                  <!-- Colors -->
                                  <td>
                                      <?php foreach ($order['items'] as $item): ?>
                                          <div>
                                              <?= htmlspecialchars($item['color']); ?>
                                          </div>
                                      <?php endforeach; ?>
                                  </td>   
                                  <!-- Yards -->
                                  <td>
                                      <?php foreach ($order['items'] as $item): ?>
                                          <div>
                                              <?= htmlspecialchars($item['yards']); ?>
                                          </div>
                                      <?php endforeach; ?>
                                  </td>   
                                  <!-- Rolls -->
                                  <td>
                                      <?php foreach ($order['items'] as $item): ?>
                                          <div>
                                              <?= htmlspecialchars($item['rolls']); ?>
                                          </div>
                                      <?php endforeach; ?>
                                  </td>   
                                  <!-- Item Subtotal -->
                                  <td>
                                      <?php foreach ($order['items'] as $item): ?>
                                          <div style="color: #dcaa2e; font-weight: lighter;">
                                              <strong>₱<?= htmlspecialchars($item['item_subtotal']); ?></strong> 
                                          </div>
                                      <?php endforeach; ?>
                                  </td>
                                  <!-- Grand Total -->
                                  <td class="text-success"><strong>₱<?= htmlspecialchars($order['grand_total']); ?></strong></td>
                                  <!-- Status -->
                                  <td>
                                      <span class="badge <?= htmlspecialchars('badge-' . strtolower(str_replace(' ', '-', $order['status']))); ?>">
                                          <?= htmlspecialchars($order['status']); ?>
                                      </span>
                                  </td>
                              </tr>
                              <?php endif; ?>
                          <?php endforeach; ?>
                      </tbody>
                  </table>
                </div>
              </div>

              <!-- Completed -->
              <div
                class="tab-pane fade"
                id="completed"
                role="tabpanel"
                aria-labelledby="completed-tab"
              >
              <h3 class="mt-4">Order Status</h3>
                <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th></th>
                            <th>Order Number</th>
                            <th>Product</th>
                            <th>Color</th>
                            <th>Yards</th>
                            <th>Item Subtotal</th>
                            <th>Grand Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $grouped_orders = [];

                        // Group orders by order number
                        foreach ($order_data as $details) {
                            $order_num = $details['order_num'];
                            if (!isset($grouped_orders[$order_num])) {
                                $grouped_orders[$order_num] = [
                                    'order_num' => $details['order_num'],
                                    'status' => $details['status'],
                                    'sub_total' => $details['sub_total'],
                                    'total_price' => $details['total_price'],
                                    'items' => []
                                ];
                            }
                            $grouped_orders[$order_num]['items'][] = $details;
                        }

                        // Display grouped orders
                        foreach ($grouped_orders as $order): ?>
                          <?php if ($order['status'] === 'Completed'): ?>
                            <tr>
                                <!-- Product Image and Details -->
                                <td>
                                    <?php 
                                    $displayed_images = []; // Array to track displayed images
                                    foreach ($order['items'] as $item): 
                                        if (!in_array($item['product_image'], $displayed_images)): // Check if the image is not already displayed
                                            $displayed_images[] = $item['product_image']; // Add the image to the displayed list
                                    ?>
                                        <div>
                                          <img src="<?= htmlspecialchars($item['product_image']); ?>" alt="Product Image" class="rounded" style="width: 60px; height: 60px; object-fit: cover; margin-top: 5px; margin-bottom: 5px; margin-left: 5px;">
                                        </div>
                                    <?php 
                                        endif;
                                    endforeach; 
                                    ?>
                                </td>
                                <!-- Order Number -->
                                <td><strong><?= htmlspecialchars($order['order_num']); ?></strong></td>
                                <!-- Product Details -->
                                <td>
                                    <?php foreach ($order['items'] as $item): ?>
                                        <div>
                                            <strong><?= htmlspecialchars($item['product_name']); ?></strong>
                                        </div>
                                    <?php endforeach; ?>
                                </td>
                                <!-- Color -->
                                <td>
                                    <?php foreach ($order['items'] as $item): ?>
                                        <div>
                                            <?= htmlspecialchars($item['color']); ?>
                                        </div>
                                    <?php endforeach; ?>
                                </td>
                                <!-- Yards -->
                                <td>
                                    <?php foreach ($order['items'] as $item): ?>
                                        <div>
                                            <?= htmlspecialchars($item['quantity']); ?>
                                        </div>
                                    <?php endforeach; ?>
                                </td>
                                <!-- Subtotal -->
                                <td style="color: #dcaa2e;">₱<?= htmlspecialchars($order['sub_total']); ?></td>
                                <!-- Grand Total -->
                                <td class="text-success"><strong>₱<?= htmlspecialchars($order['total_price']); ?></strong></td>
                                <!-- Status -->
                                <td>
                                    <span class="badge <?= htmlspecialchars('badge-' . strtolower(str_replace(' ', '-', $order['status']))); ?>">
                                        <?= htmlspecialchars($order['status']); ?>
                                    </span>
                                </td>
                            </tr>
                            <?php endif; ?>
                          <?php endforeach; ?>
                      </tbody>
                  </table>
                </div>
                <h3 class="mt-4">Bulk Order Status</h3>
                <div class="table-responsive">
                  <table class="table table-striped table-hover align-middle">
                      <thead class="table-dark">
                          <tr>
                              <th></th>
                              <th>Order Number</th>
                              <th>Product Details</th>
                              <th>Color</th>
                              <th>Yards</th>
                              <th>Rolls</th>
                              <th>Item Subtotal</th>
                              <th>Grand Total</th>
                              <th>Status</th>
                          </tr>
                      </thead>
                      <tbody>
                          <?php 
                          $grouped_bulk_orders = [];

                          // Group bulk orders by bulk_order_id
                          foreach ($bulk_order_data as $details) {
                              $bulk_order_id = $details['bulk_order_id'];
                              if (!isset($grouped_bulk_orders[$bulk_order_id])) {
                                  $grouped_bulk_orders[$bulk_order_id] = [
                                      'bulk_order_id' => $details['bulk_order_id'],
                                      'status' => $details['status'],
                                      'grand_total' => $details['item_subtotal'],
                                      'grand_total' => $details['grand_total'],
                                      'items' => []
                                  ];
                              }
                              $grouped_bulk_orders[$bulk_order_id]['items'][] = $details;
                          }

                          // Display grouped BULK ORDERS
                          foreach ($grouped_bulk_orders as $order): ?>
                            <?php if ($order['status'] === 'Completed'): ?>
                              <tr>
                                  <!-- Product Images -->
                                  <td>
                                      <?php 
                                      $displayed_images = []; // Array to track displayed images
                                      foreach ($order['items'] as $item): 
                                          if (!in_array($item['product_image'], $displayed_images)): // Check if the image is not already displayed
                                              $displayed_images[] = $item['product_image']; // Add the image to the displayed list
                                      ?>
                                          <div>
                                              <img src="<?= htmlspecialchars($item['product_image']); ?>" alt="Product Image" class="rounded" style="width: 60px; height: 60px; object-fit: cover; margin-top: 5px; margin-bottom: 5px; margin-left: 5px;">
                                          </div>
                                      <?php 
                                          endif;
                                      endforeach; 
                                      ?>
                                  </td>
                                  <!-- Order Number -->
                                  <td><strong><?= htmlspecialchars($order['bulk_order_id']); ?></strong></td>
                                  <!-- Product Details -->
                                  <td>
                                      <?php foreach ($order['items'] as $item): ?>
                                          <div>
                                              <strong><?= htmlspecialchars($item['product_name']); ?></strong>
                                          </div>
                                      <?php endforeach; ?>
                                  </td>
                                  <!-- Colors -->
                                  <td>
                                      <?php foreach ($order['items'] as $item): ?>
                                          <div>
                                              <?= htmlspecialchars($item['color']); ?>
                                          </div>
                                      <?php endforeach; ?>
                                  </td>   
                                  <!-- Yards -->
                                  <td>
                                      <?php foreach ($order['items'] as $item): ?>
                                          <div>
                                              <?= htmlspecialchars($item['yards']); ?>
                                          </div>
                                      <?php endforeach; ?>
                                  </td>   
                                  <!-- Rolls -->
                                  <td>
                                      <?php foreach ($order['items'] as $item): ?>
                                          <div>
                                              <?= htmlspecialchars($item['rolls']); ?>
                                          </div>
                                      <?php endforeach; ?>
                                  </td>   
                                  <!-- Item Subtotal -->
                                  <td>
                                      <?php foreach ($order['items'] as $item): ?>
                                          <div style="color: #dcaa2e; font-weight: lighter;">
                                              <strong>₱<?= htmlspecialchars($item['item_subtotal']); ?></strong> 
                                          </div>
                                      <?php endforeach; ?>
                                  </td>
                                  <!-- Grand Total -->
                                  <td class="text-success"><strong>₱<?= htmlspecialchars($order['grand_total']); ?></strong></td>
                                  <!-- Status -->
                                  <td>
                                      <span class="badge <?= htmlspecialchars('badge-' . strtolower(str_replace(' ', '-', $order['status']))); ?>">
                                          <?= htmlspecialchars($order['status']); ?>
                                      </span>
                                  </td>
                              </tr>
                              <?php endif; ?>
                          <?php endforeach; ?>
                      </tbody>
                  </table>
                </div>
              </div>

              <!-- Cancelled -->
              <div
                class="tab-pane fade"
                id="cancelled"
                role="tabpanel"
                aria-labelledby="cancelled-tab"
              >
              <h3 class="mt-4">Order Status</h3>
                <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th></th>
                            <th>Order Number</th>
                            <th>Product</th>
                            <th>Color</th>
                            <th>Yards</th>
                            <th>Item Subtotal</th>
                            <th>Grand Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $grouped_orders = [];

                        // Group orders by order number
                        foreach ($order_data as $details) {
                            $order_num = $details['order_num'];
                            if (!isset($grouped_orders[$order_num])) {
                                $grouped_orders[$order_num] = [
                                    'order_num' => $details['order_num'],
                                    'status' => $details['status'],
                                    'sub_total' => $details['sub_total'],
                                    'total_price' => $details['total_price'],
                                    'items' => []
                                ];
                            }
                            $grouped_orders[$order_num]['items'][] = $details;
                        }

                        // Display grouped orders
                        foreach ($grouped_orders as $order): ?>
                          <?php if ($order['status'] === 'Cancelled'): ?>
                            <tr>
                                <!-- Product Image and Details -->
                                <td>
                                    <?php 
                                    $displayed_images = []; // Array to track displayed images
                                    foreach ($order['items'] as $item): 
                                        if (!in_array($item['product_image'], $displayed_images)): // Check if the image is not already displayed
                                            $displayed_images[] = $item['product_image']; // Add the image to the displayed list
                                    ?>
                                        <div>
                                          <img src="<?= htmlspecialchars($item['product_image']); ?>" alt="Product Image" class="rounded" style="width: 60px; height: 60px; object-fit: cover; margin-top: 5px; margin-bottom: 5px; margin-left: 5px;">
                                        </div>
                                    <?php 
                                        endif;
                                    endforeach; 
                                    ?>
                                </td>
                                <!-- Order Number -->
                                <td><strong><?= htmlspecialchars($order['order_num']); ?></strong></td>
                                <!-- Product Details -->
                                <td>
                                    <?php foreach ($order['items'] as $item): ?>
                                        <div>
                                            <strong><?= htmlspecialchars($item['product_name']); ?></strong>
                                        </div>
                                    <?php endforeach; ?>
                                </td>
                                <!-- Color -->
                                <td>
                                    <?php foreach ($order['items'] as $item): ?>
                                        <div>
                                            <?= htmlspecialchars($item['color']); ?>
                                        </div>
                                    <?php endforeach; ?>
                                </td>
                                <!-- Yards -->
                                <td>
                                    <?php foreach ($order['items'] as $item): ?>
                                        <div>
                                            <?= htmlspecialchars($item['quantity']); ?>
                                        </div>
                                    <?php endforeach; ?>
                                </td>
                                <!-- Subtotal -->
                                <td style="color: #dcaa2e;">₱<?= htmlspecialchars($order['sub_total']); ?></td>
                                <!-- Grand Total -->
                                <td class="text-success"><strong>₱<?= htmlspecialchars($order['total_price']); ?></strong></td>
                                <!-- Status -->
                                <td>
                                    <span class="badge <?= htmlspecialchars('badge-' . strtolower(str_replace(' ', '-', $order['status']))); ?>">
                                        <?= htmlspecialchars($order['status']); ?>
                                    </span>
                                </td>
                            </tr>
                            <?php endif; ?>
                          <?php endforeach; ?>
                      </tbody>
                  </table>
                </div>
                <h3 class="mt-4">Bulk Order Status</h3>
                <div class="table-responsive">
                  <table class="table table-striped table-hover align-middle">
                      <thead class="table-dark">
                          <tr>
                              <th></th>
                              <th>Order Number</th>
                              <th>Product Details</th>
                              <th>Color</th>
                              <th>Yards</th>
                              <th>Rolls</th>
                              <th>Item Subtotal</th>
                              <th>Grand Total</th>
                              <th>Status</th>
                          </tr>
                      </thead>
                      <tbody>
                          <?php 
                          $grouped_bulk_orders = [];

                          // Group bulk orders by bulk_order_id
                          foreach ($bulk_order_data as $details) {
                              $bulk_order_id = $details['bulk_order_id'];
                              if (!isset($grouped_bulk_orders[$bulk_order_id])) {
                                  $grouped_bulk_orders[$bulk_order_id] = [
                                      'bulk_order_id' => $details['bulk_order_id'],
                                      'status' => $details['status'],
                                      'grand_total' => $details['item_subtotal'],
                                      'grand_total' => $details['grand_total'],
                                      'items' => []
                                  ];
                              }
                              $grouped_bulk_orders[$bulk_order_id]['items'][] = $details;
                          }

                          // Display grouped BULK ORDERS
                          foreach ($grouped_bulk_orders as $order): ?>
                            <?php if ($order['status'] === 'Cancelled'): ?>
                              <tr>
                                  <!-- Product Images -->
                                  <td>
                                      <?php 
                                      $displayed_images = []; // Array to track displayed images
                                      foreach ($order['items'] as $item): 
                                          if (!in_array($item['product_image'], $displayed_images)): // Check if the image is not already displayed
                                              $displayed_images[] = $item['product_image']; // Add the image to the displayed list
                                      ?>
                                          <div>
                                              <img src="<?= htmlspecialchars($item['product_image']); ?>" alt="Product Image" class="rounded" style="width: 60px; height: 60px; object-fit: cover; margin-top: 5px; margin-bottom: 5px; margin-left: 5px;">
                                          </div>
                                      <?php 
                                          endif;
                                      endforeach; 
                                      ?>
                                  </td>
                                  <!-- Order Number -->
                                  <td><strong><?= htmlspecialchars($order['bulk_order_id']); ?></strong></td>
                                  <!-- Product Details -->
                                  <td>
                                      <?php foreach ($order['items'] as $item): ?>
                                          <div>
                                              <strong><?= htmlspecialchars($item['product_name']); ?></strong>
                                          </div>
                                      <?php endforeach; ?>
                                  </td>
                                  <!-- Colors -->
                                  <td>
                                      <?php foreach ($order['items'] as $item): ?>
                                          <div>
                                              <?= htmlspecialchars($item['color']); ?>
                                          </div>
                                      <?php endforeach; ?>
                                  </td>   
                                  <!-- Yards -->
                                  <td>
                                      <?php foreach ($order['items'] as $item): ?>
                                          <div>
                                              <?= htmlspecialchars($item['yards']); ?>
                                          </div>
                                      <?php endforeach; ?>
                                  </td>   
                                  <!-- Rolls -->
                                  <td>
                                      <?php foreach ($order['items'] as $item): ?>
                                          <div>
                                              <?= htmlspecialchars($item['rolls']); ?>
                                          </div>
                                      <?php endforeach; ?>
                                  </td>   
                                  <!-- Item Subtotal -->
                                  <td>
                                      <?php foreach ($order['items'] as $item): ?>
                                          <div style="color: #dcaa2e; font-weight: lighter;">
                                              <strong>₱<?= htmlspecialchars($item['item_subtotal']); ?></strong> 
                                          </div>
                                      <?php endforeach; ?>
                                  </td>
                                  <!-- Grand Total -->
                                  <td class="text-success"><strong>₱<?= htmlspecialchars($order['grand_total']); ?></strong></td>
                                  <!-- Status -->
                                  <td>
                                      <span class="badge <?= htmlspecialchars('badge-' . strtolower(str_replace(' ', '-', $order['status']))); ?>">
                                          <?= htmlspecialchars($order['status']); ?>
                                      </span>
                                  </td>
                              </tr>
                              <?php endif; ?>
                          <?php endforeach; ?>
                      </tbody>
                  </table>
                </div>
              </div>
              <!-- End of Displays -->
            </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
