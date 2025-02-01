<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
        $id = $_POST["id"];
        $pass = $_POST["password"];
    ?>

        <ul>
            <li>아 &nbsp; 이&nbsp; 디 : <?= $id?></li>
            <li>비밀번호 : <?= $pass?></li>
        </ul>
</body>
</html>