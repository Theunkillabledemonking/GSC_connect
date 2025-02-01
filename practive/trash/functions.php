<?php
/**
 * 데이터베이스 연결 함수
 * 
 * @return mysqli 연결된 데이터베이스 객체를 반환홥니다.
 */
function db_connect() {
    $conn = new mysqli('localhost', 'root', '', 'school_portal');
    if ($conn->connect_error) {
        die("연결 실패 " . $conn->connect_error);
    }
    return $conn;
}

/**
 * 모든 게시물을 가져오는 함수
 * 
 * @param mysqli $conn DB 연결 객체
 * @param int $offset 페이지네이션 오프셋
 * @param int $posts_per_page 한 페이지당 게시물 수
 * @param string $keyword 검색 키워드 (기본값: 'title')
 * @param string $filter 검색 필터 (기본값: 'title')
 *  @return mysql_result 게시물 목록을 반환
 */
function get_posts($conn, $offset, $posts_per_page, $keyword = '%', $filter = 'title') {
    // 기본 SQL 쿼리 (모든 게시물 조회)
    $base_sql = "SELECT posts.id, posts.title, posts.content, posts.created_at, posts.user_id, users.username
                 FROM posts
                 JOIN users ON posts.user_id = users.id";
    
    // 검색 필터 적용 (제목 또는 작성자 기준)
    if ($filter === 'title') {
        $where_sql = "WHERE posts.title LIKE ?";
    } elseif ($filter === 'username') {
        $where_sql = "WHERE users.username LIKE ?";
    } else {
        $where_sql = ""; // 필터가 없으면 조건 없음
    }

    // 최종 SQL 쿼리 (게시물 정렬 및 페이지네이션 적용)
    $sql = "$base_sql $where_sql ORDER BY posts.created_at DESC LIMIT ? OFFSET ?";

    // 쿼리 준비
    $stmt = $conn->prepare($sql);

    // 필터가 적용된 경우와 아닌 경우에 따라 바인딩 파라미터 설정
    if ($filter === 'title' || $filter === 'username') {
        $stmt->bind_param('sii', $keyword, $posts_per_page, $offset);
    } else {
        $stmt->bind_param('ii', $posts_per_page, $offset);
    }

    // 쿼리 실행
    $stmt->execute();
    return $stmt->get_result();
}

/**
 * 게시물을 삭제하는 함수 (교수 본인만 삭제 가능, 관리자는 전부 삭제 가능)
 * 
 * @param mysqli $conn DB 연결 객체
 * @param int $post_id 삭제할 게시물 ID
 * @param int $user_id 현재 로그인한 사용자 ID
 * @param string $role 현재 로그인한 사용자의 역할
 * @return bool 삭제 성공 여부
 */
function delete_post($conn, $post_id, $user_id, $role) {
    if ($role === 'admin') {
        // 관리자는 모든 게시물 삭제 가능
        $sql = "DELETE FROM posts WHERE id = ?";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param('i', $post_id);
    } elseif ($role === 'professor') {
        // 교수는 본인이 작성한 게시물만 삭제 가능
        $sql = "DELETE FROM posts WHERE id = ? AND user_id = ?";
        $stmt = $conn->prepare($sql);

        // SQL 준비에 실패하면 false 반환
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param('ii', $post_id, $user_id);
    } else {
        // 학생은 삭제 불가
        return false;
    }

    return $stmt->execute();
}

// 전체 공용
function get_total_posts($conn, $keyword = '%', $filter = 'title') {
    $base_sql = "SELECT COUNT(*) AS total FROM posts";
    
    if ($filter === 'title') {
        $where_sql = " WHERE title LIKE ?";
    } elseif ($filter === 'username') {
        $where_sql = " JOIN users ON posts.user_id = users.id WHERE users.username LIKE ?";
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