<?php
session_start();
require_once(dirname(__DIR__, 3) . '/includes/db.php');

// 세션 및 관리자 권한 확인
if (!isset($_SESSION['user_id'])) {
    header("HTTP/1.1 401 Unauthorized");
    die(json_encode(["error" => "세션이 만료되었습니다. 다시 로그인하세요."]));
}

// 사용자 정보 가져오기
$stmt = $conn->prepare("SELECT role FROM users WHERE id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// 관리자 권한 확인
if (!$user || $user['role'] !== 'admin') {
    header("HTTP/1.1 403 Forbidden");
    die(json_encode(["error" => "권한이 없습니다."]));
}

// 필터링 조건 가져오기 (GET 파라미터)
$target = $_GET['target'] ?? '전체';

// SQL 쿼리 생성 (필터링 조건에 따라)
if ($target === '전체') {
    $query = "SELECT posts.id, posts.title, posts.target, posts.created_at, users.name AS writer 
              FROM posts 
              JOIN users ON posts.user_id = users.id";
} else {
    $query = "SELECT posts.id, posts.title, posts.target, posts.created_at, users.name AS writer 
              FROM posts 
              JOIN users ON posts.user_id = users.id
              WHERE posts.target = ?";
}

// SQL 실행
if ($target === '전체') {
    $stmt = $conn->prepare($query);
} else {
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $target);
}

if (!$stmt->execute()) {
    header("HTTP/1.1 500 Internal Server Error");
    die(json_encode(["error" => "데이터베이스 오류가 발생했습니다."]));
}

$result = $stmt->get_result();
$notices = [];

// 결과 데이터 변환
while ($row = $result->fetch_assoc()) {
    $notices[] = $row;
}

// JSON 응답 반환
header('Content-Type: application/json');
echo json_encode($notices);

// 연결 종료
$stmt->close();
$conn->close();
?>
