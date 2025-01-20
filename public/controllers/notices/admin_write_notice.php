<?php
session_start();
require_once(dirname(__DIR__, 3) . '/includes/db.php');

// 관리자 권한 확인
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $target = $_POST['target'] ?? '전체';

    $stmt = $conn->prepare("INSERT INTO posts (user_id, title, content, target) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $user_id, $title, $content, $target);

    if ($stmt->execute()) {
        header("Location: /admin_notices.php?success=notice_created");
        exit;
    } else {
        echo "오류 발생: " . $stmt->error;
    }
}
?>