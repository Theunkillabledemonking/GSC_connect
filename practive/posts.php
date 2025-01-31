<?php
session_start();
require 'auth.php';
require 'functions.php';

// DB 연결
$conn = db_connect();

// 디버깅 코드 추가
echo "<pre>";
print_r($_SESSION); // 세션 배열 전체를 출력
echo "</pre>";
echo "<pre>";
echo "Session user_id: " . ($_SESSION['user_id'] ?? 'Not Set') . "\n";
echo "Session role: " . ($_SESSION['role'] ?? 'Not Set') . "\n";
echo "</pre>";

// session_start (); // 세션 시작
$role = $_SESSION['role'] ?? ''; // 사용자 역할 확인
$user_id = $_SESSION['user_id'] ?? ''; // 사용자 id 확인

// 로그인 상태 확인
authenticate_user($conn); // 세션 또는 쿠키를 통해 인증 확인

// 검색 조건 설정
$keyword = '%' . ($_GET['keyword'] ?? '') . '%';
$filter = $_GET['filter'] ?? 'title';

// 페이지네이션 계산
$posts_per_page = 5; // 한 페이지에 표시할 게시물 수
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $posts_per_page;

// 게시물 가져오기 (권한별로 조건 설정)
if ($role === 'admin') {
    // 관리자: 모든 게시물 조회
    $posts = get_posts($conn, $offset, $posts_per_page, $keyword, $filter); // 관리자: 모든 게시물
} else {
    $posts = get_posts($conn, $offset, $posts_per_page, $keyword, $filter);  // 교수 & 학생 : 교수들의 게시물
}

// 전체 게시물 수 가져오기 (권한별로 조건 적용)
if ($role === 'admin') {
    $total_posts = get_total_posts($conn, $keyword, $filter);
} else {
    $total_posts = get_total_posts($conn, $keyword, $filter);
}

// 전체 페이지 나누기
$total_pages = ceil($total_posts / $posts_per_page);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>게시물 목록</h1>
    
    <!-- 로그아웃 링크 -->
    <p><a href="logout.php" onclick="return confirm('로그아웃 하시겠습니까?');">Logout</a></p>
    <table>

        <thead>
            <tr>
                <th>번호</th>
                <th>제목</th>
                <th>작성자</th>
                <th>작성일</th>
                <?php if ($role === 'admin' || $role === 'professor'): ?>
                    <th>삭제</th>
                <?php endif; ?>
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
                        <?php if ($role === 'admin' || ($role === 'professor' && $row['user_id'] == $_SESSION['user_id'])) : ?>
                            <td><a href="delete_post.php?id=<?= $row['id'] ?>" onclick="return confirm('정말 삭제하시겠습니까?')">삭제</a></td>
                        <?php else: ?>
                            <td></td> <!-- 빈 칸 -->
                        <?php endif; ?>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="5">게시물이 없습니다.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
    
    <!-- 검색 -->
    <form action="" method="GET">
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
                <a href="posts.php?page=<?= $i ?>&keyword=<?= urlencode($_GET['keyword'] ?? '') ?>&filter=<?= urlencode($_GET['filter'] ?? 'title') ?>"><?= $i ?></a>
            <?php endif; ?>
        <?php endfor; ?>
    </div>
    
    <!-- 글쓰기 버튼 -->
    <?php if ($role === 'admin' || $role === 'professor'): ?>
        <p><a href='create_posts.html'>글쓰기</a></p>
    <?php endif; ?>
</body>
</html>
<?php $conn->close(); ?>