<?php
// 데이터베이스 연결
session_start();
require_once(dirname(__DIR__, 2) . '/includes/db.php');

// POST 요청 데이터 가져오기
$student_id = trim($_POST['student_id']);
$password = trim($_POST['password']);

// 데이터베이스에서 사용자 정보 확인
$stmt = $conn->prepare("SELECT * FROM users WHERE student_id = ?");
$stmt->bind_param("s", $student_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    // 승인 여부 확인
    if ($user['is_approved'] !== 'approved') {
        echo "<script>alert('계정이 승인되지 않았습니다. 관리자에게 문의하세요.'); window.location.href='./main.php';</script>";
        exit;
    }

    // 비밀번호 검증
    if (password_verify($password, $user['password'])) {
        // 세션 저장
        $_SESSION['student_id'] = $user['student_id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['role'] = $user['role'];
        var_dump($_SESSION); // 세션 변수 확인
        exit;

        // 메인 페이지로 이동
        header("Location: ./main.php");
        exit();
    } else {
        header("Location: ../main.php?error=invalid_password");
        exit();
    }
} else {
    header("Location: ../main.php?error=user_not_found");
    exit();
}

$stmt->close();
$conn->close();
?>