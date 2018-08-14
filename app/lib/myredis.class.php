<?php
/*-----------------------------------------------------+
 * redis操作类
 * @author unchastity@163.com
 * @since 2015.09.16
 +-----------------------------------------------------*/
 namespace app\lib;
class MyRedis{


    private static $instance;

    private 
        $_handler = '',
        $_position = '',
        $_db_type = '';

    public function __construct($db_type, $dsn, $position) {
        $this->_handler = New Redis();
        $this->_handler->pconnect($dsn['host'], $dsn['port']);
        $this->_position = $position;
        $this->_db_type = $db_type;
    }

    /**
     * 获取主库实例
     * @param string $db_type redis名
     */
    public static function getMasterInstance($db_type){
        if(isset(self::$instance[$db_type][CConstant::DB_POS_MASTER])){
            return self::$instance[$db_type][CConstant::DB_POS_MASTER];
        }
        $dsn = self::getMaterConfig($db_type);
        return self::getInstance($db_type, $dsn, CConstant::DB_POS_MASTER);
    }

    /**
     * 获取从库实例
     * @param string $db_type redis名
     */
    public static function getSlaveInstance($db_type){
        if(isset(self::$instance[$db_type][CConstant::DB_POS_SLAVE])){
            return self::$instance[$db_type][CConstant::DB_POS_SLAVE];
        }
        $dsn = self::getSlaveConfig($db_type);
        return self::getInstance($db_type, $dsn, CConstant::DB_POS_SLAVE);
    }

    /**
     * 获取单例
     */
    private static function getInstance($db_type, $dsn, $position){
        try{
            if(!$dsn){
                throw new Exception("redis配置错误");
            }
            self::$instance[$db_type][$position] = new self($db_type, $dsn, $position);
            return self::$instance[$db_type][$position];
        }catch(Exception $e){
            self::halt($e,'redis连接失败');
        }
    }

    /**
     * 获取主库的db配置
     * @param string $db_type redis名
     */
    public static function getMaterConfig($db_type){
        $config =  Config::get($db_type, 'redis');
        $config['host'] = $config[CConstant::DB_POS_MASTER]['host'];
        $config['port'] = $config[CConstant::DB_POS_MASTER]['port'];
        return $config;
    }

    /**
     * 获取从库的db配置
     * @param string $db_name redis名
     */
    public static function getSlaveConfig($db_type){
        $config =  Config::get($db_type, 'redis');
        // 随机选取一个从库
        $index = rand(0, count($config[CConstant::DB_POS_SLAVE]) -1);
        $config['host'] = $config[CConstant::DB_POS_SLAVE][$index]['host'];
        $config['port'] = $config[CConstant::DB_POS_SLAVE][$index]['port'];
        return $config;
    }

    /**
     * 在key的前面加上前缀
     */
    public function add_prex($key, $prex){
        return "{$prex}:{$key}";
    }

    /**
     * 设置一个key=>value
     */
    public function set($key, $value, $prex, $ttl = 0) {
        $this->halt_invalid_write();
        // 数组使用json格式保存
        $value  =  is_array($value) ? json_encode($value) : $value;
        $key = $this->add_prex($key, $prex);
        if($ttl > 0){
            return $this->_handler->setex($key, $ttl, $value);
        }else{
            return $this->_handler->set($key, $value);

        }
    }

    /**
     * 获取一个key对应的value
     */
    public function get($key, $prex) {
        $this->halt_invalid_read();
        $key = $this->add_prex($key, $prex);
        $value = $this->_handler->get($key);
        $jsonData  = json_decode($value, true);
        //检测是否为JSON数据 true 返回JSON解析数组, false返回源数据
        return ($jsonData === NULL) ? $value : $jsonData;
    }


    /**
     * 删除一个key对应的value
     */
    public function delete($key, $prex) {
        $this->halt_invalid_write();
        $key = $this->add_prex($key, $prex);
        return $this->_handler->delete($key);
    }


    /**
     * 往队列中加一个value
     */
    public function push($queue, $value) {
        $this->halt_invalid_write();
        // 数组使用json格式保存
        $value  =  is_array($value) ? json_encode($value) : $value;
        return $this->_handler->lPush($queue, $value);
    }

    /**
     * 从队列中拿一个value
     */
    public function pop($queue){
        $this->halt_invalid_write();
        $value = $this->_handler->lPop($queue);
        $jsonData  = json_decode($value, true);
        //检测是否为JSON数据 true 返回JSON解析数组, false返回源数据
        return ($jsonData === NULL) ? $value : $jsonData;
    }

    /**
     * 从队列中拿num个value
     */
    public function range($queue, $num){
        $this->halt_invalid_write();
        return $this->_handler->lRange($queue, 0, $num);
    }

    /**
     * key对应的value += 1
     */
    public function incr($key, $prex){
        $this->halt_invalid_write();
        $key = $this->add_prex($key, $prex);
        return $this->_handler->incr($key);
    }

    /**
     * 清除缓存
     */
    public function flush_all(){
        // 只有开发环境下才可以清缓存 测试用
        if(!DEBUG){
            return false;
        }
        return $this->_handler->flushAll();
    }

    /**
     * 终止错误的主从操纵
     * 写缓存必须在主库执行
     */
    private function halt_invalid_write(){
        if(DEBUG && $this->_position == CConstant::DB_POS_SLAVE){
            throw new Exception("主从库操作错误");
        }
    }

    /**
     * 终止错误的主从操纵
     * 除了队列和自增以外，读缓存必须在从库执行
     */
    private function halt_invalid_read(){
        if(DEBUG && $this->_position == CConstant::DB_POS_MASTER){
            throw new Exception("主从库操作错误");
        }
    }
    /**
     * 退出
     */
    private static function halt($err,$msg=''){
        if(@defined(NO_DIE)){
            //异常不终止 重新抛出异常 供上层监测
            throw $err;
        }
        if(!DEBUG)exit('invalid operate.');
        $error = $err->getMessage();
        $errno = $err->getCode();
        $debug_info = $err->getTrace();
        $err_html = '';
        if($msg){
            $err_html .= "<b>Redis error:</b> $msg <br />";
        }
        $err_html .= "<b>Redis Error:</b><br />errno: {$errno} <br />error: {$error}<br />";
        $err_txt='';
        foreach ($debug_info as $v)
            if (isset($v['file'])) {
                $err_html .= "<b>File:</b> {$v['file']} (Line: {$v['line']})<br />";
                $err_txt .="{$v['file']} (Line: {$v['line']})\r\n";
            }
        echo "<pre>".$err_html."</pre>";
        exit();
    }
}
