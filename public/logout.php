<?php
session_start();
session_unset();
session_destroy();

// 로그인 화면으로 리다이렉트
header("Location: ../main.php");
exit;
?>
