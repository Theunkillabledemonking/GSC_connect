<?php
function db_connect() {
    $conn = new mysqli('localhost', 'root', '', 'school_portal');
    if ($conn->connect_error) {
        die("연결 실패 " . $conn->connect_error);
    }
    return $conn;
}

function get_posts($conn, $offset, $posts_per_page, $keyword = '%', $filter = 'title') {
    $base_sql = "SELECT posts.id, posts.title, posts.content, posts.created_at, users.username
                 FROM posts
                 JOIN users ON posts.user_id = users.id";
    
    if ($filter === 'title') {
        $where_sql = "WHERE posts.title LIKE ?";
    } elseif ($filter === 'username') {
        $where_sql = "WHERE users.username LIKE ?";
    } else {
        $where_sql = ""; // 필터가 없으면 조건 없음
    }

    $sql = "$base_sql $where_sql ORDER BY posts.created_at DESC LIMIT ? OFFSET ?";

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
    $base_sql = "SELECT COUNT(*) AS total FROM posts";
    
    if ($filter === 'title') {
        $where_sql = "WHERE title LIKE ?";
    } elseif ($filter === 'username') {
        $where_sql = "JOIN users ON posts.user_id = users.id WHERE users.username LIKE ?";
    } else {
        $where_sql = ""; // 필터가 없으면 조건 없음
    }
    
    $sql = "$base_sql $where_sql";
    $stmt = $conn->prepare($sql);

    if ($filter === 'title' || $filter === 'username') {
        $stmt->bind_param('s', $keyword);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc()['total'];
}
?>