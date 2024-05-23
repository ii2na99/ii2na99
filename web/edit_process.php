<?php
session_start();
include 'conn.php';

// 사용자 로그인 확인
if (!isset($_SESSION['username'])) {
    echo "로그인 후 이용해 주세요.";
    header("Location: login.php");
    exit();
}

if (isset($_POST['submit'])) {
    $post_id = intval($_POST['post_id']); // 정수형으로 변환하여 SQL 인젝션 방지
    $title = htmlspecialchars($_POST['title'], ENT_QUOTES, 'UTF-8');
    $content = htmlspecialchars($_POST['content'], ENT_QUOTES, 'UTF-8');
    $username = $_SESSION['username'];

    // 사용자 권한 확인
    $stmt = $conn->prepare("SELECT * FROM posts WHERE id = ? AND author = ?");
    $stmt->bind_param("is", $post_id, $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // 게시글 업데이트
        $stmt = $conn->prepare("UPDATE posts SET title = ?, content = ? WHERE id = ?");
        $stmt->bind_param("ssi", $title, $content, $post_id);

        if ($stmt->execute()) {
            echo "게시글이 성공적으로 수정되었습니다.";
            header("Location: list.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "게시글을 찾을 수 없거나 수정 권한이 없습니다.";
    }
    $stmt->close();
}

$conn->close();
?>
