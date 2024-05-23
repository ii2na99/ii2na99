<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>회원가입</title>
</head>


<body>
        <h2>수정</h2>
        echo "<form method='post' action='rewrite.php'>";
                echo "<input type='hidden' name='post_id' value='" . $post_id . "'>";
                echo "<textarea name='updated_content' placeholder='수정할 내용'></textarea><br>";
                echo "<input type='submit' name='update_button' value='게시글 수정'>";
                echo "</form>";
        </form>
    </body>
    
</html>
