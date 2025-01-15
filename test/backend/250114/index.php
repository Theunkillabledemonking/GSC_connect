<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $studentId = $_POST['studentId'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $conn = new mysqli('localhost', 'username', 'password', 'database');

    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO users (studentId, name, phone, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param('ssss', $studentId, $name, $phone, $password);

    if ($stmt->execute()) {
        echo '회원가입이 성공적으로 완료되었습니다!';
    } else {
        echo '오류가 발생했습니다: ' . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
