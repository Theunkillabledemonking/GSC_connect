<?php
$conn = new mysqli('localhost', 'root', '', 'school_portal');
if ($conn->connect_error) {
    die("DB 연결 실패: " . $conn->connect_error);
}

// GET 요청으로 삭제할 게시물 id 받기
if (isset($_GET['id'])) {
    $post_id = intval($_GET['id']); // 정수형으로 반환

    // DELETE 쿼리 실행
    $stmt = $conn->prepare("DELETE FROM posts WHERE id = ?");
    $stmt->bind_param("i", $post_id);

    if ($stmt->execute()) {
        echo "게시물이 성공적으로 삭제되었습니다.";
        echo "<br><a href='posts.php'>목록으로 돌아가기</a>";
    } else {
        echo "게시물 삭제에 실패했습니다.";
    }

    $stmt->close();
} else {
    echo "잘못된 요청입니다.";
}

$conn->close();
?>