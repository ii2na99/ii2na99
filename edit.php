<?php
include 'conn.php';

if(isset($_POST['submit'])) {
    $post_id = $_POST['post_id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $author = $_POST['author'];

    // 파일정보
    $file_name = $_FILES['file']['name'];
    $file_tmp = $_FILES['file']['tmp_name'];
    $file_type = $_FILES['file']['type'];
    $file_size = $_FILES['file']['size'];
    $file_error = $_FILES['file']['error'];

 
    $uploadDirectory = 'uploads/';
   
    $file_path = $uploadDirectory . $file_name;
    // 파일을 디렉토리에 저장
    move_uploaded_file($file_tmp, $file_path);

    // 게시글 수정
    if (!empty($file_name)) {
        //파일 업로드경우에만 
        $sql = "UPDATE posts SET title='$title', content='$content', author='$author', file_name='$file_name', file_path='$file_path' WHERE id='$post_id'";
    } else {
        
        $sql = "UPDATE posts SET title='$title', content='$content', author='$author' WHERE id='$post_id'";
    }

    if ($conn->query($sql) === TRUE) {
        echo "<p>게시글이 성공적으로 수정되었습니다.</p>";
        header("Location: list.php");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
