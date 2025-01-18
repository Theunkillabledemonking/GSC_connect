<?php
// 절대경로 기반으로 데이터베이스와 함수 파일 불러오기
require_once(dirname(__DIR__, 3) . '/includes/db.php');
require_once(dirname(__DIR__, 3) . '/includes/functions.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = validateInput($_POST['student_id']);
    $name = validateInput($_POST['name']);
    $password = validateInput($_POST['password']);
    $password_confirm = validateInput($_POST['password_confirm']);
    $phone = validateInput($_POST['phone']);
    $role = 'student';
    $is_approved = 'pending';

    if ($password !== $password_confirm) {
        die("비밀번호가 일치하지 않습니다.");
    }

    if (isStudentIdDuplicate($conn, $student_id)) {
        die("이미 사용 중인 학번입니다.");
    }

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $query = "INSERT INTO users (student_id, name, password, phone, role, is_approved)
              VALUES ('$student_id', '$name', '$hashed_password', '$phone', '$role', '$is_approved')";

    if (mysqli_query($conn, $query)) {
        echo "회원가입 성공! <a href='../index.php'>로그인 하러 가기</a>";
    } else {
        echo "회원가입 실패: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
