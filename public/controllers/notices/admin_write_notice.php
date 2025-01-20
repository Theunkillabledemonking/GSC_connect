<?php
session_start();
require_once(dirname(__DIR__, 3) . '/includes/db.php');

// 세션 유효성 확인
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../main.php?error=session_expired");
    exit;
}

$user_id = $_SESSION['user_id'];
$title = trim($_POST['title']);
$content = trim($_POST['content']);
$target = $_POST['target'] ?? '전체';

// 입력값 검증
if (empty($title) || empty($content)) {
    echo "제목과 내용을 입력하세요.";
    exit;
}

// 데이터베이스 삽입
$stmt = $conn->prepare("INSERT INTO posts (user_id, title, content, target, created_at) VALUES (?, ?, ?, ?, NOW())");
$stmt->bind_param("isss", $user_id, $title, $content, $target);

if ($stmt->execute()) {
    echo "공지사항이 성공적으로 등록되었습니다.";
    header("Location: ../../../views/admin_notices.html?success=created");
    
    exit;
} else {
    echo "데이터베이스 오류: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>