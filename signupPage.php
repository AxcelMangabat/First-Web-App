<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Registration</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <main class="loginContainer">

        <div class="signupPanel">

            <span class="logo">CRUD</span>

            <h1 class="loginTitle">Sign Up</h1>

            <p class="loginDesc">Create you own account</p>


            <form action="signup.php" method="post">


                <div class="fieldGroup">

                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" placeholder="Your name" required>

                </div>

                  <?php
                    if (isset($_GET['email_msg'])) {
                        echo "
                        <div class='error_msg'>
                        
                        <h6 style='color: red;'>" . $_GET['email_msg'] . "</h6>
                        
                        
                        </div>
                        ";
                    }


                    ?>

                <div class="fieldGroup">

                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" placeholder="you@example.com" required>

                </div>

                <div class="fieldGroup">

                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" placeholder="username" required>

                </div>

                <div class="formOption show">

                    <a href="#" onclick="togglePassword('Signuppassword', 'ConfirmPassword', this); return false;"
                        class="ShowPass">Show</a>

                </div>

                <div class="fieldGroup">

                    <label for="Signuppassword">Password</label>
                    <input type="password" name="password" id="Signuppassword" placeholder="Enter password" required>

                </div>

                <?php
                    if (isset($_GET['password_notsame'])) {
                        echo "
                        <div class='error_msg'>
                        
                        <h6 style='color: red;'>" . $_GET['password_notsame'] . "</h6>
                        
                        
                        </div>
                        ";
                    }


                    ?>


                <div class="fieldGroup">

                    <label for="ConfirmPassword">Confirm password</label>
                    <input type="password" name="ConfirmPassword" id="ConfirmPassword" placeholder="Confirm password"
                        required>

                </div>

                <div class="buttonBox">

                    <button type="submit" name="signup" class="loginBtn">Sign In</button>

                </div>
            </form>

            <div class="loginFooter">

                <p>Already have an acount?</p>

                <a class="create" href="index.php">Sign In</a>

            </div>

        </div>

    </main>

    <script src="script.js"></script>
</body>

</html>