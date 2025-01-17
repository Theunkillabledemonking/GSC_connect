<?php
include __DIR__ . '/../../src/config/database.php'; // 데이터베이스 연결

header('Content-Type: application/json; charset=utf-8'); // JSON 응답 설정

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // POST 데이터를 안전하게 읽기
    $studentId = htmlspecialchars($_POST['studentId'], ENT_QUOTES, 'UTF-8');
    $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $phone = htmlspecialchars($_POST['phone'], ENT_QUOTES, 'UTF-8');
    $password = htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8');

    // 모든 필드가 입력되었는지 확인
    if (!$studentId || !$name || !$email || !$phone || !$password) {
        echo json_encode([
            "success" => false,
            "message" => "모든 필드를 올바르게 입력해주세요."
        ]);
        exit;
    }

    // 비밀번호 암호화
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // 데이터베이스에 삽입
    try {
        $sql = "INSERT INTO users (student_id, name, email, phone, password, role, is_approved)
                VALUES (?, ?, ?, ?, ?, 'student', 'pending')";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $studentId, $name, $email, $phone, $hashedPassword);

        if ($stmt->execute()) {
            echo json_encode([
                "success" => true,
                "message" => "회원가입이 완료되었습니다. 관리자의 승인을 기다려주세요."
            ]);
        } else {
            echo json_encode([
                "success" => false,
                "message" => "회원가입 중 오류가 발생했습니다: " . $stmt->error
            ]);
        }

        $stmt->close();
    } catch (mysqli_sql_exception $e) {
        echo json_encode([
            "success" => false,
            "message" => "데이터베이스 오류: " . $e->getMessage()
        ]);
    } finally {
        $conn->close();
    }
} else {
    echo json_encode([
        "success" => false,
        "message" => "잘못된 요청입니다."
    ]);
}
?>
