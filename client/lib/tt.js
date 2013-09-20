var 
  data,
  event_count=8;

function login()//登陆，登陆后记录用户信息
{
  console.log("登陆");
  var e=$("#email").val(),
      p=$("#password").val();
  if( e == '' )
  {
    alert("邮箱不能为空！");
    return false;
  } 
  if( p == '' )
  {
    alert("password can't be empty");
    return false;
  }
  
  $("#login_button").val("登录中..");
  
  var email = $('#email').val();
  var password = $('#password').val();
  var key = Base64.encode(email+':'+password);
  var url="http://ttevent.sinaapp.com/api.php/Public/login"
  $.post( url , { 'key':key },
    function(ret){
      console.log(data);
      var data = $.parseJSON( ret );
      if(data.status == 0)
      {
        alert("错误的账号或密码！"); 
        $( "#login_button" ).val( "登录" );
      }
      else{
        kset( "u_token" , data.info.token);
        kset( "u_id" , data.info.user.id)
        kset( "u_email" , $("#email").val() );
        kset( "u_password" , $("#password").val() );
        kset( "u_nickname" , data.info.user.nickname);
        kset( "u_event_count", data.info.user.event_count);
        kset( "u_event_follow" , data.info.user.event_follow);
        kset( "u_event_join" , data.info.user.event_jion);
        kset( "u_status",data.info.user.status);
        kset( "u_update_time",getDate(data.info.user.update_time));
        kset( "u_img",data.info.user.small_img);
        kset( "u_real_name",data.info.user.real_name);
        kset( "u_event_email",data.info.user.event_email);
        kset( "u_mobile",data.info.user.mobile);
        change_page( "hotevent" );
      }
    }
    );
}

function register()
{
  
}

function hotevent_init()
{
  console.log("热门活动");
  $.post( 'http://ttevent.sinaapp.com/api.php/Public/getHotestEvents', event_count ,
  function(ret){
    var data= $.parseJSON(ret),
        str='';
    for (var i = 0; i < event_count; i++) {
    var img = data.info.events[i].small_img,
        name= data.info.events[i].name,
        id = data.info.events[i].id,
        time = getDate(data.info.events[i].start_time) + ' — ' + getDate(data.info.events[i].end_time),
        location = data.info.events[i].city + ' ' + data.info.events[i].area + ' ' + data.info.events[i].location;
      str+='<li><a href="#event_detail" onclick="f_event_detail('+ trim(id) +');" data-event_id ="' + id +'"><img src="' + img + '"><h3>'+ name +'</h3><p>时  间：' + time + '<br />地  点：' + location + '<br />主办方：' + data.info.events[i].user.nickname + '</p></a><li>';
      }
      $("#he-list").html(str);
  });
}

  
//controllers.event ={
 // pageshow: 
function f_event_detail(eid){//活动详情
  console.log("活动详情:" + eid);
  kset( 'current_eid' , eid );
  $.post( 'http://ttevent.sinaapp.com/api.php/Public/getEventInfo',{ id : eid , token : kget( 'u_token')},
    function(ret){
      var data= $.parseJSON(ret);
        $("#event_detail_tmpl").html( $.tmpl("event_detail_tpl", {'item':data.info.event}) );
  });
}

function event_follow(eid){//关注活动
  console.log("关注活动");
  tt_confirm( '确认关注此活动吗？' , function()
  {
      $.post( 'http://ttevent.sinaapp.com/api.php/EventFollow/follow',{ event_id : eid , token : kget( 'u_token' )},
    function(ret){
      var edata= $.parseJSON(ret);
      if (edata.status == 1 ) {
        $( "#b_event_follow" ).val( "取消关注" );
        var t="event_unfollow("+ eid +")";
        $( "#b_event_follow" ).attr( "onclick", t );
        console.log("关注成功！");
        tt_alert("关注成功！");
      }else{
        console.log("啊哦，关注失败");
        tt_alert("啊哦，关注失败");
      }
    });
  });
}

function event_unfollow(eid){//取消关注
  console.log("取消活动");
  $.post( 'http://ttevent.sinaapp.com/api.php/EventFollow/unfollow',{ token : kget( 'u_token' ), event_id : eid },
  function(ret){
    var edata= $.parseJSON(ret);
    if (edata.status == 1 ) {
      $( "#b_event_follow" ).val( "关注" );
      var t="event_follow("+ eid +")";
      $( "#b_event_follow" ).attr( "onclick", t );
      console.log("取消关注成功！");
    }
  });
}

function event_join(eid){//参加活动
  console.log("参加活动");
  var e=$("#event_email").val(),
      n=$("#real_name").val(),
      m=$("#mobile").val(),
      eid =kget(event_join_id);
  $.post( 'http://ttevent.sinaapp.com/api.php/EventJoin/join',{ token : kget( 'u_token' ), event_id : eid, event_email : e, real_name : n, mobile : m },
  function(ret){
    var edata= $.parseJSON(ret);
    if (edata.status == 1 ) {
      $( "#b_event_join" ).val( "退出" );
      var t="event_unfollow("+ eid +")";
      $( "#b_event_join" ).attr( "onclick", t );
    console.log("参与活动成功！");
    }
  });
}

function event_unjoin(eid){//取消参加
  console.log("取消参加");
  $.post( 'http://ttevent.sinaapp.com/api.php/EventJoin/unjoin',{ token : kget( 'u_token' ), event_id : eid },
  function(edata){
    if (edata.status == 1 ) {
      $( "#b_event_join" ).val( "参与" );
      $( "#b_event_join" ).attr( "onclick","#event_join");
    console.log("取消参与成功！");
    }
  });
}

function QRscan(){
  sina.barcodeScanner.scan( function(result) {
    var eid = result.text.slice(41);
    tt_confirm('扫描成功，是否查看该活动详细信息？', function(){
      document.location.href("#event_detail");
      $.post( 'http://ttevent.sinaapp.com/api.php/Public/getEventInfo',{ id : eid , token : kget( 'u_token')},
        function(ret){
          var data= $.parseJSON(ret);
          $("#event_detail_tmpl").html( $.tmpl("event_detail_tpl", {'item':data.info.event}) );
        });
    });
  });
}

function change_page( page )
{
  console.log("切换页面");
  location = page + '.html';
}

function tt_alert( string , title , button  )
{
  if( !title ) title = '系统消息';
  navigator.notification.alert( string , function(){} , title , button );
}

function tt_confirm( string , callback , title , button  )
{
  if( !title ) title = '系统消息';
  if( !button ) button = '确定,取消';
  return navigator.notification.confirm( string , mycallback , title , button );
  function mycallback( btn )
  {
    if( btn == 1 && typeof callback == 'function' )
    callback();
  }  
}

function trim(str){ 
  return str.replace(/(^\s*)|(\s*$)/g,""); 
} 

//时间戳转换为  ----年--月--日 --：--，无秒
function getDate(tm){
  var d = new Date(parseInt(tm) * 1000);
  s = d.getFullYear() + "-";
  s += ("0"+(d.getMonth()+1)).slice(-2) + "-";
  s += ("0"+d.getDate()).slice(-2) + " ";
  s += ("0"+d.getHours()).slice(-2) + ":";
  s += ("0"+d.getMinutes()).slice(-2);
  return s;
}

//时间转换时间戳
function transDate(endTime){
  var date=new Date();
  date.setFullYear(endTime.substring(0,4));
  date.setMonth(endTime.substring(5,7)-1);
  date.setDate(endTime.substring(8,10));
  date.setHours(endTime.substring(11,13));
  date.setMinutes(endTime.substring(14,16));
  date.setSeconds(endTime.substring(17,19));
  return Date.parse(date)/1000;
}

function kset( key , value )
{
  window.localStorage.setItem( key , value );
}

function kget( key  )
{
  return window.localStorage.getItem( key );
}

function kremove( key )
{
  window.localStorage.removeItem( key );
}

function kclear()
{ 
  window.localStorage.clear();
}  