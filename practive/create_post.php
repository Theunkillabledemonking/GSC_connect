<?php
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
    $user_id = 1; // 예; 로그인된 사용자 ID (세션에서 가져온다고 가정)

    // Prepared Statement를 사용한 안전한 쿼리
    $stmt = $conn->prepare("INSERT INTO posts (title, content, user_id) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $title, $content, $user_id);

    // 쿼리 실행 및 결과 확인
    if ($stmt->execute()) {
        echo "게시물이 성공적으로 작성되었습니다.";
    } else {
        echo "게시물 작성 실패: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>