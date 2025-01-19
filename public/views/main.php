<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header("Location: ../index.php"); // 로그인 페이지로 이동
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
    <!-- CSS 경로 -->
    <link rel="stylesheet" href="../css/main.css">
</head>
<body>
    <div class="main-container">
        <header class="header">
            <h1 class="welcome">환영합니다, <?php echo $name; ?>님!</h1>
        </header>

        <?php if ($role === 'admin'): ?>
        <!-- 관리자용 화면 -->
        <div class="dashboard admin-dashboard">
            <div class="card">
                <h2>전체 공지사항</h2>
                <button onclick="navigateTo('./view_notices.php')">보기</button>
            </div>
            <div class="card">
                <h2>시간표</h2>
                <button onclick="navigateTo('./schedule.php')">보기</button>
            </div>
            <div class="card">
                <h2>승인 관리</h2>
                <button onclick="navigateTo('./manage_users.php')">관리</button>
            </div>
        </div>
        <?php else: ?>
        <!-- 일반 학생용 화면 -->
        <div class="dashboard student-dashboard">
            <div class="card">
                <h2>전체 공지사항</h2>
                <button onclick="navigateTo('./view_notices_user.php')">보기</button>
            </div>


            <div class="card">
                <h2>시간표</h2>
                <button onclick="navigateTo('./schedule.php')">보기</button>
            </div>
        </div>
        <?php endif; ?>

        <footer class="footer">
            <a href="../logout.php" class="logout-button">로그아웃</a>
        </footer>
    </div>

    <script>
        function navigateTo(page) {
            window.location.href = page;
        }
    </script>
</body>
</html>
