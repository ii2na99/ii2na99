<?php
$host = 'localhost';
$user = 'root';
$password = 'cong99'; 
$database = 'cong';

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("연결실패: " . $conn->connect_error);
}
?>