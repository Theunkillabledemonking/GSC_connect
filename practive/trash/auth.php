<?php
/**
 * 사용자 인증을 수행하는 함수
 * 
 * 세션을 확인하고, 사용자의 역할(role)과 세션 유효성을 검증합니다. 
 * 필요 시 세션을 갱신하거나 만료 처리를 수행합니다.
 *
 * @param mysqli $conn 데이터베이스 연결 객체
 * @param string|null $required_role 필수 역할 (null일 경우 역할 확인을 건너뜀)
 */
function authenticate_user($conn, $required_role = null) {
    // 세션 시작: 세션이 이미 시작되지 않았다면 새로 시작

    // 세션에 사용자 ID가 존재하는지 확인 (로그인 여부 판단)
    if (!isset($_SESSION['user_id'])) {
        // 사용자 인증이 되어 있지 않으면 로그인 페이지로 리디렉션
        header("Location: login.php?message=unauthenticated");
        exit(); // 이후 코드 실행 방지
    }

    // 역할 확인: $required_role이 설정되어 있으면 사용자의 역할을 검증
    if ($required_role && (!isset($_SESSION['role']) || $_SESSION['role'] !== $required_role)) {
        // 역할이 요구된 값과 다를 경우 접근 권한이 없으므로 로그인 페이지로 리디렉션
        header("Location: login.php?message=access_denied");
        exit();
    }

    // 현재 시간과 세션 생성 시간을 비교하여 세션 만료 여부 확인
    $current_time = time(); // 현재 시간 (Unix 타임스탬프)
    if ($current_time - $_SESSION['login_time'] > $_SESSION['expire_time']) {
        // 세션 만료 처리: 세션 데이터 제거 및 종료
        session_unset(); // 모든 세션 변수 해제
        session_destroy(); // 세션 파괴
        // 세션 만료 메시지와 함께 로그인 페이지로 리디렉션
        header("Location: login.php?message=session_expired");
        exit();
    } else {
        // 세션이 유효한 경우: 세션 시간을 갱신하여 만료 시간을 연장
        $_SESSION['login_time'] = $current_time;
        return true; // 인증 성공
    }
}

/**
 * 역할(role)을 확인하는 함수
 * 
 * 세션에서 사용자의 역할(role)을 확인하여 지정된 역할과 일치하지 않으면 접근을 차단합니다.
 *
 * @param string $required_role 필수 역할
 */
function check_role($required_role) {
    // 세션에 role이 없거나, 현재 역할이 요구된 역할과 일치하지 않으면
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== $required_role) {
        // 접근 권한이 없으므로 로그인 페이지로 리디렉션
        header("Location: login.php?message=access_denied");
        exit();
    }
}

/**
 * 세션 유효성을 확인하는 함수
 * 
 * 세션에서 사용자 ID가 존재하는지 확인하여 로그인 상태를 검증합니다.
 */
function check_session() {
    // 세션에 user_id가 없으면 (로그인하지 않은 상태)
    if (!isset($_SESSION['user_id'])) {
        // 인증되지 않았으므로 로그인 페이지로 리디렉션
        header("Location: login.php?message=unauthenticated");
        exit();
    }
}
?>
