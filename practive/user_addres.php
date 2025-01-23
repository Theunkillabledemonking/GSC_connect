<form method="post">
    <label for="rrn">주민등록번호</label>
    <input type="text" id="rrn" name="rrn" placeholder="132456-1234567">
    <button type="submit">클릭</button>
</form>

<?php
if (isset($_POST['rrn'])) {
    // 주민번호 입력값
    $rrn = $_POST['rrn'];

    // 하이폰 제거
    $cleaned_rrn = '';
    for ($i = 0; $i < strlen($rrn); $i++) {
        if ($rrn[$i] !== "-"){
            $cleaned_rrn .= $rrn[$i];
        }
    }
    
    // 길이 확인
    if (strlen($cleaned_rrn) !== 13) {
        echo "주민번호는 13자리여야 합니다.";
        exit;
    }
    
    // 생년월일 유효성 검사
    $year = (int)($cleaned_rrn[0] . $cleaned_rrn[1]);
    $month = (int)($cleaned_rrn[2] . $cleaned_rrn[3]);
    $day = (int)($cleaned_rrn[4] . $cleaned_rrn[5]);

    if ($month < 1 || $month > 12 || $day < 1 || $day > 31) {
        echo "유효하지 않은 생년월일입니다.";
        exit;
    }

    // 젠더 판별
    $gender = $cleaned_rrn[6];
    if ($gender !== '1' && $gender !== '2' && $gender !== '3' && $gender !== '4') {
        echo "유효하지 않은 성별 코드입니다.";
        exit;
    }

    // 검사 배열
    $check_array = [2, 3, 4, 5, 6, 7, 8, 9, 2, 3, 4, 5];

    $total_num = 0;
    for ($i = 0; $i < 12; $i++) {
        $total_num += (int)$cleaned_rrn[$i] * $check_array[$i];
    }

    $check_digit = (11 - $total_num % 11)%10;
    
    if ((int)$cleaned_rrn[12] !== $check_digit) {
        echo "유효하지 않은 주민등록번호입니다.";
        exit;
    }

    // 결과 출력
    $gender_label = ($gender === '1' || $gender == '3') ? "남성" : "여성";
    echo "입력하신 주민등록번호는 {$gender_label}이며 유효합니다.";
    echo substr($cleaned_rrn, 0, 6) . "-";
    echo $gender . str_repeat("*", 6);

} else {
    echo "값을 입력해주세요";
}
?>