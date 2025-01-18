<?php
$pageTitle = "로그인";

// 절대경로 기반으로 헤더와 푸터 불러오기
require_once(dirname(__DIR__, 2) . '/includes/header.php');
?>

<div class="container">
    <h1>GSC Portal</h1>
    <div class="form-container">
        <form action="./views/process_login.php" method="POST">
            <input type="text" name="student_id" placeholder="학번" required>
            <input type="password" name="password" placeholder="비밀번호" required>
            <button type="submit">LOG IN</button>
        </form>
        <div class="signup-link">
            계정이 없으신가요? <a href="./views/signup.php">Sign Up</a>
        </div>
    </div>
</div>

<?php require_once(dirname(__DIR__, 2) . '/includes/footer.php'); ?>
