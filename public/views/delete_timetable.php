<?php
session_start();
require_once('./includes/db.php');

// 관리자 권한 확인
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("권한이 없습니다.");
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = "DELETE FROM timetable WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        echo "<script>alert('시간표가 삭제되었습니다.'); window.location.href='./view_timetable.php';</script>";
    } else {
        echo "<script>alert('삭제에 실패했습니다.');</script>";
    }
    $stmt->close();
}
?>
