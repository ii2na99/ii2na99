<!DOCTYPE html>
<html>
<head>
    <title>게시판</title>
</head>
<body>

<h1> list </h1>

<?php
// DB 정보
$host = 'localhost';
$user = 'root';
$password = 'cong99';
$database = 'cong';


$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("연결실패: " . $conn->connect_error);
}


$sql = "SELECT * FROM posts";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    
    while($row = $result->fetch_assoc()) {
        
        echo "<h2><a href='view.php?id=" . $row["id"] . "'>" . $row["title"]. "</a></h2>";
        echo "<p>작성자: " . $row["author"]. " | 작성일: " . $row["created_at"]. "</p>";
        echo "<form method='post' action='deleteposts.php'>";
        echo "<input type='hidden' name='post_id' value='" . $row["id"] . "'>";
        echo "<input type='submit' name='delete_button' value='삭제'>";
        echo "</form>";
        echo "<hr>";
        echo "<hr>";
    }
} else {
    echo "게시글이 없습니다.";
}
$conn->close();
?>


<a href="writes.php"> !write! </a>
<a href="mains.php">  [home] </a>

</body>
</html>