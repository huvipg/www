<?php
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
   $sql="SELECT  apply,room_owner,member_list  FROM chat_room WHERE chat_room_id='$chat_room_id'";
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


function  aks_group($formid,$groupid)
{global $conn;
  $n=0;
  $c=0;
  //100代表无数据
if (queryid_group($groupid)!=100) {
    list($apply,$room_owner,$member_list) =queryid_group($groupid);

    $form_id_name=$formid.'#'.$apply;
    $array_apply=explode('#', $apply);
    $array_member=explode(';', $member_list);
    $unarray_member=array_filter($array_member);
    $unarray_apply=array_filter($array_apply);
  //  print_r($unarray_apply);

    foreach ($unarray_apply as $value) {
      if($value==$formid){
        $n++;
      }
  }
  foreach ($unarray_member as $value) {
      if($value==$formid){
        $c++;
      }
  }
//  echo "C:",$c;

if($room_owner==$formid){
  echo "管理员已是成员,不能添加!";
}
else {
//  echo "现在添加请求apply的数据";
//如果数据为空插入数据 如果请求到apply数据 把apply分割成数组 用数组下标比对formid 如果相等 重复 什么也不做
//先管理员鉴权,成功?如果请求到apply数据 把apply分割成数组
//用数组下标比对toid 如果相等  apply数组删除再合成apply再更新apply列
//再把toid添加到member_list 列中
  if (($c==0 && $n==0)) {
    up_apply($formid,$groupid);
  } else if ($n>0||$c>0) {
  //echo "您已请求添加群,重复添加";
  echo '{"aks":"'.$formid.'", "token":300,"warning":"'.'您已请求添加群,重复添加!或者他已在群中!"}';
          // code...
        } else if ($n==0&&$c==0) {

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
}


}


else {
 echo '{"aks":"'.$formid.'", "token":300,"warning":"'.'该群id不存在!"}';
}
}

function  up_apply($formid,$groupid)
{global $conn;
  if (queryid_group($groupid)!=100) {
      list($queryid_group,$room_owner,$member_list) =queryid_group($groupid);
  }
  //echo "apply#:".$queryid_group;
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

@$formid= $_GET['formid'];
@$groupid= $_GET['groupid'];
@$token=$_GET['token'];
@$msg=$_GET['msg'];
//echo "申请入群函数:\n";
//formid_aks_group($formid,$groupid);
//echo "查看申请入群函数:\n";

  if(jquser($formid,$token)==1){
  //  echo "授权成功";
aks_group($formid,$groupid);

      }

  else {
  //echo "授权失败";
  }
$conn->close();


 ?>
