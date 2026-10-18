<?php include('users.php'); ?>

<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $query = "DELETE FROM `students` WHERE `id` = '$id'";
    $result = mysqli_query($connection, $query);

    if (!$result) {
        die("Query Failed: " . mysqli_error($connection));
    } else {
        header('location:dashboard.php?delete_msg=Record has been deleted successfully.');
        exit();
    }
}
?>
<?php include('footer.php'); ?>