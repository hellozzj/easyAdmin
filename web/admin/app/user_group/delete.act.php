<?php
/**
 * 删除后台用户组
 * 
 */
 use app\lib\page; 
use app\lib\db\db; 
use app\lib\cconstant; 
use app\dal\admin_user_right;
use app\lib\app;
class Act_Delete extends Action{
	
    public function __construct(){
        parent::__construct();
    }

	/**
     * 执行入口
     */
    public function process(){
        if(!isset($this->_input['gid']) || !is_numeric($this->_input['gid'])){
            throw new Exception('参数错误!');
        }
        $gid = $this->_input['gid'];

		$res = Admin_User_Right::delAdminGroup($gid);
		App::alert('操作成功','href',App::url('list', '', '', true));
    }
}
