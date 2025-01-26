<?php
session_start();
session_unset();   // 모든 세션 변수 제거
session_destroy(); // 세선 종료

// 로그인 페이지로 리다이렉트
header("Location: login.php");
exit();
?>