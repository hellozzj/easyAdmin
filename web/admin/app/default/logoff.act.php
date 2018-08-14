<?php
/**----------------------------------------------------+
 * 退出登录
 * @author unchastity@163.com
 +-----------------------------------------------------*/
use app\lib\page; 
use app\lib\db\db; 
use app\lib\cconstant; 
use app\dal\admin_user_right;
use app\lib\app; 
use app\lib\action; 
class Act_Logoff extends Action{
	public function __construct(){
        parent::__construct();
        $this->_AuthLevel =  ACT_OPEN;
    }
    public function process(){
		session_destroy();
        App::redirect(App::url('login', ''));
    }
}
