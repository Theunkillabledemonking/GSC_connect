<?php
require_once '../model/User.php'; // User 모델 포함
session_start(); // 세션 시작

// 요청 메서드가 POST인지 확인인
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 사용자 입력 데이터 가져오기
    $student_id = $_POST['stdent_id']; // 학번
    $password = $_POST['password'];    // 비밀번호

    // User 모델의 authenticate 함수 호출 (로그인 인증)
    $user = User::authenticate($student_id, $password);

    // 인증 결과 확인인
    if ($user) {
        // 세션에 사용자 정보 저장
        $_SESSION['user_id'] = $user['id']; // 사용자 ID
        $_SESSION['role'] = $user['role'];  // 사용자 역할 
        $_SESSION['name'] = $user['name'];  // 사용자 이름

        // 대시보드 페이지로 리다이렉트트
        header("Location: ../view/dashboard.html");
    } else {
        // 로그인 실패 메시지 출력
        echo "로그인 실패: 잘못된 id 또는 password";
    }
}
?>