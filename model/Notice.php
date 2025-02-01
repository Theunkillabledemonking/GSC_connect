<?php
require_once '../config/config.php';

class Notice {
    // 공지사항 작성
    public static function create($title, $content, $author_id) {
        $conn = connect_db();

        $sql = "INSERT INTO notices (title, content, author_id) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $title, $content, $author_id);

        if ($stmt->execute()) {
            $stmt->close();
            $conn->close();
            return true; // 작성 성공
        } else {
            $stmt->close();
            $conn->close();
            return false; // 작성 실패
        }
    }

    // 공지사항 수정
    public static function update($notice_id, $title, $content, $author_id) {
        $conn = connect_db();

        $sql =  "UPDATE notices SET title = ?, content = ?, AND author_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssii", $title, $content, $notice_id, $author_id);

        if ($stmt->execute()) {
            $stmt->close();
            $conn->close();
            return true; // 수정 성공
        } else {
            $stmt->close();
            $conn->close();
            return false; // 수정 실패
        }
    }

    // 공지사항 삭제
    public static function delete($notice_id) {
        $conn = connect_db();

        $sql = "DELETE FROM notices WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $notice_id);

        if ($stmt->execute()) {
            $stmt->close();
            $conn->close();
            return true; // 삭제 성공
        } else {
            $stmt->close();
            $conn->close();
            return false; // 삭제 실패
        }
    }

    // 공지사항 작성자 id 가져오기기
    public static function getAuthorID($notice_id) {
        $conn = connect_db();

        $sql = "SELECT author_id FROM notices WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $notice_id);
        $stmt->execute();
        $stmt->bind_result($author_id);
        $stmt->fetch();

        $stmt->close();
        $conn->close();
        return $author_id;
    }

    // 공지사항 목록 조회
    public static function getAll() {
        $conn = connect_db();

        $sql = "SELECT id, title, content, author_id, created_at FROM notices";
        $result = $conn->query($sql);

        $notices = [];
        while ($row = $result->fetch_assoc()) {
            $notices[] = $row;
        }

        $conn->close();
        return $notices; // 공지사항 목록 반환
    }
}
?>