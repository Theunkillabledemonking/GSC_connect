<?php
// database/db_connect.php
$servername = "127.0.0.1";
$username = "root";
$password = "gsc1234!@#$";
$dbname = "school_portal";

// 데이터베이스 연결
$conn = new mysqli($servername, $username, $password, $dbname);

// 연결 확인
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
