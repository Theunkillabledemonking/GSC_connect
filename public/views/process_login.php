<?php
session_start();
require_once(dirname(__DIR__, 2) . '/includes/db.php');

function redirectWithError($url, $error) {
    header("Location: $url?error=$error");
    exit();
}

// POST 요청 데이터 가져오기
$student_id = trim($_POST['student_id'] ?? '');
$password = trim($_POST['password'] ?? '');

// 입력 값 검증
if (empty($student_id) || empty($password)) {
    redirectWithError('../main.php', 'empty_fields');
}

// 데이터베이스에서 사용자 정보 확인
$stmt = $conn->prepare("SELECT * FROM users WHERE student_id = ?");
$stmt->bind_param("s", $student_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    // 승인 여부 확인
    if ($user['is_approved'] !== 'approved') {
        redirectWithError('../main.php', 'account_not_approved');
    }

    // 비밀번호 검증
    if (password_verify($password, $user['password'])) {
        // 세션 저장
        $_SESSION['student_id'] = $user['student_id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['role'] = $user['role'];

        // 메인 페이지로 이동
        header("Location: ./main.php");
        exit();
    } else {
        redirectWithError('../main.php', 'invalid_password');
    }
} else {
    redirectWithError('../main.php', 'user_not_found');
}

$stmt->close();
$conn->close();
?>
