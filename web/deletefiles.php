<?php
if(isset($_POST['post_id'])) {
    $post_id = $_POST['post_id'];
    
    include 'conn.php';
    
    // 준비된 문(Prepared Statements)을 사용하여 SQL 인젝션 방지
    $stmt = $conn->prepare("SELECT * FROM posts WHERE id=?");
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // 삭제할 파일 경로
        $file_path = 'uploads/' . $row['file_name'];

        // 파일 존재 여부 확인 후 삭제
        if (file_exists($file_path)) {
            unlink($file_path);
        }

        // DB에서 파일 정보 업데이트
        $sql_update = "UPDATE posts SET file_name='', file_data='', file_path='' WHERE id=?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("i", $post_id);
        if ($stmt_update->execute()) {
            echo "<p>업로드된 파일이 성공적으로 삭제되었습니다.</p>";
            header("Location: list.php");
            exit();
        } else {
            echo "Error: " . $sql_update . "<br>" . $conn->error;
        }
        $stmt_update->close();
    } else {
        echo "게시글을 찾을 수 없습니다.";
    }
    
    $stmt->close();
    $conn->close();
} else {
    echo "게시글 ID가 전달되지 않았습니다.";
}
?>
