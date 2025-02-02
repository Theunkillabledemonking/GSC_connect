<?php
require_once '../model/User.php'; // User 모델 포함
session_start(); // 세션 시작

// 1. 로그인 요청 확인
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 사용자 입력 데이터 가져오기
    $student_id = $_POST['student_id']; // 학번
    $password = $_POST['password'];    // 비밀번호

    // DB에서 사용자 정보 조회 
    $user = User::getUserByID($student_id, $password);

    // 비밀번호 검증 및 로그인 처리
    if ($user && password_verify($password, $user['password'])) {
        // 세션에 사용자 정보 저장
        $_SESSION['user_id'] = $user['student_id']; // 사용자 ID
        $_SESSION['role'] = $user['role'];  // 사용자 역할 
        $_SESSION['user_name'] = $user['name'];  // 사용자 이름

        // 대시보드 페이지로 리다이렉트트
        header("Location: ../view/dashboard.html");
    } else {
        // 로그인 실패 메시지 출력
        echo "로그인 실패: 잘못된 id 또는 password";
    }
}
?>