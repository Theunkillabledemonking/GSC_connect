<?php
    session_start();
    unset($_SESSION["username"]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <ul>
        <li><?= "userid 세선: ".$_SESSION["userid"]."<br>"?></li>
        <li><?= "username 세선: ".$_SESSION["username"]."<br>"?></li>
        <li><?= "username 세션이 삭제되었습니다" ?></li>
    </ul>
</body>
</html>