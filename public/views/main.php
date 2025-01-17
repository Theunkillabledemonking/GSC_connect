<?php
// 세션 시작
session_start();

// 사용자의 역할(role)을 확인
$role = $_SESSION['role'] ?? 'guest'; // 세션에서 역할을 가져오고 기본값은 'guest'
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>메인 페이지</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <div class="container">
        <!-- 로고 -->
        <div class="logo">
            <img src="gsc.png" alt="학교 로고">
        </div>
        <!-- 제목 -->
        <h1>환영합니다!</h1>
        <!-- 공지사항 및 시간표 버튼 -->
        <div class="main-boxes">
            <div class="box">
                <h2>전체 공지사항</h2>
                <button onclick="navigateTo('all-notices.php')">보기</button>
            </div>
            <div class="box">
                <h2>학년별 공지사항</h2>
                <button onclick="navigateTo('grade-notices.html')">보기</button>
            </div>
            <div class="box">
                <h2>시간표</h2>
                <button onclick="navigateTo('schedule.html')">보기</button>
            </div>
            <!-- 관리자만 볼 수 있는 승인관리 버튼 -->
            <?php if ($role === 'admin'): ?>
            <div class="box admin-box">
                <h2>승인 관리</h2>
                <button onclick="navigateTo('approval-management.php')">관리</button>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <script>
        function navigateTo(page) {
            window.location.href = page; // 페이지 이동
        }
    </script>
</body>
</html>
