<?php
session_start();

// DB 정보
$host = 'localhost';
$user = 'root';
$password = 'cong99';
$database = 'cong';

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("연결 실패: " . $conn->connect_error);
}

// 사용자 입력 값
$username = $_POST['username'];
$password = $_POST['password'];

// 준비된 문을 사용하여 SQL 인젝션 방지
$stmt = $conn->prepare("SELECT * FROM user WHERE USERNAME = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['PASSWORD'])) {
        // 로그인 성공, 세션 설정
        session_regenerate_id(true); // 세션 고정 공격 방지
        $_SESSION["username"] = $username;
        header("Location: list.php");
        exit();
    } else {
        // 비밀번호가 잘못된 경우
        $_SESSION['error'] = "아이디 또는 비밀번호가 잘못되었습니다.";
        header("Location: register.html");
        exit();
    }
} else {
    // 사용자 이름이 잘못된 경우
    $_SESSION['error'] = "아이디 또는 비밀번호가 잘못되었습니다.";
    header("Location: register.html");
    exit();
}

$stmt->close();
$conn->close();
?>
