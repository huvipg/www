
<?php
//登入判断,尚未登录！请返回登录
session_start();
$userid=$_SESSION['userid'];
$token=$_SESSION['token'];
if ((isset($userid) && !empty($userid))|| (isset($token) && !empty($token))) {
    echo "登录成功id:".$_SESSION['userid'];
    echo "token:".$_SESSION['token'];
}else{
    echo "您还尚未登录！请返回登录~~";
header("location:./login/login.html");
    echo "<a href='login.html'>如果跳转失败请点击跳转~~</a>";

}
?>
<!DOCTYPE html>
<html>
<head>

<meta charset="utf-8">
<title>仿微信电脑版聊天</title>
<link rel="stylesheet" href="css/amazeui.min.css" />
<link rel="stylesheet" href="css/main.css" />
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://cdn.staticfile.org/axios/0.18.0/axios.min.js"></script>
  <script src="http://libs.baidu.com/jquery/2.1.4/jquery.min.js"></script>
</head>
<body >
<div class="box"  >
	<div class="wechat"  >

		<div class="sidestrip" >
			<div class="am-dropdown" data-am-dropdown >
				<!--头像插件-->
				<div class="own_head am-dropdown-toggle" id="header">
          <img :src="headsrc" alt="" style="height:34px;height:34px;"/>
        </div>
				<div class="am-dropdown-content"  >
					<div class="own_head_top" id="app_me">
						<div class="own_head_top_text" >
							<p class="own_name">{{info.name}}<img src="images/icon/head.png" alt="" /></p>
							<p class="own_numb">微信号：{{info.username}}</p>
						</div>
						<img :src="info.headsrc" alt="" />
					</div>
					<div class="own_head_bottom">
						<p><span>地区</span>江西 九江</p>
						<div class="own_head_bottom_img">
							<a href=""><img src="images/icon/head_1.png"/></a>
							<a href=""><img src="images/icon/head_2.png"/></a>
						</div>
					</div>
				</div>
      </div>
			<!--三图标-->
			<div class="sidestrip_icon">
				<a id="si_1" style="background: url(images/icon/head_2_1.png) no-repeat;"></a>
				<a id="si_2"></a>
				<a id="si_3"></a>
			</div>

			<!--底部扩展键-->
			<div id="doc-dropdown-justify-js">
				<div class="am-dropdown" id="doc-dropdown-js" style="position: initial;">
					<div class="sidestrip_bc am-dropdown-toggle"></div>
					<ul class="am-dropdown-content" style="">
						<li>
							<a href="#" data-am-modal="{target: '#doc-modal-1', closeViaDimmer: 0, width: 400, height: 225}">意见反馈</a>
							<div class="am-modal am-modal-no-btn" tabindex="-1" id="doc-modal-1">
							  <div class="am-modal-dialog">
								<div class="am-modal-hd">Modal 标题
								  <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
								</div>
								<div class="am-modal-bd">
								  Modal 内容。本 Modal 无法通过遮罩层关闭。
								</div>
							  </div>
							</div>
						</li>

						<li><a href="#">备份与恢复</a></li>
						<li><a href="#">设置</a></li>
					</ul>
				</div>
			</div>
		</div>


		<!--聊天列表-->
		<div class="middle on" >
			<div class="wx_search">

			</div>
			<div class="office_text">
				<ul class="user_list" id="app_v1">

					<li  @click="aa(site,index)"  v-for="(site,index) in info"  :class = "isactive == index ? 'user_active' : '' " :id="liId(site.id)" >
						<div class="user_head"><img :src="site.mavata" /></div>
						<div class="user_text">

							<p class="user_name">{{site.name}}</p>
							<p class="user_message" :id="msgId(site.id)" >{{site.msg}}</p>
						</div>
						<div class="user_time" :id="msgId(site.id)+'time'">{{mytime(site.time)}}</div>
					</li>




				</ul>
			</div>
		</div>

		<!--好友列表-->
		<div class="middle">
			<div class="wx_search">
				<input type="text" placeholder="搜索"/>
				<button>+</button>
			</div>
			<div class="office_text">
				<ul class="friends_list">
					<li>
						<p>新的朋友</p>
						<div class="friends_box">
							<div class="user_head"><img src="images/head/1.jpg"/></div>
							<div class="friends_text">
								<p class="user_name">新的朋友</p>
							</div>
						</div>
					</li>
					<li>
						<p>公众号</p>
						<div class="friends_box">
							<div class="user_head"><img src="images/head/2.jpg"/></div>
							<div class="friends_text">
								<p class="user_name">公众号</p>
							</div>
						</div>
					</li>
					<li>
						<p>A</p>
						<div class="friends_box">
							<div class="user_head"><img src="images/head/3.jpg"/></div>
							<div class="friends_text">
								<p class="user_name">彭于晏丶plus</p>
							</div>
						</div>
						<div class="friends_box">
							<div class="user_head"><img src="images/head/4.jpg"/></div>
							<div class="friends_text">
								<p class="user_name">陈依依</p>
							</div>
						</div>
						<div class="friends_box">
							<div class="user_head"><img src="images/head/5.jpg"/></div>
							<div class="friends_text">
								<p class="user_name">毛毛</p>
							</div>
						</div>
					</li>
					<li>
						<p>B</p>
						<div class="friends_box">
							<div class="user_head"><img src="images/head/6.jpg"/></div>
							<div class="friends_text">
								<p class="user_name">苏笑言</p>
							</div>
						</div>
						<div class="friends_box">
							<div class="user_head"><img src="images/head/7.jpg"/></div>
							<div class="friends_text">
								<p class="user_name">往事不再提</p>
							</div>
						</div>
					</li>
					<li>
						<p>C</p>
						<div class="friends_box">
							<div class="user_head"><img src="images/head/8.jpg"/></div>
							<div class="friends_text">
								<p class="user_name">夏继涛</p>
							</div>
						</div>
						<div class="friends_box">
							<div class="user_head"><img src="images/head/9.jpg"/></div>
							<div class="friends_text">
								<p class="user_name">早安无恙</p>
							</div>
						</div>
						<div class="friends_box">
							<div class="user_head"><img src="images/head/10.jpg"/></div>
							<div class="friends_text">
								<p class="user_name">王鹏</p>
							</div>
						</div>
					</li>
					<li>
						<p>D</p>
						<div class="friends_box">
							<div class="user_head"><img src="images/head/11.jpg"/></div>
							<div class="friends_text">
								<p class="user_name">涨了潮了</p>
							</div>
						</div>
						<div class="friends_box">
							<div class="user_head"><img src="images/head/12.jpg"/></div>
							<div class="friends_text">
								<p class="user_name">Ktz丶中融资</p>
							</div>
						</div>
					</li>
				</ul>
			</div>
		</div>

		<!--程序列表-->
		<div class="middle">
			<div class="wx_search">
				<input type="text" placeholder="搜索收藏内容"/>
				<button>+</button>
			</div>
			<div class="office_text">
				<ul class="icon_list">
					<li class="icon_active">
						<div class="icon"><img src="images/icon/icon.png" alt="" /></div>
						<span>全部收藏</span>
					</li>
					<li>
						<div class="icon"><img src="images/icon/icon1.png" alt="" /></div>
						<span>链接</span>
					</li>
					<li>
						<div class="icon"><img src="images/icon/icon2.png" alt="" /></div>
						<span>相册</span>
					</li>
					<li>
						<div class="icon"><img src="images/icon/icon3.png" alt="" /></div>
						<span>笔记</span>
					</li>
					<li>
						<div class="icon"><img src="images/icon/icon4.png" alt="" /></div>
						<span>文件</span>
					</li>
					<li>
						<div class="icon"><img src="images/icon/icon5.png" alt="" /></div>
						<span>音乐</span>
					</li>
					<li>
						<div class="icon"><img src="images/icon/icon6.png" alt="" /></div>
						<span>标签</span>
					</li>
				</ul>
			</div>
		</div>

		<!--聊天窗口-->
		<div class="talk_window"  >
			<div class="windows_top">
				<div class="windows_top_box" id="app_f">

					<span id="f_name">暂未选择好友聊天</span>
					<span id="f_id">0</span>

		<!--隐藏样式
					<span id="f_id"style="display:none;">0<span>
    -->
					<ul class="window_icon">
						<li><a href=""><img src="images/icon/icon7.png"/></a></li>
						<li><a href=""><img src="images/icon/icon8.png"/></a></li>
						<li><a href=""><img src="images/icon/icon9.png"/></a></li>
						<li><a href=""><img src="images/icon/icon10.png"/></a></li>
					</ul>
					<div class="extend" class="am-btn am-btn-success" data-am-offcanvas="{target: '#doc-oc-demo3'}"></div>
					<!-- 侧边栏内容 -->
					<div id="doc-oc-demo3" class="am-offcanvas">
						<div class="am-offcanvas-bar am-offcanvas-bar-flip">
							<div class="am-offcanvas-content">
								<p><a href="http://music.163.com/#/song?id=385554" target="_blank">网易音乐</a></p>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!--聊天内容-->
      <div id="chatwindow" style="display:none;">
			<div class="windows_body" >
				<div class="office_text" style="height: 100%;" id="endgun">


          <ul class="content" id="chatbox" style="overflow-y:scroll;">
						<li class="me"><img src="images/own_head.jpg" title="金少凯"><span>{{allmsg}}</span></li>
						<li class="other"><img src="images/head/15.jpg" title="张文超"><span>勇夫安知义，智者必怀仁</span></li>
					</ul>
				</div>
			</div>

			<div class="windows_input" id="talkbox">
				<div class="input_icon">
					<a href="javascript:;"></a>
					<a href="javascript:;"></a>
					<a href="javascript:;"></a>
					<a href="javascript:;"></a>
					<a href="javascript:;"></a>
					<a href="javascript:;"></a>
				</div>
				<div class="input_box">
					<textarea name="" rows="" cols="" id="input_box"></textarea>
					<button id="send">发送（S）</button>
				</div>
				</div>

			</div>
		</div>
	</div>
</div>


<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/amazeui.min.js"></script>
<script type="text/javascript" src="js/zUI.js"></script>
<script type="text/javascript" src="js/wechat.js"></script>

<script type="text/javascript">
	var time = '2019年09月25日 10:43:24';
    // 时间统一函数
    function getTimeText(argument) {
        var timeS = argument;
        var todayT = ''; //
        var yestodayT = '';
        var timeCha = getTimeS(timeS);
        timeS = timeS.slice(-8);
        todayT = new Date().getHours()*60*60*1000 + new Date().getMinutes()*60*1000 + new Date().getSeconds()*1000;
        yestodayT = todayT + 24*60*60*1000;
        if(timeCha > yestodayT) {
            return argument.slice(0,11);
        }
        if(timeCha > todayT && timeCha < yestodayT) {
            return timeS.slice(0,2)>12?'昨天 下午'+(timeS.slice(0,2)==12 ? 12 : timeS.slice(0,2) - 12)+timeS.slice(2,5):'昨天 上午'+timeS.slice(0,5);
        }
        if(timeCha < todayT) {
            return timeS.slice(0,2)>=12?'下午'+(timeS.slice(0,2)==12 ? 12 : timeS.slice(0,2) - 12)+timeS.slice(2,5):'上午'+timeS.slice(0,5);
        }
        
    }
 
// 时间戳获取
    function getTimeS(argument) {
        var timeS = argument;
        timeS = timeS.replace(/[年月]/g,'/').replace(/[日]/,'');
        return new Date().getTime() - new Date(timeS).getTime() - 1000; //有一秒的误差
 
    }
    var timeText = getTimeText(time);
    console.log(time+'应该显示为   '+timeText)


document.onkeydown=function(e){
if(e.keyCode == 13 && e.ctrlKey){
                 // 这里实现换行
document.getElementById("input_box").value += "\n";
}else if(e.keyCode == 13){
// 避免回车键换行
e.preventDefault();
// 下面写你的发送消息的代码
$("#send").click();//消息发送
}
}


const formid='<?php echo $userid; ?>';
const token='<?php echo $token; ?>';
const f_find_url="http://149.28.27.116/xmsg-php/f-find-msg.php?formid="+formid+"&token="+token;
const mynews_url="http://149.28.27.116/xmsg-php/mynews.php?formid="+formid+"&token="+token;

//三图标

window.onload=function(){



	function a(){
		var si1 = document.getElementById('si_1');
		var si2 = document.getElementById('si_2');
		var si3 = document.getElementById('si_3');
		si1.onclick=function(){
			si1.style.background="url(images/icon/head_2_1.png) no-repeat"
			si2.style.background="";
			si3.style.background="";
		};
		si2.onclick=function(){
			si2.style.background="url(images/icon/head_3_1.png) no-repeat"
			si1.style.background="";
			si3.style.background="";
		};
		si3.onclick=function(){
			si3.style.background="url(images/icon/head_4_1.png) no-repeat"
			si1.style.background="";
			si2.style.background="";
		};
	};


	function b(){
     var ws = new WebSocket("ws://149.28.27.116:1094/webSocket");
     var time=CurentTime();
     var id=$('#f_id').html();
var onemsg='';
     var cmdcode=formid+"T"+id;
     ws.onopen = function()
     {
        // Web Socket 已连接上，使用 send() 方法发送数据

        var json=  {Cmdcode:99999945,UserName:formid, toId: 99999999 ,DataType: "send",Msg:onemsg,Time:time,Token:token,Type:1};

    ws.send(JSON.stringify(json));
     };

     ws.onmessage = function (evt)
     {
    //				var data= evt.data;
    var		data = JSON.parse(evt.data);



    //									console.log(data);

        console.log('data',data);
        console.log('data.Msg',data.Msg);
        console.log('formid',formid);
        console.log('id',id);


		var chat = document.getElementById('chatbox');
		

           var vid=$('#f_id').html();
        console.log('vid',vid);
        console.log('data.toid',data.toId);
        
        var timeid=data.toId+"time";
        console.log('timeid',timeid);

   var sendtime=getTimeText(CurentTime());
    $("#"+timeid).html(sendtime);

        
         $("#"+data.toId).html(data.Msg);
        
        
        if( data.Cmdcode==formid){

     $("#"+data.toId).html(data.Msg);
        }
        else {
     $("#"+data.Cmdcode).html(data.Msg);

        }


                if(data.DataType == 'send'){
                		if( data.Cmdcode==formid){
				chat.innerHTML += '<li class="me"><img src="'+'images/own_head.jpg'+'"><span>'+data.Msg+'</span></li>';

    //            $('#chatbox').innerHTML +='<li class="me"><img src="'+'images/own_head.jpg'+'"><span>'+data.Msg+'</span></li>';
                		}
                		  else if (data.Cmdcode==vid) {
				chat.innerHTML += '<li class="other"><img src="'+'images/own_head.jpg'+'"><span>'+data.Msg+'</span></li>';
                		}
}
var now = new Date();
var div = document.getElementById('endgun');
div.scrollTop = div.scrollHeight;
/*
"data": [{"id": "2", "name": "小红", "msg": "","mavata": "3624!400x400.jpeg"},
{"id": "1", "name": "小明", "msg": "","mavata": "https://a59!400x400.jpeg"},
{"id": "12", "name": "小绿", "msg": "","mavata": "form_id_name"}]
*/
//Vue.set(app1.info[1],'msg',data.msg),
     };

                        //alert(received_msg);



		var text = document.getElementById('input_box');
    var getid=document.getElementById('f_id');
		var chat = document.getElementById('chatbox');
		var btn = document.getElementById('send');
		var talk = document.getElementById('talkbox');
		btn.onclick=function(){
			if(text.value ==''){
				alert('不能发送空消息');
			}else{
var msg=text.value;
				//chat.innerHTML += '<li class="me"><img src="'+'images/own_head.jpg'+'"><span>'+text.value+'</span></li>';
				text.value = '';
				chat.scrollTop=chat.scrollHeight;
				talk.style.background="#fff";
				text.style.background="#fff";
var time=CurentTime();
var id=$('#f_id').html();
     var cmdcode=formid+"T"+id;
        var json=  {Cmdcode:formid,UserName:formid,toId: id ,DataType: "send",Msg:msg,Time:time,Token:token,Type:1};
      if(ws.readyState == 1){
        ws.send(JSON.stringify(json));
        var localTime = new Date().getTime(); //当前系统时间
 const inmsg='http://149.28.27.116:11111/inmsg/' +formid+ '/' +id+ '/' + localTime + '/'+msg;


          	 console.log("插入msg",inmsg);
             $.ajax({
                 type: "get",
                 url: inmsg,
                 dataType: "jsonp",		//这个设置可以允许跨域调用js
                 jsonpCallback: "myjson",	//这个很重要,是根据跨域目标服务器上返回的json数据中的函数起名
                 success: function(data) {
          	 console.log("请求data",data);
if(data.aks==200)
{
   console.log("插入msg成功");

}
}
});
      }else{
        alert("聊天已中断！");
      }

      };
		};
	};
	a();
	b();
  //WebSocketTest(999999,'','')
};
</script>
<script type="text/javascript">

</script>
<script type = "text/javascript">

var app1 =new Vue({

  el: '#app_v1',
  data () {
    return {
      info: null,
      allmsg:null,
      isactive :null
    }
  },
  
  /* 定时执行
  created: function () {
            setInterval(this.mytime, 1000*60);
        },
       */ 
	methods:{
		liId:function(index){
						return "liId_" +index
					},

	msgId:function(index){
						return index
					},
					
  mytime:function(site){
  	const JUST_NOW = 3000; //3s内
const IN_SECOND = 1000 * 60; //一分钟
const IN_MINUTE = 1000 * 60 * 60; //一小时
const IN_HOUR = 1000 * 60 * 60 * 12; //12小时
const IN_DAY = 1000 * 60 * 60 * 24 * 1; //1天
const IN_MONTH = 1000 * 60 * 60 * 24 * 30; //1个月
           var localTime = new Date().getTime(); ; //当前系统时间
           console.log("当前系统时间",localTime);
            
  var createTime = site;//消息创建时间
  console.log("消息创建时间",createTime);
  var diff = localTime - createTime;
  if (diff <= JUST_NOW)
  {
  	    return '刚刚';
  }

  else if (diff <= IN_SECOND)
{
	return "1分钟内";
}   
 else if (diff <= IN_MINUTE)
 	{
 		return parseInt(diff / IN_SECOND) + '分钟前';
 	}
    
  else if (diff >= IN_MINUTE &&diff<IN_DAY) {
	 return parseInt(diff / IN_MINUTE) + '小时前';
}
   
  else if (diff>=IN_DAY&&diff <= IN_DAY * 7) {
      return parseInt(diff / IN_DAY) + '天前';
    }
else if (diff > IN_DAY * 7) {
  	 var dateType = "";
  var date = new Date();
  date.setTime(createTime);
//  dateType += date.getFullYear();  //年
  dateType += date.getMonth()+"月"; //月
  dateType += date.getDay()+"日";  //日
  return dateType;
  }

  
  
                  },


        aa (site,index){


				//	WebSocketTest(site.id,site.name,site.mavata);
//这里写get 接口获取全部聊天数据
//http://149.28.27.116:8888/allmsg/10/11/aaa



	 console.log("好友名称",site.name);
	 console.log("我的id",formid);
	 console.log("我的token",token);

	 console.log("好友id",site.id);
   $("#f_name").html(site.name);
   $("#f_id").html(site.id);
          //alert(site.id);
$('#chatbox li').remove()

          const getallmsg='http://149.28.27.116:8888/allmsg/'+formid+'/'+site.id+'/'+token


          	 console.log("请求allmsg_url",getallmsg);
             $.ajax({
                 type: "get",
                 url: getallmsg,
                 dataType: "jsonp",		//这个设置可以允许跨域调用js
                 jsonpCallback: "myjson",	//这个很重要,是根据跨域目标服务器上返回的json数据中的函数起名
                 success: function(data) {
          	 console.log("请求data",data);
if(data.aks==100)
{
   console.log("请求data数据为空",data.aks);

}
else if (data.aks==300) {
   console.log("请求data数据",data.aks);

};



		var chat = document.getElementById('chatbox');

           var vid=$('#f_id').html();
        console.log('vid',vid);
if(data.cmd == 'allmsg'){
		var msg = '';
    var mm='';
    var car='';
    var i=0;
		for( i in data.msg){
      if( data.msg[i].form==formid){
  msg +='<li class="me"><img src="'+'images/own_head.jpg'+'"><span>'+data.msg[i].msg+'</span></li>';
    mm=msg;
  		}
      else
       {
  msg +='<li class="other"><img src="'+'images/own_head.jpg'+'"><span>'+data.msg[i].msg+'</span></li>';
      }
		}
		chat.innerHTML = msg;
}
var now = new Date();
var div = document.getElementById('endgun');
div.scrollTop = div.scrollHeight;
                   //$("#dd0").html(data.bmnum);
                 }
               });
if(site.id>0){
  $("#chatwindow").show();
}
 this.isactive = index
        }
    },
  mounted () {
    axios
		      .get(f_find_url)
    .then(response => (this.info = response.data.data))
//      .then((response) => { // this.user = response.data this.info = response.data.data })
      .catch(function (error) { // 请求失败处理
        console.log(error);
      });
  }
})

var app2 =new Vue({

  el: '#app_me',
  data () {
    return {
      info: null
    }
  },
  mounted () {
    axios
		      .get(mynews_url)
      .then(response => (this.info = response.data))
      .catch(function (error) { // 请求失败处理
        console.log(error);
      });
  }
})

var app3 =new Vue({

  el: '#header',
  data () {
    return {
      headsrc:null
    }
  },
  mounted () {
    axios
		      .get(mynews_url)
      .then(response => (this.headsrc = response.data.headsrc))
      .catch(function (error) { // 请求失败处理
        console.log(error);
      });
  }
})



</script>
<script type="text/javascript">
	
	


function CurentTime()
    {
        var now = new Date();

        var year = now.getFullYear();       //年
        var month = now.getMonth() + 1;     //月
        var day = now.getDate();            //日

        var hh = now.getHours();            //时
        var mm = now.getMinutes();          //分
        var ss = now.getSeconds();           //秒

        var clock = year + "-";

        if(month < 10)
            clock += "0";

        clock += month + "-";

        if(day < 10)
            clock += "0";

        clock += day + " ";

        if(hh < 10)
            clock += "0";

        clock += hh + ":";
        if (mm < 10) clock += '0';
        clock += mm + ":";

        if (ss < 10) clock += '0';
        clock += ss;
        return(clock);
}

</script>



</body>
</html>
