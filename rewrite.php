<!DOCTYPE html>
<html>
<head>
    <title>게시글 수정</title>
</head>
<body>

<?php

include 'conn.php';


if(isset($_GET['id'])) {
    $post_id = $_GET['id'];

    $sql = "SELECT * FROM posts WHERE id='$post_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // 게시글 내용 표시
        $row = $result->fetch_assoc();

        ?>
        
        <!-- 게시글 수정 폼 -->
        <form method="post" action="edit.php" enctype="multipart/form-data">
            <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
            <input type="text" name="title" placeholder="제목" value="<?php echo $row["title"]; ?>"><br>
            <textarea name="content" placeholder="내용"><?php echo $row["content"]; ?></textarea><br>
            <input type="text" name="author" placeholder="작성자" value="<?php echo $row["author"]; ?>"><br>
            <?php 
                // 현재 업로드된 파일 표시
                $file_path = 'uploads/' . $row["file_name"];
                echo "<p>현재 파일: <a href='$file_path' target='_blank'>" . $row["file_name"] . "</a></p>";
            ?>
            <input type="file" name="file"><br>
            <input type="submit" name="submit" value="게시글 수정">
        </form>
        <form method="post" action="deletefile.php">
            <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
            <input type="submit" name="delete_file" value="업로드된 파일 삭제">
        </form>
        <?php
    } else {
        echo "게시글을 찾을 수 없습니다.";
    }
} else {
    echo "게시글 ID가 전달되지 않았습니다.";
}

echo "<a href='list.php'>list  </a>";


$conn->close();
?>

</body>
</html>
