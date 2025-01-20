<?php
session_start();
require_once(dirname(__DIR__, 3) . '/includes/db.php');

// 관리자 권한 확인
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("권한이 없습니다.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $writer = $_SESSION['name'];
    $content = $_POST['content'];
    $target = $_POST['target'];

    $query = "INSERT INTO posts (title, writer, content, target) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssss', $title, $writer, $content, $target);

    if ($stmt->execute()) {
        header('Location: ../../views/admin_view_notices.html');
        exit();
    } else {
        echo "공지사항 작성 실패";
    }
}
?>
