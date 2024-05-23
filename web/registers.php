<?php
$host = 'localhost';
$user = 'root';
$password = 'cong99';
$database = 'cong';

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("연결 실패: " . $conn->connect_error);
}

$username = $_POST['username'];
$password = $_POST['password'];
$name = $_POST['name'];
$birthdate = $_POST['birthdate'];

// 비밀번호 해싱
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// 사용자 이름이 이미 존재하는지 확인
$stmt = $conn->prepare("SELECT * FROM user WHERE USERNAME = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // 이미 존재하는 아이디일 경우 메시지 표시
    echo "이미 존재하는 아이디입니다. 다른 아이디를 사용해주세요.";
    
} else {
    // 존재하지 않는 아이디일 경우 삽입 실행
    $stmt = $conn->prepare("INSERT INTO user (USERNAME, PASSWORD, NAME, BIRTH) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $hashed_password, $name, $birthdate);
    if ($stmt->execute()) {
        echo "회원가입 성공!";
    } else {
        echo "Error: " . $stmt->error;
    }
}

$stmt->close();
$conn->close();
?>
<a href="loginsform.php">[로그인하기!]</a>
