<form method="post">
    <label for="rrn">주민등록번호</label>
    <input type="text" id="rrn" name="rrn" placeholder="132456-1234567">
    <button type="submit">클릭</button>
</form>

<?php
if((isset($_POST['rrn']))) {
    // 주민번호 입력값
    $rrn = $_POST['rrn'];
    // 하이폰을 지우고 재정렬한 배열
    $clear_array = [];
    // 합계
    $total_num = 0;
    // 검사 배열
    $check_array = [2, 3, 4, 5, 6, 7, 8, 9, 2, 3, 4, 5];

    for ($i = 0; $i < strlen($rrn); $i++) {
        if ($rrn[$i] !== "-"){
        $clear_array[] = $rrn[$i];
        }
    }
    
    $length = 0;
    
    for ($i = 0; $i < count($clear_array); $i++) {
        $length++;
    }

    if ($length !== 13) {
        echo "13자리가 아닙니다.";
        exit;
    } 
    
    // 연도
    $year = ($clear_array[0] . $clear_array[1]);    
    if (!(0 <= $year && $year <= 99)) {
        echo "잘못된 년도입니다.";
        exit;
    }

    // 월
    $month = ($clear_array[2] . $clear_array[3]);
    if (!(1 <= $month && $month <= 12)) {
        echo "잘못된 월입니다.";
        exit;
    }

    // 일
    $day = ($clear_array[4] . $clear_array[5]);
    if (!(1 <= $day && $day <= 31)) {
        echo "잘못된 날짜입니다.";
        exit;
    }

    // 젠더 판별
    $gender_check = $clear_array[6];
    $gender;
    switch($gender_check) {
        case "1" :
        case "3" :
            $gender = "남성";
            break;
        case "2":
        case "4":
            $gender = "여성";
            break;
        default:
            echo "유효하지 않는 값입니다.";
            exit;
    }

    for ($i = 0; $i < $length - 1; $i++) {
        $total_num += (int)$clear_array[$i] * $check_array[$i];
    }

    $multi = (11 - $total_num % 11)%10;
    
    if ((int)$clear_array[12] === $multi) {
        echo "입력하신 주민등록번호 $gender ";
        for ($i = 0; $i < 6; $i++) {
            echo $clear_array[$i];
        }
        echo "-$clear_array[6]";
        for ($i = 0; $i < 7; $i++) {
            echo "*";
        }
        echo "은(는) 유효합니다.";
    } else {
        echo "유효하지않는 주민먼호";
        exit;
    }

} else {
    echo "값을 입력해주세요";
}
?>