<?php
session_start();

// 로그인 여부 확인 (세션 기반으로 검증)
if (!isset($_SESSION['student_id'])) {
    header("Location: ./index.php");
    exit;
}

// 페이지 제목 설정
$pageTitle = "GSC Portal - 메인 화면";

// 사용자 정보 가져오기
$student_id = htmlspecialchars($_SESSION['student_id']);
$name = htmlspecialchars($_SESSION['name']);
$role = htmlspecialchars($_SESSION['role']);

// 절대경로 기반으로 헤더 불러오기
require_once(dirname(__DIR__, 1) . '/includes/header.php');

// HTML 파일 불러오기
include_once(dirname(__DIR__, 1) . '/views/main.php');

// 절대경로 기반으로 푸터 불러오기
require_once(dirname(__DIR__, 1) . '/includes/footer.php');


?>
