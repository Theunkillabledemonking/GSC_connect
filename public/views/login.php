<?php
include '../src/config/database.php'; // 데이터베이스 연결

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $identifier = $_POST['identifier'] ?? null;
    $password = $_POST['password'] ?? null;

    if (!$identifier || !$password) {
        header("Location: ../index.html?error=empty_fields");
        exit;
    }

    // 사용자 조회
    $sql = "SELECT * FROM users WHERE (student_id = ? OR email = ?) AND is_approved = 'approved'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $identifier, $identifier);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];

            // 역할(role)에 따라 리디렉션
            if ($user['role'] === 'admin') {
                header("Location: ../views/admin_dashboard.php");
            } else {
                header("Location: ../views/main.php");
            }
            exit;
        } else {
            header("Location: ../index.html?error=invalid_password");
            exit;
        }
    } else {
        header("Location: ../index.html?error=user_not_found");
        exit;
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: ../index.html?error=invalid_request");
    exit;
}
?>
