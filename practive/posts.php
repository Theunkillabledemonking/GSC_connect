<?php
//MySQL 연결
$conn = new mysqli('localhost', 'root', '', 'school_portal');
if ($conn->connect_error) {
    die("DB연결 실패: ". $conn->connect_error);
}

// 페이지 번호 계산
$posts_per_page = 5; // 한 페이지에 표시할 게시물 수
$page = isset($_GET['page']) ? intval($_GET['page']) : 1; // 현재 페이지
$offset = ($page - 1) * $posts_per_page;

// 게시물 조회 쿼리 생성
$sql = "SELECT posts.id, posts.title, posts.content, posts.created_at, users.username FROM posts
        JOIN users ON posts.user_id = users.id
        ORDER BY posts.created_at DESC
        LIMIT ? OFFSET ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $posts_per_page, $offset);
$stmt->execute();
$result = $stmt->get_result();

// 전체 게시물 수 조회
$total_posts_result = $conn->query("SELECT COUNT(*) AS total FROM posts");
$total_posts = $total_posts_result->fetch_assoc()['total'];
$total_pages = ceil($total_posts / $posts_per_page);

// html 출력 시작
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
    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>번호</th>
                <th>제목</th>
                <th>작성자</th>
                <th>날짜</th>
            </tr>
        </thead>
        <tbody>
        <?php
        if ($result->num_rows > 0) {
            $number = 1; // 목록 번호
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $number++ . "</td>"; //번호
                echo "<td><a href='post_detail.php?id=" . $row['id'] . 
                "'>" . htmlspecialchars($row['title']) . "</a></td>"; // 제목 클릭 시 상세보기
                echo "<td>" . htmlspecialchars($row['username']) . "</td>"; // 작성자
                echo "<td>" . $row['created_at'] . "<td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>게시물이 없습니다.</td></tr>";
        }
        ?>
        </tbody>
    </table>

    <!-- 페이지네이션 -->
    <div>
        <?php
        for ($i = 1; $i <= $total_pages; $i++) {
            if ($i == $page) {
                echo "<strong>$i</strong>"; // 현재 페이지는 굵게 표시
            } else {
                echo "<a href='posts.php?page=$i'>$i</a>";
            }
        }
        ?>
    </div>
</body>
</html>
<?php $conn->close(); ?>