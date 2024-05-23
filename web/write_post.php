<?php
session_start();

// 로그인 세션 확인
if (!isset($_SESSION['username'])) {
    // 로그인되지 않은 경우 로그인 페이지로 이동
    header("Location: login.php");
    exit();
}

// DB 연결 설정
$host = 'localhost';
$user = 'root';
$password = 'cong99';
$database = 'cong';

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("연결 실패: " . $conn->connect_error);
}

// 게시글 작성 폼 제출 처리
if (isset($_POST['submit'])) {
    // 폼으로부터 받은 데이터 처리
    $title = htmlspecialchars($_POST['title'], ENT_QUOTES, 'UTF-8');
    $content = htmlspecialchars($_POST['content'], ENT_QUOTES, 'UTF-8');
    $author = $_SESSION['username']; // 현재 로그인한 사용자의 이름을 사용

    // DB에 데이터 삽입
    $stmt = $conn->prepare("INSERT INTO posts (title, content, author) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $title, $content, $author);

    if ($stmt->execute()) {
        echo "<p>게시글이 성공적으로 작성되었습니다.</p>";
        header("Location: list.php"); // 작성 성공 시 목록 페이지로 이동
        exit();
    } else {
        echo "게시글 작성에 실패했습니다.";
    }
    $stmt->close();
}

$conn->close();
?>
