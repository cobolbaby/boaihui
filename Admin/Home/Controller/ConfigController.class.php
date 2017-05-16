<?php
namespace Home\Controller;
use Think\Controller;
class   ConfigController extends CommonController {
    
	  public function paidanma(){
		   $data['values']=I('account');
			 if(IS_POST){
				$query=M('config')->where("id=3")->save($data);
				if($query){
					 $this->success("操作成功");
				}else{
					 $this->error("失败");
				}
			 }else{
				$info=M('config')->where("id=3")->find();
				$this->assign('info',$info);
				$this->display();
				 
			 }
		  
	  }
}