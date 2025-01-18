<?php
// Input 검증 함수
function validateInput($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

// 학번 중복 확인 함수
function isStudentIdDuplicate($conn, $student_id) {
    $query = "SELECT * FROM users WHERE student_id = '$student_id'";
    $result = mysqli_query($conn, $query);
    return ($result && mysqli_num_rows($result) > 0);
}
?>