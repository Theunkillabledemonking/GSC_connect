<?php
// 데이터베이스 연결
$conn = new mysqli('localhost', 'root', '', 'school_portal');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 공지사항 가져오기
$noticeResult = $conn->query("SELECT title FROM notices ORDER BY created_at DESC LIMIT 5");

// 시간표 가져오기
$timetableResult = $conn->query("SELECT grade, subject, time_slot FROM timetable");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>메인 페이지</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <div class="container">
        <h1>공지사항 및 시간표</h1>
        
        <div class="box-wrapper">
            <!-- 공지사항 박스 -->
            <div class="box">
                <h2>전체 공지사항</h2>
                <ul class="notice-list">
                    <?php while ($row = $noticeResult->fetch_assoc()): ?>
                        <li><?= htmlspecialchars($row['title']) ?></li>
                    <?php endwhile; ?>
                </ul>
            </div>

            <!-- 시간표 박스 -->
            <div class="box">
                <h2>시간표</h2>
                <table class="timetable">
                    <thead>
                        <tr>
                            <th>학년</th>
                            <th>과목</th>
                            <th>시간</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $timetableResult->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['grade']) ?></td>
                                <td><?= htmlspecialchars($row['subject']) ?></td>
                                <td><?= htmlspecialchars($row['time_slot']) ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>

<?php
// 데이터베이스 연결 종료
$conn->close();
?>
