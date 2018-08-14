<?php
/**
* 删除

* @author 
* 模版生成时间：2018-05-30 13:18:32
*/

use app\lib\page; 
use app\lib\db\db; 
use app\lib\cconstant; 
use app\dal\admin_user_right;
use app\lib\app; 
use app\lib\form; 

class Act_T_User_DELETE extends Page {

    const GO_BACK = "?mod=t_user&act=t_user";

    public function __construct() {
        parent::__construct();
        $this->db_master = Db::getMasterInstance(CConstant::DB_MAIN);
    }

    /**
     * 执行入口
     */
    public function process (){
        if(!isset($this->_input['id']) || !is_numeric($this->_input['id'])){
            throw new Exception('参数错误!');
            exit();
        }

        $rt = $this->db_master->query("DELETE FROM `t_user` WHERE id='{$this->_input['id']}'");
        if($rt){
            $msg = '操作成功';
        }else{
            $msg = '操作失败';
        }
        $this->alert($msg,'href',self::GO_BACK);
    }

}

