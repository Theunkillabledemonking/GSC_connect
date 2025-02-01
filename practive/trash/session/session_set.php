<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        session_start();
        echo "세션 시작!!!<br>";

        $_SESSION['userid'] = "ocella";
        $_SESSION['username'] = '박영준';
        echo '세션 등록 완료!! <br>';

        echo $_SESSION['userid']."<br>";
        echo $_SESSION['username']."<br>";
        ?>
</body>
</html>