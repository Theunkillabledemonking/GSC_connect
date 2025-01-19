<?php
require_once(dirname(__DIR__, 2) . '/includes/db.php');

if (!isset($_GET['id'])) {
    die("잘못된 접근입니다.");
}

$id = intval($_GET['id']);
$query = "SELECT * FROM notices WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("공지사항을 찾을 수 없습니다.");
}

$notice = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($notice['title']); ?></title>
    <link rel="stylesheet" href="./css/notices.css">
</head>
<body>
    <div class="container">
        <h1><?php echo htmlspecialchars($notice['title']); ?></h1>
        <p>작성자: <?php echo htmlspecialchars($notice['writer']); ?></p>
        <p>대상: <?php echo htmlspecialchars($notice['target']); ?></p>
        <p>작성일: <?php echo $notice['created_at']; ?></p>
        <div class="content">
            <?php echo nl2br(htmlspecialchars($notice['content'])); ?>
        </div>
        <a href="notices.php" class="btn">돌아가기</a>
    </div>
</body>
</html>
