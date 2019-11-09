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
//echo "查询群组是否存在";
function queryid_group($chat_room_id)
{
global $conn;
    $sql="SELECT  apply FROM chat_room WHERE chat_room_id='$chat_room_id'";
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
//查询formid的群>5,限制建群
function  qu_group_formid($formid)
{global $conn;
  $sql="SELECT  * FROM chat_room WHERE room_owner='$formid'";
  $result = $conn->query($sql);
  if ($result->num_rows > 40) {
      // 输出数据
      while($row = $result->fetch_assoc())
       {
                    return 1;
       }                      }
  else {
          return 0 ;
       }
}
//创建群插入群信息
function  group_mk_formid($formid,$groupname)
{global $conn;
$member_list=$formid.";";
$room_owner=$formid;
  $sql="SELECT  * FROM  user WHERE  userid='$formid'" ;
  $result = $conn->query($sql);
                       if ($result->num_rows > 0) {
                          // 输出数据
                          while( $row = $result->fetch_assoc()) {
$self_display_name	=$row["name"]; }

      $time=date("Y/m/d h:i");                //数据库没有信息,插入sns_friend表,使用前需要注意,判断是否存在,if不存在插入,存在不做任何操作,返回对方已是你的好友,或正等待对方好友通过!
  //return array ($a,$b,$c,$aa,$bb,$cc,1,$msg,$time);
  $display_name_list=$self_display_name.";";

   $sql="INSERT INTO chat_room (member_list,display_name_list,room_owner,self_display_name,group_time,chat_room_nick) VALUES('$member_list','$display_name_list','$room_owner','$self_display_name','$time','$groupname')";

              if (mysqli_query($conn, $sql)) {
                 echo '{"aks":"'.$formid.'", "token":200,"warning":"'.'建群成功!"}';
                 $groupid=mysqli_insert_id($conn);
              } else {
                 echo "Error: " . $sql . "" . mysqli_error($conn);
                 $groupid=1;
              }



}
else {
  //return array('NO');
                 $groupid=0;
}
return $groupid;
}


//先查询获取user的group表,把群id.$group 更新到 group表中.

function add_groupid_user($formid,$groupid)
{
global $conn;
$sql="SELECT  * FROM  user WHERE  userid='$formid'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
      // 输出数据
      while($row = $result->fetch_assoc())
       {
         @$group=$row['allgroup'];


       }
       $upgroup=$groupid.'-'.$group;
       echo "allgroup:".$upgroup;

       $sql="UPDATE user SET allgroup='$upgroup' WHERE (userid='$formid')";
       //UPDATE `user` SET headsrc="form_id_name" WHERE (userid=`$formid`)
       $retval = mysqli_query( $conn,$sql);
       if(! $retval )
       {
           die('无法更新数据: ' . mysqli_error($conn));
       }
       else {
            //echo '{"aks":"'.$formid.'", "token":200,"warning":"'.'群id已添加到用户表!"}';
       }




                    }
  else {
          return 0 ;
       }
}



@$formid= $_GET['formid'];
//fromid=&groupname=&&token=ddd
@$groupname= $_GET['groupname'];
@$token=$_GET['token'];


          if(jquser($formid,$token)==1){
          //  echo "授权成功";
          if (qu_group_formid($formid)==1) {
            echo "您已经建立了5个群,不能再新建群!";
            // code...
          } else {
            // code...
          $xid= group_mk_formid($formid,$groupname);
          if ($xid==1||$xid==0) {
            // code...
          } else {
          //  echo "刚才插入的id:".$xid;
add_groupid_user($formid,$xid);
          }

          }
}
          else {
          //echo "授权失败";
          }
$conn->close();









 ?>
