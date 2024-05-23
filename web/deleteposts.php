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

// 사용자 로그인 확인
if (!isset($_SESSION['username'])) {
    echo "로그인 후 이용해 주세요.";
    header("Location: login.php");
    exit();
}

if (isset($_POST['delete_button'])) {
    $post_id = intval($_POST['post_id']); // 정수형으로 변환하여 SQL 인젝션 방지
    $username = $_SESSION['username'];

    // 사용자 권한 확인
    $stmt = $conn->prepare("SELECT * FROM posts WHERE id = ? AND author = ?");
    $stmt->bind_param("is", $post_id, $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // 게시글 삭제
        $stmt = $conn->prepare("DELETE FROM posts WHERE id = ?");
        $stmt->bind_param("i", $post_id);

        if ($stmt->execute()) {
            echo "<p>게시글이 성공적으로 삭제되었습니다.</p>";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "게시글을 찾을 수 없거나 삭제 권한이 없습니다.";
    }
}

$conn->close();
?>

<a href="list.php">[list]</a>
