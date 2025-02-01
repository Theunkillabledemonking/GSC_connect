<?php
// 데이터베이스 연결 설정
define('DB_HOST','localhost');          // 호스트 이름
define('DB_USER', 'root');              // 사용자 이름
define('DB_PASSWORD', 'gsc1234!@#$');   // 비밀번호
define('DB_NAME', 'school_portal');     // 데이터 베이스 이름

// 데이터베이스 연결 함수
function connect_db() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    // 연결 실패 시 오류 메시지 출력
    if ($conn->connect_error) {
        die("데이터베이스 연결 실패: ". $conn->connect_error);
    }
    return $conn;
}
?>