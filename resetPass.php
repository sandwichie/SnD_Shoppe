<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>S&D | Reset Password</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    <link rel="icon" href="Assets/sndlo.ico" type="logo">
    <style>
    *{
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "Playfair Display", serif;
    };

    /* =======================================================LOGIN========================================*/

    body {
        font-family: 'Playfair', sans-serif;
        margin: 0;
        width: 100%;
        padding: 0;
    }

    .containerReset {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh; 
        background-image: url(/SND/Assets/bgLogin.png);
    }

    .reset-form {
        background-color: #333;
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.1);
        max-width: 550px;
        width: 100%;
    }

    .reset-form h1 {
        text-align: center;
        font-size: 36px;
        color: #fff;
        margin-bottom: 20px;
        text-transform: uppercase;
        letter-spacing: 2px;
    }

    .reset-form label {
        display: block;
        margin-bottom: 10px;
        color: #fff;
        font-size: 14px;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    .reset-form input[type="text"] {
        width: 100%;
        padding: 12px;
        margin-bottom: 20px;
        background-color: #ccc;
        border: none;
        border-radius: 5px;
        color: #000;
        font-size: 16px;
    }

    .input-container {
        position: relative; /* Allows for absolute positioning of child elements */
        margin-bottom: 15px; /* Space between inputs */
    }

    .input-container input[type="password"] {
        width: 100%;
        padding: 12px; 
        padding-right: 40px; 
        background-color: #ccc;
        border: none;
        border-radius: 5px;
        color: #000;
        font-size: 16px;
        }

    .input-container i {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #333;
    }

    .reset-form label[for="remember"] {
        color: #fff;
        margin-bottom: 10px;
        font-size: 14px;
    }

    .reset-form p {
        color: #ccc;
        font-size: 15px;
        margin-bottom: 20px;
        text-align: center;
    }

    .reset-form p a {
        color: #f3c552;
        text-decoration: none;
    }

    .buttons {
        display: flex;
        justify-content: space-between;
        margin-top: -5px;
        padding: 15px;
        position: relative;
    }

    .buttons .btnReset:hover {
        background-color: #E9B022;
    }
   
    .buttons .btnCancel:hover {
        background-color: #555;
    }

    .buttons .btnCancel,
    .buttons .btnReset {
        width: 48%;
        padding: 10px;
        font-size: 16px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.3s ease; /* Smooth transition */
        border: 1px solid #000000;
    }

    .buttons .btnCancel {
        background-color: #2E2E31;
        color: white;
    }

    .buttons .btnReset {
        background-color: #E0B853;
        color: #333;
    }

    .reset-form img {
        display: block;
        margin-left: auto;
        margin-right: auto;
        margin-bottom: 10px;
        width: 20%; 
    }

    </style>
</head>
<body>

      <div class="containerReset">
        <div class="reset-form">
        <form action="" method="POST">
            <img src="Assets/sndlogo-wShadow.png" alt="logo"/>
            <h1>Create a new password</h1>
            <p>Please choose a password that hasn't been used before. Must be at least 8.</p>

            <div class="input-container">
                <input type="password" id="passwordSet" placeholder="Set new password" name="psw" required/>
                <i class="far fa-eye" id="togglePassword1" style="cursor: pointer;"></i> <!-- Eye icon inside input -->
            </div>

            <div class="input-container">
                <input type="password" id="passwordConfirm" placeholder="Confirm new password" name="psw-confirm" required/>
                <i class="far fa-eye" id="togglePassword2" style="cursor: pointer;"></i> <!-- Eye icon inside input -->
            </div>

            <div class="buttons">
                <button type="button" class="btnCancel" onclick="window.location.href='#';">Cancel</button>
                <button type="submit" name ="login" class="btnReset">Reset Password</button>
            </div>
        </form>
      </div>
      
    </div>
    
    <!--javascript-->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword1 = document.querySelector('#togglePassword1');
            const togglePassword2 = document.querySelector('#togglePassword2');
            const passwordSet = document.querySelector('#passwordSet');
            const passwordConfirm = document.querySelector('#passwordConfirm');


            if (togglePassword1 && togglePassword2) {
                togglePassword1.addEventListener('click', function () {
                    const type = passwordSet.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordSet.setAttribute('type', type);
                    this.classList.toggle('fa-eye-slash');
                });

                togglePassword2.addEventListener('click', function () {
                    const type = passwordConfirm.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordConfirm.setAttribute('type', type);
                    this.classList.toggle('fa-eye-slash');
                });
            }
        });
    </script>
        <script>
            alert("<?php echo $message; ?>");
        </script>
</body>
</html>
