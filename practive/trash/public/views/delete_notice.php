<?php
session_start();
require_once(dirname(__DIR__, 2) . '/includes/db.php');

// 관리자 권한 확인
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("권한이 없습니다.");
}

// POST 요청 확인 (보안을 위해 GET 대신 POST로 수정)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);

    // 공지사항 삭제
    $query = "DELETE FROM notices WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        echo "<script>alert('공지사항이 삭제되었습니다.'); window.location.href='./notices.php';</script>";
    } else {
        echo "<script>alert('공지사항 삭제에 실패했습니다.');</script>";
    }

    $stmt->close();
} else {
    die("잘못된 접근입니다.");
}
?>
