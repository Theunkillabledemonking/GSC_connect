<?php
session_start();
if (!isset($_SESSION['role'])) {
    header("Location: index.php"); // 로그인 페이지로 리다이렉션
    exit;
}

$role = $_SESSION['role']; // 역할(role) 가져오기

if ($role === 'admin') {
    // 관리자 화면
    echo "<h1>관리자 대시보드</h1>";
    echo "<p>관리자님 환영합니다!</p>";
    echo "<a href='manage_users.php'>사용자 관리</a>";
} elseif ($role === 'student') {
    // 학생 화면
    echo "<h1>학생 대시보드</h1>";
    echo "<p>학생님 환영합니다!</p>";
    echo "<a href='view_schedule.php'>시간표 보기</a>";
} else {
    // 알 수 없는 역할
    echo "<p>잘못된 접근입니다.</p>";
    session_destroy();
    header("Location: index.php");
    exit;
}
?>
