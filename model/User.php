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
}
?>