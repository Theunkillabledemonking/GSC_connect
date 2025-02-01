<?php
require 'functions.php';

session_start(); // 세션 시작

// 로그인 상태 확인
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('로그인이 필요합니다.');</script>";
    header("Refresh: 3; url=login.php"); // 3초 후 로그인 페이지로 리다이렉트
    exit();
}

// DB 연결
$conn = db_connect();

// 검색 조건 설정
$keyword = '%' . ($_GET['keyword'] ?? '') . '%';
$filter = $_GET['filter'] ?? 'title';

// 페이지네이션 계산
$posts_per_page = 5; // 한 페이지에 표시할 게시물 수
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $posts_per_page;

// 게시물 가져오기 (검색 조건 및 페이징 적용)
$posts = get_posts($conn, $offset, $posts_per_page, $keyword, $filter);

// 전체 게시물 수 가져오기 (검색 조건 적용)
$total_posts = get_total_posts($conn, $keyword, $filter);
$total_pages = ceil($total_posts / $posts_per_page);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시물 목록</title>
</head>
<body>
    <h1>게시물 목록</h1>

    <!-- 로그아웃 링크 -->
    <p><a href="logout.php" onclick="return confirm('로그아웃 하시겠습니까?');">Logout</a></p>

    <!-- 게시물 테이블 -->
    <table>
        <thead>
            <tr>
                <th>번호</th>
                <th>제목</th>
                <th>작성자</th>
                <th>작성일</th>
                <th>삭제</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($posts->num_rows > 0) : ?>
                <?php $number = $offset + 1; ?>
                <?php while ($row = $posts->fetch_assoc()) : ?>
                    <tr>
                        <td><?= $number++ ?></td>
                        <td><a href="post_detail.php?id=<?= $row['id'] ?>"><?= htmlspecialchars($row['title']) ?></a></td>
                        <td><?= htmlspecialchars($row['username']) ?></td>
                        <td><?= $row['created_at'] ?></td>
                        <td><a href="delete_post.php?id=<?= $row['id'] ?>" onclick="return confirm('정말 삭제하시겠습니까?')">삭제</a></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="5">게시물이 없습니다.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- 검색 -->
    <form action="list.php" method="GET">
        <input type="text" name="keyword" placeholder="검색어를 입력해주세요" 
               value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>">
        <select name="filter">
            <option value="title" <?= ($_GET['filter'] ?? '') === 'title' ? 'selected' : '' ?>>제목</option>
            <option value="username" <?= ($_GET['filter'] ?? '') === 'username' ? 'selected' : '' ?>>작성자</option>
        </select>
        <button type="submit">검색</button>
    </form>

    <!-- 페이지네이션 -->
    <div class="pagination">
        <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
            <?php if ($i == $page): ?>
                <strong><?= $i ?></strong>
            <?php else: ?>
                <a href="list.php?page=<?= $i ?>&keyword=<?= urlencode($_GET['keyword'] ?? '') ?>&filter=<?= urlencode($_GET['filter'] ?? 'title') ?>"><?= $i ?></a>
            <?php endif; ?>
        <?php endfor; ?>
    </div>

    <p><a href="create_posts.html">글쓰기</a></p>
</body>
</html>

<?php $conn->close(); ?>
