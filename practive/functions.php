<?php
function db_connect() {
    $conn = new mysqli('localhost', 'root', '', 'school_portal');
    if ($conn->connect_error) {
        die("연결 실패 " . $conn->connect_error);
    }
    return $conn;
}

function get_posts($conn, $offset, $posts_per_page, $keyword = '%', $filter = 'title') {
    if ($filter === 'title') {
        $sql = "SELECT posts.id, posts.title, posts.content, posts.created_at, users.username
                FROM posts
                JOIN users ON posts.user_id = users.id
                WHERE posts.title LIKE ?
                ORDER BY posts.created_at DESC
                LIMIT ? OFFSET ?";
    } elseif ($filter === 'username') {
        $sql = "SELECT posts.id, posts.title, posts.content, posts.created_at, users.username
                FROM posts
                JOIN users ON posts.user_id = users.id
                WHERE users.username LIKE ?
                ORDER BY posts.created_at DESC
                LIMIT ? OFFSET ?";
    } else {
        // 기본 동작: 필터가 없으면 전체 게시물을 가져옴
        $sql = "SELECT posts.id, posts.title, posts.content, posts.created_at, users.username
                FROM posts
                JOIN users ON posts.user_id = users.id
                ORDER BY posts.created_at DESC
                LIMIT ? OFFSET ?";
    }

    $stmt = $conn->prepare($sql);

    if ($filter === 'title' || $filter === 'username') {
        $stmt->bind_param('sii', $keyword, $posts_per_page, $offset);
    } else {
        $stmt->bind_param('ii', $posts_per_page, $offset);
    }

    $stmt->execute();
    return $stmt->get_result();
}

function get_total_posts($conn, $keyword = '%', $filter = 'title') {
    if ($filter === 'title') {
        $sql = "SELECT COUNT(*) AS total FROM posts WHERE title LIKE ?";
    } elseif ($filter === 'username') {
        $sql = "SELECT COUNT(*) AS total
                FROM posts
                JOIN users ON posts.user_id = users.id
                WHERE users.username LIKE ?";
    } else {
        // 기본 동작: 필터가 없으면 전체 게시물 수를 계산
        $sql = "SELECT COUNT(*) AS total FROM posts";
    }

    $stmt = $conn->prepare($sql);

    if ($filter === 'title' || $filter === 'username') {
        $stmt->bind_param('s', $keyword);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc()['total'];
}
?>