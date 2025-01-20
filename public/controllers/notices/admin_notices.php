<?php
session_start();
require_once(dirname(__DIR__, 3) . '/includes/db.php');

// 관리자 권한 확인
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("권한이 없습니다.");
}

// 공지사항 데이터 가져오기
$query = "SELECT * FROM notices ORDER BY created_at DESC";
$result = $conn->query($query);

// 데이터를 JSON 형식으로 반환
$notices = [];
while ($row = $result->fetch_assoc()) {
    $notices[] = $row;
}

// JSON으로 반환
header('Content-Type: application/json');
echo json_encode($notices);
?>