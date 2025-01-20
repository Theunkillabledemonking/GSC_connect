<?php
session_start();
require_once(dirname(__DIR__, 2) . '/includes/db.php');

// 로그인 검증 (관리자 권한 확인)
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("권한이 없습니다.");
}

$query = "SELECT * FROM notices ORDER BY created_at DESC";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>공지사항 관리</title>
</head>
<body>
    <form method="post" action="admin_delete_notice.php">
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
</body>
</html>
