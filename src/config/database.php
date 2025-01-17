<?php
$host = '127.0.0.1';      // 호스트
$username = 'root';       // 사용자명
$port = '3306';
$password = 'gsc1234!@#$';           // 비밀번호 (기본적으로는 비어 있음)
$database = 'users'; // 데이터베이스 이름

$conn = new mysqli($host, $username, $password, $database, $port);

// 연결 오류 확인
if ($conn->connect_error) {
    die('Database connection failed: ' . $conn->connect_error);
} else {
    echo "Database connected successfully!";
}
?>