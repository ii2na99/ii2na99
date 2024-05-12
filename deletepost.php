<?php

$host = 'localhost';
$user = 'root';
$password = 'cong99';
$database = 'cong';


$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("연결실패: " . $conn->connect_error);
}


if(isset($_POST['delete_button'])) {
    $post_id = $_POST['post_id'];

    
    $sql = "DELETE FROM posts WHERE id='$post_id'";
    if ($conn->query($sql) === TRUE) {
        echo "<p>게시글이 성공적으로 삭제되었습니다.</p>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<a href="list.php">  [list] </a>