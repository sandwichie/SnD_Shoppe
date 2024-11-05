<?php
//database
session_start();
$servername = "localhost";
$dbname = "db_sdshoppe";
$username = "root";  
$password = "";  

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(isset($_POST['continue'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];

        $stmt = $conn->prepare("INSERT INTO users_credentials (FIRSTNAME, LASTNAME) VALUES (?, ?)");
        $stmt->bind_param("ss", $firstname, $lastname);  // "ss" means two string parameters
        
        if ($stmt->execute()) {
            $user_id = $conn->insert_id;  
            $_SESSION['user_id'] = $user_id;  

            header("Location: SignUp.php");
            exit();
            //echo "<script>window.location.href = 'SignUp.php?';</script>";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }    
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="icon" href="/Assets/images/sndlogo.png" type="logo">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <title>S&D FABRIC SHOPPE</title>
    <link rel="icon" href="Assets/sndlo.ico">
    <link rel="stylesheet" href="cssStyles/sndLandingpage-style.css">
    
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #f1e8d9; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <a class="navbar-brand fs-4" href="homepage.html">
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
                        <a class="nav-link nav-link-black active" aria-current="page" href="cart.html">
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
                                <a class="dropdown-item" href="settings.html">Settings</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item text-danger" href="login.html">Login</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!--WELCOME/INTRO-->
    <div class="welcome-row">
        <div class="col-1">
            <h1>Where Quality Fabrics<br>Meet Creativity</h1>
            <summary style="list-style-type: none;font-weight: lighter;">Discover a world of premium fabrics tailored to inspire your creative journey. Whether you’re crafting clothing, home décor, or unique accessories, we’re here to provide the finest materials to bring your ideas to life.</summary>
            <form action="homepage.html">
                <button type="submit">Explore Now!</button>
            </form>
        </div>
        <div class="col-2">
            <img src="Assets/intro-pic.png" alt="whole-pic">
        </div>
    </div>

    <!--CATEGORIES-->
    <div class="categories">
        <div class="available-row" style="background: linear-gradient(360deg, rgba(234,217,149,0.6694327389158788) -84%, rgba(255,255,255,0) 100%); height: 100px; box-shadow: -1px 4px 5px rgba(0, 0, 0, 0.15);">
            <h2>Available Fabrics</h2>
        </div>

        <div class="available-row" style="margin-bottom: 20px; margin-top: 20px;">
            <a href="url">New Arrivals</a>
            <a href="url">Popular</a>
            <a href="url">Order Here</a>
        </div>

        <div class="row">
            <div class="categories-col">
                <img src="Assets/fabrics-edited/design1.png">
                <a href="url">Beaded Lace</a>
                <p>info info info</p>
            </div>
            <div class="categories-col">
                <img src="Assets/fabrics-edited/design2.png">
                <a href="url">Lace</a>
                <p>info info info</p>
            </div>
            <div class="categories-col">
                <img src="Assets/fabrics-edited/design3.png">
                <a href="url">Satin</a>
                <p>info info info</p>
            </div>
        </div> 

        <div class="row" style="margin-top: 50px;  padding-bottom: 50px;">
            <div class="categories-col">
                <img src="Assets/fabrics-edited/design4.png">
                <a href="url">Sequence</a>
                <p>info info info</p>
            </div>
            <div class="categories-col">
                <img src="Assets/fabrics-edited/design5.png">
                <a href="url">Silk</a>
                <p>info info info</p>
            </div>
            <div class="categories-col">
                <img src="Assets/fabrics-edited/design6.png">
                <a href="url">Velvet</a>
                <p>info info info</p>
            </div>
        
        </div> 
    </div>

    <!--ABOUT US-->
    
    <div class="aboutUs" style="background: linear-gradient(180deg, rgba(234,217,149,0.6694327389158788) -84%, rgba(255,255,255,0) 100%); height: auto; box-shadow: -1px -4px 5px rgba(0, 0, 0, 0.15);">
        <div class="pic-abt">
            <img src="Assets/aboutUs-pic.png">
        </div>
        <div class="content-abt">
            <div class="abt1">
                <h1>ABOUT US</h1>
                <strong>From Classic to Trendy, We Have the<br>Fabric You Need!</strong>
                <cite><br>Lorem ipsum dolor sit amet. Ad architecto iusto ut quasi voluptatum<br> in maiores ipsum. Qui illum enim et quaerat velit quo temporibus<br> aperiam et consectetur modi et cupiditate numquam ex expedita omnis.
                <br><br></cite>
                <form action="homepage.html">
                    <button type="submit">Shop Now!</button>
                </form>
            </div>

            <div class="abt2">
                <h1>CONTACT US</h1>
                <div class="contact-item">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path fill="#202020" d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64h98.2V334.2H109.4V256h52.8V222.3c0-87.1 39.4-127.5 125-127.5c16.2 0 44.2 3.2 55.7 6.4V172c-6-.6-16.5-1-29.6-1c-42 0-58.2 15.9-58.2 57.2V256h83.6l-14.4 78.2H255V480H384c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64z"/></svg>
                    <a href="https://www.facebook.com/nasfia.batuaanman" target="_blank" rel="noopener noreferrer">https://www.facebook.com/nasfia.batuaanman</a>
                </div>
                <div class="contact-item" style="margin-top: 10px;">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path fill="#202020" d="M164.9 24.6c-7.7-18.6-28-28.5-47.4-23.2l-88 24C12.1 30.2 0 46 0 64C0 311.4 200.6 512 448 512c18 0 33.8-12.1 38.6-29.5l24-88c5.3-19.4-4.6-39.7-23.2-47.4l-96-40c-16.3-6.8-35.2-2.1-46.3 11.6L304.7 368C234.3 334.7 177.3 277.7 144 207.3L193.3 167c13.7-11.2 18.4-30 11.6-46.3l-40-96z"/></svg>
                    <a href="tel:+639183116920" target="_blank" rel="noopener noreferrer">+639183116920</a>
                </div>
                <div class="contact-item" style="margin-top: 10px;">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48L48 64zM0 176L0 384c0 35.3 28.7 64 64 64l384 0c35.3 0 64-28.7 64-64l0-208L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z"/></svg>
                    <a href="mailto:dmangadang@yahoo.com" target="_blank" rel="noopener noreferrer">dmangadang@yahoo.com</a>
                </div>
            </div>
        </div>
    </div>

    <!--SHADOW-->
    <div class="available-row" style="background: linear-gradient(360deg, rgba(234,217,149,0.6694327389158788) -84%, rgba(255,255,255,0) 100%); height: 100px; box-shadow: -1px 4px 5px rgba(0, 0, 0, 0.15);"></div>

      <!--PRE-SIGN UP-->
    <div class="presignup">
        <div class="presignup-container">
            <form action="" method="POST">
                <img src="Assets/sndlogo-wShadow.png" width="80px" alt="logo"/>
                <div class="input-group">
                <label for="firstName">First Name</label>
                <input type="text" name="firstname" id="fName" required>
            </div>
            <div class="input-group">
                <label for="lastName">Last Name</label>
                <input type="text" name="lastname" id="lName" required>
            </div>
            
            <button type="submit" class="btn" name="continue" required>Register Now</button></br></br>
                        
                <a href="Login.html">HAVE AN ACCOUNT?<span class="underline-link"><br>LOGIN HERE</span> </a> 
            </form>
        </div>
        <div class="presignup-abt">
            <h2>Register Today to Experience the Finest Fabrics with S&D!</h2>
        </div>
    </div>

</body>
</html>
