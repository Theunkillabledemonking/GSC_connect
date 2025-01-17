<?php
include '../src/config/database.php'; // 데이터베이스 연결

$response = ["success" => false, "message" => "", "role" => ""];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $identifier = $_POST['identifier'] ?? null;
    $password = $_POST['password'] ?? null;

    if (!$identifier || !$password) {
        $response["message"] = "아이디와 비밀번호를 입력해주세요.";
        echo json_encode($response);
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

            $response["success"] = true;
            $response["username"] = $user['name'];
            $response["role"] = $user['role']; // 역할(role)을 클라이언트로 전달
        } else {
            $response["message"] = "비밀번호가 일치하지 않습니다.";
        }
    } else {
        $response["message"] = "사용자를 찾을 수 없거나 승인되지 않았습니다.";
    }

    $stmt->close();
    $conn->close();
} else {
    $response["message"] = "잘못된 요청입니다.";
}

header("Content-Type: application/json");
echo json_encode($response);
?>
