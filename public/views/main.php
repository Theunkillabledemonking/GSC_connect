<?php
// 학번 확인
if (!isset($_GET['student_id'])) {
    header("Location: ./login.php");
    exit;
}

// 사용자 정보 가져오기
$student_id = htmlspecialchars($_GET['student_id']);

// 데이터베이스 연결
require_once('./includes/db.php');

// 사용자 데이터 가져오기
$query = "SELECT name, role FROM users WHERE student_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $student_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $name = $user['name'];
    $role = $user['role'];
} else {
    // 사용자가 존재하지 않을 경우 로그인 페이지로 이동
    header("Location: ../index.html");
    exit;
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GSC Portal - 메인 화면</title>
    <link rel="stylesheet" href="./css/main.css">
</head>
<body>
    <div class="container">
        <h1>GSC Portal 메인 화면</h1>
        <p>환영합니다, <strong><?php echo htmlspecialchars($name); ?></strong>님!</p>

        <?php if ($role === 'admin'): ?>
            <!-- 관리자 메뉴 -->
            <h2>관리자 메뉴</h2>
            <ul>
                <li><a href="./manage_users.php">사용자 관리</a></li>
                <li><a href="./manage_notices.php">공지사항 관리</a></li>
                <li><a href="./manage_timetable.php">시간표 관리</a></li>
            </ul>
        <?php else: ?>
            <!-- 사용자 메뉴 -->
            <h2>학생 메뉴</h2>
            <ul>
                <li><a href="./view_notices.php">공지사항 보기</a></li>
                <li><a href="./view_timetable.php">시간표 보기</a></li>
            </ul>
        <?php endif; ?>

        <a href="./logout.php" class="logout-button">로그아웃</a>
    </div>
</body>
</html>
