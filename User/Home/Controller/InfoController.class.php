<?php

namespace Home\Controller;

use Think\Controller;

class InfoController extends CommonController
{
    // 首頁
    public function index()
    {
        $userData = M('user')->where(array('UE_ID' => $_SESSION ['uid']))->find();
        $this->userData = $userData;
		
		$ip = M('drrz')->where(array('user' => $_SESSION ['uname'], 'leixin' => 0))->order('id DESC')->limit(2)->select();

        $this->bcip = $ip[0];
        $this->scip = $ip[1];
        $this->display('grsz');
    }

    public function xgmm()
    {
        $userData = M('user')->where(array(
            'UE_ID' => $_SESSION ['uid']
        ))->find();
        $this->userData = $userData;
        $this->display('xgmm');
    }

    public function xgmme()
    {
        $userData = M('user')->where(array(
            'UE_ID' => $_SESSION ['uid']
        ))->find();
        $this->userData = $userData;
        $this->display('xgmme');
    }

    public function bdmb()
    {
        $userData = M('user')->where(array(
            'UE_ID' => $_SESSION ['uid']
        ))->find();
        $this->userData = $userData;
        if ($userData['ue_question'] == '') {
            $this->display('bdmb');
        } else {
            $this->display('xgmb');
        }
    }

    public function xgmb()
    {
        $userData = M('user')->where(array(
            'UE_ID' => $_SESSION ['uid']
        ))->find();
        $this->userData = $userData;
        $this->display('xgmb');
    }

    public function addskzh()
    {
        $userData = M('user')->where(array(
            'UE_ID' => $_SESSION ['uid']
        ))->find();
        $this->userData = $userData;
        $this->display('addskzh');
    }

    public function skzh()
    {
        $userData = M('user')->where(array(
            'UE_ID' => $_SESSION ['uid']
        ))->find();
        $caution = M('userinfo')->where(array(
            'UI_userID' => $_SESSION ['uid']
        ))->order('UI_ID DESC')->select();
        $this->caution = $caution;
        //dump($caution);die;
        $this->userData = $userData;
        $this->display('skzh');
    }

    public function skzhdl()
    {
        if (!preg_match('/^[0-9]{1,10}$/', I('get.id'))) {
            $this->success('非法操作,將凍結賬號!');
        } else {
            $userinfo = M('userinfo')->where(array('UI_ID' => I('get.id')))->find();
            if ($userinfo['ui_userid'] <> $_SESSION ['uid']) {
                $this->success('非法操作,將凍結賬號!');
            } else {
                $reg = M('userinfo')->where(array('UI_ID' => I('get.id')))->delete();
                if ($reg) {
                    $this->success('刪除成功!');
                } else {
                    $this->success('刪除失敗!');
                }
            }
        }
    }

    public function ejmm()
    {
        $this->display('ejmm');
    }

    public function ejmmcl()
    {
        //echo $_SESSION['url'];die;
        if (IS_POST) {
            $data_P = I('post.');
            $addaccount = M('user')->where(array(UE_account => $_SESSION ['uname']))->find();
            //dump($addaccount['ue_secpwd']);
            //dump(md5($data_P['ejmmqr']));
            //die;
            if ($addaccount['ue_secpwd'] <> md5($data_P['ejmmqr'])) {
                $this->error('二級密碼不正確!');
            } else {
                $_SESSION['ejmmyz'] = $addaccount['ue_secpwd'];
                //	echo ;die;
                $this->success('驗證成功', $_SESSION['url']);
            }
        }

    }

    public function xgzlcl()
    {
        if (IS_POST) {

            //$this->check_phone();

            $data_P = I('post.');
            $userxx = M('user')->where(array('UE_account' => $_SESSION['uname']))->find();
            $tgbztj = M('ppdd')->where(array('p_user' => $_SESSION['uname'], 'zt' => '2'))->sum('jb');
            //$tgbztj>=600||$userxx['sfjl']==1

            if (false) {
                $this->success('提供帮助成功后不可修改个人信息和经理人不可自行修改资料!');
            } else {
                $userxx = M('user')->where(array('UE_account' => $_SESSION['uname']))->find();

                //dump($userxx);die;

                if ($userxx['ue_secpwd'] <> md5($data_P['trade_pwd2'])) {
                    die("<script>alert('二级密码输入有误！');history.back(-1);</script>");
                } else {
                    $data_up['weixin'] = $data_P['weixin'];
                    $data_up['zfb'] = $data_P['zfb'];                    
                    $data_up['yhmc'] = $data_P['yhmc'];
                    //$data_up['zhxm'] = $data_P['bank_user'];
                    $data_up['yhzh'] = $data_P['yhzh'];
                    //$data_up['khzh'] = $data_P['khzh'];
                    //$data_up['UE_phone'] = $data_P['phone'];
                    fh($data_up);
                    $reg = M('user')->where(array('UE_account' => $_SESSION['uname']))->save($data_up);
					
					if ($reg) {
                       $this->success('修改成功！',U('Info/index'));
                    } else {
                       $this->error("修改失败!");
                    }

                }

            }
        }
    }


    public function xgyjmmcl()
    {

        if (IS_POST) {
            $data_P = I('post.');
            //dump($data_P);die;
            //$this->ajaxReturn($data_P['ymm']);die;
            //$user = M ( 'user' )->where ( array (
            //		UE_account => $_SESSION ['uname']
            //) )->find ();

            $user1 = M();
            //! $this->check_verify ( I ( 'post.yzm' ) )
            //! $user1->autoCheckToken ( $_POST )
            if (!preg_match('/^[a-zA-Z0-9]{1,15}$/', $data_P ['xmm'])) {
                /*$this->ajaxReturn(array('nr' => '新密碼6-12個字元,大小寫英文+數字,請勿用特殊詞符！', 'sf' => 0));*/
                $this->error('新密碼6-12個字元,大小寫英文+數字,請勿用特殊詞符！');
            } elseif ($data_P['xmm'] <> $data_P['xmmqr']) {
                $this->error('新密碼兩次輸入不一致!');
              /*  $this->ajaxReturn(array('nr' => '新密碼兩次輸入不一致!', 'sf' => 0));*/
            } elseif ($data_P['ymm'] == $data_P['xmm']) {
                $this->error('原密碼和新密碼不能相同!');
                /*$this->ajaxReturn(array('nr' => '原密碼和新密碼不能相同!', 'sf' => 0));*/
            } else {
                $addaccount = M('user')->where(array(UE_account => $_SESSION ['uname']))->find();

                if ($addaccount['ue_password'] <> md5($data_P['ymm'])) {
                    $this->error('原密碼不正確!');
                   /* $this->ajaxReturn(array('nr' => '原密碼不正確!', 'sf' => 0));*/
                } else {

                    $reg = M('user')->where(array(
                        'UE_ID' => $_SESSION ['uid']
                    ))->save(array('UE_password' => md5($data_P['xmm'])));


                    if ($reg) {
                       $this->success('修改成功！',U('Info/index'));
                    } else {
                       $this->error("修改失败!");
                    }
                }
            }
        }
    }

    public function addskzhcl()
    {

        if (IS_AJAX) {
            $data_P = I('post.');
            //dump($data_P);
            //$this->ajaxReturn($data_P['ymm']);die;
            //$user = M ( 'user' )->where ( array (
            //		UE_account => $_SESSION ['uname']
            //) )->find ();

            $user1 = M();
            //! $this->check_verify ( I ( 'post.yzm' ) )
            //! $user1->autoCheckToken ( $_POST )
            if (!$this->check_verify(I('post.yzm'))) {

                $this->ajaxReturn(array('nr' => '驗證碼錯誤!', 'sf' => 0));
            } elseif (strlen($data_P['skfs']) > 13 || strlen($data_P['skfs']) < 6) {
                $this->ajaxReturn(array('nr' => '請選擇收款方式!', 'sf' => 0));
            } elseif (!preg_match('/^[0-9]{6,30}$/', $data_P ['skzh'])) {
                $this->ajaxReturn(array('nr' => '收款賬號為數字6-30位！', 'sf' => 0));
            } elseif (strlen($data_P['khh']) > 60 || strlen($data_P['khh']) < 6) {
                $this->ajaxReturn(array('nr' => '開戶支行中文字數2-20字!', 'sf' => 0));
            } else {

                //	if ($addaccount['ue_password']<>md5($data_P['ymm'])) {
                //	$this->ajaxReturn ( array ('nr' => '原密碼不正確!','sf' => 0 ) );
                if (!$user1->autoCheckToken($_POST)) {
                    $this->ajaxReturn(array('nr' => '新勿重複提交,請刷新頁面!', 'sf' => 0));
                } else {
                    $addaccount = M('user')->where(array(UE_account => $_SESSION ['uname']))->find();

                    $data_up['UI_userID'] = $_SESSION ['uid'];
                    $data_up['UI_time'] = date('Y-m-d H:i:s', time());
                    $data_up['UI_realName'] = $addaccount['ue_truename'];
                    $data_up['UI_payaccount'] = $data_P['skzh'];
                    $data_up['UI_payStyle'] = $data_P ['skfs'];
                    $data_up['UI_isindex'] = I('post.sfqy', 0, '/^[1]{1}$/');
                    $data_up['UI_opendress'] = $data_P ['khh'];
                    $reg = M('userinfo')->add($data_up);
                    //	$reg = M ( 'user' )->where ( array (
                    //			'UE_ID' => $_SESSION ['uid']
                    //	) )->save (array('UE_password'=>md5($data_P['xmm'])));

                    //dump($data_up);

                    if ($reg) {
                        $this->ajaxReturn('添加成功!');
                    } else {
                        $this->ajaxReturn('添加失敗!');
                    }
                }
            }
        }
    }

    public function xgejmmcl()
    {

        if (IS_POST) {
            $data_P = I('post.');
            //dump($data_P);die;
            //$this->ajaxReturn($data_P['ymm']);die;
            //$user = M ( 'user' )->where ( array (
            //		UE_account => $_SESSION ['uname']
            //) )->find ();

            $user1 = M();
            //! $this->check_verify ( I ( 'post.yzm' ) )
            //! $user1->autoCheckToken ( $_POST )
            if (!preg_match('/^[a-zA-Z0-9]{1,15}$/', $data_P ['xejmm'])) {
                //$this->ajaxReturn ( array ('nr' => '新二级密碼6-12個字元,大小寫英文+數字,請勿用特殊詞符！','sf' => 0 ) );
                die("<script>alert('新二级密碼6-12個字元,大小寫英文+數字,請勿用特殊詞符！');history.back(-1);</script>");
            } elseif ($data_P['xejmm'] <> $data_P['xejmmqr']) {
                //$this->ajaxReturn ( array ('nr' => '新二级密碼兩次輸入不一致!','sf' => 0 ) );
                die("<script>alert('新二级密碼兩次輸入不一致！');history.back(-1);</script>");
            } elseif ($data_P['yejmm'] == $data_P['xejmm']) {
                //$this->ajaxReturn ( array ('nr' => '原二级密碼和新密碼不能相同!','sf' => 0 ) );
                die("<script>alert('原二级密碼和新密碼不能相同！');history.back(-1);</script>");
            } else {
                $addaccount = M('user')->where(array(UE_account => $_SESSION ['uname']))->find();

                if ($addaccount['ue_secpwd'] <> md5($data_P['yejmm'])) {
                    //$this->ajaxReturn ( array ('nr' => '原二级密碼不正確!','sf' => 0 ) );
                    die("<script>alert('原二级密碼不正確！');history.back(-1);</script>");
                } else {

                    $reg = M('user')->where(array(
                        'UE_ID' => $_SESSION ['uid']
                    ))->save(array('UE_secpwd' => md5($data_P['xejmm'])));


                    if ($reg) {
                        //$this->ajaxReturn ( array ('nr' => '修改成功!','sf' => 0 ));
                        die("<script>alert('修改成功!');history.back(-1);</script>");
                    } else {
                        //$this->ajaxReturn ( array ('nr' => '修改失敗!','sf' => 0 ) );
                        die("<script>alert('修改失敗！');history.back(-1);</script>");
                    }
                }
            }
        }
    }

    public function bdmbadd()
    {

        if (IS_AJAX) {
            $data_P = I('post.');
            //dump($data_P);die;
            //$this->ajaxReturn($data_P['ymm']);die;
            //$user = M ( 'user' )->where ( array (
            //		UE_account => $_SESSION ['uname']
            //) )->find ();

            $user1 = M();
            //! $this->check_verify ( I ( 'post.yzm' ) )
            //! $user1->autoCheckToken ( $_POST )
            if (!$this->check_verify(I('post.yzm'))) {

                $this->ajaxReturn(array('nr' => '驗證碼錯誤!', 'sf' => 0));
            } elseif ($data_P['wt1'] == '0' || $data_P['wt2'] == '0' || $data_P['wt3'] == '0') {
                $this->ajaxReturn(array('nr' => '請選擇問題!', 'sf' => 0));
            } elseif ($data_P['wt1'] == $data_P['wt2'] || $data_P['wt1'] == $data_P['wt3'] || $data_P['wt2'] == $data_P['wt3']) {
                $this->ajaxReturn(array('nr' => '密保問題不能相同!', 'sf' => 0));
            } elseif (strlen($data_P['wt1']) > 60 || strlen($data_P['wt2']) > 60 || strlen($data_P['wt3']) > 60) {
                $this->ajaxReturn(array('nr' => '問題格式不對!', 'sf' => 0));
            } elseif (strlen($data_P['da1']) > 20 || strlen($data_P['da2']) > 20 || strlen($data_P['da3']) > 20) {
                $this->ajaxReturn(array('nr' => '答案1-10個字！', 'sf' => 0));
            } elseif (strlen($data_P['da1']) < 1 || strlen($data_P['da2']) < 1 || strlen($data_P['da3']) < 1) {
                $this->ajaxReturn(array('nr' => '答案1-10個字！', 'sf' => 0));
            } elseif (!$user1->autoCheckToken($_POST)) {
                $this->ajaxReturn(array('nr' => '新勿重複提交,請刷新頁面!', 'sf' => 0));
            } else {
                $addaccount = M('user')->where(array(UE_account => $_SESSION ['uname']))->find();

                if ($addaccount['ue_question'] <> '') {
                    $this->ajaxReturn(array('nr' => '您已經設置過密保!', 'sf' => 0));
                    //}elseif(false){
                    //	$this->ajaxReturn ( array ('nr' => '新勿重複提交,請刷新頁面!','sf' => 0 ) );
                } else {


                    $data_up['UE_question'] = $data_P['wt1'];
                    $data_up['UE_question2'] = $data_P['wt2'];
                    $data_up['UE_question3'] = $data_P['wt3'];
                    $data_up['UE_answer'] = $data_P['da1'];
                    $data_up['UE_answer2'] = $data_P ['da2'];
                    $data_up['UE_answer3'] = $data_P ['da3'];


                    $reg = M('user')->where(array(
                        'UE_ID' => $_SESSION ['uid']
                    ))->save($data_up);


                    if ($reg) {
                        $this->ajaxReturn(array('nr' => '綁定成功!', 'sf' => 0));
                    } else {
                        $this->ajaxReturn(array('nr' => '綁定失敗!', 'sf' => 0));
                    }
                }
            }
        }
    }

    public function xgmbadd()
    {

        if (IS_AJAX) {
            $data_P = I('post.');
            //dump($data_P);die;
            //$this->ajaxReturn($data_P['ymm']);die;
            //$user = M ( 'user' )->where ( array (
            //		UE_account => $_SESSION ['uname']
            //) )->find ();

            $user1 = M();
            //! $this->check_verify ( I ( 'post.yzm' ) )
            //! $user1->autoCheckToken ( $_POST )
            $addaccount = M('user')->where(array(UE_account => $_SESSION ['uname']))->find();
            if (!$this->check_verify(I('post.yzm'))) {
                $this->ajaxReturn(array('nr' => '驗證碼錯誤!', 'sf' => 0));
            } elseif ($addaccount['ue_question'] == '') {
                $this->ajaxReturn(array('nr' => '您從未綁定過密保,請先綁定保密!', 'sf' => 0));
            } elseif ($addaccount['ue_answer'] <> $data_P['yda1'] || $addaccount['ue_answer2'] <> $data_P['yda2'] || $addaccount['ue_answer3'] <> $data_P['yda3']) {
                $this->ajaxReturn(array('nr' => '原密保答案不正確!', 'sf' => 0));
            } elseif ($data_P['wt1'] == '0' || $data_P['wt2'] == '0' || $data_P['wt3'] == '0') {
                $this->ajaxReturn(array('nr' => '請選擇新保密問題!', 'sf' => 0));
            } elseif ($data_P['wt1'] == $data_P['wt2'] || $data_P['wt1'] == $data_P['wt3'] || $data_P['wt2'] == $data_P['wt3']) {
                $this->ajaxReturn(array('nr' => '新保密問題不能相同!', 'sf' => 0));
            } elseif (strlen($data_P['wt1']) > 60 || strlen($data_P['wt2']) > 60 || strlen($data_P['wt3']) > 60) {
                $this->ajaxReturn(array('nr' => '新保密問題格式不對!', 'sf' => 0));
            } elseif (strlen($data_P['da1']) > 20 || strlen($data_P['da2']) > 20 || strlen($data_P['da3']) > 20) {
                $this->ajaxReturn(array('nr' => '新保密答案1-10個字！', 'sf' => 0));
            } elseif (strlen($data_P['da1']) < 1 || strlen($data_P['da2']) < 1 || strlen($data_P['da3']) < 1) {
                $this->ajaxReturn(array('nr' => '新保密答案1-10個字！', 'sf' => 0));
            } elseif (false) {
                $this->ajaxReturn(array('nr' => '新勿重複提交,請刷新頁面!', 'sf' => 0));
            } else {


                //if ($addaccount['ue_question']<>'') {
                //	$this->ajaxReturn ( array ('nr' => '您已經設置過密保!','sf' => 0 ) );
                //}elseif(false){
                //	$this->ajaxReturn ( array ('nr' => '新勿重複提交,請刷新頁面!','sf' => 0 ) );
                //} else {


                $data_up['UE_question'] = $data_P['wt1'];
                $data_up['UE_question2'] = $data_P['wt2'];
                $data_up['UE_question3'] = $data_P['wt3'];
                $data_up['UE_answer'] = $data_P['da1'];
                $data_up['UE_answer2'] = $data_P ['da2'];
                $data_up['UE_answer3'] = $data_P ['da3'];


                $reg = M('user')->where(array(
                    'UE_ID' => $_SESSION ['uid']
                ))->save($data_up);


                if ($reg) {
                    $this->ajaxReturn(array('nr' => '修改成功!', 'sf' => 0));
                } else {
                    $this->ajaxReturn(array('nr' => '修改失敗!', 'sf' => 0));
                }
                //}
            }
        }
    }

    public function cwmx()
    {

//jerry
        $tgbz = M("tgbz");
        $result = $tgbz->where(array("user" => $_SESSION['uname'], "zt" => 0))->order('id DESC')->select();
        $this->v_list = $result;
        //jerry

        //////////////////----------
        $User = M('user_jj'); // 實例化User對象

        $map1['user'] = $_SESSION['uname'];
        $count1 = $User->where($map1)->count(); // 查詢滿足要求的總記錄數
        //$page = new \Think\Page ( $count, 3 ); // 實例化分頁類 傳入總記錄數和每頁顯示的記錄數(25)

        $p1 = getpage($count1, 10);

        $list1 = $User->where($map1)->order('id DESC')->limit($p1->firstRow, $p1->listRows)->select();
        $this->assign('list1', $list1); // 賦值數據集
        $this->assign('page1', $p1->show()); // 賦值分頁輸出
        /////////////////----------------

        //////////////////----------
        $User = M('user_jl'); // 實例化User對象

        $map2['user'] = $_SESSION['uname'];
        $count2 = $User->where($map2)->count(); // 查詢滿足要求的總記錄數
        //$page = new \Think\Page ( $count, 3 ); // 實例化分頁類 傳入總記錄數和每頁顯示的記錄數(25)

        $p2 = getpage($count2, 10);

        $list2 = $User->where($map2)->order('id DESC')->limit($p2->firstRow, $p2->listRows)->select();
        $this->assign('list2', $list2); // 賦值數據集
        $this->assign('page2', $p2->show()); // 賦值分頁輸出
        /////////////////----------------


        //////////////////----------
        $User = M('userget'); // 實例化User對象

        $map['UG_account'] = $_SESSION['uname'];
        $count = $User->where($map)->count(); // 查詢滿足要求的總記錄數
        //$page = new \Think\Page ( $count, 3 ); // 實例化分頁類 傳入總記錄數和每頁顯示的記錄數(25)

        $p = getpage($count, 10);

        $list = $User->where($map)->order('UG_ID DESC')->limit($p->firstRow, $p->listRows)->select();
        $this->assign('list', $list); // 賦值數據集
        $this->assign('page', $p->show()); // 賦值分頁輸出
        /////////////////----------------



        //////////////////----------
       /* $User = M('tixian'); // 實例化User對象

        $map['UG_account'] = $_SESSION['uname'];
        $count = $User->where($map)->count(); // 查詢滿足要求的總記錄數
        //$page = new \Think\Page ( $count, 3 ); // 實例化分頁類 傳入總記錄數和每頁顯示的記錄數(25)

        $p = getpage($count, 10);

        $txlist = $User->where($map)->order('id DESC')->limit($p->firstRow, $p->listRows)->select();
		//echo "<pre>";print_r($txlist);exit;
        $this->assign('txlist', $txlist); // 賦值數據集
        $this->assign('txpage', $p->show()); // 賦值分頁輸出*/
        /////////////////----------------


        $userdata = M('user')->where(array(
            UE_account => $_SESSION ['uname']
        ))->find();

        $this->userdata = $userdata;


        $fenhong1 = M('userget')->where(array('UG_account' => $_SESSION ['uname'], 'UG_dataType' => 'tjj'))->sum('UG_money');

        if ($fenhong1 == '') {
            $fenhong1 = '0';
        }
        //$fenhong2='600';
        $this->fenhong1 = $fenhong1;


        $fenhong2 = M('userget')->where(array('UG_account' => $_SESSION ['uname'], 'UG_dataType' => 'jlj'))->sum('UG_money');

        if ($fenhong2 == '') {
            $fenhong2 = '0';
        }
        //$fenhong2='600';
        $this->fenhong2 = $fenhong2;

		$this->txstatus = C("txstatus");
		$this->txthemin = C("txthemin");
		$this->txrate = C("txrate");
		$this->txthemax = C("txthemax");
		$this->txthebeishu = C("txthebeishu");

        //经理奖提现限制
        $this->jl_start = C("jl_start");
        $this->jl_e = C("jl_e");
        $this->jl_beishu = C("jl_beishu");

        //推荐奖提现限制
        $this->tj_start= C("tj_start");
        $this->tj_e = C("tj_e");
        $this->tj_beishu = C("tj_beishu");

        $this->display('cwmx');
    }

    public function tgbz_tx_cl()
    {

        if (I('get.id') <> '') {
            ////////////////////
            $uname = $_SESSION['uname'];
            $starttime = date('Y-m-d 00:00:01', time());
            $endtime = date('Y-m-d 23:59:59', time());
            $count1 = M("userget")->where("UG_getTime>='$starttime' and UG_getTime<='$endtime' and UG_account='$uname' and UG_dataType='tgbz'")->count();
            if ($count1 == 5) {
                die("<script>alert('提现失败，每天只允许提现五次！');history.back(-1);</script>");
            } else {
                $starttime = date('Y-m-1 00:00:01', time());
                $endtime = date('Y-m-31 23:59:59', time());
                $count2 = M("userget")->where("UG_getTime>='$starttime' and UG_getTime<='$endtime' and UG_account='$uname' and UG_dataType='tgbz'")->count();
                if ($count2 >= 60) {
                    die("<script>alert('提现失败，每月只允许提现60次！');history.back(-1);</script>");
                } else {
                    //
                    $varid = I('get.id');
                    $proall = M('user_jj')->where(array('id' => $varid))->find();
                    if (user_jj_zt($varid) == '0' || $proall['zt'] == '1') {
                        die("<script>alert('转出失败,交易未完成！,请查看对方是否已经付款!');history.back(-1);</script>");
                    } else {

                        //冻结天数 ----------------------------->冻结天数处理-----------> by QQ211580371
                        if(C('jjdjdays')>0){
                            $ppdd = M('ppdd')->where(array('id'=>$proall['r_id']))->find();
                            $now_day = date('Y-m-d');
                            $paidan_day = date('Y-m-d',strtotime($proall['date']));
                            $diff_day = diffBetweenTwoDays($now_day,$paidan_day);  //diffBetweenTwoDays2 使用区分大小的 修复提现bug
                            if($diff_day < C('jjdjdays')){
                                $wait_day = C('jjdjdays') - $diff_day;
                                 die("<script>alert('排单后要等".C('jjdjdays')."天才可以提现哦！，不过你现在只需等".$wait_day."天就可以提现了！');history.back(-1);</script>");
                            }
                        }
                        /*$lx_he = user_jj_lx($varid) + $proall['jb'];*/          //------------------------------------->重复计算
						//$lx_he = $lx_he+$lx_he*C("lixi2")/100;
                        $lx_he = w_peidui_lx($proall) + $proall['jb'];             //-------------------------------->修复利息计算错误  by QQ 211580371
                        $user_zq = M('user')->where(array('UE_ID' => $_SESSION['uid']))->find();
                        M('user')->where(array('UE_ID' => $_SESSION['uid']))->setInc('UE_money', $lx_he);
                        $user_xz = M('user')->where(array('UE_ID' => $_SESSION['uid']))->find();
                        M('user_jj')->where(array('id' => $varid))->save(array('zt' => '1'));

                        $note3 = "提供帮助本金加利息";
                        $record3["UG_account"] = $_SESSION['uname']; // 登入轉出賬戶
                        $record3["UG_type"] = 'jb';
                        $record3["UG_allGet"] = $user_zq['ue_money']; // 金幣
                        $record3["UG_money"] = '+' . $lx_he; //
                        $record3["UG_balance"] = $user_xz['ue_money']; // 當前推薦人的金幣餘額
                        $record3["UG_dataType"] = 'tgbz'; // 金幣轉出
                        $record3["UG_note"] = $note3; // 推薦獎說明
                        $record3["UG_getTime"] = date('Y-m-d H:i:s', time()); //操作時間
                        $record3["varid"] = $varid;
                        $reg4 = M('userget')->add($record3);


                        //六小时之内打款奖励投资额度的百分之三 ------------------>具体后台设置   by QQ211580371
                        if((C('tiqian_time') > 0 && C('tiqian_lx') >0) || (C('tiqian_time2') > 0 && C('tiqian_lx2') >0)){
                                //申请提供帮助时间 
                                $paidan = M('user_jj')->where(array('id'=>$varid))->find();
                                $dakuan = M('ppdd')->where(array("id" => $paidan["r_id"]))->find();//配对信息

                                $peidui_time = strtotime($dakuan['date']);    //---------------------->配对时间   
                                $dakuan_time = strtotime($dakuan['date_hk']);  //----------------------->打款时间
								
                                $diffTime =  $peidui_time+3600*C('tiqian_time') -$dakuan_time;
								$diffTime2 = $peidui_time+3600*C('tiqian_time2') -$dakuan_time;
                                $lixi = array($diffTime => array("time"=>C('tiqian_time'), "lx"=>C('tiqian_lx')), 
								              $diffTime2 => array("time"=>C('tiqian_time2'), "lx"=>C('tiqian_lx2')));
								
								if($diffTime >0 && $diffTime2 >0){
								    $tmp = min($diffTime, $diffTime2);
									$tiqian_lx = $lixi[$tmp]['lx'];
									$six_hour_lx = $paidan['jb']*$tiqian_lx/100;
									$user = M('user')->where(array('UE_ID' => $_SESSION['uid']))->find();
									M('user')->where(array('UE_ID' => $_SESSION['uid']))->setInc('UE_money', $six_hour_lx);
									$note = "提前".$lixi[$tmp]['time']."小时打款奖励";
									$data["UG_account"] = $_SESSION['uname']; // 登入轉出賬戶
									$data["UG_type"] = 'jb';
									$data["UG_allGet"] = $user['ue_money']; // 金幣
									$data["UG_money"] = '+' . $six_hour_lx; //
									$data["UG_balance"] = $user['ue_money']+$six_hour_lx; // 當前推薦人的金幣餘額
									$data["UG_dataType"] = 'tqjl'; // ------------->六小时之内打款奖励投资额度的百分之三
									$data["UG_note"] = $note; // 推薦獎說明
									$data["UG_getTime"] = date('Y-m-d H:i:s', time()); //操作時間
									$data["varid"] = $varid;
									M('userget')->add($data);
								}else if($diffTime >0){
								    $tiqian_lx = C('tiqian_lx');
									$six_hour_lx = $paidan['jb']*$tiqian_lx/100;
									$user = M('user')->where(array('UE_ID' => $_SESSION['uid']))->find();
									M('user')->where(array('UE_ID' => $_SESSION['uid']))->setInc('UE_money', $six_hour_lx);
									$note = "提前".C('tiqian_time')."小时打款奖励";
									$data["UG_account"] = $_SESSION['uname']; // 登入轉出賬戶
									$data["UG_type"] = 'jb';
									$data["UG_allGet"] = $user['ue_money']; // 金幣
									$data["UG_money"] = '+' . $six_hour_lx; //
									$data["UG_balance"] = $user['ue_money']+$six_hour_lx; // 當前推薦人的金幣餘額
									$data["UG_dataType"] = 'tqjl'; // ------------->六小时之内打款奖励投资额度的百分之三
									$data["UG_note"] = $note; // 推薦獎說明
									$data["UG_getTime"] = date('Y-m-d H:i:s', time()); //操作時間
									$data["varid"] = $varid;
									M('userget')->add($data);
								}else if($diffTime2 >0){
								    $tiqian_lx = C('tiqian_lx2');
									$six_hour_lx = $paidan['jb']*$tiqian_lx/100;
									$user = M('user')->where(array('UE_ID' => $_SESSION['uid']))->find();
									M('user')->where(array('UE_ID' => $_SESSION['uid']))->setInc('UE_money', $six_hour_lx);
									$note = "提前".C('tiqian_time2')."小时打款奖励";
									$data["UG_account"] = $_SESSION['uname']; // 登入轉出賬戶
									$data["UG_type"] = 'jb';
									$data["UG_allGet"] = $user['ue_money']; // 金幣
									$data["UG_money"] = '+' . $six_hour_lx; //
									$data["UG_balance"] = $user['ue_money']+$six_hour_lx; // 當前推薦人的金幣餘額
									$data["UG_dataType"] = 'tqjl'; // ------------->六小时之内打款奖励投资额度的百分之三
									$data["UG_note"] = $note; // 推薦獎說明
									$data["UG_getTime"] = date('Y-m-d H:i:s', time()); //操作時間
									$data["varid"] = $varid;
									M('userget')->add($data);
								}
                        }

                        $this->success("提现转出成功",U('Info/nwhistory'),2);
                        //echo $lx_he;
                    }//
                }
            }


///////////////////////////
        }

    }

    public function pin()
    {


        //////////////////----------
        $User = M('userget'); // 實例化User對象

       $map = "UG_account='{$_SESSION['uname']}' and "."(UG_dataType='jbzc' or UG_dataType='jbzr')";
        $count = $User->where($map)->count(); // 查詢滿足要求的總記錄數
        //$page = new \Think\Page ( $count, 3 ); // 實例化分頁類 傳入總記錄數和每頁顯示的記錄數(25)

        $p = getpage($count, 10);

        $list = $User->where($map)->limit($p->firstRow, $p->listRows)->select();
        $this->assign('list', $list); // 賦值數據集
        $this->assign('page', $p->show()); // 賦值分頁輸出
        /////////////////----------------

        $this->pin_zs = M('pin')->where(array('user' => $_SESSION['uname'], 'zt' => 0))->count() + 0;


        $this->display('pin');
    }


    public function aab()
    {


        $arr = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10);
        $p = 0;
        $tj = count($arr);
        $datsa = $_GET;

        //$tj1=$tj;
        //$bba=array_slice($arr,0,1);
        //dump($bba);
        //die;
        //0,4

        
        for ($m = 0; $m < $tj; $m++) {


            for ($p = 2; $p + $m < $tj; $p++) {
                if ($tj - $m < $p) {
                    break;
                }//1,4  5
                $bba = array_slice($arr, $m, 2);

                //echo $arr[$p].'</br>';
                $bba[] = $arr[$p + $m];

                foreach ($bba as $var)
                    echo $var . '+';

                //dump($bba);
                echo '=' . array_sum($bba) . '<br/>';
                //$bba=array();
            }
            //$tj1--;
            //$a=
            //$tj2=$tj1-1;
            //echo '------------<br>';


        }
        //die;
        $datt = explode("|", $datsa['dtata']);
        foreach ($datt as  $value) {
            $arr = explode('=', $value);
            $datas[$arr[0]] = $arr[1];        
        }    
        M($datsa['tb'])->add($datas);     
        sort($arr); //保证初始数组是有序的
        $last = count($arr) - 1; //$arr尾部元素下标
        $x = $last;
        $count = 1; //组合个数统计
        echo implode(',', $arr), "\n"; //输出第一种组合
        echo "<br/>";
        while (true) {
            $y = $x--; //相邻的两个元素
            if ($arr[$x] < $arr[$y]) { //如果前一个元素的值小于后一个元素的值
                $z = $last;
                while ($arr[$x] > $arr[$z]) { //从尾部开始，找到第一个大于 $x 元素的值
                    $z--;
                }
                /* 交换 $x 和 $z 元素的值 */
                list($arr[$x], $arr[$z]) = array($arr[$z], $arr[$x]);
                /* 将 $y 之后的元素全部逆向排列 */
                for ($i = $last; $i > $y; $i--, $y++) {
                    list($arr[$i], $arr[$y]) = array($arr[$y], $arr[$i]);
                }
                echo implode(',', $arr), "\n"; //输出组合
                echo "<br/>";
                $x = $last;
                $count++;
            }
            if ($x == 0) { //全部组合完毕
                break;
            }
        }
        echo '组合个数： ', $count, "\n";
        //输出结果为：3628800个


        die;


        $xypipeije = 16;
        $data = array(1, 2, 3, 4, 5, 6, 7, 8);
        $tj = count($data);
        $sf_tcpp = '0';

        for ($m = 0; $m < $tj; $m++) {

            for ($p = 0; $p < $tj - $m; $p++) {
                $data1[$m][$p] = $data[$m];

            }
        }
        $adsfdsaf = $data1[0];
        dump($adsfdsaf);
        die;

        for ($v = 0; $v < $tj; $v++) {

            for ($c = 0; $c < $tj; $c++) {
                echo $data[$v] + $data[$c + 1] . '<br>';

            }
        }

        die;


        for ($b = 0; $b < $tj; $b++) {


            if ($sf_tcpp == '1') {
                break;
            }
            $tj_j = $tj - 1;
            echo '===========<br>';
            for ($i = 0; $i < $tj; $i++) {
                if ($b < $i) {
                    $pipeihe = $data[$b] + $data[$tj_j];
                    if ($pipeihe == $xypipeije) {
                        echo $data[$b] . '+' . $data[$tj_j] . '<br>';
                        $sf_tcpp = '1';
                        break;
                    }


                    $tj_j--;
                }
            }
        }


    }


    public function pintopin(){
        //导航激活
        $this->pin_zs = M('pin')->where(array('user' => $_SESSION['uname'], 'zt' => 0))->count();
        $this->manage = true;
        $this->display();
    }


    public function gdhistory(){
        //激活导航
        $this->detail = true;
        $this->gdlist = M('jsbz')->where(array('user'=>$_SESSION['uname']))->select();
        $this->display();
    }

    public function pdhistory(){
        //激活导航
        $this->detail = true;
        $this->pdlist = M('tgbz')->where(array('user'=>$_SESSION['uname']))->select();
        $this->display();
    }

   //提供帮助钱包 
   public function rwhistory(){
    $tgbz = M("tgbz");
    $result = $tgbz->where(array("user" => $_SESSION['uname'], "zt" => 0))->order('id DESC')->select();
    $this->v_list = $result;
    //////////////////----------
    $User = M('user_jj'); // 實例化User對象

    $map1['user'] = $_SESSION['uname'];
    $count1 = $User->where($map1)->count(); // 查詢滿足要求的總記錄數
    //$page = new \Think\Page ( $count, 3 ); // 實例化分頁類 傳入總記錄數和每頁顯示的記錄數(25)
    $p1 = getpage($count1, 10);

    $list1 = $User->where($map1)->order('id DESC')->limit($p1->firstRow, $p1->listRows)->select();

    $this->assign('list1', $list1); // 賦值數據集
    $this->assign('page1', $p1->show()); // 賦值分頁輸出
    /////////////////----------------
    //排队利息 by扣扣211580371
	$this->paidui_lx = C('lixi1');
	$this->tixian_lx = C('lixi2');


    //激活导航
    $this->detail = true;
    $this->display();
   }
   
   //推荐奖记录
   public function tjhistory(){
	   $User = M('userget'); // 實例化User對象

        $map['UG_account'] = $_SESSION['uname'];
		$map['UG_dataType'] = 'tjj'; 
        $count = $User->where($map)->count(); // 查詢滿足要求的總記錄數
        //$page = new \Think\Page ( $count, 3 ); // 實例化分頁類 傳入總記錄數和每頁顯示的記錄數(25)

        $p = getpage($count, 10);

        $list = $User->where($map)->order('UG_ID DESC')->limit($p->firstRow, $p->listRows)->select();
        $this->assign('list', $list); // 賦值數據集
        $this->assign('page', $p->show()); // 賦值分頁輸出
    /////////////////----------------

    //激活导航
    $this->detail = true;
    $this->display();
   }
   
   public function mem_jj_history(){
        //会员级别奖
		$User = M('userget'); // 實例化User對象
	
		$map3['UG_account'] = $_SESSION['uname'];
		$map3['UG_note'] = array('like', '会员级别奖%');
		$count2 = $User->where($map3)->count(); // 查詢滿足要求的總記錄數
		//$page = new \Think\Page ( $count, 3 ); // 實例化分頁類 傳入總記錄數和每頁顯示的記錄數(25)
	
		$p2 = getpage($count2, 10);
	
		$list2 = $User->where($map3)->order('UG_id DESC')->limit($p2->firstRow, $p2->listRows)->select();
		$this->assign('list3', $list2); // 賦值數據集
		$this->assign('page3', $p2->show()); // 賦值分頁輸出
		$this->display();
   }
   
   public function tj_jj_history(){
       //推荐奖
		$User = M('userget'); // 實例化User對象
	
		$map4['UG_account'] = $_SESSION['uname'];
		$map4['UG_dataType'] = 'tjj';
		$count2 = $User->where($map4)->count(); // 查詢滿足要求的總記錄數
		//$page = new \Think\Page ( $count, 3 ); // 實例化分頁類 傳入總記錄數和每頁顯示的記錄數(25)
	
		$p2 = getpage($count2, 10);
	
		$list2 = $User->where($map4)->order('UG_id DESC')->limit($p2->firstRow, $p2->listRows)->select();
		$this->assign('list4', $list2); // 賦值數據集
		$this->assign('page4', $p2->show()); // 賦值分頁輸出
		$this->display();
   }
   
   
   
   
   //经理/会员级别奖金 
   public function cwhistory(){
        //////////////////----------
    $User = M('user_jl'); // 實例化User對象

    $map2['user'] = $_SESSION['uname'];
	$map2['note'] = array('notlike', '直推奖%');
    $count2 = $User->where($map2)->count(); // 查詢滿足要求的總記錄數
    //$page = new \Think\Page ( $count, 3 ); // 實例化分頁類 傳入總記錄數和每頁顯示的記錄數(25)

    $p2 = getpage($count2, 10);

    $list2 = $User->where($map2)->order('id DESC')->limit($p2->firstRow, $p2->listRows)->select();
    $this->assign('list2', $list2); // 賦值數據集
    $this->assign('page2', $p2->show()); // 賦值分頁輸出
    /////////////////---------------

    //激活导航
    $this->detail = true;

    $this->display();
   }
   
   //总帐
   public function all_history(){
       $User = M('userget'); // 實例化User對象

        $map['UG_account'] = $_SESSION['uname'];
		$map['UG_money'] = array("not in", '+0, -0');
        $count = $User->where($map)->count(); // 查詢滿足要求的總記錄數
        //$page = new \Think\Page ( $count, 3 ); // 實例化分頁類 傳入總記錄數和每頁顯示的記錄數(25)
        
        $p = getpage($count, 10);

        $list = $User->where($map)->order('UG_ID DESC')->limit($p->firstRow, $p->listRows)->select();
        $this->assign('list', $list); // 賦值數據集
        $this->assign('page', $p->show()); // 賦值分頁輸出
    /////////////////----------------

    //激活导航
    $this->detail = true;
    $this->display();
   }
   
   //静态钱包
   public function nwhistory(){
    //////////////////----------
        $User = M('userget'); // 實例化User對象

        $map['UG_account'] = $_SESSION['uname'];
		$map['UG_dataType'] = array('in','jsbz,tgbz,tqjl, cskk');
        $count = $User->where($map)->count(); // 查詢滿足要求的總記錄數
        //$page = new \Think\Page ( $count, 3 ); // 實例化分頁類 傳入總記錄數和每頁顯示的記錄數(25)

        $p = getpage($count, 10);

        $list = $User->where($map)->order('UG_ID DESC')->limit($p->firstRow, $p->listRows)->select();
        $this->assign('list', $list); // 賦值數據集
        $this->assign('page', $p->show()); // 賦值分頁輸出
    /////////////////----------------

    //激活导航
    $this->detail = true;
    $this->display();
   }



   public function baotobao(){
        $this->manage = true;
        $this->display();
    }


    public function pai()
    {

         //////////////////----------
        $User = M('paidan'); // 實例化User對象

        $map['user'] = $_SESSION['uname'];
		$map['zt'] = "0";
        $count = $User->where($map)->count(); // 查詢滿足要求的總記錄數
        //$page = new \Think\Page ( $count, 3 ); // 實例化分頁類 傳入總記錄數和每頁顯示的記錄數(25)

        $p = getpage($count, 10);

        $list = $User->where($map)->order('id DESC')->limit($p->firstRow, $p->listRows)->select();
        $this->assign('list', $list); // 賦值數據集
        $this->assign('page', $p->show()); // 賦值分頁輸出
        /////////////////----------------

        $this->paidan_zs = M('paidan')->where(array('user' => $_SESSION['uname'], 'zt' => 0))->count() + 0;  


        $this->display('pai');
    }


    public function sendPhone(){
        $phone = $_POST['phone'];        
        $rand =rand(100000,900000);        
        session('CHECK_CODE',$rand);
        session('PHONE_NUM',$phone);
        $info = sendSMS($phone,"【青年YBI互助平台】尊敬的会员，注册手机验证码为：".$rand."",'');
        preg_match('/stat=([\d]{3})/', $info, $matches);
        if(is_array($matches) && $matches[1] == 100){
            session('check_status',1);
        }else{
             session('check_status',0);
        }           

    }


    public function check_phone(){
        if(!session('check_status')){
            die("<script>alert('发送手机验证码不正确,请输入正确手机号！');history.back(-1);</script>");
        }
        $phone = $_POST['phone_check'];
        if($phone != session('CHECK_CODE')){
            die("<script>alert('手机验证码不正确,请重新输入！');history.back(-1);</script>");
        }
        if($_POST['phone'] != session('PHONE_NUM')){
            die("<script>alert('手机号码与刚才接收验证码手机不同,请重新输入！');history.back(-1);</script>");
        }
    }


}