<?php
session_start();
require_once('./includes/db.php');

// 기본 학년 설정
$grade = $_GET['grade'] ?? '1학년';

// 시간표 데이터 가져오기
$query = "SELECT * FROM timetable WHERE grade = ? ORDER BY FIELD(day_of_week, '월', '화', '수', '목', '금'), period ASC";
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $grade);
$stmt->execute();
$result = $stmt->get_result();

// 데이터 저장
$timetable = [];
while ($row = $result->fetch_assoc()) {
    $timetable[] = $row;
}

// 관리자 확인
$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
?>
<!DOCTYPE html>
<html lang="ko">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>정규 시간표</title>
    <link rel="stylesheet" href="./css/schedule.css" />
  </head>
  <body>
    <div class="container">
      <div class="header">
        <h1>정규 시간표</h1>
        <form method="GET">
          <select name="grade" onchange="this.form.submit()">
            <option value="1학년" <?php if ($grade === '1학년') echo 'selected'; ?>>1학년</option>
            <option value="2학년" <?php if ($grade === '2학년') echo 'selected'; ?>>2학년</option>
            <option value="3학년" <?php if ($grade === '3학년') echo 'selected'; ?>>3학년</option>
          </select>
        </form>
      </div>
      <table>
        <thead>
          <tr>
            <th>시간</th>
            <th>월</th>
            <th>화</th>
            <th>수</th>
            <th>목</th>
            <th>금</th>
          </tr>
        </thead>
        <tbody>
          <?php for ($i = 1; $i <= 9; $i++): ?>
            <tr>
              <td><?php echo $i; ?>교시</td>
              <?php foreach (['월', '화', '수', '목', '금'] as $day): ?>
                <td>
                  <?php
                  $subject = '';
                  $professor = '';
                  $id = '';
                  foreach ($timetable as $row) {
                    if ($row['period'] == $i && $row['day_of_week'] == $day) {
                      $subject = $row['subject_name'];
                      $professor = $row['professor_name'];
                      $id = $row['id'];
                      break;
                    }
                  }
                  ?>
                  <?php if ($isAdmin): ?>
                    <form method="POST" action="edit_timetable.php">
                      <input type="hidden" name="id" value="<?php echo $id; ?>">
                      <input type="text" name="subject_name" value="<?php echo htmlspecialchars($subject); ?>" placeholder="수업명" required>
                      <input type="text" name="professor_name" value="<?php echo htmlspecialchars($professor); ?>" placeholder="교수명" required>
                      <button type="submit">저장</button>
                      <a href="delete_timetable.php?id=<?php echo $id; ?>" onclick="return confirm('정말 삭제하시겠습니까?');">삭제</a>
                    </form>
                  <?php else: ?>
                    <?php echo htmlspecialchars($subject) . '<br>(' . htmlspecialchars($professor) . ')'; ?>
                  <?php endif; ?>
                </td>
              <?php endforeach; ?>
            </tr>
          <?php endfor; ?>
        </tbody>
      </table>
      <div class="buttons">
        <?php if ($isAdmin): ?>
          <button onclick="alert('관리자는 이미 수정 가능합니다.')">관리자 기능</button>
        <?php endif; ?>
        <button onclick="window.history.back();">돌아가기</button>
      </div>
    </div>
  </body>
</html>
