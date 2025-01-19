<?php
session_start();
require_once(dirname(__DIR__, 2) . '/includes/db.php');

// 관리자 권한 확인
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("권한이 없습니다.");
}

// 공지사항 ID 확인
if (!isset($_GET['id'])) {
    die("잘못된 접근입니다.");
}

$id = intval($_GET['id']);

// 공지사항 데이터 가져오기
$query = "SELECT * FROM notices WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("공지사항을 찾을 수 없습니다.");
}

$notice = $result->fetch_assoc();
$stmt->close();

// 공지사항 수정 처리
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);

    $updateQuery = "UPDATE notices SET title = ?, content = ? WHERE id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param('ssi', $title, $content, $id);

    if ($stmt->execute()) {
        echo "<script>alert('공지사항이 성공적으로 수정되었습니다.'); window.location.href='./notices.php';</script>";
    } else {
        echo "<script>alert('공지사항 수정에 실패했습니다.');</script>";
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>공지사항 수정</title>
</head>
<body>
    <h1>공지사항 수정</h1>
    <form action="./edit_notice.php?id=<?php echo $id; ?>" method="POST">
        <label for="title">제목:</label><br>
        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($notice['title']); ?>" required><br><br>
        <label for="content">내용:</label><br>
        <textarea id="content" name="content" rows="5" required><?php echo htmlspecialchars($notice['content']); ?></textarea><br><br>
        <button type="submit">수정</button>
    </form>
    <a href="./notices.php">목록으로 돌아가기</a>
</body>
</html>
