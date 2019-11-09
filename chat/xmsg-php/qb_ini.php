<?php
header("Content-Type: text/html;charset=utf-8");
$servername = "localhost";
$username = "hvp";
$password = "huvip4912";
$dbname = "msg";
// 创建连接
$conn = new mysqli($servername, $username, $password, $dbname);
 $program_char = "utf8" ;
 mysqli_set_charset( $conn , $program_char );
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}
?>
