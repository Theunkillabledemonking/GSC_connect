<?php
$host = '127.0.0.1';      // 호스트
$username = 'root';       // 사용자명
$password = 'gsc1234!@#$';           // 비밀번호 (기본적으로는 비어 있음)
$database = 'school_portal'; // 데이터베이스 이름

$conn = new mysqli($host, $username, $password, $database);

// 연결 오류 확인
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}
?>
