<?php
session_start();
require_once(dirname(__DIR__, 3) . '/includes/db.php');

// 관리자 권한 확인
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("권한이 없습니다.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_ids'])) {
    $ids = $_POST['delete_ids'];
    $id_placeholders = implode(',', array_fill(0, count($ids), '?'));

    $query = "DELETE FROM notices WHERE id IN ($id_placeholders)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param(str_repeat('i', count($ids)), ...$ids);

    if ($stmt->execute()) {
        echo "<script>alert('공지사항이 성공적으로 삭제되었습니다.'); window.location.href='./admin_notices.php';</script>";
    } else {
        echo "<script>alert('공지사항 삭제에 실패했습니다.');</script>";
    }
}
?>
