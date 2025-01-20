<?php
session_start();
require_once(dirname(__DIR__, 3) . '/includes/db.php');

// 관리자 권한 확인
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("권한이 없습니다.");
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';
    $target = $_POST['target'] ?? '전체';
    $user_id = $_SESSION['user_id']; // 로그인된 사용자 ID
    $writer = $_SESSION['name']; // 로그인된 사용자 이름

    $stmt = $conn->prepare("INSERT INTO posts (title, content, user_id, writer, target, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("sssss", $title, $content, $user_id, $writer, $target);

    if ($stmt->execute()) {
        echo "공지사항 작성 성공!";
    } else {
        echo "오류: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    // POST가 아닌 경우 접근 제한
    http_response_code(405);
    echo "허용되지 않은 요청 방법입니다.";
}
?>