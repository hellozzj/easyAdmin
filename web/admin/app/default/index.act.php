<?php
/*-----------------------------------------------------+
 * 首页公告 
 +-----------------------------------------------------*/
use app\lib\page; 
use app\lib\db\db; 
use app\lib\cconstant; 
use app\dal\admin_user_right;
use app\lib\app; 
class Act_Index extends Page{
    public function __construct(){
        parent::__construct();
		$this->_AuthLevel =  ACT_NEED_LOGIN;
    }

    public function process(){
        $this->assign('title','首页');
        $this->display();
    }
}
