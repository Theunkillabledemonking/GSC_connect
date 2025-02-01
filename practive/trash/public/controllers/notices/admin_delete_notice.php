<?php
session_start();
require_once(dirname(__DIR__, 3) . '/includes/db.php');

// 관리자 권한 확인
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("권한이 없습니다.");
}

$data = json_decode(file_get_contents('php://input'), true);
if (!empty($data['delete_ids'])) {
    $ids = implode(',', array_map('intval', $data['delete_ids']));
    $query = "DELETE FROM posts WHERE id IN ($ids)";
    $result = mysqli_query($conn, $query);

    echo json_encode(['success' => $result ? true : false]);
} else {
    echo json_encode(['success' => false, 'error' => 'No IDs provided']);
}

mysqli_close($conn);
?>