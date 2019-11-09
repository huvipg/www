<?php
session_start();
header("content-type:text/html;charset=utf-8");
//连接数据库
$link = mysqli_connect("localhost","hvp","huvip4912","msg");
if (!$link) {
    die("连接失败: " . mysqli_connect_error());
}
if(isset($_POST)){
    //判断验证码是否填写并且是否正确
     if($_POST['code']!=$_SESSION['code']){
        echo('验证码不正确');
        return;
    }
    $username=$_POST['username'];
    $pwd=$_POST['password'];
    $email=$_POST['email'];
    $time= date("Y/m/d H:i:s");
echo $username,$pwd;
    $sql="select * from user where username = '{$_POST['username']}' or email='{$_POST['email']}'";
    $rs=mysqli_query($link,$sql); //执行sql查询
    $row=mysqli_fetch_assoc($rs);
    $username=$_POST['username'];
    if($row) { // 用户存在；
        if ($username == $row['username'] || $email == $row['email']) { //对密码进行判断。
            echo "用户名已经注册";

        }
    }else{
      $sql="INSERT INTO form(username,password,email,time) VALUES('$username','$pwd','$email','$time')";
    mysqli_query($link,$sql); //执行sql查询
              header("location:login.html");

    }
}
?>
