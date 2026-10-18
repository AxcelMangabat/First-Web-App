<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Portal</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <main class="loginContainer">

        <div class="loginPanel">

            <span class="logo">CRUD</span>

            <h1 class="loginTitle">Weclome</h1>

            <p class="loginDesc">Sign in to you account</p>

            <?php
                    if (isset($_GET['success_msg'])) {
                        echo "
                        <div class='error_msg'>
                        
                        <h6 style='color: green;'>" . $_GET['success_msg'] . "</h6>
                        
                        
                        </div>
                        ";
                    }


                    ?>
               <?php
                    if (isset($_GET['noacc'])) {
                        echo "
                        <div class='error_msg'>
                        
                        <h6 style='color: red;'>" . $_GET['noacc'] . "</h6>
                        
                        
                        </div>
                        ";
                    }


                    ?>

            <form action="login.php" method="post">

                <div class="fieldGroup">

                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" placeholder="Enter email" required>

                </div>

                
                <input type="hidden" name="Username">
                <input type="hidden" name="Name">


                <div class="formOption show">

                    <a href="#" onclick="togglePassword2('Loginpassword', this); return false;"
                        class="ShowPass">Show</a>

                </div>

                <div class="fieldGroup">

                    <label for="Loginpassword">Password</label>
                    <input type="password" name="password" id="Loginpassword" placeholder="Enter password" required>

                </div>
                   <?php
                    if (isset($_GET['inc_password'])) {
                        echo "
                        <div class='error_msg2'>
                        
                        <h6 style='color: red;'>" . $_GET['inc_password'] . "</h6>
                        
                        
                        </div>
                        ";
                    }


                    ?>

                <div class="buttonBox">

                    <button type="submit" name="login" class="loginBtn">Sign In</button>

                </div>
            </form>

            <div class="loginFooter">

                <p>Dont have an account?</p>

                <a class="create" href="signupPage.php">Create account</a>

            </div>

        </div>

    </main>


    <script src="script.js"></script>
</body>

</html>