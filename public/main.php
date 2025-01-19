<!DOCTYPE html>
<html lang="ko">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>GSC Portal - 로그인</title>
    <link rel="stylesheet" href="./css/login.css" />
  </head>
  <body>
    <div class="container">
      <h1>GSC Portal</h1>
      <div class="form-container">
        <!-- 로그인 폼 -->
        <form action="./views/process_login.php" method="POST">
          <input type="text" name="student_id" placeholder="학번" required />
          <input
            type="password"
            name="password"
            placeholder="비밀번호"
            required
          />
          <button type="submit">LOG IN</button>
        </form>

        <!-- 오류 메시지 표시 -->
        <?php if (isset($_GET['error'])): ?>
          <p class="error">
            <?php
            if ($_GET['error'] === 'incorrect_password') {
                echo "비밀번호가 틀렸습니다.";
            } elseif ($_GET['error'] === 'user_not_found') {
                echo "학번이 존재하지 않습니다.";
            } elseif ($_GET['error'] === 'account_not_approved') {
                echo "계정이 승인되지 않았습니다.";
            }
            ?>
          </p>
        <?php endif; ?>

        <div class="signup-link">
          계정이 없으신가요? <a href="./views/signup.php">Sign Up</a>
        </div>
      </div>
    </div>
  </body>
</html>
