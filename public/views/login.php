<?php
include '../../src/config/database.php'; // 데이터베이스 연결

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $identifier = $_POST['identifier']; // 학번 또는 이메일
    $password = $_POST['password'];     // 비밀번호

    // 학번 또는 이메일로 사용자 조회 (승인된 사용자만 로그인 가능)
    $sql = "SELECT * FROM users WHERE (student_id = ? OR email = ?) AND is_approved = 'approved'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $identifier, $identifier);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // 비밀번호 검증
        if (password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];

            // 역할(role)에 따라 다른 페이지로 리다이렉션
            if ($user['role'] === 'admin') {
                header("Location: dashboard.php"); // 관리자 페이지로 이동
            } elseif ($user['role'] === 'student') {
                header("Location: ../../views/main.php"); // 학생 페이지로 이동
            }
            exit;
        } else {
            echo "<script>alert('비밀번호가 올바르지 않습니다.');</script>";
        }
    } else {
        echo "<script>alert('사용자를 찾을 수 없거나 승인되지 않았습니다.');</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
