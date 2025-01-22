<form method="post">
    <label for="rrn">주민등록번호</label>
    <input type="text" id="rrn" name="rrn" placeholder="010410-3683219">
    <button type="submit">확인</button>
</form>

<?php
if (isset($_POST['rrn'])) {
    $rrn = $_POST['rrn'];
    $clear_rnn = "";
    $number_array = [2, 3, 4, 5, 6, 7, 8, 9, 2, 3, 4, 5];
    $total_num = 0;

    for ($i = 0; $i < strlen($rrn); $i++) {
        if ($rrn[$i] !== "-") {
            $clear_rnn .= $rrn[$i];
        }
    }

    if (strlen($clear_rnn) !== 13 || !ctype_digit($clear_rnn)) {
        echo "주민번호 형식이 올바르지 않습니다.";
        exit;
    }

    for ($i = 0; $i < 12; $i++) {
        $total_num += $number_array[$i] * (int)$clear_rnn[$i];    
    }

    $result = (11 - ($total_num % 11) % 10);
    if ($result === (int)$clear_rnn[12]) {
        echo "올바른 값입니다.";
    } else {
        echo "유효하지 않습니다.";
    }
    
}else {
    echo "주민등록번호를 입력해주세요";
}
?>