<?php
session_start();
require_once(dirname(__DIR__, 2) . '/includes/db.php');

// 공지사항 데이터 가져오기
$query = "SELECT * FROM notices ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>공지사항</title>
</head>
<body>
    <h1>공지사항</h1>
    <ul>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <li>
                <strong><?php echo htmlspecialchars($row['title']); ?></strong>
                <p><?php echo htmlspecialchars($row['content']); ?></p>
                <small><?php echo $row['created_at']; ?></small>

                <!-- 관리자만 수정 및 삭제 버튼 표시 -->
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <a href="./edit_notice.php?id=<?php echo $row['id']; ?>">수정</a>
                    <a href="./delete_notice.php?id=<?php echo $row['id']; ?>" onclick="return confirm('정말 삭제하시겠습니까?');">삭제</a>
                <?php endif; ?>
            </li>
        <?php endwhile; ?>
    </ul>

    <!-- 관리자만 공지사항 추가 버튼 표시 -->
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
        <a href="./add_notice.php">공지사항 추가</a>
    <?php endif; ?>
</body>
</html>
// 관리자 권한 확인
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("권한이 없습니다.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $writer = $_SESSION['name']; // 세션에서 작성자 이름 가져오기
    $target = $_POST['target'];
    $content = $_POST['content'];

    $query = "INSERT INTO notices (title, writer, target, content) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssss', $title, $writer, $target, $content);

    if ($stmt->execute()) {
        echo "<script>alert('공지사항이 작성되었습니다.'); window.location.href='notices.php';</script>";
    } else {
        echo "<script>alert('작성에 실패했습니다.');</script>";
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>공지사항 작성</title>
    <link rel="stylesheet" href="./css/notices.css">
</head>
<body>
    <div class="container">
        <h1>공지사항 작성</h1>
        <form method="POST" action="">
            <label for="title">제목:</label>
            <input type="text" id="title" name="title" required><br><br>

            <label for="target">대상:</label>
            <select id="target" name="target" required>
                <option value="전체">전체</option>
                <option value="학생">학생</option>
                <option value="교수">교수</option>
            </select><br><br>

            <label for="content">내용:</label>
            <textarea id="content" name="content" rows="5" required></textarea><br><br>

            <button type="submit" class="btn">완료</button>
            <a href="notices.php" class="btn">돌아가기</a>
        </form>
    </div>
</body>
</html>