<?php include('users.php'); ?>
<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}

$query = "SELECT * FROM `students` WHERE `id` = '$id'";
$result = mysqli_query($connection, $query);

if (!$result) {
    die("Query Failed: " . mysqli_error($connection));
} else {
    $row = mysqli_fetch_assoc($result);

}
?>

<link rel="stylesheet" href="style.css">


<main class="loginContainer">
    <div class="loginPanel">

        <h1 class="loginTitle">Update</h1>

        <p class="loginDesc">Update A record</p>


        <form action="update_page_1.php?id_new=<?php echo $id; ?>" method="post">
            <div class="fieldGroup">
                <label for="First_Name">First Name</label>
                <input type="text" name="First_Name" id="First_Name" class="form-control"
                    value="<?php echo $row['First_Name']; ?>">
            </div>
            <div class="fieldGroup">
                <label for="Last_Name">Last Name</label>
                <input type="text" name="Last_Name" id="Last_Name" class="form-control"
                    value="<?php echo $row['Last_Name']; ?>">
            </div>
            <div class="fieldGroup">
                <label for="Age">Age</label>
                <input type="number" name="Age" id="Age" class="form-control" value="<?php echo $row['Age']; ?>">
            </div><br>

            <div class="buttonBox">

                <button type="submit" class="loginBtn" class="btn btn-success" name="update_students">Update</button>

            </div>
        </form>

    </div>
</main>

<?php
if (isset($_POST['update_students'])) {
    if (isset($_GET['id_new'])) {
        $idnew = $_GET['id_new'];
    }

    $fname = $_POST['First_Name'];
    $lname = $_POST['Last_Name'];
    $age = $_POST['Age'];

    $query = "UPDATE `students` SET `First_Name` = '$fname', `Last_Name` = '$lname', `Age` = '$age' WHERE `id` = '$idnew'";

    $result = mysqli_query($connection, $query);

    if (!$result) {
        die("Query Failed" . mysqli_error($connection));
    } else {
        header('location:dashboard.php?update_msg=You have successfully updated the data.');
        exit();
    }
}
?>


<?php include('footer.php'); ?>