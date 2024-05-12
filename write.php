<?php
$host = 'localhost';
$user = 'root';
$password = 'cong99';
$database = 'cong';

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("연결실패: " . $conn->connect_error);
}

if(isset($_POST['submit'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $author = $_POST['author'];

  
    $file_name = $_FILES['file']['name'];
    $file_tmp = $_FILES['file']['tmp_name'];
    $file_type = $_FILES['file']['type'];
    $file_size = $_FILES['file']['size'];
    $file_error = $_FILES['file']['error'];

   
    $uploadDirectory = 'uploads/';
   
    $file_path = $uploadDirectory . $file_name;
   
    move_uploaded_file($file_tmp, $file_path);

    
    $sql = "INSERT INTO posts (title, content, author, file_name, file_data, file_path) VALUES ('$title', '$content', '$author', '$file_name', '$file_data', '$file_path')";
    if ($conn->query($sql) === TRUE) {
        echo "<p>게시글이 성공적으로 작성되었습니다.</p>";
        header("Location: list.php");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>게시글 작성</title>
</head>
<body>

<!-- 게시글 작성 폼 -->
<form method="post" action="write.php" enctype="multipart/form-data">
    <input type="text" name="title" placeholder="제목"><br>
    <textarea name="content" placeholder="내용"></textarea><br>
    <input type="text" name="author" placeholder="작성자"><br>
    <input type="file" name="file"><br>
    <input type="submit" name="submit" value="게시글 작성">
</form>

<a href="list.php"> list </a>

</body>
</html>
