<?php

define("CRUD_HOSTNAME", "localhost");
define("CRUD_USERNAME", "root");
define("CRUD_PASSWORD", "");
define("CRUD_DATABASE", "crud_operation");

$connection = mysqli_connect (CRUD_HOSTNAME, CRUD_USERNAME, CRUD_PASSWORD, CRUD_DATABASE);

if (!$connection){
	die("Connection Failed");
}
?>