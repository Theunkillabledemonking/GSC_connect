<?php
require_once '../../src/config/database.php';

// POST 요청 데이터 수집
$student_id = $_POST['student_id'];
$name = $_POST['name'];
$phone = $_POST['phone'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // 비밀번호 암호화
$role = 'student'; // 기본값
$is_approved = 'pending'; // 기본값

// 데이터베이스에 데이터 삽입
$stmt = $conn->prepare("INSERT INTO users (student_id, name, phone, password, role, is_approved) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $student_id, $name, $phone, $password, $role, $is_approved);

if ($stmt->execute()) {
    header("Location: ../index.html"); // 회원가입 성공 시 메인 화면으로 이동
    exit();
} else {
    echo "회원가입에 실패했습니다: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
