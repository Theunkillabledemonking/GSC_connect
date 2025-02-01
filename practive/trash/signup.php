<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'school_portal');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $password);

    if ($stmt->execute()) {
        echo "<script>
            alert('회원가입 성공!');
            window.location.href = 'login.php';
        </script>";
            exit();
    } else {
        echo "회원가입 실패:" . $conn->error;
    }

    $stmt->close();
}
?>

<form action="" method="post">
    <input type="text" name="username" placeholder="아이디" require>
    <input type="password" name="password" placeholder="비밀번호" require>
    <button type="submit">회원가입</button>
    <button type="button" value="button" onclick="location.href='login.php'">돌아가기</button>
</form>