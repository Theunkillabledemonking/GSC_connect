<?php
session_start();

// 로그인 여부 확인
if (!isset($_SESSION['user_id'])) {
    header("Location: ./views/login.php"); // 로그인 페이지로 리다이렉션
    exit;
}

$pageTitle = "로그인";

// 절대경로 기반으로 헤더 불러오기
require_once(dirname(__DIR__, 1) . '/includes/header.php');

// HTML 파일 불러오기
include_once(dirname(__DIR__, 1) . '/views/main.php');

// 절대경로 기반으로 푸터 불러오기
require_once(dirname(__DIR__, 1) . '/includes/footer.php');
?>
