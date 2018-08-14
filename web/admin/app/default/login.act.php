<?php
/**----------------------------------------------------+
 * 系统用户登录
 * @author unchastity@163.com
 +-----------------------------------------------------*/
use app\lib\page; 
use app\lib\db\db; 
use app\lib\cconstant; 
use app\dal\admin_user_right;
use app\lib\app; 
use Maatwebsite\Excel\Facades\Excel;
use DfaFilter\SensitiveHelper;

class Act_Login extends Page{

    public function __construct(){
        parent::__construct();
        $this->_AuthLevel =  ACT_OPEN;
    }

    public function process(){
        if(!isset($this->_input['username'])){
            $this->showPage();
            return;
        }

        if(!$this->login($this->_input['username'], $this->_input['passwd'])){
            $this->showPage('用户名或密码错误', $this->_input['username']);
            return;
        }

        // 是否有指定特殊跳转?
        if(isset($this->_input['redirect'])){
            App::redirect(urldecode($this->_input['redirect']));
        }else{
            App::redirect(App::url('index'));
        }
    }

    /**
     * 登录
     * @param string $username 用户名
     * @param string $passwd 密码
     * @return 是否成功
     */
    private function login($username, $passwd){
        $info = $this->getUserinfo($username);
        //exit_json(md5($passwd));
        if(md5($passwd) != $info['user_pass']){
            return false;
        }

        if($info['status'] || !$info['check_state']){
            return false;
        }
        //登录成功
        $_SESSION['user_id'] = $info['user_id'];
        $_SESSION['group_id'] = $info['group_id'];
        $_SESSION['user_name'] = $info['user_name'];
        $rights = $this->get_rights($info['group_id']);
        $_SESSION['rights'] = $rights;
        $menu = $this->get_menu($info['group_id']);
        $_SESSION['menu'] = $menu;
        $helperinfo = array();
        $helperinfo = array(
            'uname' => $info['user_name'],
            'pwd' => md5($info['user_pass']),
            'sign' => md5($info['user_id'].$info['group_id'].$info['user_name']),
        );
        $_SESSION['helper_data'] = urlencode(serialize($helperinfo));
        return true;
    }
	
	/**
     * 获取访问权限
     * @param int $group_id 用户组id
     * @return array
     */
	private function get_rights($group_id){
		$auth = array();
		$menu_cnf = require CONFIG_DIR.'menu.php';
		$group_info = Admin_User_Right::getAdminGroupById($group_id);
		if(!empty($group_info)){
			
			$group_rights = json_decode($group_info['rights'],true);
			foreach($menu_cnf as $mkey => $mval){
				foreach($mval['sub'] as $key => $val){
					if($group_info['rights'] == 'all' || in_array($mkey.'_'.$key,$group_rights)){
						$auth[] = $val['url'];
					}
					
					if(isset($val['sub'])){
						foreach($val['sub'] as $k => $v){
							if($group_info['rights'] == 'all' || in_array($mkey.'_'.$key.'_'.$k,$group_rights)){
								$auth[] = $v['url'];
							}
						}
					}
				}
			}
			
		}
		
		return $auth;
	}
	
	/**
     * 获取菜单
     * @param int $group_id 用户组id
     * @return array
     */
	private function get_menu($group_id){
		$menu = array();
		$menu_cnf = require CONFIG_DIR.'menu.php';
		$group_info = Admin_User_Right::getAdminGroupById($group_id);
		if(!empty($group_info)){
			$group_rights = json_decode($group_info['rights'],true);
			foreach($menu_cnf as $mkey => $mval){
				foreach($mval['sub'] as $key => $val){
					if($group_info['rights'] == 'all'){//管理员组
						if($val['is_show'] === false){
							unset($menu_cnf[$mkey]['sub'][$key]);
						}
					}else{//非管理员组
						if($val['is_show'] === false || !in_array($mkey.'_'.$key,$group_rights)){
							unset($menu_cnf[$mkey]['sub'][$key]);
						}
					}
				}
			}
			
			foreach($menu_cnf as $mkey => $mval){
				if(is_array($mval['sub']) && count($mval['sub']) < 1){
					unset($menu_cnf[$mkey]);
				}
			}

			$menu = $menu_cnf;
			
		}
        
    	return $menu;
	}

    private function showPage($msg='', $username=''){
        $this->assign('message', $msg);
        $this->assign('username', $username);
        $this->display();
    }

    private function getUserinfo($username){
		$db_slave = Db::getSlaveInstance(CConstant::DB_MAIN);
        $sql = "select * from admin_user where user_name='$username'";
		
        return $db_slave->get_row($sql);
    }
}
