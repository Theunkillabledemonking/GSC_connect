<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header("Location: ../main.php");
    exit();
}

$name = htmlspecialchars($_SESSION['name']);
$role = htmlspecialchars($_SESSION['role']);
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GSC Portal - 메인 화면</title>
    <link rel="stylesheet" href="../css/main.css">
</head>
<body>
    <div class="container">
        <h1 class="welcome">환영합니다, <?php echo $name; ?>님!</h1>

        <?php if ($role === 'admin'): ?>
        <!-- 관리자용 화면 -->
        <div class="main-boxes admin-view">
            <div class="box">
                <h2>전체 공지사항</h2>
                <button onclick="navigateTo('all-notices.php')">보기</button>
            </div>
            <div class="box">
                <h2>시간표</h2>
                <button onclick="navigateTo('schedule.html')">보기</button>
            </div>
            <div class="box">
                <h2>승인 관리</h2>
                <button onclick="navigateTo('approval-management.php')">관리</button>
            </div>
        </div>
        <?php else: ?>
        <!-- 일반 학생용 화면 -->
        <div class="main-boxes student-view">
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
        </div>
        <?php endif; ?>

        <a href="../logout.php" class="logout-button">로그아웃</a>
    </div>

    <script>
        function navigateTo(page) {
            window.location.href = page;
        }
    </script>
</body>
</html>
