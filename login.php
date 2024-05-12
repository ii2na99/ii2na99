<?php
session_start();

// DB 정보
$host = 'localhost';
$user = 'root';
$password = 'cong99';
$database = 'cong';

$conn = new mysqli($host, $user, $password, $database);


if ($conn->connect_error) {
    die("연결실패: " . $conn->connect_error);
}


$username = $_POST['username'];
$password = $_POST['password'];

// DB 조회
$sql = "SELECT * FROM user WHERE USERNAME='$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['PASSWORD'])) {
       
        $_SESSION["username"] = $username;
        header("Location: list.php");
    } else {
        
        $error = "아이디 또는 비밀번호가 잘못되었습니다.";

        header("Location: register.html");
    }
} else {
    
    $error = "아이디 또는 비밀번호가 잘못되었습니다.";

    header("Location: register.html");
}


$conn->close();
?>
