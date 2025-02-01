<?php
require_once '../model/User.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['stdent_id'];
    $password = $_POST['password'];

    // 사용자 인증
    $user = User::authenticate($student_id, $password);

    if ($user) {
        // 세션에 사용자 정보 저장
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['name'] = $user['name'];
        header("Location: ../view/dashboard.html");
    } else {
        echo "로그인 실패: 잘못된 id 또는 password";
    }
}
?>