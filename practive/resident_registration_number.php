<form method="post">
    <label for="rrn">주민번호</label>
    <input type="text" id="rrn" name="rrn" placeholder="123456-1234567">
    <button type="submit">출력</button>
    </label>
</form>

<?php 
    if((isset($_POST['rrn']))){
        $rrn = $_POST['rrn'];
        $rrn = array('0', '1', '0', '4', '1', '0', '-', '3', '6', '8', '3', '2', '1', '9');
        $clear_number=array();
        $check_number = [2, 3, 4, 5, 6, 7, 8, 9, 2, 3, 4, 5];
        $total_count = 0;

        for ($i = 0; $i < count($rrn); $i++) {
            if ($rrn[$i] !== "-"){
            $clear_number[] = $rrn[$i];
            }
        }
        
        foreach ($clear_number as $bar) {
            echo $bar;
        }
        echo "<br>";
            
        
        $length = 0;
        
        for ($i = 0; $i < 13; $i++) {
            $length++;
        }
        echo $length;
        echo "<br>";
        if ($length !== 13) {
            echo "13자리가 아닙니다.";
            exit;
        } 
        
        // 연도
        $year = $clear_number[0] .= $clear_number[1];    
        if (!(00 <= $year || $year <= 99)) {
            echo "잘못된 년도입니다.";
            exit;
        }

        // 월
        $month = $clear_number[2] .= $clear_number[3];
        if (!(1 <= $month || $month <= 12)) {
            echo "잘못된 월입니다.";
            exit;
        }

        // 일
        $day = $clear_number[4] .= $clear_number[5];
        echo $day;
        if (!(1 <= $day || $day <= 31)) {
            echo "잘못된 날짜입니다.";
            exit;
        }

        // 젠더 판별
        $gender_check = $clear_number[6];
        $gender;
        switch($gender_check) {
            case "1":
                $gender = 1;
                break;
            case "2":
                $gender = 2;
                break;
            case "3":
                $gender = 3;
                break;
            case "4":
                $gender = 4;
                break;
            default:
                echo "유효하지 않는 값입니다.";
        }

        for ($i = 0; $i < $length - 1; $i++) {
            echo "$clear_number[$i] +";
            echo "$check_number[$i]";
            echo "<br>";
            $total_count += (int)$clear_number[$i] * $check_number[$i];
        }
        
        $multi = ((11 - $total_count % 11) % 10);
        if ((int)$clear_number[12] === $multi) {
            echo "입력하신 주민등록번호";
            for ($i = 0; $i < 7; $i++) {
                echo $clear_number[$i];
            }
            echo $gender;
            for ($i = 0; $i < 7; $i++) {
                echo "*";
            }
            echo "은(는) 유효합니다.";
        } else {
            echo "유효하지않는 주민먼호";
        }

        
        // 사용자로부터 주민등록번호 13자리 입력
        // 형식: 123456-1234567

        // 입력받은 주민등록번호가 다음조건을 모두 만족 체크

        // 주민등록번호는 숫자 13자리

        // 앞 6자리는 생년월일

        // 연도는 1900~2099
    }else{
        echo "주민등록번호를 입력해주세요";
    }
?>
