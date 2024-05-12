<?php
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
$name = $_POST['name'];
$birthdate = $_POST['birthdate'];

// PW 해싱
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// DB에 정보 넣기
$sql = "INSERT INTO user (USERNAME, PASSWORD, NAME, BIRTH) VALUES ('$username', '$hashed_password', '$name', '$birthdate')";
if ($conn->query($sql) === TRUE) {
    echo "회원가입 성공!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>

<a href="loginform.html">  [로그인하기!] </a>