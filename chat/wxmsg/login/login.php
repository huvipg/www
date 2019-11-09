<?php
session_start();
include 'qb_ini.php';
if(isset($_POST)){
    //用户名不能为空
      //判断验证码是否填写并且是否正确
    if(!$_POST['code']){
        echo('验证码不能为空');
        return;
    }else if($_POST['code']!=$_SESSION['code']){
        echo('验证码不正确');
        return;
    }
    $username=$_POST['username'];
    $pwd=$_POST['password'];
    $sql="select * from user where username = '{$_POST['username']}' and password='{$_POST['password']}'";
    $rs=mysqli_query($conn,$sql); //执行sql查询
    $row=mysqli_fetch_assoc($rs);
    $username=$_POST['username'];
    if($row) { // 用户存在；
        if ($username == $row['username'] && $pwd == $row['password']) { //对密码进行判断。
          $userid=$row['userid'];
          $token=$row['token'];
            echo "登陆成功，正在为你跳转至后台页面";

            $_SESSION['userid'] = $userid;
            $_SESSION['token'] = $token;
            echo "userid is :".$userid.'</br>';
            echo "token is :".$token.'</br>';
            header("location:../index.php");
        }
    }else{
        echo "账号或密码错误" . "<br/>";
        echo "<a href='login.html'>返回登陆页面</a>";
    }
}
?>
