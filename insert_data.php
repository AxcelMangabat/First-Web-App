<?php
include 'users.php';

if (isset($_POST['add_students'])) {
	$fname = $_POST['First_Name'];
	$lname = $_POST['Last_Name'];
	$age = $_POST['Age'];

	if (empty($fname) || empty($lname) || empty($age)) {
		header('location:dashboard.php?message=ALL FIELDS ARE REQUIRED!');
		exit();
	} else {
		$query = "INSERT INTO students (First_Name, Last_Name, Age) VALUES ('$fname', '$lname', '$age')";

		$result = mysqli_query($connection, $query);

		if (!$result) {
			die("Query FAILED " . mysqli_error($connection));
		} else {
			header('location:dashboard.php?insert_msg=Your data has been added successfully');
			exit();
		}
	}
}
?>