<?php
session_start();
require_once(dirname(__DIR__, 2) . '/includes/db.php');

// 로그인 확인
if (!isset($_SESSION['student_id'])) {
    header("Location: ../index.php");
    exit();
}

// 사용자 정보 가져오기
$name = htmlspecialchars($_SESSION['name']);
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>공지사항</title>
    <link rel="stylesheet" href="../css/notices_user.css">
</head>
<body>
    <div class="container">
        <h1>공지사항</h1>
        <p>안녕하세요, <strong><?php echo $name; ?></strong>님!</p>

        <!-- 공지사항 필터 -->
        <form method="GET" action="">
            <label for="target">대상별 필터:</label>
            <select id="target" name="target" onchange="this.form.submit()">
                <option value="전체" <?php if (!isset($_GET['target']) || $_GET['target'] === '전체') echo 'selected'; ?>>전체</option>
                <option value="1학년" <?php if (isset($_GET['target']) && $_GET['target'] === '1학년') echo 'selected'; ?>>1학년</option>
                <option value="2학년" <?php if (isset($_GET['target']) && $_GET['target'] === '2학년') echo 'selected'; ?>>2학년</option>
                <option value="3학년" <?php if (isset($_GET['target']) && $_GET['target'] === '3학년') echo 'selected'; ?>>3학년</option>
            </select>
        </form>

        <!-- 공지사항 목록 -->
        <table>
            <thead>
                <tr>
                    <th>대상</th>
                    <th>제목</th>
                    <th>작성일</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $targetFilter = isset($_GET['target']) ? $_GET['target'] : '전체';
                $query = "SELECT * FROM notices";
                if ($targetFilter !== '전체') {
                    $query .= " WHERE target = ?";
                }
                $query .= " ORDER BY created_at DESC";

                $stmt = $conn->prepare($query);
                if ($targetFilter !== '전체') {
                    $stmt->bind_param('s', $targetFilter);
                }
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr onclick=\"viewNotice(" . $row['id'] . ")\">";
                        echo "<td>" . htmlspecialchars($row['target']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['title']) . "</td>";
                        echo "<td>" . $row['created_at'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>공지사항이 없습니다.</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <button onclick="window.location.href='../main.php';" class="back-button">돌아가기</button>
    </div>

    <script>
        function viewNotice(id) {
            window.location.href = `view_notice.php?id=${id}`;
        }
    </script>
</body>
</html>
