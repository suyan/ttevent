<?php 
class PublicAction extends Action{

	public function _initialize(){
	  vendor('MobileDetect.Mobile_Detect');
	  $mobile = new Mobile_Detect();
	  if($mobile->isMobile()){
	    $this->mobile = true;
	  }
	}

	function _empty(){ 
	  header("HTTP/1.0 404 Not Found");//使HTTP返回404状态码 
	  $this->show("木有页面啦"); 
	} 

	public function login() {
		$this->title = '登陆';
		if(!isset($_SESSION[C('USER_AUTH_KEY')])) {
			//登录表单
			$input_email=array(
				'type'=>'email',
				'id'=>'email',
				'name'=>'邮箱',
				'rules'=>'{required:true,email:true}',
				'messages'=>'{required:"请输入邮箱",email:"请输入正确的邮箱"}',
				);
			$input_password=array(
				'type'=>'password',
				'id'=>'password',
				'name'=>'密码',
				'rules'=>'{required:true}',
				'messages'=>'{required:"请输入密码"}',
				);
			$this->data = array(
				'form_id'=>'loginForm',
				'form_title'=>'登录',
				'action_url'=>U('Public/checkLogin'),
				'submit_name'=>'登陆',
				'submit_loading'=>'登录中...',
				'success'=>'$("#show_success").html(ret.info).show();history.go(0);',
				'error'=>'$("#show_alert").html(ret.info).show();',
				'inputs'=>array(
					'email'=>$input_email,
					'password'=>$input_password,
					),
				);
			$this->display('Public:login');
		}else{
			$this->redirect('Public/index');
		}
	}

	public function checkLogin(){
		if(empty($_POST['email'])){
			$this->error("帐号错误！");
		}else if(empty($_POST['password'])){
			$this->error("密码必须");
		}
		$email=$this->_post('email');
		$password = md5($this->_post('password'));
		$user = D('User')->checkUser($email,$password);
		if(is_null($user)){
			$this->error("帐号不存在或密码错误!");
		}else{
			//更新登录信息
			D('User')->userLogin($user['id']);
			//更新session
			session(C('USER_AUTH_KEY'),$user['id']);
			session('email',$user['email']);
			session('nickname',$user['nickname']);
			session('avatar',$user['middle_img']);
		}
		$this->success('登录成功！');
	}
	
	public function logout(){
		if(session(C('USER_AUTH_KEY'))){
			session(null);
		}
		$this->redirect('Public/index');
	}

	public function checkEmail(){
		$email = $this->_param('email');
		$User = M('User');
		if($User->where("email='$email'")->getField('id')){
			$this->show('false');
		}else{
			$this->show('true');
		}
	}

	public function register(){
		$this->title='注册';
		if(!isset($_SESSION[C('USER_AUTH_KEY')])) {
			//注册表单
			$input_email=array(
				'type'=>'email',
				'id'=>'email',
				'name'=>'邮箱',
				'rules'=>'{required:true,email:true,remote:"'.U("Public/checkEmail").'"}',
				'messages'=>'{required:"请输入邮箱",email:"请输入正确的邮箱",remote:"邮箱已存在"}',
				);
			$input_password=array(
				'type'=>'password',
				'id'=>'password',
				'name'=>'密码',
				'rules'=>'{required:true,minlength:6}',
				'messages'=>'{required:"请输入密码",minlength:"密码最短为六位"}',
				);
			$input_confirm_password=array(
				'type'=>'password',
				'id'=>'confirm_password',
				'name'=>'确认密码',
				'rules'=>'{required:true,minlength:6,equalTo:"#password"}',
				'messages'=>'{required:"请输入密码",minlength:"密码最短为六位",equalTo:"密码输入不一致"}',
				);
			$input_nickname = array(
				'type'=>'text',
				'id'=>'nickname',
				'name'=>'昵称',
				'rules'=>'{required:true,minlength:2}',
				'messages'=>'{required:"请输入昵称",minlength:"昵称最少为两个字"}',
				);
			$this->data = array(
				'form_id'=>'registerForm',
				'form_title'=>'注册',
				'action_url'=>U('Public/addUser'),
				'submit_name'=>'注册',
				'submit_loading'=>'请稍后...',
				'success'=>'$("#show_success").html(ret.info).show();history.go(0);',
				'error'=>'$("#show_alert").html(ret.info).show();',
				'inputs'=>array(
					'email'=>$input_email,
					'password'=>$input_password,
					'confirm_password'=>$input_confirm_password,
					'nickname'=>$input_nickname
					),
				);
			$this->display('Public:register');
		}else{
			$this->redirect('Public/index');
	  } 
	}

	public function addUser(){
		$User = D('User');
		$data = $User->create();
		if($data){
			$ret = $User->addUser($data);
	    if($ret){
	      session(C('USER_AUTH_KEY'),$ret);
	      session('nickname',$data['nickname']);
	      session('email',$data['email']);
				session('avatar',$data['middle_img']);
	      $this->success('注册成功！','index');
			}else{
	      $this->error($User->getError());
	    }
		}else{
	    $this->error($User->getError());
		}
	}

	public function index(){
		redirect(__APP__.'/');
	}

	public function verify() {
		$type = isset($_GET['type'])?$_GET['type']:'gif';
		import("ORG.Util.Image");
		Image::buildImageVerify(4,1,$type);
	}
}