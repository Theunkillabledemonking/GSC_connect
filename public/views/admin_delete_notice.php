<?php
session_start();
require_once(dirname(__DIR__, 2) . '/includes/db.php');

// 로그인 검증 (관리자 권한 확인)
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("권한이 없습니다.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_ids'])) {
    $ids = $_POST['delete_ids'];
    $id_placeholders = implode(',', array_fill(0, count($ids), '?'));

    $query = "DELETE FROM notices WHERE id IN ($id_placeholders)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param(str_repeat('i', count($ids)), ...$ids);
    $stmt->execute();

    header('Location: admin_notices.php');
    exit();
}
?>
