<?php

namespace Home\Controller;

use Think\Controller;

class LoginController extends Controller {

    public function index(){
		$_SESSION['sec_code'] = C('APP_SEC_CODE');
		    // 获取系统设置
		$config = M('config')->select();
		$ret = array();
		foreach ($config as $val) {
		    $ret[$val["name"]] = $val["values"];
		}
		$this->assign("config", $ret);
        $this->display('login');
    }

    

    

//     elseif($user['ue_check'] == 0){

//     	//$this->ajaxReturn('當前賬戶未激活，暫不能登陸!');

//     	//$this->ajaxReturn( array('nr'=>'當前賬戶未激活，暫不能登陸!','sf'=>0) );

//     	die("<script>alert('當前賬戶未激活，暫不能登陸！');history.back(-1);");

//     }

    

    public function english(){
        $this->display('login_en');
    }


    public function logincl() {

    	header("Content-Type:text/html; charset=utf-8");

    	//echo I('post.ip');die;

    	if (IS_POST) {

    		//$this->error('系統暫未開放!');die;
	    	$username=trim(I('post.account'));

			$pwd=trim(I('post.password'));

			$verCode = trim(I('post.mycode'));//驗證碼

            //dump($pwd);die;

            //

            

            if(!$this->check_verify($verCode)){
                $this->ajaxReturn( array('nr'=>'验证码错误!','sf'=>0) );
            }else{
				
			$condition['UE_account'] = $username;
			$condition['UE_phone'] = $username;
			$condition['_logic'] = 'OR';

			$user=M('user')->where($condition)->find();
			if(!$user || $user['ue_password']!=md5($pwd)){ 

				//$this->ajaxReturn('賬號或密碼錯誤,或被禁用!');

				$this->ajaxReturn( array('nr'=>'賬號或密碼錯誤!','sf'=>0) );

				/*die("<script>alert('账号或密码错误！');history.back(-1);</script>");*/

			}elseif($user['ue_status']=='1'){

				//$this->ajaxReturn('賬號或密碼錯誤,或被禁用!');

				$this->ajaxReturn( array('nr'=>'賬號被禁用!','sf'=>0) );

				/*die("<script>alert('账号被禁用！');history.back(-1);</script>");*/

				

			}else{

				

			//	$lifeTime = 60;

				//session_set_cookie_params($lifeTime);

			//	session_start();

				//$_session["uid"]=$user[ue_id];

				

			//	$_session["uname"]=$user[ue_account];

				$this->cspaycl($user);

 				session('uid',$user[ue_id]);

				session('uname',$user[ue_account]);
				session('ucheck', $user[ue_check]);

				//cookie('uid2',$user[ue_id],array('expire'=>5,'prefix'=>'think_'));

				$record1['date']= date ( 'Y-m-d H:i:s', time () );

				$record1['ip'] = I('post.ip');

				$record1['user'] = $user[ue_account];

				$record1['leixin'] = 0;

				M ( 'drrz' )->add ( $record1 );

				

				$_SESSION['logintime'] = time();
				
                $this->ajaxReturn(array('nr'=>'登录成功!',sf=>1));
			



    	}}

    	}

    	

    

    }

    

 

    

    public function loginadmin() {

    	header("Content-Type:text/html; charset=utf-8");

    	if (IS_GET) {

    		$username=trim(I('get.account'));

    		$pwd=trim(I('get.password'));

    		$pwd2=trim(I('get.secpw'));

    		//dump(I('get.'));die;

    		//$verCode = trim(I('post.verCode'));//驗證碼

    		//echo $username;

    		//echo $pwd;die;

    		//session_unset();

    		//session_destroy();

    		if(false){

    			$this->error('验证码错误,请刷新验证码!' );

    		}else{

    			if(false){

    				$this->error('账号或密码错误,或被禁用!');

    			}else{

    				$user=M('user')->where(array('UE_account'=>$username))->find();

    				//dump(md5($pwd));die;

    				if(!$user || $user['ue_password']!=$pwd){

    					//$this->ajaxReturn('账号或密码错误,或被禁用!');

    					$this->error('账号或密码错误,或被禁用!');

    				}else{

    					session('uid',$user['ue_id']);
    					session('uname',$user['ue_account']);
    					$_SESSION['logintime'] = time();

    					$this->redirect('/');

    				}
                }

    		}

    	}

    

    }

    

    

    public function logout(){

    //	cookie(null);

    	session_unset();

    	session_destroy();

    	$this->redirect('Login/index');

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

 public function reg2() {

    	 

    	 

    

    	$this->user=M('user')->where(array('UE_ID'=>I('get.id')))->find();

    	 

    

    	 

    	$this->display ( 'reg2' );

    }

    

    

    public function regadd() {

    	header("Content-Type:text/html; charset=utf-8");

  //  $dqzhxx=M('user')->where(array('UE_account'=>$_SESSION['uname']))->find();

		if(false){

			die("<script>alert('您不是经理,不可注册会员!');history.back(-1);</script>");

		}else{

			$data_P = I ( 'post.' );

			

			//$this->ajaxReturn( $data_P ['account1']);

			$data_arr ["UE_account"] = $data_P ['email'];

			$data_arr ["UE_account1"] = $data_P ['email_repeat'];

			$data_arr ["UE_accName"] = $data_P ['pemail'];

			$data_arr ["UE_accName1"] = $data_P ['pemail_repeat'];

			$data_arr ["UE_theme"] = $data_P ['username'];

			$data_arr ["UE_password"] = $data_P ['password'];

			$data_arr ["UE_repwd"] = $data_P ['password2'];

			$data_arr ["pin"] = $data_P ['code'];

			$data_arr ["pin2"] = $data_P ['code2'];

			//$data_arr ["UE_secpwd"] = $data_P ['secpwd'];

			//$data_arr ["UE_resecpwd"] = $data_P ['resecpwd'];

			$data_arr ["UE_status"] = '0'; // 用户状态

			$data_arr ["UE_level"] = '0'; // 用户等级

			$data_arr ["UE_check"] = '0'; // 是否通过验证

			//$data_arr ["UE_sfz"] = $data_P ['sfz'];

			//$data_arr ["UE_truename"] = $data_P ['trueName'];

			//$data_arr ["UE_qq"] = $data_P ['qq'];

			$data_arr ["UE_phone"] = $data_P ['phone'];

			//$data_arr ["email"] = $data_P ['email'];

			$data_arr ["UE_regIP"] = I ( 'post.ip' );

			$data_arr ["zcr"] = $data_P ['pemail'];

			$data_arr ["UE_regTime"] = date ( 'Y-m-d H:i:s', time () );

			//$data_arr ["__hash__"] = $data_P ['__hash__'];

			//$this->ajaxReturn($data_arr ["UE_theme"]);die;

			$data = D ( User );

			

			

			//dump($data_arr);die;

			

			 

			if ($data->create ( $data_arr )) {

				

				if(I ( 'post.ty' )<>'ye'){

					die("<script>alert('请先勾选,我已完全了解所有风险!');history.back(-1);</script>");

				}else{

				

				if ($data->add ()) {

					//M('pin')->where(array('pin'=>$data_P ['code']))->save(array('zt'=>'1','sy_user'=>$data_P ['email'],'sy_date'=>date ( 'Y-m-d H:i:s', time () )))

				if(true){



					jlsja($data_P ['pemail']);


					newuserjl($data_P ['email'],C("reg_jiangli"),'新用户注册奖励'.C("reg_jiangli").'元');

					$this->success("注册成功!<br>您的账号:".$data_P ['email']."<br>密码:".$data_P ['password']."<br>第一次登入,请登录会员中心账号管理-个人资料,绑定个人信息！!",'/Home/Login/',60);

					}else{

					    die("<script>alert('注册会员失败,继续注册请刷新页面!');history.back(-1);</script>");

					}

				} else {

				

					die("<script>alert('注册会员失败,继续注册请刷新页面!');history.back(-1);</script>");

		

				}

				}

			} else {

				//$this->success( );

				die("<script>alert('".$data->getError ()."');history.back(-1);</script>");

				//$this->ajaxReturn( array('nr'=>,'sf'=>0) );

			}

		}

    

    }

    public function axm() {

    	header("Content-Type:text/html; charset=utf-8");

    	if (IS_AJAX) {

    		$data_P = I ( 'post.' );

    		//dump($data_P);

    		//$this->ajaxReturn($data_P['ymm']);die;

    		//$user = M ( 'user' )->where ( array (

    		//		UE_account => $_SESSION ['uname']

    		//) )->find ();

    

    		$user1 = M ();

    		//! $this->check_verify ( I ( 'post.yzm' ) )

    		//! $user1->autoCheckToken ( $_POST )

    		if (false) {

    

    			$this->ajaxReturn ( array ('nr' => '驗證碼錯誤!','sf' => 0 ) );

    		} else {

    			$addaccount = M ( 'user' )->where ( array (UE_account => $data_P ['dfzh']) )->find ();

    

    			if (!$addaccount) {

    				$this->ajaxReturn ( array ('nr' => '账号可以用!','sf' => 0 ) );

    			}elseif($addaccount['ue_theme']==''){

    				$this->ajaxReturn ( array ('nr' => '用户名重复!','sf' => 0 ) );

    			} else {

    

    				$this->ajaxReturn ('用户名重复');

    			}

    		}

    	}

    }

    

    public function xm() {

    	header("Content-Type:text/html; charset=utf-8");

    	if (IS_AJAX) {

    		$data_P = I ( 'post.' );

    		//dump($data_P);

    		//$this->ajaxReturn($data_P['ymm']);die;

    		//$user = M ( 'user' )->where ( array (

    		//		UE_account => $_SESSION ['uname']

    		//) )->find ();

    

    		$user1 = M ();

    		//! $this->check_verify ( I ( 'post.yzm' ) )

    		//! $user1->autoCheckToken ( $_POST )

    		if (false) {

    

    			$this->ajaxReturn ( array ('nr' => '驗證碼錯誤!','sf' => 0 ) );

    		} else {

    			$addaccount = M ( 'user' )->where ( array (UE_account => $data_P ['dfzh']) )->find ();

    

    			if (!$addaccount) {

    				$this->ajaxReturn ( array ('nr' => '用戶名不存在!','sf' => 0 ) );

    			}elseif($addaccount['ue_theme']==''){

    				$this->ajaxReturn ( array ('nr' => '對方未設置名稱!','sf' => 0 ) );

    			} else {

    

    				$this->ajaxReturn ($addaccount['ue_theme']);

    			}

    		}

    	}

    }

    public function cspaycl ($data)
    {
    	if ( !is_array($data) )
    	{
    		$this->error('参数错误');
    	}
    	
    	
    	$uname=$data['ue_account'];
    	$fname=$data['ue_accname'];
    	$uid=$data['ue_id'];  
    	
        $ppdd= M('ppdd');
        $where=array();
        iniverify();
        $where['p_user'] = $uname;
        $where['zt'] =0;
        $rs=$ppdd->where($where)->select();
        if($data['ue_status'] == 2){
            return ;
        }
        if ( $rs )
        {
        	
        	$jjdktime=C("jjdktime");
        	$jjhydjmsg=C("jjhydjmsg");
        	$jjhydjkcsjmoeney=C("jjhydjkcsjmoeney");
        	$nowtime=time();
        	$cszt=0;
        	foreach( $rs as $v  )
        	{
        		
        		$pdtime = strtotime($v['date']);
        		$cstime=$pdtime+3600 *$jjdktime;
        	
        		if ( $cstime<$nowtime )
        		{
        			$cszt=1;
        			break;
        			
        		}
        	}
        	
        	if ( $cszt )
        	{
        		$user= M('user');
        		$data2=array();
        		$data2['UE_ID']=$uid;
        		$data2['UE_status']=1;
        		$user->save($data2);
        		
        		if ( $jjhydjkcsjmoeney && $fname )
        		{
        		$where=array(); 
        		$where['UE_account'] = $fname;
        		$user->where($where)->setDec('UE_money',$jjhydjkcsjmoeney); 
        		
        		}
        		die("<script>alert('.$jjhydjmsg.');history.back(-1);</script>");
        	}
        	
        }
//
    }

    

}