<?php
session_start(); // 세션 시작

// MySQL 연결
$conn = new mysqli('localhost', 'root', '', 'school_portal');
if ($conn->connect_error) {
    die("DB 연결 실패:" . $conn->connect_error);
}

// POST 데이터 처리
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 입력값 가져오기
    $title = $_POST['title'];
    $content = $_POST['content'];

    // 세션에서 로그인된 사용자 ID 가져오기
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id']; // 로그인된 사용자 ID
    } else {
        die("로그인된 사용자만 게시물을 작성을 작성할 수 있습니다.");
    }

    // Prepared Statement를 사용한 안전한 쿼리
    $stmt = $conn->prepare("INSERT INTO posts (title, content, user_id) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $title, $content, $user_id);

    // 쿼리 실행 및 결과 확인
    if ($stmt->execute()) {
        echo "<script>
            alert('게시물 작성 완료!');
            window.location.href = 'posts.php';
        </script>";
        exit();
    } else {
        echo "게시물 작성 실패: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>