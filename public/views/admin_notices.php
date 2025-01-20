<?php
session_start();
require_once(dirname(__DIR__, 2) . '/includes/db.php');

// 관리자 권한 확인
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("권한이 없습니다.");
}

// 공지사항 목록 가져오기
$query = "SELECT * FROM posts ORDER BY created_at DESC";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>공지사항 관리</title>
    <script>
        function confirmDelete() {
            return confirm('선택한 공지사항을 삭제하시겠습니까?');
        }
    </script>
</head>
<body>
    <h1>공지사항 관리</h1>
    <form method="post" action="./admin_delete_notice.php" onsubmit="return confirmDelete();">
        <table>
            <thead>
                <tr>
                    <th>선택</th>
                    <th>번호</th>
                    <th>제목</th>
                    <th>대상</th>
                    <th>작성일</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><input type="checkbox" name="delete_ids[]" value="<?php echo $row['id']; ?>"></td>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['title']); ?></td>
                    <td><?php echo htmlspecialchars($row['target']); ?></td>
                    <td><?php echo $row['created_at']; ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <button type="submit">삭제하기</button>
    </form>
    <button onclick="window.location.href='./admin_write_notice.php';">공지사항 작성</button>
</body>
</html>
