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
                <p><?php echo mb_strimwidth(htmlspecialchars($row['content']), 0, 100, '...'); ?></p>
                <small>작성일: <?php echo $row['created_at']; ?></small>

                <!-- 관리자만 수정 및 삭제 버튼 표시 -->
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <form action="./edit_notice.php?id=<?php echo $row['id']; ?>" method="GET" style="display:inline;">
                        <button type="submit">수정</button>
                    </form>
                    <form action="./delete_notice.php" method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <button type="submit" onclick="return confirm('정말 삭제하시겠습니까?');">삭제</button>
                    </form>
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
