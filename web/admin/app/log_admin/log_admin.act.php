<?php
/**
 * 后台操作日志管理

 * @author unchastity@163.com
 * 模版生成时间：2016-03-09 17:26:15
 */

class Act_Log_Admin extends Page {

    const TABLE_NAME = "log_admin";
    const TABLE_KEY_FIELD = "id";

    public $order_by = "create_time";
    public $sorting = "DESC";


    public function __construct() {
        parent::__construct();
        $this->db_slave = Db::getSlaveInstance(CConstant::DB_MAIN);


        if(!isset($this->_input['kw']['start_time'])){
            $this->_input['kw']['start_time'] = date('Y-m-d', strtotime('-1 month'));
        }

        if(!isset($this->_input['kw']['end_time'])){
            $this->_input['kw']['end_time'] = date('Y-m-d');
        }

        $this->log_type_arr = array(
            "-999" => "--&nbsp;&nbsp;全部&nbsp;&nbsp;--",
            " 1" => "用户操作",
            "2" => "后台任务",
        );

    }

    /**
     * 执行入口
     */
    public function process (){
        $this->assign('title', '后台操作日志');
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

        if(isset($this->_input['kw']['start_time']) && $this->_input['kw']['start_time']){
            $start_time = strtotime($this->_input['kw']['start_time']);
        }else{
            $start_time = strtotime('-1 month');
            $this->_input['kw']['start_time'] = date('Y-m-d', $start_time);
        }

        if(isset($this->_input['kw']['end_time']) && $this->_input['kw']['end_time']){
            $end_time = strtotime($this->_input['kw']['end_time'].' 23:59:59');
        }else{
            $end_time = strtotime(date('Y-m-d 23:59:59'));
            $this->_input['kw']['end_time'] = date('Y-m-d');
        }    
        $where[] = "create_time >= '".$start_time."'";
        $where[] = "create_time <= '".$end_time."'";


        if(isset($this->_input['kw']['log_user']) && $this->_input['kw']['log_user']){
            $where[] = "log_user like '{$this->_input['kw']['log_user']}%'";
        }

        if(isset($this->_input['kw']['task_name']) && $this->_input['kw']['task_name']){
            $where[] = "task_name like '{$this->_input['kw']['task_name']}%'";
        }

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

