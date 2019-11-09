<?php
/*
*/
//鉴权成功 fomid token 查询 user
//再查询是否好友, sns_friend 不存在就查询 两个 user用户表 再插到sns_friend中
include 'qb_ini.php';
//鉴权
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
   $sql="SELECT  apply,room_owner,member_list FROM chat_room WHERE chat_room_id='$chat_room_id'";
   $result = $conn->query($sql);
   if ($result->num_rows > 0) {
       // 输出数据
       while($row = $result->fetch_assoc())
        {
$apply=$row["apply"];
$room_owner=$row["room_owner"];
$member_list=$row["member_list"];
 $return[] =$apply;
 $return[] =$room_owner;
 $return[]=$member_list;
                     return $return;
        }                      }
   else {
           return 100 ;
        }
}




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

//如果数据为空插入数据 如果请求到apply数据 把apply分割成数组 用数组下标比对formid 如果相等 重复 什么也不做
//先管理员鉴权,成功?如果请求到apply数据 把apply分割成数组
//用数组下标比对toid 如果相等  apply数组删除再合成apply再更新apply列
//再把toid添加到member_list 列中
function  find_f($formid,$toid,$groupid)
{global $conn;
  $n=0;
  if (queryid_group($groupid)!=100) {
      list($apply,$room_owner,$member_list) =queryid_group($groupid);
  }
  else {
    echo "数据库没有信息";
  }
  $array_member_list=explode(';', $member_list);
  $unarray_member_list=array_filter($array_member_list);
//  print_r($unarray_apply);
foreach ($unarray_member_list as $value) {
if($value==$toid){
   $n++;
}
}
  return $n;
}


function  admin_or_id($formid,$toid,$groupid)
{global $conn;
  $addlist='';
  $nu=0;
  if (queryid_group($groupid)!=100) {
      list($apply,$room_owner,$member_list) =queryid_group($groupid);
  }
  else {
    echo "数据库没有信息";
  }
  $array_apply=explode('#', $apply);
  $unarray_apply=array_filter($array_apply);
//  print_r($unarray_apply);

  $group_id_list=$toid.';'.$member_list;
  foreach ($unarray_apply as $value) {
    if($value==$toid){
      $nu++;
  $sql="UPDATE chat_room SET member_list='$group_id_list' WHERE (chat_room_id='$groupid')";
  $retval = mysqli_query( $conn, $sql );
  if(! $retval )
  {
      die('无法更新数据: ' . mysqli_error($conn));
  }
  else {
      // echo '{"aks":"'.$toid.'", "token":200,"warning":"'.'申请入群已通过!添加申请id到member_list表中"}';

  }
    }
    else {
    $addlist=$value."#";
    }
}
//echo "addlist:".$addlist;

$sql="UPDATE chat_room SET apply='$addlist' WHERE (chat_room_id='$groupid')";
$retval = mysqli_query( $conn, $sql );
if(! $retval )
{
    die('无法更新数据: ' . mysqli_error($conn));
}
else {
/*
echo "apply:",$apply;
echo "addlist:",$addlist;
echo "member_list:",$member_list;
*/
$isgourp=find_f($formid,$toid,$groupid);
if ($isgourp>0) {
  add_groupid_user($toid,$groupid);
     echo '{"aks":"'.$toid.'", "token":200,"warning":"'.'入群成功,该用户现已是群成员!"}';
}
else if($isgourp==0){
     echo '{"aks":"'.$toid.'", "token":200,"warning":"'.'入群失败!"}';

}

}
}
function  up_apply($formid,$groupid)
{global $conn;
  if (queryid_group($groupid)!=100) {
      list($queryid_group,$room_owner) =queryid_group($groupid);
  }
  echo "apply#:".$queryid_group;
  $form_id_name=$formid.'#'.$queryid_group;
  $sql="UPDATE chat_room SET apply='$form_id_name' WHERE (chat_room_id='$groupid')";
  $retval = mysqli_query( $conn, $sql );
  if(! $retval )
  {
      die('无法更新数据: ' . mysqli_error($conn));
  }
  else {
       echo '{"aks":"'.$formid.'", "token":200,"warning":"'.'已申请入群,请等待管理员通过!"}';

  }
}


function query_allgroup($formid,$groupid)
{
global $conn;
$n=0;
$sql="SELECT  * FROM  user WHERE  userid='$formid'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
      // 输出数据
      while($row = $result->fetch_assoc())
       {
         @$group=$row['allgroup'];
       }
       $array_list_allgroup=explode('-', $group);
       $unarray_list_allgroup=array_filter($array_list_allgroup);
     //  print_r($unarray_apply);
     foreach ($unarray_list_allgroup as $value) {
      // echo "list_allgroup:".$value."</br>";
     if($value==$groupid){
        $n++;
      //  echo "用户群列表重复重复";
        $group=11;
     }
     }

     }
     else {
         $group=0;
     }
     return $group;
   }



//先查询获取user的group表,把群id.$group 更新到 group表中.

function add_groupid_user($formid,$groupid)
{
global $conn;
//先获取user $allgroup=$row['allgroup'];
//$list_allgroup - 分割 $allgroup
//循环 L_a 值判断>=1 不执行更新
$group=query_allgroup($formid,$groupid);
if ($group==0) {
  $group='';
}
elseif ($group==11) {
  // code...
}
else {

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




}



@$formid= $_GET['formid'];
@$toid= $_GET['toid'];
@$groupid= $_GET['groupid'];

@$token=$_GET['token'];
@$msg=$_GET['msg'];
//echo "申请入群函数:\n";
//formid_aks_group($formid,$groupid);
//echo "查看申请入群函数:\n";

  if(jquser($formid,$token)==1){
  //  echo "授权成功";
  if (admin_token($formid,$groupid)==1) {
admin_or_id($formid,$toid,$groupid);
  } else {
     echo '{"aks":"'.$formid.'", "token":100,"warning":"'.'你没有管理群权限!"}';
  }


      }

  else {
  //echo "授权失败";
  }
$conn->close();









 ?>
