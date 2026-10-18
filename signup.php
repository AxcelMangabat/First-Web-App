<?php

include 'dbcon.php';
require_once __DIR__ . '/mail_config.php';

if (isset($_POST['signup'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['ConfirmPassword'];

    $query = "SELECT ID FROM users WHERE email = ?";

    $prepareQuery = mysqli_prepare($connection, $query);

    mysqli_stmt_bind_param(
        $prepareQuery,
        "s",
        $email
    );

    mysqli_stmt_execute($prepareQuery);

    mysqli_stmt_store_result($prepareQuery);


    if (mysqli_stmt_num_rows($prepareQuery) > 0) {
        mysqli_stmt_close($prepareQuery);

        header('location:signupPage.php?email_msg=Email already exist');
        exit();
    }
    mysqli_stmt_close($prepareQuery);

    if (empty($name) || empty($email) || empty($username) || empty($password) || empty($confirm_password)) {
        header('location:index.php?message=Please fill in all fields');
        exit();
    } else {
        if ($password !== $confirm_password) {
            header('location:signupPage.php?password_notsame=Password must be the same');
            exit();
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);


        $query = "INSERT INTO users(`Name`, `Email`, `Username`, `Password`) VALUES (?, ?, ?, ?)";

        $prepareQuery = mysqli_prepare($connection, $query);

        mysqli_stmt_bind_param(
            $prepareQuery,
            "ssss",
            $name,
            $email,
            $username,
            $hashedPassword
        );

        $success = mysqli_stmt_execute($prepareQuery);

        mysqli_stmt_close($prepareQuery);

        if (!$success) {
            header('Location: index.php?failed_msg=Account Creation Failed');
            exit();
        }
        $emailSent = sendWelcomeEmail($email, $name);

        if (!$emailSent) {
            error_log("Account created, but welcome email failed for a registered user.");
        }

        header('Location: index.php?success_msg=Account Created Successfully!');
        exit();



    }




}




?>