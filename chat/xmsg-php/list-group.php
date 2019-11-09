<?php
include 'qb_ini.php';//鉴权
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



function  member_list($formid,$groupid)
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
$josna= '{"aks":"'.$formid.'", "token":200,"warning":"'.'群成员列表请求完成!'.'","data": [';
$josnb="";

foreach ($unarray_member_list as $value) {
  $n++;

  $josnb .= '{"member_list":'.$value.'},';
}
$josnb=substr($josnb, 0, -1);
$josbc= "]". "} ";
if ($n<=0) {
  echo '{"aks":"'.$formid.'", "token":300,"warning":"'.'群成员列表为空,还没人加入!"}';
  }
  else {
    echo $josna.$josnb.$josbc;
  }
}


function  apply($formid,$groupid)
{global $conn;
  $n=0;
  if (queryid_group($groupid)!=100) {
      list($apply,$room_owner,$member_list) =queryid_group($groupid);
  }
  else {
    echo "数据库没有信息";
  }

  $array_apply=explode('#', $apply);
  $unarray_apply=array_filter($array_apply);
//  print_r($unarray_apply);
$josna= '{"aks":"'.$formid.'", "token":200,"warning":"'.'群申请列表请求完成!'.'","data": [';
$josnb="";

foreach ($unarray_apply as $value) {
  $n++;
  $josnb .= '{"apply":'.$value.'},';
}
$josbc= "]". "} ";


if ($n<=0) {
//  echo "apply:没有人申请加群!";
echo '{"aks":"'.$formid.'", "token":300,"warning":"'.'暂没申请入群!"}';
}
else {
  echo $josna.$josnb.$josbc;
}
}
/*
"data": [{
  "id": "1",
  "name": "小明",
  "mavata": "http://a.com/a1.png"
}, {
  "id": "12",
  "name": "小绿",
  "mavata": "http://a.com/c3.png"
}, {
  "id": "13",
  "name": "小天",
  "mavata": "http://a.com/d3.png"
}]
}
*/

@$formid= $_GET['formid'];
@$toid= $_GET['toid'];
@$groupid= $_GET['groupid'];
@$token=$_GET['token'];
@$opt=$_GET['opt'];


if(jquser($formid,$token)==1){
//  echo "授权成功";
if (admin_token($formid,$groupid)==1) {
  if ($opt=="grouper") {
member_list($formid,$groupid);

} else if ($opt=="applyer") {
apply($formid,$groupid);

  }

} else {
   echo '{"aks":"'.$formid.'", "token":100,"warning":"'.'你没有管理群权限!"}';
}
    }

else {
//echo "授权失败";
}



 ?>
