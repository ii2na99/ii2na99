<?php
session_start();

$host = 'localhost';
$user = 'root';
$password = 'cong99';
$database = 'cong';

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("연결 실패: " . $conn->connect_error);
}

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // 사용자 로그인 시도 횟수 체크
    $login_attempts = isset($_SESSION['login_attempts']) ? $_SESSION['login_attempts'] : 0;

    // 사용자가 로그인 시도를 3회 이상 했을 경우 잠금
    if ($login_attempts >= 3) {
        echo "로그인 시도 횟수가 많아서 잠시 후 다시 시도해 주세요.";
        exit();
    }

    // 사용자가 로그인 시도를 한 번 이상 하였을 경우 시도 횟수 증가
    $_SESSION['login_attempts'] = ++$login_attempts;

    // 비밀번호는 해싱하여 저장되므로, 저장된 비밀번호와 비교할 때에도 해싱하여 비교합니다.
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // 로그인 성공 시 세션 변수 설정
            $_SESSION['username'] = $username;
            unset($_SESSION['login_attempts']); // 로그인 성공 시 로그인 시도 횟수 초기화
            header("Location: mains.php");
            exit();
        } else {
            echo "아이디 또는 비밀번호가 잘못되었습니다.";
        }
    } else {
        echo "아이디 또는 비밀번호가 잘못되었습니다.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form action="logins.php" method="post">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" value="Login">
    </form>
    <a href="mains.php">[홈으로]</a>
</body>
</html>
