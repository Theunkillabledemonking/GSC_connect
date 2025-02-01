<?php
require_once '../config/config.php'; // 데이터베이스 연결 설정 포함

class User {
    // 회원가입 처리 함수
    public static function register($student_id, $name, $email, $password) {
        $conn = connect_db(); // 데이터베이스 연결
        $hashed_password = password_hash($password, PASSWORD_DEFAULT); // 비밀번호 해싱

        // 사용자 데이터 삽입 쿼리
        $sql = "INSERT INTO users (student_id, name, email, password) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $student_id, $name, $email, $hashed_password);

        // 쿼리 실행 및 결과 반환
        if ($stmt->execute()) {
            $stmt->close(); // 쿼리 종료
            $conn->close(); // 데이터베이스 연결 종료
            return true; // 성공
        } else {
            $stmt->close(); // 쿼리 종료
            $conn->close(); // 데이터베이스 연결 종료료
            return false; // 실패
        }
    }

    // 사용자 인증 (로그인) 처리 함수
    public static function authenticate($student_id, $password) {
        $conn = connect_db(); // 데이터베이스 연결

        // 학번으로 사용자 정보 조회
        $sql = "SELECT id, name, role, password FROM users WHERE student_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $student_id);
        $stmt->execute();
        $stmt->bind_result($id, $name, $role, $hashed_password);

        // 결과가 존재하고 비밀번호가 일치하는지 확인
        if ($stmt->fetch()) {
            // 비밀번호 검증
            if (password_verify($password, $hashed_password)) {
                $stmt->close();
                $conn->close();
                return [
                    'id' => $id,
                    'name' => $name,
                    'role' => $role
                ]; // 인증 성공
            }
        }

        $stmt->close();
        $conn->close();
        return false; // 인증 실패
    }
}
?>