<?php
session_start();
// 데이터베이스 연결
require_once(dirname(__DIR__, 3) . '/includes/db.php');

// 관리자 권한 확인
if ($_SESSION['role'] !== 'admin') {
    header("Location: ./main.php");
    exit;
}

// POST 요청 처리 (승인/거부)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = strip_tags($_POST['student_id']);
    $action = $_POST['action']; // approve 또는 reject

    if ($action === 'approve') {
        $query = "UPDATE users SET is_approved = 'approved' WHERE student_id = ?";
    } elseif ($action === 'reject') {
        $query = "DELETE FROM users WHERE student_id = ?";
    } else {
        die("유효하지 않은 작업입니다.");
    }

    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $student_id);

    if ($stmt->execute()) {
        $message = ($action === 'approve') ? "사용자가 승인되었습니다." : "사용자가 삭제되었습니다.";
        echo "<script>alert('$message'); window.location.href='./manage_users.php';</script>";
    } else {
        echo "<script>alert('작업에 실패했습니다. 다시 시도해주세요.'); window.location.href='./manage_users.php';</script>";
    }

    $stmt->close();
    mysqli_close($conn);
    exit;
}

// 승인 대기 중인 사용자 목록 가져오기
$query = "SELECT student_id, name FROM users WHERE is_approved = 'pending'";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>사용자 관리</title>
    <link rel="stylesheet" href="../css/manage_users.css">
</head>
<body>
    <h1>사용자 승인 관리</h1>
    <table>
        <thead>
            <tr>
                <th>학번</th>
                <th>이름</th>
                <th>작업</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['student_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td>
                        <form action="./manage_users.php" method="POST" style="display:inline;">
                            <input type="hidden" name="student_id" value="<?php echo $row['student_id']; ?>">
                            <input type="hidden" name="action" value="approve">
                            <button type="submit" class="btn-approve">승인</button>
                        </form>
                        <form action="./manage_users.php" method="POST" style="display:inline;" onsubmit="return confirm('정말 삭제하시겠습니까?');">
                            <input type="hidden" name="student_id" value="<?php echo $row['student_id']; ?>">
                            <input type="hidden" name="action" value="reject">
                            <button type="submit" class="btn-reject">거부</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
