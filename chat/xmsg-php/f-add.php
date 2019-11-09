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

function  up_or_id($formid,$toid)
{global $conn;
  $sql="UPDATE sns_friend SET or_id='0033' WHERE (or_id='$formid') and (( friend_frommid ='$formid' and friend_tomid='$toid') or(friend_frommid ='$toid' and friend_tomid='$formid'))";
//同意所有好友请求 $sql="UPDATE sns_friend SET friend_followstate=2 WHERE  2 =or_id ";
$retval = mysqli_query( $conn, $sql );
if(! $retval )
{
    die('无法更新数据: ' . mysqli_error($conn));
}
return 1;
}

function queryid_sns_friend ($formid,$toid)
{
  global $conn;
    $sql = "SELECT  * FROM  sns_friend WHERE   friend_frommid ='$formid' and friend_tomid='$toid'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // 输出数据
        while ($row = $result->fetch_assoc()) {
            if ($row["friend_followstate"] == 1) {
                $ismsg = "好友请求已发送,对方还没有通过你的好友验证!";

            } else if ($row["friend_followstate"] == 2) {
                $ismsg = "对方已经是你的好友!";
            }
            echo '{"aks":"' . $formid . '", "token":200,"warning":"' . $ismsg . '","friend_followstate":' . $row["friend_followstate"] . '}';
            return 1;
        }
    } else {
        return 0;
    }
}

function  query_youme_user($formid,$toid)
{global $conn;
  global $msg;
  $sql="SELECT  * FROM  user WHERE  userid='$formid' or userid='$toid'" ;
  $result = $conn->query($sql);
                       if ($result->num_rows > 0) {
                          // 输出数据
                              $num=0;
                          while( $row = $result->fetch_assoc()) {
          if($num==0){ $num+=1; $a=$row["userid"]; $b=$row["name"]; $c=$row["headsrc"]; }
if ($num==1) { $aa=$row["userid"]; $bb=$row["name"]; $cc=$row["headsrc"]; }
                }
      $time=date("Y/m/d h:i");                //数据库没有信息,插入sns_friend表,使用前需要注意,判断是否存在,if不存在插入,存在不做任何操作,返回对方已是你的好友,或正等待对方好友通过!
 //return array ($a,$b,$c,$aa,$bb,$cc,1,$msg,$time);

 $sql="INSERT INTO sns_friend (friend_frommid,friend_frommname,friend_frommavatar,friend_tomid,friend_tomname,friend_tomavatar,friend_followstate,one_msg,friend_addtime,or_id) VALUES('$a','$b','$c','$aa','$bb','$cc',1,'$msg','$time','$toid')";

            if (mysqli_query($conn, $sql)) {
               echo '{"aks":"'.$formid.'", "token":200,"warning":"'.'好友请求已发送,请等待对方通过!"}';
            } else {
               echo "Error: " . $sql . "" . mysqli_error($conn);
            }


}
else {
  //return array('NO');
}
}

@$formid= $_GET['formid'];
@$toid= $_GET['toid'];
@$token=$_GET['token'];
@$msg=$_GET['msg'];

if ($formid==$toid) {
    echo '{"aks":"'.$formid.'", "token":100,"warning":"你不能添加自己为好友"}';
                    }
else {

          if(jquser($formid,$token)==1){
          //  echo "授权成功";

            if(queryid_user($toid)==1){
              //echo "id存在";
              if (queryid_sns_friend($formid, $toid) == 1 || queryid_sns_friend($toid, $formid) == 1) {
                up_or_id($formid,$toid);
                }
               else {
              //  echo "没查到朋友表,插入数据到朋友表";
                query_youme_user($formid,$toid);
              }
                                    }
            else {
              //echo "id不存在";
              echo '{"aks":"'.$formid.'", "token":200,"warning":"'.'您输入用户id有误,该用户不存在"}';
            }
            }

          else {
          //echo "授权失败";
          }
  }








$conn->close();









 ?>
