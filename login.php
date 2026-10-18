<?php

include 'dbcon.php';

if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $username = $_POST['Username'];
    $name = $_POST['Name'];

    $query = "SELECT `Username`,`Name`, `Password` FROM users where email = ?";

    $prepareQuery = mysqli_prepare($connection, $query);

    mysqli_stmt_bind_param(
        $prepareQuery,
        "s",
        $email
    );

    mysqli_stmt_execute($prepareQuery);

    mysqli_stmt_store_result($prepareQuery);

    if(mysqli_stmt_num_rows($prepareQuery) > 0){
        
        mysqli_stmt_bind_result($prepareQuery, $dbUsername, $dbName, $hashedPassword);

        mysqli_stmt_fetch($prepareQuery);

        if(password_verify($password, $hashedPassword)){
            session_start();

            session_regenerate_id(true);
            $_SESSION['Name'] = $dbName;
            $_SESSION['Username'] = $dbUsername;
            $_SESSION['email'] = $email;

            mysqli_stmt_close($prepareQuery);
            
            header('location:dashboard.php');
            exit();

        }else{
            header('location:index.php?inc_password=Incorrect password');
            exit();
        }
    }else{
        header('location:index.php?noacc=Email unrecognized');
        exit();
    }
        
}
?>