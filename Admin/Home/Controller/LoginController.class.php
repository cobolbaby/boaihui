<?php
namespace Home\Controller;
use Think\Controller;
class LoginController extends Controller {
    public function index(){
        $this->display('index/login');
    }
    
    public function logincl() {
    	header("Content-Type:text/html; charset=utf-8");
    	//echo I('post.ip');die;
    	if (IS_POST) {
    		//$this->error('系統暫未開放!');die;
	    	$username=trim(I('post.account'));
			$pwd=trim(I('post.password'));
			$secondary_code = trim(I('post.secondary_code'));
			$verCode = trim(I('post.verCode'));//驗證碼
			//dump($pwd);die;
			//!$this->check_verify($verCode)
			if(!$this->check_verify($verCode)){
				die("<script>alert('驗證碼錯誤,請刷新驗證碼！');history.back(-1);</script>");
				//$this->ajaxReturn( array('nr'=>'驗證碼錯誤,請刷新驗證碼!','sf'=>0) );
			}else{
			$user=M('member')->where(array('MB_username'=>$username))->find();
 			//dump(md5($pwd));die;
			if(!$user || $user['mb_userpwd']!=md5($pwd) || $user['mb_secondary_code'] != md5($secondary_code)){ 
				die("<script>alert('賬號或密碼錯誤,或被禁用！');history.back(-1);</script>");
			}else{
				
			//	$lifeTime = 60;
				//session_set_cookie_params($lifeTime);
			//	session_start();
				//$_session["uid"]=$user[ue_id];
				
			//	$_session["uname"]=$user[ue_account];
				
 				//session('uid',$user[ue_id]);
				session('adminuser',$user['mb_username']);
				session('adminqx',$user['mb_right']);
				session('adminqxstr', $user['mb_rightstr']);
				//cookie('uid2',$user[ue_id],array('expire'=>5,'prefix'=>'think_'));
				$record1['date']= date ( 'Y-m-d H:i:s', time () );
				$record1['ip'] = I('post.ip');
				$record1['user'] = $username;
				$record1['leixin'] = 1;
				M ( 'drrz' )->add ( $record1 );
				$_SESSION['logintime'] = time();
				die("<script>alert('登入成功！');document.location.href='/admin.php/Home/Index/main';</script>");

    	}}
    	
    	}
    
    }
    
 
    
    
    
    
    public function logout(){
    //	cookie(null);
    	session_unset();
    	session_destroy();
    	$this->success('退出成功','/admin.php/Home/Login');
    }
    //驗證碼模塊
    function check_verify($code){

    	$verify = new \Think\Verify();
    	return $verify->check($code);
    }
    
    function verify() {
    	$config =    array(
    			'fontSize'    =>    16,    // 驗證碼字體大小
    			'length'      =>    5,     // 驗證碼位數
    			'useCurve'    =>    false, // 關閉驗證碼雜點
    		'useCurve' => false,
    	);
    	
    	$Verify = new \Think\Verify($config);
    	$Verify->codeSet = '0123456789';
    	$Verify->entry();
    }

}