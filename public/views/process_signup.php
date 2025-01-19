<?php
// 절대경로 기반으로 데이터베이스와 함수 파일 불러오기
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
        die("비밀번호가 일치하지 않습니다.");
    }

    // 학번 중복 확인
    if (isStudentIdDuplicate($conn, $student_id)) {
        die("이미 사용 중인 학번입니다.");
    }

    // 이메일 중복 확인
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("올바른 이메일 형식이 아닙니다.");
    }
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        die("이미 사용 중인 이메일입니다.");
    }

    // 비밀번호 해싱
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // 데이터베이스 삽입
    $query = "INSERT INTO users (student_id, name, email, password, phone, role, is_approved)
              VALUES ('$student_id', '$name', '$email', '$hashed_password', '$phone', '$role', '$is_approved')";

    if (mysqli_query($conn, $query)) {
        echo "회원가입 성공! <a href='../main.php'>로그인 하러 가기</a>";
    } else {
        echo "회원가입 실패: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
