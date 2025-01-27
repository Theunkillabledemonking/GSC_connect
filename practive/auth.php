<?php
function authenticate_user($conn) {
    session_start();

    // 세션 확인
    if (isset($_SESSION['user_id'])) {
        $current_time = time();
        if ($current_time - $_SESSION['login_time'] > $_SESSION['expire_time']) {
            // 세션 만료
            session_unset();
            session_destroy();
            header("Location: login.php?message=session_expired");
            exit();
        } else {
            // 세션 갱신
            $_SESSION['login_time'] = $current_time;
            return true; // 인증 성공
        }
    } elseif (isset($_COOKIE['remember_token'])) {
        // 쿠키 확인 (세션이 만료되었을 때)
        $token = $_COOKIE['remember_token'];
        $stmt = $conn->prepare("SELECT id FROM users WHERE remember_token = ?");
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $stmt->bind_result($id);

        if ($stmt->fetch()) { // 결과 행을 가져옵니다.
            // 세션 재생성
            $_SESSION['user_id'] = $id;
            $_SESSION['login_time'] = time();
            $_SESSION['expire_time'] = 3600;
            return true; // 인증 성공
        } else {
            // 유효하지 않은 쿠키 처리
            setcookie("remember_token", "", time() - 3600, "/"); // 쿠키 삭제
            header("Location: login.php?message=invalid_cookie");
            exit();
        }
    } else {
        // 로그인되지 않은 경우
        header("Location: login.php");
        exit();
    }
}

?>