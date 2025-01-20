<?php
session_start();
require_once(dirname(__DIR__, 2) . '/includes/db.php');

// 로그인 확인
if (!isset($_SESSION['student_id'])) {
    header("Location: ../index.php");
    exit();
}

// 디버깅용: 세션 데이터 출력
var_dump($_SESSION);

// 학년 필터링
$target = isset($_SESSION['grade']) ? $_SESSION['grade'] : null; // 학년 정보 확인
if (!$target) {
    die("학년 정보가 없습니다. 관리자에게 문의하세요.");
}

// SQL 쿼리 준비
$query = $target === '전체'
    ? "SELECT * FROM notices ORDER BY created_at DESC"
    : "SELECT * FROM notices WHERE target = '전체' OR target = ? ORDER BY created_at DESC";

$stmt = $conn->prepare($query);
if (!$stmt) {
    die("SQL 준비 실패: " . $conn->error);
}

if ($target !== '전체') {
    $stmt->bind_param('s', $target);
}

if (!$stmt->execute()) {
    die("SQL 실행 실패: " . $stmt->error);
}

$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>공지사항</title>
    <link rel="stylesheet" href="../css/notices.css">
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
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['title']); ?></td>
                    <td><?php echo htmlspecialchars($row['target']); ?></td>
                    <td><?php echo $row['created_at']; ?></td>
                </tr>
                <?php endwhile; ?>

            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
