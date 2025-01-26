<?php
$conn = new mysqli('localhost', 'root', '', 'school_portal');
if ($conn->connect_error) {
    die("DB 연결 실패: " . $conn->connect_error);
}

// GET 요청으로 게시물 ID 받기
if (isset($_GET['id'])) {
    $post_id = intval($_GET['id']); 

    // 게시물 데이터 조회
    $stmt = $conn->prepare("SELECT title, contetnt FROM posts WHERE id = ?");
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $stmt->bind_result($title, $content);

    if ($stmt->fetch()) {
        // 데이터가 있으면 수정 폼 출력
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>게시물 수정</title>
        </head>
        <body>
            <h1>게시물 수정</h1>
            <form action="edit_post.php" method="post">
            <input type="hidden" name="id" value="<?= htmlspecialchars($post_id) ?>">
                <label for="title">제목:</label>
                <input type="text" id="title" name="title" value="<?= htmlspecialchars($title) ?>" required><br><br>
                <label for="content">내용:</label><br>
                <textarea id="content" name="content" rows="10" cols="50" required><?= htmlspecialchars($content) ?></textarea><br><br>
                <button type="submit">수정하기</button>
            </form>
            
        </body>
        </html>
        <?php
    } else {
        echo "게시물을 찾을 수 없습니다.";
    }
    $stmt->close();
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // post 요청으로 수정 데이터 받기
    $post_id = intval($_POST['id']);
    $title = $_POST['title'];
    $content = $_POST['content'];

    // 데이터베이스 업데이트
    $stmt = $conn->prepare("UPDATE posts SET title = ?, content = ?, WHERE id = ?");
    $stmt->bind_param("ssi", $title, $content, $post_id);

    if ($stmt->execute()) {
        echo "게시물이 성공적으로 수정되었습니다";
        echo "<a href='posts.php'>목록으로 돌아가기</a>";
    } else {
        echo "수정에 실패했습니다.";
    }
    $stmt->clone();
}

$conn->close();
?>