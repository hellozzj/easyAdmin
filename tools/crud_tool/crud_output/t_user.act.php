<?php
/**
* 测试测试管理

* @author zhanzengjin
* 模版生成时间：2018-05-29 15:04:24
*/
use app\lib\page; 
use app\lib\db\db; 
use app\lib\cconstant; 
use app\dal\admin_user_right;
use app\lib\app;

class Act_T_User extends Page {

    const TABLE_NAME = "t_user";
    const TABLE_KEY_FIELD = "id";

    public $order_by = "";
    public $sorting = "ASC";


    public function __construct() {
        parent::__construct();
        $this->db_slave = Db::getSlaveInstance(CConstant::DB_MAIN);
    }

    /**
     * 执行入口
     */
    public function process (){
        $this->assign('title', '测试测试');
        if(isset($this->_input['is_ajax'])){
            $this->assign('data', $this->get_data());
            $total_record = $this->get_total_num();
            $this->assign('total_record', $total_record);
            $this->assign('page', $this->create_pager($total_record));
            $this->assign('pager_limit', $this->create_pager_limit());
            $this->assign('limit', $this->limit);
        }
        $this->display();
    }

    /**
     * 获取查询条件语句
     */
    private function condition() {
        $where = array();   
                        
                        
        if(!$where) return '';
        return  " WHERE ".implode(' AND ', $where);
    }

    /**
     * 获取数据列表
     */
    public function get_data(){
        $where = $this->condition();
        $order_and_limit = $this->get_order_and_limit();
        $this->sql = "SELECT COUNT(*) FROM `".self::TABLE_NAME."` {$where}";
        return $this->db_slave->get_all("SELECT * FROM `".self::TABLE_NAME."` {$where} {$order_and_limit}");
    }

    /**
     * 获取数据总条数
     */
    public function get_total_num(){
        return $this->db_slave->get_one($this->sql);
    }


    public function fetch() {
        //如果没有添加任何模板则默认使用与当前动作同名的模板
        if(!count($this->_tplFile)){
            if(isset($this->_input['is_ajax'])){
                $this->addTemplate('sub_'.CURRENT_ACTION);
            }else{
                $this->addTemplate(CURRENT_ACTION);
            }
        }
        $this->compile($this->_pagevar);
        return $this->_contents;
    }
}

