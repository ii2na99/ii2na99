<!DOCTYPE html>
<html>
<head>
    <title>게시글 상세 내용</title>
</head>
<body>

<?php

$host = 'localhost';
$user = 'root';
$password = 'cong99';
$database = 'cong';


$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("연결실패: " . $conn->connect_error);
}


if(isset($_GET['id'])) {
    $post_id = $_GET['id'];

    
    $sql = "SELECT * FROM posts WHERE id='$post_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        
        $row = $result->fetch_assoc();
        echo "<h2>" . $row["title"]. "</h2>";
        echo "<p>" . $row["content"]. "</p>";
        echo "<p>작성자: " . $row["author"]. " | 작성일: " . $row["created_at"]. "</p>";
        
        // 파일 다운로드 링크 추가
        echo "<p><a href='uploads/" . $row["file_name"] . "'>" . $row["file_name"] . "</a></p>";

        // 수정하기 링크
        echo "<a href='rewrite.php?id=" . $row["id"] . "'>수정하기</a>";
        echo "<hr>";
    } else {
        echo "게시글을 찾을 수 없습니다.";
    }
} else {
    echo "게시글 ID가 전달되지 않았습니다.";
}

echo "<a href='list.php'>list</a>";

$conn->close();
?>

</body>
</html>
