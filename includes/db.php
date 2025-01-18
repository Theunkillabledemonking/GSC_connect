<?php
$host = "127.0.0.1";
$username = "root";
$password = "gsc1234!@#$";
$dbname = "school_portal";

$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
