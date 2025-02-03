<?php
session_start();

// 로그인 여부 확인
if (!isset($_SESSION['role'])) {
    http_response_code(401); // 인증되지 않은 사용자
    echo json_encode(["status" => "error", "message" => "로그인되지 않았습니다."]);
    exit;
}

// 사용자 역할 반환
echo json_encode([
    "user_id" => $_SESSION['user_id'],
    "role" => $_SESSION['role'], // 세션에서 역할 가져오기
    "name" => isset($_SESSION['name']) ? $_SESSION['name'] : null // 사용자 이름도 반환
]);
?>