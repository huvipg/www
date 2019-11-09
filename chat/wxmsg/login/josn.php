<?php
//返回账号密码是否正确
include 'qb_ini.php';
session_start();
if (!$conn) {
     $httpCode=mysqli_connect_error();
}
else {
 $httpCode="yes";
}


function login($user,$pass)
{
global $conn;
		$sql="select * from user where (username = '{$user}' || email  = '{$user}' ) and password='{$pass}'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
      // 输出数据
      while($row = $result->fetch_assoc())
       {
         $return[]=$row['username'];
         $return[]=$row['password'];
         $return[]=$row['email'];

       }
       return $return;
                             }
  else {
          return 0 ;
       }
}


@$user = isset($_GET["user"]) ? $_GET["user"] : " ";
@$pass = isset($_GET["pass"]) ? $_GET["pass"] : " ";
@$code = isset($_GET["code"]) ? $_GET["code"] : " ";
if (@$code !=$_SESSION['code']){
	$code="0";}
		else {
			$code="1";
		}
		if(login($user,$pass)!=0) { // 用户存在；

      list($getuser,$getpass,$getemail) = login($user,$pass);
				if (($user == $getuser || $user == $getemail ) && $pass == $getpass) { //对密码进行判断。
						$iscode="1";

				}
		}else{
						$iscode="0";
		}


echo " {". '"httpCode":'  .'"'. $httpCode.'"'.",".  '"iscode":'  .'"'.$iscode .'"' . ",".  '"code":'  .'"'.$code .'"'    .'}';

?>
