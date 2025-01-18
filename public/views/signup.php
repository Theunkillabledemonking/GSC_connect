<?php
$pageTitle = "회원가입";

// 헤더 포함
include_once('../../includes/header.php');
?>

<div class="container">
    <h1>회원가입</h1>
    <?php if (!empty($_GET['error'])): ?>
        <p class="error"><?php echo htmlspecialchars($_GET['error']); ?></p>
    <?php elseif (!empty($_GET['success'])): ?>
        <p class="success"><?php echo htmlspecialchars($_GET['success']); ?></p>
    <?php endif; ?>

    <form method="POST" action="./process_signup.php" onsubmit="return checkInput()">
        <input type="text" id="student_id" name="student_id" placeholder="학번" required>
        <input type="text" id="name" name="name" placeholder="이름" required>
        <input type="text" id="phone" name="phone" placeholder="전화번호" required>
        <input type="email" id="email" name="email" placeholder="이메일" required>
        <input type="password" id="password" name="password" placeholder="비밀번호" required>
        <input type="password" id="password_confirm" name="password_confirm" placeholder="비밀번호 확인" required>
        <button type="submit">회원가입</button>
    </form>

    <!-- 되돌아가기 버튼 -->
    <a href="../index.html" class="back-button">돌아가기</a>
</div>

<?php include_once('../../includes/footer.php'); ?>
