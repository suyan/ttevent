<div id="nav">
  <li><a href="#s1">页面跳转</a></li>
  <li><a href="#s2">加载完成</a></li>
  <li><a href="#s3">刷新页面</a></li>
  <li><a href="#s4">json转化和解析</a></li>
  <li><a href="#s5">时间转换</a></li>
  <li><a href="#s6">URI编码转换</a></li>
  <li><a href="#s7">HTML编码转换</a></li>
  <li><a href="#s8">tmpl,template()模板</a></li>
  <li><a href="#s9">列表右边的小红泡，显示数字</a></li>
</div>
<h2 id="s1">页面跳转</h2>
    window.navigate("top.jsp");
    window.history.back(-1);
    window.location.href="login.jsp?backurl="+window.location.href; 
    self.location='top.htm';
    top.location='xx.jsp';
    
<h2 id="s2">加载完成</h2>
    window.onload 
    必须等页面内包括图片的所有元素加载完成后才能执行。
    不能同时编写多个，只执行一个
    $(document).ready()
    是DOM结构绘制完毕后就可以执行
    可以编写多个
    简写$(function(){});
    $(window).load()等同与window.onload

<h2 id="s3">刷新页面</h2>
    history.go(0) 
    location.reload() 
    location=location 
    location.assign(location) 
    document.execCommand('Refresh') 
    window.navigate(location) 
    location.replace(location) 
    document.URL=location.href 

<h2 id="s4">json转化和解析</h2>

    JSON.parse("{a:'111',b:'ccc'}");  //解析
    eval("("+"{{ cpu_data }}"+")"); //解析

<h2 id="s5">时间转换</h2>

    var day1 = parseInt(new Date().valueOf()/1000); //获得当前时间时间戳
    day2 = new Date(day1*1000);
    alert(day2.getFullYear()+"-"+(day2.getMonth()+1)+"-"+day2.getDate()+" "+day2.getHours()+":"+day2.getMinutes()+":"+day2.getSeconds())
    d = new Date();
    s = d.getFullYear() + "-";
    s += ("0"+(d.getMonth()+1)).slice(-2) + "-";
    s += ("0"+d.getDate()).slice(-2) + " ";
    s += ("0"+d.getHours()).slice(-2) + ":";
    s += ("0"+d.getMinutes()).slice(-2) + ":";
    s += ("0"+d.getSeconds()).slice(-2) + ".";
    s += ("00"+d.getMilliseconds()).slice(-3);

<h2 id="s6">URI编码转换</h2>

    var a="':'";
    en = encodeURI(a);    //编码
    a = decodeURI(en);    //解码

<h2 id="s7">HTML编码转换</h2>

    function htmlEncode(value){
      return $('<div/>').text(value).html();
    }

    function htmlDecode(value){
      return $('<div/>').html(value).text();
    }
<h2 id="s8"> tmpl,template()模板 </h2>
    //jq.web.template - a javascript template library
    <div id="template_content"></div>
    <script type="text/html" id="my_template">
        <% for (i=0;i<5;i++) %>
        This is item <%=i%><br />
    </script>   //script中写框架
    <script type="text/javascript">
        var init_template = function () {
            $("#template_content").html($.template("my_template"));
        };      //这里调用
        window.addEventListener("load", init_template, false);
    </script>
    //使用
    $.tmpl( tmpl , data );
    $.template( tmpl , data);

<h2 id="s9">列表右边的小红泡，显示数字</h2>
    $.ui.updateBadge("#jqmlink",$("#jqm").find("li").length);