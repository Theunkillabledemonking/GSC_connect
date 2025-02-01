<?php
require_once '../config/config.php';

class User {
    // 회원가입 처리
    public static function register($student_id, $name, $email, $password) {
        $conn = connect_db();
        $hashed_password = password_hash($password, PASSWORD_DEFAULT); // 비밀번호 해싱

        $sql = "INSERT INTO users (student_id, name, email, password) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $student_id, $name, $email, $hashed_password);

        if ($stmt->execute()) {
            $stmt->close();
            $conn->close();
            return true; // 성공
        } else {
            $stmt->close();
            $conn->close();
            return false; // 실패패
        }
    }

    // 사용자 인증 (로그인)
    public static function authenticate($student_id, $password) {
        $conn = connect_db();

        // 사용자 정보 조회
        $sql = "SELECT id, name, role, password FROM users WHERE student_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $student_id);
        $stmt->execute();
        $stmt->bind_result($id, $name, $role, $hashed_password);

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