<?php
session_start();

// 절대경로 기반으로 데이터베이스와 함수 파일 불러오기
require_once(dirname(__DIR__, 2) . '/`in`cludes/db.php');
require_once(dirname(__DIR__, 2) . '/includes/functions.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = validateInput($_POST['student_id']);
    $password = validateInput($_POST['password']);

    $query = "SELECT * FROM users WHERE student_id = '$student_id'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        if (password_verify($password, $user['password'])) {
            if ($user['is_approved'] !== 'approved') {
                die("계정이 승인되지 않았습니다. 관리자에게 문의하세요.");
            }

            $_SESSION['user_id'] = $user['student_id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['role'] = $user['role'];

            header("Location: ./main.php");
            exit;
        } else {
            echo "비밀번호가 일치하지 않습니다.";
        }
    } else {
        echo "학번이 존재하지 않습니다.";
    }

    mysqli_close($conn);
}
?>
