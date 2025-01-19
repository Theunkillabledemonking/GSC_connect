<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    header("Location: ./main.php");
    exit;
}

// 데이터베이스 연결
require_once('./includes/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['student_id'];
    $action = $_POST['action']; // approve 또는 reject

    if ($action === 'approve') {
        $query = "UPDATE users SET is_approved = 'approved' WHERE student_id = ?";
    } elseif ($action === 'reject') {
        $query = "DELETE FROM users WHERE student_id = ?";
    } else {
        echo "유효하지 않은 작업입니다.";
        exit;
    }

    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $student_id);
    if ($stmt->execute()) {
        echo "작업이 성공적으로 완료되었습니다.";
    } else {
        echo "작업에 실패했습니다.";
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
</head>
<body>
    <h1>사용자 승인 관리</h1>
    <table>
        <tr>
            <th>학번</th>
            <th>이름</th>
            <th>작업</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['student_id']); ?></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td>
                    <form action="./manage_users.php" method="POST" style="display:inline;">
                        <input type="hidden" name="student_id" value="<?php echo $row['student_id']; ?>">
                        <input type="hidden" name="action" value="approve">
                        <button type="submit">승인</button>
                    </form>
                    <form action="./manage_users.php" method="POST" style="display:inline;">
                        <input type="hidden" name="student_id" value="<?php echo $row['student_id']; ?>">
                        <input type="hidden" name="action" value="reject">
                        <button type="submit">거부</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
