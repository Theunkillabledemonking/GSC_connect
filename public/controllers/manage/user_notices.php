<?php
session_start();
require_once(dirname(__DIR__, 2) . '/includes/db.php');

// 로그인 확인
if (!isset($_SESSION['student_id'])) {
    header("Location: ../index.php");
    exit();
}

// 디버깅용: 세션 데이터 출력
var_dump($_SESSION);

// // 학년 필터링
// $target = isset($_SESSION['grade']) ? $_SESSION['grade'] : null; // 학년 정보 확인
// if (!$target) {
//     die("학년 정보가 없습니다. 관리자에게 문의하세요.");
// }

// SQL 쿼리 준비
$query = $target === '전체'
    ? "SELECT * FROM notices ORDER BY created_at DESC"
    : "SELECT * FROM notices WHERE target = '전체' OR target = ? ORDER BY created_at DESC";

$stmt = $conn->prepare($query);
if (!$stmt) {
    die("SQL 준비 실패: " . $conn->error);
}

if ($target !== '전체') {
    $stmt->bind_param('s', $target);
}

if (!$stmt->execute()) {
    die("SQL 실행 실패: " . $stmt->error);
}

$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>공지사항</title>
    <link rel="stylesheet" href="../css/notices.css">
</head>
<body>
    <h1>공지사항</h1>

    <!-- 필터링 드롭다운 -->
    <form method="GET" action="">
        <label for="target">대상:</label>
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
                <th>번호</th>
                <th>제목</th>
                <th>대상</th>
                <th>작성일</th>
                <th>작성자</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // SQL 쿼리
            $target = isset($_GET['target']) ? $_GET['target'] : '전체';
            $query = $target === '전체'
                ? "SELECT * FROM notices ORDER BY created_at DESC"
                : "SELECT * FROM notices WHERE target = ? ORDER BY created_at DESC";

            $stmt = $conn->prepare($query);
            if ($target !== '전체') {
                $stmt->bind_param('s', $target);
            }
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr onclick=\"location.href='notice_detail.php?id={$row['id']}'\">";
                    echo "<td>{$row['id']}</td>";
                    echo "<td>" . htmlspecialchars($row['title']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['target']) . "</td>";
                    echo "<td>{$row['created_at']}</td>";
                    echo "<td>" . htmlspecialchars($row['writer']) . "</td>";
                    echo "</tr>";
                }
            } 
            ?>
        </tbody>
    </table>

    <!-- 페이지네이션 (예: 1, 2, 3 버튼) -->
    <div>
        <?php
        // 페이지네이션 계산 및 출력 (단순 예)
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $totalPages = 5; // 총 페이지 수 (샘플 값)
        for ($i = 1; $i <= $totalPages; $i++) {
            echo "<a href='?page=$i&target=$target'>$i</a> ";
        }
        ?>
    </div>
    <button onclick="window.location.href='../main.php';">돌아가기</button>
</body>
</html>
