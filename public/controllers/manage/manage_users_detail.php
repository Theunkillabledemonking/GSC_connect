<?php
session_start();
require_once(dirname(__DIR__, 3) . '/includes/db.php');

// 관리자 권한 확인
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../views/error.php?msg=Unauthorized");
    exit;
}

// 수정/삭제 로직 (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $student_id = strip_tags($_POST['student_id'] ?? '');

    if (empty($student_id)) {
        die("잘못된 접근입니다. student_id가 없습니다.");
    }

    if ($action === 'delete') {
        // 사용자 삭제
        $query = "DELETE FROM users WHERE student_id = ?";
        $stmt  = $conn->prepare($query);
        $stmt->bind_param("s", $student_id);
        $stmt->execute();
        $stmt->close();

        // 삭제 후 목록 페이지로 이동
        header("Location: ../views/manage_users.html?msg=deleted");
        exit;
    } 
    elseif ($action === 'update') {
        // 사용자 정보 업데이트
        $new_student_id = strip_tags($_POST['new_student_id'] ?? '');
        $name           = strip_tags($_POST['name'] ?? '');
        $phone          = strip_tags($_POST['phone'] ?? '');
        $grade          = strip_tags($_POST['grade'] ?? '');
        $password       = $_POST['password'] ?? ''; // 평문이므로 주의

        if (!empty($password)) {
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $query = "UPDATE users 
                      SET student_id = ?, name = ?, phone = ?, grade = ?, password = ?
                      WHERE student_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssssss", 
                $new_student_id, $name, $phone, $grade, $hashed_password, $student_id
            );
        } else {
            // 비밀번호 변경이 없을 경우
            $query = "UPDATE users 
                      SET student_id = ?, name = ?, phone = ?, grade = ?
                      WHERE student_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sssss", 
                $new_student_id, $name, $phone, $grade, $student_id
            );
        }

        $stmt->execute();
        $stmt->close();

        // 수정 후 상세 페이지 재이동
        header("Location: ../views/manage_user_detail.html?student_id={$new_student_id}&msg=updated");
        exit;
    }
    else {
        die("유효하지 않은 작업입니다.");
    }
}

// GET: 상세 조회
if (!isset($_GET['student_id'])) {
    die("잘못된 접근입니다. student_id가 없습니다.");
}
$student_id = strip_tags($_GET['student_id']);

$query = "SELECT * FROM users WHERE student_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $student_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if (!$user) {
    mysqli_close($conn);
    die("존재하지 않는 사용자입니다.");
}

// JSON으로 사용자 정보 전송 (JS가 fetch로 가져감)
header('Content-Type: application/json');
echo json_encode($user);

mysqli_close($conn);
