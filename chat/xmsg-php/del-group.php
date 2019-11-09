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

//查询群组是否存在
//echo "查询群组是否存在";
function queryid_group($chat_room_id)
{
global $conn;
   $sql="SELECT  room_owner,member_list FROM chat_room WHERE chat_room_id='$chat_room_id'";
   $result = $conn->query($sql);
   if ($result->num_rows > 0) {
       // 输出数据
       while($row = $result->fetch_assoc())
        {
$room_owner=$row["room_owner"];
$member_list=$row["member_list"];
 $return[] =$room_owner;
 $return[]=$member_list;
                     return $return;
        }                      }
   else {
           return 100 ;
        }
}

function queryid_user($id)
{
global $conn;
   $sql="SELECT * FROM user WHERE userid='$id'";
   $result = $conn->query($sql);
   if ($result->num_rows > 0) {
       // 输出数据
       while($row = $result->fetch_assoc())
        {
$allgroup=$row["allgroup"];
        }                      }
   else {
           $allgroup=100;
        }
                     return $allgroup;
}
function del_userid($formid,$groupid)
{
  global $conn;
$nu=0;
$addlist='';
if (queryid_user($formid)!=100) {
    $allgroup =queryid_user($formid);
    $array_allgroup=explode('-', $allgroup);
    $unarray_allgroup=array_filter($array_allgroup);
    foreach ($unarray_allgroup as $value) {
      if($value==$groupid){
        $nu++;
            }
      else {
      $addlist.=$value."-";
      }
  }
    //  echo "addlist:".$addlist;

       $sql="UPDATE user SET allgroup='$addlist' WHERE (userid='$formid')";
       $retval = mysqli_query( $conn,$sql);
       if(! $retval )
       {
           die('无法更新数据: ' . mysqli_error($conn));
       }
       else {
         if ($nu>0) {
$retrun=0;
         //   echo '{"aks":"'.$formid.'", "token":200,"warning":"'.'已经退出该群!"}';
         } else {
$retrun=10;
          //  echo '{"aks":"'.$formid.'", "token":300,"warning":"'.'你不在该群中!"}';
         }

       }

  }
  else {
$retrun=-1;
    //echo "查无user数据!";
  }
  return $retrun;

}


function  del_in_group($formid,$groupid)
{global $conn;
  $addlist='';
  $nu=0;
  if (queryid_group($groupid)!=100) {
      list($room_owner,$member_list) =queryid_group($groupid);
    //  echo "获取到的member:".$member_list;
    //http://149.28.27.116/cs_msg/del-group.php?formid=12&groupid=2&token=ccc formid=用户id
      $array_member_list=explode(';', $member_list);
      $unarray_member_list=array_filter($array_member_list);
      $group_id_list=$formid.';'.$member_list;
      foreach ($unarray_member_list as $value) {
        if($value==$formid){
          $nu++;
              }
        else {
        $addlist.=$value.";";
        }
    }
      //  echo "addlist:".$addlist;

         $sql="UPDATE chat_room SET member_list='$addlist' WHERE (chat_room_id='$groupid')";
         //UPDATE `user` SET headsrc="form_id_name" WHERE (userid=`$formid`)
         $retval = mysqli_query( $conn,$sql);
         if(! $retval )
         {
             die('无法更新数据: ' . mysqli_error($conn));
         }
         else {
           if ($nu>0) {
             $retrun=0;
            //  echo '{"aks":"'.$formid.'", "token":200,"warning":"'.'已经退出该群!"}';
           } else {
             $retrun=10;
             // echo '{"aks":"'.$formid.'", "token":300,"warning":"'.'你不在该群中!"}';
           }

         }

  }
  else {
       $retrun=-1;
  //  echo "查无数据!";
  }

return $retrun;
}

/*
chat_room&order%5B0%5D=member_list
如果重复就删除
*/

function  admin_token($formid,$groupid)
{global $conn;
  $sql="SELECT  room_owner FROM  chat_room WHERE   room_owner='$formid'&&chat_room_id='$groupid'";
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


@$formid= $_GET['formid'];
@$groupid= $_GET['groupid'];
@$token=$_GET['token'];
//echo queryid_user($formid);

if(jquser($formid,$token)==1){
// echo "授权成功";
//del_friend ($formid,$toid);
 //queryid_sns_friend ($formid,$formid);
$isgrouper=admin_token($formid,$groupid);
if($isgrouper==0){

$acode= del_in_group($formid,$groupid);
$bcode= del_userid($formid,$groupid);
if ($acode==0||$acode==0) {
              echo '{"aks":"'.$formid.'", "token":200,"warning":"'.'已经退出该群!"}';
} else if ($acode==10||$acode==10) {
              echo '{"aks":"'.$formid.'", "token":300,"warning":"'.'你不在该群中!"}';
}
else {
              echo '{"aks":"'.$formid.'", "token":300,"warning":"'.'查无数据!"}';
}

}
elseif ($isgrouper==1) {
  echo "群主不能退出群,只能对群进行解散、转让、升级等操作";
}
}
else {
//echo "授权失败";
}
$conn->close();

 ?>
