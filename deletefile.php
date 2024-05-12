<?php

if(isset($_POST['post_id'])) {
    $post_id = $_POST['post_id'];

   
    include 'conn.php';

   
    $sql = "SELECT * FROM posts WHERE id='$post_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // 삭제할 파일 경로
        $file_path = 'uploads/' . $row['file_name'];
        
        
        if (file_exists($file_path)) {
            unlink($file_path); 
        }

        // DB에서 파일 정보 업데이트
        $sql_update = "UPDATE posts SET file_name='', file_data='', file_path='' WHERE id='$post_id'";
        if ($conn->query($sql_update) === TRUE) {
            echo "<p>업로드된 파일이 성공적으로 삭제되었습니다.</p>";
            header("Location: list.php");
        } else {
            echo "Error: " . $sql_update . "<br>" . $conn->error;
        }
    } else {
        echo "게시글을 찾을 수 없습니다.";
    }

    $conn->close();
} else {
    echo "게시글 ID가 전달되지 않았습니다.";
}
?>
