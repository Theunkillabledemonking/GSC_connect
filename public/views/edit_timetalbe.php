<?php
session_start();
require_once('./includes/db.php');

// 관리자 권한 확인
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("권한이 없습니다.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $subject_name = $_POST['subject_name'];
    $professor_name = $_POST['professor_name'];

    $query = "UPDATE timetable SET subject_name = ?, professor_name = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssi', $subject_name, $professor_name, $id);

    if ($stmt->execute()) {
        echo "<script>alert('시간표가 수정되었습니다.'); window.location.href='./view_timetable.php';</script>";
    } else {
        echo "<script>alert('수정에 실패했습니다.');</script>";
    }
    $stmt->close();
}
?>
