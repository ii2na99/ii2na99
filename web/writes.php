<?php
session_start();

// 로그인 확인
if (!isset($_SESSION['username'])) {
    echo "로그인 후 이용해 주세요.";
    exit();
}

// DB 연결 설정
$host = 'localhost';
$user = 'root';
$password = 'cong99';
$database = 'cong';

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("연결실패: " . $conn->connect_error);
}

// 게시글 작성 폼 제출 처리
if(isset($_POST['submit'])) {
    // 입력된 데이터에서 HTML 및 스크립트 태그 제거하여 사용
    $title = htmlspecialchars($_POST['title'], ENT_QUOTES, 'UTF-8');
    $content = htmlspecialchars($_POST['content'], ENT_QUOTES, 'UTF-8');
    $author = htmlspecialchars($_POST['author'], ENT_QUOTES, 'UTF-8');

    // 파일 업로드 여부 확인
    $file_name = '';
    $file_path = '';
    if(isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        // 파일 정보 추출
        $file_name = $_FILES['file']['name'];
        $file_tmp = $_FILES['file']['tmp_name'];
        $file_size = $_FILES['file']['size'];
        $file_type = $_FILES['file']['type'];

        // 업로드 폴더 설정
        $uploadDirectory = 'uploads/';
        // 실제 파일 경로
        $file_path = $uploadDirectory . $file_name;

        // 파일 이동
        if(move_uploaded_file($file_tmp, $file_path)) {
            // 파일 업로드 성공 시 파일명과 경로를 변수에 저장
            $file_name = $_FILES['file']['name'];
            $file_path = $uploadDirectory . $file_name;
        } else {
            echo "파일 업로드 실패";
        }
    }

    // 쿼리 준비
    $stmt = $conn->prepare("INSERT INTO posts (title, content, author, file_name, file_path) VALUES (?, ?, ?, ?, ?)");
    // 바인딩
    $stmt->bind_param("sssss", $title, $content, $author, $file_name, $file_path);
    // 실행
    if ($stmt->execute()) {
        echo "<p>게시글이 성공적으로 작성되었습니다.</p>";
        // 작성 완료 후 목록 페이지로 이동
        header("Location: list.php");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

// DB 연결 종료
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>게시글 작성</title>
</head>
<body>

<!-- 게시글 작성 폼 -->
<form method="post" action="writes.php" enctype="multipart/form-data">
    <input type="text" name="title" placeholder="제목"><br>
    <textarea name="content" placeholder="내용"></textarea><br>
    <input type="text" name="author" placeholder="작성자" value="<?php echo htmlspecialchars($_SESSION['username']); ?>" readonly><br>
    <input type="file" name="file"><br>
    <input type="submit" name="submit" value="게시글 작성">
</form>

<a href="list.php"> list </a>

</body>
</html>
