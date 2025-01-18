<?php
$pageTitle = "로그인";

// 절대경로 기반으로 헤더 불러오기
require_once(dirname(__DIR__, 2) . '/includes/header.php');

// HTML 파일 불러오기
include_once(dirname(__DIR__) . '/public/html/login.html');

// 절대경로 기반으로 푸터 불러오기
require_once(dirname(__DIR__, 2) . '/includes/footer.php');
