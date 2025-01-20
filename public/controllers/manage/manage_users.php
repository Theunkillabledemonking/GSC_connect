<?php
session_start();
// 데이터베이스 연결
require_once(dirname(__DIR__, 3) . '/includes/db.php');

// 관리자 권한 확인
if ($_SESSION['role'] !== 'admin') {
    header("Location: ./main.php");
    exit;
}
// 관리자 권한 확인
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../views/error.php?msg=Unauthorized");
    exit;
}

// 승인 또는 거절 처리
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = strip_tags($_POST['student_id']);
    $action = $_POST['action'];

    if ($action === 'approve') {
        $query = "UPDATE users SET is_approved = 'approved' WHERE student_id = ?";
    } elseif ($action === 'reject') {
        $query = "DELETE FROM users WHERE student_id = ?";
    } else {
        die("유효하지 않은 작업입니다.");
    }

    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $student_id);
    $stmt->execute();

    // 완료 후 다시 목록 페이지로 이동
    header("Location: ../views/manage_users.html?success=$action");
    exit;
}

// 승인 대기 목록 반환 (JSON 응답 예시)
$query = "SELECT student_id, name, phone, grade FROM users WHERE is_approved = 'pending'";
$result = mysqli_query($conn, $query);

$pendingUsers = [];
while ($row = mysqli_fetch_assoc($result)) {
    $pendingUsers[] = $row;
}

// JSON으로 응답
header('Content-Type: application/json');
echo json_encode($pendingUsers);

mysqli_close($conn);