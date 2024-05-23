<?php
session_start();
include 'conn.php';

// 사용자 로그인 확인
if (!isset($_SESSION['username'])) {
    echo "로그인 후 이용해 주세요.";
    header("Location: logins.php");
    exit();
}

if (isset($_GET['id'])) {
    $post_id = intval($_GET['id']); // 정수형으로 변환하여 SQL 인젝션 방지
    $username = $_SESSION['username'];

    // 게시글 작성자 확인
    $stmt = $conn->prepare("SELECT * FROM posts WHERE id = ? AND author = ?");
    $stmt->bind_param("is", $post_id, $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // 게시글 내용 표시
        $row = $result->fetch_assoc();
        
        // 게시글 작성자와 현재 사용자가 일치하는지 확인
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>게시글 수정</title>
        </head>
        <body>
            <h2>게시글 수정</h2>
            <form method="post" action="edit_process.php" enctype="multipart/form-data">
                <input type="hidden" name="post_id" value="<?php echo htmlspecialchars($post_id); ?>">
                <label for="title">제목:</label><br>
                <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($row['title']); ?>" required><br>
                <label for="content">내용:</label><br>
                <textarea id="content" name="content" required><?php echo htmlspecialchars($row['content']); ?></textarea><br>
                <label for="author">작성자:</label><br>
                <input type="text" id="author" name="author" value="<?php echo htmlspecialchars($row['author']); ?>" readonly><br>
                <label for="file">파일:</label><br>
                <a href="<?php echo htmlspecialchars($row['file_path']); ?>" target="_blank"><?php echo htmlspecialchars($row['file_name']); ?></a><br>
                <input type="file" id="file" name="file"><br>
                <input type="submit" name="submit" value="게시글 수정">
            </form>
            <a href="list.php">목록으로</a>
        </body>
        </html>
        <?php
    } else {
        echo "해당 게시글을 수정할 수 있는 권한이 없습니다.";
    }
} else {
    echo "게시글 ID가 전달되지 않았습니다.";
}

$conn->close();
?>
