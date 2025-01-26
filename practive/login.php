<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'school_portal');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $hased_password);

    if ($stmt->fetch() && password_verify($password, $hased_password)) {
        $_SESSION['user_id'] = $id;
        echo "로그인 성공!";
        // 게시판 이동
        header("Location: posts.php");
        exit();
    } else {
        echo "로그인 실패: 아이디 또는 비밀번호를 확인하세요.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="POST">
        <input type="text" name="username" placeholder="아이디" require>
        <input type="password" name="password" placeholder="비밀번호" require>
        <button type="submit">로그인</button>
        <button type="button" value="button" onclick="location.href='signup.php'">회원가입</button>
    </form>
</body>
</html>