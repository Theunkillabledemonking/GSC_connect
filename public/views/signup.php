<?php
require_once '../src/config/database.php';

// POST 데이터 확인
if (empty($_POST['student_id']) || empty($_POST['name']) || empty($_POST['phone']) || empty($_POST['email']) || empty($_POST['password'])) {
    die("Error: All fields are required.");
}

$student_id = $_POST['student_id'];
$name = $_POST['name'];
$phone = $_POST['phone'];
$email = $_POST['email']; // email 값 추가
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$role = 'student';
$is_approved = 'pending';

// 데이터 삽입 쿼리
$stmt = $conn->prepare("INSERT INTO users (student_id, name, phone, email, password, role, is_approved) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssss", $student_id, $name, $phone, $email, $password, $role, $is_approved);

if ($stmt->execute()) {
    echo "회원가입 성공!";
} else {
    die("Error inserting data: " . $stmt->error);
}

$stmt->close();
$conn->close();
?>
