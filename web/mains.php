<!DOCTYPE html>
<html>
<head>
    <title>maru_cong</title>
</head>
<body>

<?php

session_start();
$csrf_token = bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $csrf_token;
?>

<form method="get" action="loginsform.php">
    <input type="submit" name="GO_button" value="GO!">
</form>
<form method="get" action="register.html">
    <input type="submit" name="JOIN_button" value="JOIN!">
</form>


</body>
</html>