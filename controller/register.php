<?php
require_once '../config/config.php'; // 데이터베이스 연결 파일

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 입력 데이터 받기
    $student_id = $_POST['student_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // 비밀번호 일치 확인
    if ($password !== $confirm_password) {
        die("비밀번호가 일치하지 않습니다.");
    }

    // User 모델을 사용하여 회원가입 처리
    if (User::register($student_id, $name, $email, $password)) {
        echo "회원가입이 완료되었습니다.";
    } else {
        echo "회원가입에 실패했습니다";
    }
}
?>