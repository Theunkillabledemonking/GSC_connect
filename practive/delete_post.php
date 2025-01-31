<?php
require 'auth.php';
require 'functions.php';

// 데이터베이스 연결
$conn = db_connect();

// 세션 시작
session_start();

// 사용자 로그인 확인
authenticate_user($conn);

// 사용자 역할 및 ID 확인
$role = $_SESSION['role'] ?? '';
$user_id = $_SESSION['user_id'] ?? '';

// 삭제할 게시물 ID 확인
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("잘못된 요청입니다.");
}
$post_id = intval($_GET['id']); // 숫자로 변환하여 보안 강화

// 게시물 삭제 실행
if (delete_post($conn, $post_id, $user_id, $role)) {
    echo "<script>alert('게시물이 삭제되었습니다.'); location.href='posts.php';</script>";
} else {
    echo "<script>alert('게시물이 삭제에 실패했습니다. 권한을 확인하세요.'); location.href='posts.php';</script>";
}

/// db 종료
$conn->close();
?>