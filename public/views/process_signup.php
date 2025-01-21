<?php
require_once(dirname(__DIR__, 2) . '/includes/db.php');
require_once(dirname(__DIR__, 2) . '/includes/functions.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 입력 값 가져오기 및 검증
    $student_id = validateInput($_POST['student_id']);
    $name = validateInput($_POST['name']);
    $password = validateInput($_POST['password']);
    $password_confirm = validateInput($_POST['password_confirm']);
    $phone = validateInput($_POST['phone']);
    $email = validateInput($_POST['email']);
    $role = 'student';
    $is_approved = 'pending';

    // 비밀번호 확인
    if ($password !== $password_confirm) {
        header("Location: ../signup.php?error=password_mismatch");
        exit;
    }

    // 학번 중복 확인
    if (isStudentIdDuplicate($conn, $student_id)) {
        header("Location: ../signup.php?error=student_id_taken");
        exit;
    }

    // 이메일 중복 확인
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../signup.php?error=invalid_email");
        exit;
    }

    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result && $result->num_rows > 0) {
        header("Location: ../signup.php?error=email_taken");
        exit;
    }

    // 비밀번호 강도 확인
    if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/', $password)) {
        header("Location: ../signup.php?error=weak_password");
        exit;
    }

    // 전화번호 확인
    if (!preg_match('/^\d{10,15}$/', $phone)) {
        header("Location: ../signup.php?error=invalid_phone");
        exit;
    }

    // 비밀번호 해싱
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // 데이터베이스 삽입
    $query = "INSERT INTO users (student_id, name, email, password, phone, role, is_approved)
              VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sssssss', $student_id, $name, $email, $hashed_password, $phone, $role, $is_approved);

    if ($stmt->execute()) {
        header("Location: ../main.php?success=signup_success");
    } else {
        echo "회원가입 실패: " . $stmt->error;
    }

    $stmt->close();
    mysqli_close($conn);
}
?>
