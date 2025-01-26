<?php 
require 'functions.php';

session_start(); // 세션시작, 반드시 상단 위치

// 로그인 상태 확인
if (!isset($_SESSION['user_id'])) {
    // 경고 메세지 출력 및 리다이렉트
    echo "<script>alert('로그인이 필요합니다.');</script>";
    header("Refresh: 3; url=login.php");
    exit();
}

$posts_per_page = 5;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $posts_per_page;

// db 연결
$conn = db_connect();

// 검색 조건
$keyword = isset($_GET['keyword']) ? '%' . $_GET['keyword'] . '%' : '%';
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'title';

// SQL 쿼리 작성
if ($filter === 'title') {
    $query = "SELECT posts.id, posts.title, posts.content, posts.created_at, users.username
              FROM posts
              JOIN users ON posts.user_id = users.id
              WHERE posts.title LIKE ?
              ORDER BY posts.created_at DESC";
} elseif ($filter === 'username') {
    $query = "SELECT posts.id, posts.title, posts.content, posts.created_at, users.username
              FROM posts
              JOIN users ON posts.user_id = users.id
              WHERE users.username LIKE ?
              ORDER BY posts.created_at DESC";
}

// Prepared Statement 실행
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $keyword);
$stmt->execute();
$result = $stmt->get_result();
?>

<!-- 검색 결과 출력 -->
<table>
    <thead>
        <tr>
            <th>번호</th>
            <th>제목</th>
            <th>작성자</th>
            <th>작성일</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><a href="view.php?id=<?= $row['id'] ?>"><?= htmlspecialchars($row['title']) ?></td>
                    <td><?= htmlspecialchars($row['username']) ?></td>
                    <td><?= $row['created_at'] ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="4">검색 결과가 없습니다.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?php
$stmt->close();
$conn->close();
?>
