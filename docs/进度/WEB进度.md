<div id="nav">
  <li><a href="#s0">更新日志</a></li>
  <li><a href="#s1">接口</a></li>
  <li><a href="#s2">活动</a></li>
  <li><a href="#s3">用户</a></li>

</div>

<h2 id="s0">更新日志</h2>

<table class="table table-bordered table-condensed">
  <tr><td class="span2">时间</td><td>主要修改内容</td><td>版本号</td></tr>
  <tr><td>2013-05-03 21:18</td><td>
    <li>增加用户关注功能</li>
    <li>增加页面缓存功能</li>
  </td><td>1.1.1</td></tr> 
  <tr><td>2013-04-16 21:24</td><td>
    <li>增加了活动管理部分</li>
    <li>关注/参与活动</li>
    <li>完善个人资料修改，以及一些页面显示</li>
    <li>未登录可见部分响应式布局，可以手机直接扫码进入查看</li>
  </td><td>1.1.0</td></tr> 
  <tr><td>2013-04-10 20:30</td><td>
    活动创建等基本功能，第一个可用版本……
  </td><td>1.0.0</td></tr> 
</table>

<h1 id="s1">接口</h1>
<table class="table table-bordered table-condensed">
  <tr><td rowspan=2>用户接口</td><td>功能</td><td>版本</td><td>状态</td></tr>
  <tr class="success"><td>用户登录</td><td>1.0.0</td><td>@done</td></tr>

  <tr><td rowspan=8>活动接口</td><td>功能</td><td>版本</td><td>状态</td></tr>
  <tr class="success"><td>获得最热活动</td><td>1.0.0</td><td>@done</td></tr>
  <tr class="success"><td>关注活动</td><td>1.0.0</td><td>@done</td></tr>
  <tr class="success"><td>取消关注活动</td><td>1.0.0</td><td>@done</td></tr>
  <tr class="success"><td>参加活动</td><td>1.0.0</td><td>@done</td></tr>
  <tr class="success"><td>取消参加活动</td><td>1.0.0</td><td>@done</td></tr>
  <tr class="success"><td>获得一个活动全部资料</td><td>1.1.1</td><td>@done</td></tr>
  <tr class="info"><td>搜索活动</td><td>1.1.1</td><td>@todo</td></tr>
</table>


<h2 id="s2">活动</h2>

<table class="table table-bordered table-condensed">
  <tr><td rowspan=5>创建活动</td><td>功能</td><td>版本</td><td>状态</td></tr>
  <tr class="success"><td>所用用户可以创建活动</td><td>1.0.0</td><td>@done</td></tr>
  <tr class="success"><td>第一步：活动名称和活动策划</td><td>1.0.0</td><td>@done</td></tr>
  <tr class="success"><td>第二步：活动封面，上传并裁剪</td><td>1.0.0</td><td>@done</td></tr>
  <tr class="success"><td>第三步：活动详细情况，时间，地点，分类，标签，说明</td><td>1.0.0</td><td>@done</td></tr>

  <tr><td rowspan=6>查看活动</td><td>功能</td><td>版本</td><td>状态</td></tr>
  <tr class="success"><td>查看活动详细情况，包括时间、地点、说明</td><td>1.0.0</td><td>@done</td></tr>
  <tr class="success"><td>未登录用户可以查看，不可以评论和关注</td><td>1.0.0</td><td>@done</td></tr>
  <tr class="success"><td>登录用户可以查看、关注、评论活动</td><td>1.0.0</td><td>@done</td></tr>
  <tr class="success"><td>活动动态，主要利用在活动直播时</td><td>1.1.0</td><td>@done</td></tr>
  <tr class="success"><td>活动接入二维码</td><td>1.1.0</td><td>@done</td></tr>

  <tr><td rowspan=2>关注活动</td><td>功能</td><td>版本</td><td>状态</td></tr>
  <tr class="success"><td>登录用户可以关注/取消关注活动</td><td>1.0.0</td><td>@done</td></tr>

  <tr><td rowspan=2>参加活动</td><td>功能</td><td>版本</td><td>状态</td></tr>
  <tr class="success"><td>登录用户可以参加/取消参加活动</td><td>1.1.0</td><td>@done</td></tr>

  <tr><td rowspan=2>评论活动</td><td>功能</td><td>版本</td><td>状态</td></tr>
  <tr class="success"><td>登录用户可以评论活动</td><td>1.0.0</td><td>@done</td></tr>

  <tr><td rowspan=3>修改活动</td><td>功能</td><td>版本</td><td>状态</td></tr>
  <tr class="success"><td>活动创建者可以修改活动全部内容</td><td>1.0.0</td><td>@done</td></tr>
  <tr class="success"><td>活动修改后通知已关注此活动的用户</td><td>1.0.0</td><td>@done</td></tr>

  <tr><td rowspan=5>管理活动</td><td>功能</td><td>版本</td><td>状态</td></tr>
  <tr class="success"><td>查看活动的全部信息</td><td>1.1.0</td><td>@done</td></tr>
  <tr class="success"><td>查看所有参与用户</td><td>1.1.0</td><td>@done</td></tr>
  <tr class="success"><td>查看所有关注用户</td><td>1.1.0</td><td>@done</td></tr>
  <tr class="success"><td>查看活动管理员</td><td>1.1.0</td><td>@done</td></tr>

  <tr><td rowspan=2>删除活动</td><td>功能</td><td>版本</td><td>状态</td></tr>
  <tr class="success"><td>活动创建者可以删除活动</td><td>1.0.0</td><td>@done</td></tr>  
</table>

<h2 id="s3">用户</h2>

<table class="table table-bordered table-condensed">
  <tr><td rowspan=3>用户注册</td><td>功能</td><td>版本</td><td>状态</td></tr>
  <tr class="success"><td>允许所有用户注册</td><td>1.0.0</td><td>@done</td></tr>
  <tr class="success"><td>需要邮箱、密码、昵称</td><td>1.0.0</td><td>@done</td></tr>

  <tr><td rowspan=2>用户登录</td><td>功能</td><td>版本</td><td>状态</td></tr>
  <tr class="success"><td>注册用户登录，需要邮箱密码</td><td>1.0.0</td><td>@done</td></tr>

  <tr><td rowspan=3>个人动态</td><td>功能</td><td>版本</td><td>状态</td></tr>
  <tr class="success"><td>以feed墙形式刷新</td><td>1.0.0</td><td>@done</td></tr>
  <tr class="success"><td>只支持查看全部动态</td><td>1.0.0</td><td>@done</td></tr>

  <tr><td rowspan=4>通知</td><td>功能</td><td>版本</td><td>状态</td></tr>
  <tr class="success"><td>以分页形式查看</td><td>1.0.0</td><td>@done</td></tr>
  <tr class="success"><td>只支持查看全部通知，查看时讲所有通知置为已读</td><td>1.0.0</td><td>@done</td></tr>  
  <tr class="success"><td>个人动态，显示自己关注的活动的一些主要变化</td><td>1.1.0</td><td>@done</td></tr>

  <tr><td rowspan=5>帐号设置</td><td>功能</td><td>版本</td><td>状态</td></tr>
  <tr class="success"><td>基本资料：昵称</td><td>1.0.0</td><td>@done</td></tr>
  <tr class="success"><td>详细资料：活动接收邮箱、真实姓名、性别、手机号码</td><td>1.1.0</td><td>@done</td></tr>
  <tr class="success"><td>修改头像</td><td>1.0.0</td><td>@done</td></tr>  
  <tr class="success"><td>修改密码</td><td>1.0.0</td><td>@done</td></tr>  

  <tr><td rowspan=4>我的活动</td><td>功能</td><td>版本</td><td>状态</td></tr>
  <tr class="success"><td>已参于活动</td><td>1.0.0</td><td>@done</td></tr>
  <tr class="success"><td>已关注活动，点击进入活动介绍页</td><td>1.0.0</td><td>@done</td></tr>  
  <tr class="success"><td>管理的活动，点击对活动进行管理</td><td>1.0.0</td><td>@done</td></tr>    

  <tr><td rowspan=4>用户关系</td><td>功能</td><td>版本</td><td>状态</td></tr>
  <tr class="success"><td>关注其他用户</td><td>1.1.1</td><td>@done</td></tr>
  <tr class="info"><td>查看自己关注用户</td><td>1.1.1</td><td>@todo</td></tr>  
  <tr class="info"><td>查看关注自己的用户</td><td>1.1.1</td><td>@todo</td></tr>    
</table>
