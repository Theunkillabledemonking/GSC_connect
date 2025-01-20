<?php
session_start();
require_once(dirname(__DIR__, 2) . '/includes/db.php');

// 로그인 확인
if (!isset($_SESSION['student_id'])) {
    header("Location: ../index.php");
    exit();
}

// 학년에 따른 필터링
$target = $_SESSION['grade']; // 유저 학년 정보
$query = $target === '전체' 
    ? "SELECT * FROM notices ORDER BY created_at DESC"
    : "SELECT * FROM notices WHERE target = '전체' OR target = ? ORDER BY created_at DESC";

$stmt = $conn->prepare($query);
if ($target !== '전체') {
    $stmt->bind_param('s', $target);
}
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>공지사항</title>
    <scri
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>번호</th>
                <th>제목</th>
                <th>대상</th>
                <th>작성일</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['title']); ?></td>
                <td><?php echo htmlspecialchars($row['target']); ?></td>
                <td><?php echo $row['created_at']; ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
