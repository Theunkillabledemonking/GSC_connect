<?php

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
?>