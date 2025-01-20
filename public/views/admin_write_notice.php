<?php
session_start();
require_once(dirname(__DIR__, 2) . '/includes/db.php');

// 관리자 권한 확인
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("권한이 없습니다.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $writer = $_SESSION['name']; // 세션에서 관리자 이름 가져오기
    $content = $_POST['content'];
    $target = $_POST['target'];

    // 공지사항 작성 쿼리
    $query = "INSERT INTO notices (title, writer, content, target) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssss', $title, $writer, $content, $target);

    if ($stmt->execute()) {
        echo "<script>alert('공지사항이 성공적으로 작성되었습니다.'); window.location.href='./admin_notices.php';</script>";
    } else {
        echo "<script>alert('공지사항 작성에 실패했습니다.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>공지사항 작성</title>
</head>
<body>
    <h1>공지사항 작성</h1>
    <form method="post" action="./admin_write_notice.php">
        <label for="title">제목:</label>
        <input type="text" id="title" name="title" required>
        <label for="target">대상:</label>
        <select id="target" name="target" required>
            <option value="전체">전체</option>
            <option value="1학년">1학년</option>
            <option value="2학년">2학년</option>
            <option value="3학년">3학년</option>
        </select>
        <label for="content">내용:</label>
        <textarea id="content" name="content" required></textarea>
        <button type="submit">작성하기</button>
    </form>
    <button onclick="window.location.href='./admin_notices.php';">목록으로 돌아가기</button>
</body>
</html>
