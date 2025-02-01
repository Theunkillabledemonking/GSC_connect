<?php
session_start(); // 세션 시작
require 'auth.php';

// MySQL 연결
$conn = new mysqli('localhost', 'root', '', 'school_portal');
if ($conn->connect_error) {
    die("DB 연결 실패: " . $conn->connect_error);
}

// 현재 로그인한 사용자 정보 가져오기
$role = $_SESSION['role'] ?? '';
$user_id = $_SESSION['user_id'] ?? '';

// GET 요청으로 게시물 ID 받기
if (isset($_GET['id'])){
    $post_id = intval($_GET['id']); // ID를 정수형으로 변환하여 안전하게 처리

    // 게시물 조회 쿼리
    $stmt = $conn->prepare("SELECT posts.title, posts.content, posts.created_at, posts.user_id, users.username
                            FROM posts
                            JOIN users ON posts.user_id = user_id
                            WHERE posts.id = ?");
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($title, $content, $created_at, $post_user_id, $username);

    if ($stmt->fetch()) {
        // 게시물 데이터 출력
        echo "<h1>" . htmlspecialchars($title) . "<h1>";
        echo "<p>작성자: " . htmlspecialchars($username) . "</p>";
        echo "<p>작성일: " . $created_at . "</p>";
        echo "<hr>";
        echo "<p>" . nl2br(htmlspecialchars($content)) . "</p>";

        // 수정 버튼 (관리자: 모든 글 수정 가능 / 교수: 자기 글만 수정 가능)
        if ($role === 'admin' || ($role === 'professor' && $user_id === $post_user_id)) {
            echo "<p><a href='edit_post.php?id=$post_id'>수정하기</a></p>";
        }
        echo "<p><a href='posts.php?id=$post_id'>돌아가기</a></p>";

        // 이전 게시물 조회
        $prev_stmt = $conn->prepare("SELECT id FROM posts WHERE id < ? ORDER BY id DESC LIMIT 1");
        $prev_stmt->bind_param("i", $post_id);
        $prev_stmt->execute();
        $prev_stmt->bind_result($prev_id);
        $prev_link = $prev_stmt->fetch() ? "<a href='post_detail.php?id=$prev_id'>이전 게시물</a>" : "이전 게시물이 없습니다.";
        $prev_stmt->close();

        // 다음 게시물 조회
        $next_stmt = $conn->prepare("SELECT id FROM posts WHERE id > ? ORDER BY id ASC LIMIT 1");
        $next_stmt->bind_param("i", $post_id);
        $next_stmt->execute();
        $next_stmt->bind_result($prev_id);
        $next_link = $next_stmt->fetch() ? "<a href='post_detail.php?id=$prev_id'>다음 게시물</a>" : "다음 게시물이 없습니다.";
        $next_stmt->close();

        // 이전/다음 게시물 링크 출력
        echo "<hr>";
        echo "<div>$prev_link | $next_link</div>";

    } else {
        echo "<p>게시물을 찾을 수 없습니다.</p>";
    }
    $stmt->close();
} else {
    echo "<p>잘못된 접근입니다</p>";
}

$conn->close();
?>