<?php
    setcookie("userid", "", time() - 3600);
    setcookie("username", "", time() - 3600);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        echo "userid와 username 쿠키가 삭제되었다!";
        ?>
</body>
</html>