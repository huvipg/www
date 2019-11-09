
<?php
//登入判断,尚未登录！请返回登录
session_start();
if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
    echo "登录成功：".$_SESSION['user'];
}else{
    echo "您还尚未登录！请返回登录~~";

    echo "<a href='login.html'>如果跳转失败请点击跳转~~</a>";

}
?>
