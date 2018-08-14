<?php
/**
 * 公用类
 *
 * @author fengchao
 * 模版生成时间：2015-12-03 14:12:41
 */

class Act_Common extends Page {
    public
        $_AuthLevel = ACT_OPEN;
    public function __construct() {
        parent::__construct();
    }

    /**
     * 执行入口
     */
    public function process(){
        if(isset($this->_input['node'])){
            $node = $this->_input['node'];
            die($this->{$node}());
        }
    }

    // ----------- 921部分 ------------------
    /**
     *获取游戏列表
     */
    public function get_all_game(){

        $game_list = Channel_Game::getAllGame();

        return $this->createHtml($game_list, '请选择');

    }
    /**
     *获取一级渠道列表
     */
    /*public function get_parent_channel(){
        $channel_list = Channel_Game::getParentChannel();

        return $this->createHtml($channel_list, '渠道');

    }*/

    public function get_game_channel(){
        $result = array();
        $game_code = isset($this->_input['kw']['game_code']) ? $this->_input['kw']['game_code'] : '';
        $result = Channel_Game::getGameChannel($game_code);
        return $this->createHtml($result, '渠道');
    }

    public function get_channel_data(){
        $result = array();
        $device_type = isset($this->_input['kw']['device_type']) ? $this->_input['kw']['device_type'] : '';
        return json_encode(Channel_Game::getChannel($device_type));
    }

    public function get_channel(){
        $result = array();
        $device_type = isset($this->_input['kw']['device_type']) ? $this->_input['kw']['device_type'] : '';
        $result = Channel_Game::getChannel($device_type);

        return $this->createHtml($result, '渠道');
    }

    /**
     *获取一级游戏列表
     */
    public function get_parent_game(){
        $developer_code = isset($this->_input['kw']['developer_code']) ? $this->_input['kw']['developer_code'] : '';
        $game_list = Channel_Game::getParentGame($developer_code);

        return $this->createHtml($game_list, '一级游戏');

    }

    public function get_parent_game_by_device(){
        $device_type = isset($this->_input['kw']['device_type']) ? $this->_input['kw']['device_type'] : '';
        $result = Channel_Game::getParentGameByDevice($device_type);
        return $this->createHtml($result, '一级游戏');
    }

    public function get_child_game(){
        $parent_game_id = isset($this->_input['kw']['parent_game_id']) ? $this->_input['kw']['parent_game_id'] :''; 
        $result = Channel_Game::getChildGame($parent_game_id);
        return $this->createHtml($result, '二级游戏');
    }
    /**
     *获取开发商列表
     */
    public function get_all_developer(){

        $developer_list = Channel_Game::getAllDeveloper();

        return $this->createHtml($developer_list, '请选择开发商');

    }

    /**
     *获取一级游侠列表
     */
    public function get_all_parent_game(){

        $parent_gam_list = Channel_Game::getParentGame();

        return $this->createHtml($parent_gam_list, '请选择一级游戏');

    }


    //------------------------ 公用部分 ----------------------

    public function createHtml($input = array(), $msg=''){
        $html = "<option value=''>".$msg."</option>";
        if(!empty($input)){
            foreach($input as $key=>$val){
                $html .= "<option value=".$key.">".$val."</option>";
            }

        }
        return $html;
    } 
}

