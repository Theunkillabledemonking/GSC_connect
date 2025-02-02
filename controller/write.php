<?php
session_start();
require_once '../model/Notice.php';

// 관리자나 교수만 작성 가능
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['admin', 'professor'])) {
    http_response_code(403); // 권한 없음
    echo "글 작성 권한이 없습니다.";
    exit;
}

// 폼 데이터 가져오기
$title = $_POST['title'];
$content = $_POST['content'];
$author_id = $_SESSION['user_id']; // 작성자 ID

// 공지사항 작성
if (Notice::create($title, $content, $author_id)) {
    http_response_code(200); // 성공
} else {
    http_response_code(500); // 서버 오류
}
?>