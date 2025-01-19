<?php
// 데이터베이스 연결
require_once(dirname(__DIR__, 2) . '/includes/db.php');

// POST 요청 확인
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 입력 값 가져오기
    $student_id = trim($_POST['student_id']);
    $password = trim($_POST['password']);

    // 학번으로 사용자 검색
    $query = "SELECT * FROM users WHERE student_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // 학번 존재 여부 확인
    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // 비밀번호 검증
        if (password_verify($password, $user['password'])) {
            // 계정 승인 여부 확인
            if ($user['is_approved'] !== 'approved') {
                header("Location: ../index.php?error=account_not_approved");
                exit;
            }

            // 로그인 성공 - main.php로 이동
            header("Location: ./main.php?student_id=$student_id");
            exit;
        } else {
            // 비밀번호가 틀린 경우
            header("Location: ../index.php?error=incorrect_password");
            exit;
        }
    } else {
        // 학번이 존재하지 않을 경우
        header("Location: ../index.php?error=user_not_found");
        exit;
    }

    // Prepared Statement 종료
    $stmt->close();
}

// 데이터베이스 연결 종료
mysqli_close($conn);
?>
