<?php
require_once '../../src/config/database.php';

// POST 요청 데이터 가져오기
$student_id = $_POST['student_id'];
$password = $_POST['password'];

// 데이터베이스에서 사용자 정보 확인
$stmt = $conn->prepare("SELECT * FROM users WHERE student_id = ?");
$stmt->bind_param("s", $student_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    // 비밀번호 검증
    if (password_verify($password, $user['password'])) {
        // 세션 시작 및 사용자 정보 저장
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['student_id'] = $user['student_id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['role'] = $user['role'];

        // 로그인 성공 후 메인 페이지로 이동
        header("Location: main.php");
        exit();
    } else {
        echo "잘못된 비밀번호입니다.";
    }
} else {
    echo "해당 학번으로 등록된 사용자가 없습니다.";
}

$stmt->close();
$conn->close();
?>
