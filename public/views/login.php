<?php
session_start();

// 로그인 확인
if (!isset($_SESSION['student_id'])) {
    header("Location: ../index.php");
    exit;
}

$pageTitle = "메인화면";
include_once(dirname(__DIR__, 2) . '/includes/header.php');

// 사용자 정보
$user_role = $_SESSION['role'];
$user_name = $_SESSION['name'];
?>

<div class="container">
    <h1>GSC Portal 메인화면</h1>
    <p>환영합니다, <strong><?php echo htmlspecialchars($user_name); ?></strong>님!</p>

    <?php if ($user_role === 'admin'): ?>
        <!-- 관리자 전용 메뉴 -->
        <h2>관리자 메뉴</h2>
        <ul>
            <li><a href="./manage_users.php">사용자 관리</a></li>
            <li><a href="./manage_notices.php">공지사항 관리</a></li>
            <li><a href="./manage_timetable.php">시간표 관리</a></li>
        </ul>
    <?php else: ?>
        <!-- 학생 전용 메뉴 -->
        <h2>학생 메뉴</h2>
        <ul>
            <li><a href="./view_notices.php">공지사항 보기</a></li>
            <li><a href="./view_timetable.php">시간표 보기</a></li>
        </ul>
    <?php endif; ?>

    <a href="./logout.php" class="logout-button">로그아웃</a>
</div>

<?php include_once(dirname(__DIR__, 2) . '/includes/footer.php'); ?>
