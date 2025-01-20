<?php
session_start();
require_once(dirname(__DIR__, 3) . '/includes/db.php');

// 관리자 권한 확인
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("권한이 없습니다.");
}

if (!isset($_GET['id'])) {
    die("잘못된 접근입니다.");
}

$id = intval($_GET['id']);
$query = "SELECT * FROM notices WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$notice = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $target = $_POST['target'];

    $update_query = "UPDATE notices SET title = ?, content = ?, target = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param('sssi', $title, $content, $target, $id);

    if ($update_stmt->execute()) {
        echo "<script>alert('공지사항이 성공적으로 수정되었습니다.'); window.location.href='./admin_notices.php';</script>";
    } else {
        echo "<script>alert('공지사항 수정에 실패했습니다.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>공지사항 수정</title>
</head>
<body>
    <h1>공지사항 수정</h1>
    <form method="post" action="">
        <label for="title">제목:</label>
        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($notice['title']); ?>" required>
        <label for="target">대상:</label>
        <select id="target" name="target">
            <option value="전체" <?php if ($notice['target'] === '전체') echo 'selected'; ?>>전체</option>
            <option value="1학년" <?php if ($notice['target'] === '1학년') echo 'selected'; ?>>1학년</option>
            <option value="2학년" <?php if ($notice['target'] === '2학년') echo 'selected'; ?>>2학년</option>
            <option value="3학년" <?php if ($notice['target'] === '3학년') echo 'selected'; ?>>3학년</option>
        </select>
        <label for="content">내용:</label>
        <textarea id="content" name="content" required><?php echo htmlspecialchars($notice['content']); ?></textarea>
        <button type="submit">수정하기</button>
    </form>
    <button onclick="window.location.href='./admin_notices.php';">목록으로 돌아가기</button>
</body>
</html>
