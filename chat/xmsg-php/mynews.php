<?php
header("Content-Type: text/html; charset=UTF-8");
include 'qb_ini.php';


function jquser($formid,$token)
{
global $conn;
$sql="SELECT  * FROM  user WHERE  userid='$formid'&&token='$token'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
      // 输出数据
      while($row = $result->fetch_assoc())
       {
         $name=$row['name'];
         $username=$row['username'];
         $headsrc=$row['headsrc'];
    echo '{"aks":"'.$formid.'", "token":200,"warning":"获取个人信息!","name":"'.$name.'",'.'"username":"'.$username.'",'.'"headsrc":"'.$headsrc.'"}';

       }                      }
  else {
    $bb='{"aks":"'.$formid.'", "token":100,"warning":"鉴权失败,非法访问!"}';
    echo $bb;
          return 0 ;
       }
}


@$formid= $_GET['formid'];
@$token=$_GET['token'];

jquser($formid,$token);



 ?>
