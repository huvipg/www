<?php
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
          return 1;
       }                      }
  else {
    $bb='{"aks":"'.$formid.'", "token":100,"warning":"鉴权失败,非法访问!"}';
    echo $bb;
          return 0 ;
       }
}

 function queryid_user($toid)
{
global $conn;
    $sql="SELECT  * FROM  user WHERE  userid='$toid'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // 输出数据
        while($row = $result->fetch_assoc())
         {
            return 1;
         }                      }
    else {
            return 0 ;
         }
}

function queryid_sns_friend ($formid,$toid)
{
  global $conn;
    $sql = "SELECT  * FROM  sns_friend WHERE ( friend_frommid ='$formid' and friend_tomid='$toid') or(friend_frommid ='$toid' and friend_tomid='$formid')";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // 输出数据
        while ($row = $result->fetch_assoc()) {
            if ($row["friend_followstate"] == 1) {
                $ismsg = "好友删除成功!";
            } else if ($row["friend_followstate"] == 2) {
                $ismsg = "好友删除失败!";

            }
            echo '{"aks":"' . $formid . '", "token":200,"warning":"' . $ismsg . '","friend_followstate":' . $row["friend_followstate"] . '}';
            return 1;
        }
    } else {
        return 0;
    }
}


function del_friend ($formid,$toid)
{global $conn;

$sql="UPDATE sns_friend SET friend_followstate='1',or_id='0' WHERE(( friend_frommid ='$formid' and friend_tomid='$toid') or(friend_frommid ='$toid' and friend_tomid='$formid'))";
//同意所有好友请求 $sql="UPDATE sns_friend SET friend_followstate=2 WHERE  2 =or_id ";
$retval = mysqli_query( $conn, $sql );
if(! $retval )
{
    die('无法更新数据: ' . mysqli_error($conn));
}
return 1;
}


@$formid= $_GET['formid'];
@$toid= $_GET['toid'];
@$token=$_GET['token'];
@$msg=$_GET['msg'];


if(jquser($formid,$token)==1){
// echo "授权成功";
del_friend ($formid,$toid);
 queryid_sns_friend ($formid,$toid);
}
else {

//echo "授权失败";
}








$conn->close();









 ?>
