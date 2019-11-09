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
    $sql = "SELECT  * FROM  sns_friend WHERE   friend_frommid ='$formid' and friend_tomid='$toid'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // 输出数据
        while ($row = $result->fetch_assoc()) {
            if ($row["friend_followstate"] == 1) {
                $ismsg = "对方还没有通过你的好友验证!";
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



function mynews($formid)
{
global $conn;
$sql="SELECT  * FROM  user WHERE  userid='$formid'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
      // 输出数据
      while($row = $result->fetch_assoc())
       {
         $name=$row['name'];
         $username=$row['username'];
         $headsrc=$row['headsrc'];
$mynews=',"name":"'.$name.'",'.'"username":"'.$username.'",'.'"headsrc":"'.$headsrc.'"';
return $mynews;
       }                      }
  else {
          return '' ;
       }
}

function  friend_end_msg($formid,$id)
{global $conn;
$sql=" SELECT * FROM webim_msg where  (f_id=$formid and t_id=$id) or (f_id=$id and t_id=$formid) order by id desc limit 0,1";
$result = $conn->query($sql);
                     if ($result->num_rows > 0) {
                        // 输出数据
                            $num=0;
                        while( $row = $result->fetch_assoc()) {
    $return[]= $row['t_msg'];
   $return[]=$row['add_time'];


//$endtime=$row['add_time'];
//$endmsg=$row['t_msg'];
                        }

                      }
else { $return=''; }
return $return;
}


function  query_me_friend($formid)
{global $conn;
$sql="SELECT * FROM sns_friend where  (friend_frommid='$formid' or friend_tomid='$formid')and friend_followstate=2";
  $result = $conn->query($sql);
                       if ($result->num_rows > 0) {
                          // 输出数据
                              $num=0;
                              $josna= '{"aks":"'.$formid.'", "token":200,"warning":"'.'好友列表请求完成!'.'","data": [';
                              $josnb="";
                          while( $row = $result->fetch_assoc()) {
$a=$row['friend_frommid'];
$b=$row['friend_tomid'];
if ($a==$formid ){
  $id=$row['friend_tomid'];
  $name=$row['friend_tomname'];
  $tomavata=$row['friend_tomavatar'];
  $num+=1;
}
else {
  $id=$row['friend_frommid'];
  $name=$row['friend_frommname'];
  $tomavata=$row['friend_frommavatar'];
}
//echo '{id:'.$id.' name:'.$name.'mavata:'.$tomavata.'}';
  list($endmsg,$endtime)=friend_end_msg($formid,$id);
//echo "endmsg:",$endmsg;

$josnb .=   '{"id": "' . $id . '", "name": "' . $name . '", "msg": "' . $endmsg    . '", "time": "' . $endtime  .  '","mavata": "' . $tomavata .'"},';
}

//$josnb .=   '{"id": "' . $id . '", "name": "' . $name . '","mavata": "' . $tomavata .'"},';
//}
//$tf=mynews($formid); if ($tf!='') { //  echo $tf; }

  $josnb=substr($josnb, 0, -1);

  $josbc= "]". "} ";
  echo $josna.$josnb.$josbc;



}
}



@$formid= $_GET['formid'];
@$toid= $_GET['toid'];
@$token=$_GET['token'];
@$msg=$_GET['msg'];

if ($formid==$toid) {
    echo '{"aks":"'.$formid.'", "token":100,"warning":"你不能添加自己为好友"}';
  // code...
} else {

if(jquser($formid,$token)==1){
//  echo "授权成功";
query_me_friend($formid);
}
else {

//echo "授权失败";
}





}



$conn->close();









 ?>
