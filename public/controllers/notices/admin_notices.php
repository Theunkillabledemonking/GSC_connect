<?php
session_start();
require_once(dirname(__DIR__, 3) . '/includes/db.php');

// 관리자 권한 확인
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("권한이 없습니다.");
}

$query = "SELECT id, title, target, created_at FROM posts";
$result = mysqli_query($conn, $query);

$notices = [];
while ($row = mysqli_fetch_assoc($result)) {
    $notices[] = $row;
}

header('Content-Type: application/json');
echo json_encode($notices);

mysqli_close($conn);
?>