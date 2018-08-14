<?php
// helper 类
namespace app\common;
use voku\helper\AntiXSS;

class Helper{
	public function __construct(){
		echo "string";exit;
	}

	/*
	 * 扫描所有子目录
	 * */
	public static function scanDirs($dir){
	    $dirs = array();
	    $dh  = @opendir($dir);
	    while (false !== ($file_name = readdir($dh))) {
	        if($file_name !='.' && $file_name !='..' && is_dir($dir.$file_name)){
	            $dirs[] = $dir.$file_name;
	        }
	    }
	    @closedir($dh);
	    return $dirs;
	}

	public static function alert($content = false, $url = ""){
	    $javascript = "<script>";

	    //链接警告窗口
	    $javascript .= $content ? ("alert('" . $content . "');") : ("");

	    //链接跳转信息
	    $javascript .= ($url == "") ? ("history.back();") : ("document.location.href='" . $url . "'");

	    //链接尾部信息
	    $javascript .= "</script>";

	    echo $javascript;
	    exit;
	}

	public static function ip_valid($ip) {
	    //为开发便利设127.0.0.1为合法
	    if(DEBUG&&$ip=='127.0.0.1') return true;
	    if (filter_var($ip, FILTER_VALIDATE_IP, 
	        //FILTER_FLAG_IPV4 | 
	        //FILTER_FLAG_IPV6 |
	        FILTER_FLAG_NO_RES_RANGE |
	        FILTER_FLAG_NO_PRIV_RANGE) === false)
	        return false;
	    return true;
	}

	/*
	 * HTTP_X_FORWARDED_FOR为逗号分隔的一系列Ip，或者unknown,或者null
	 * 取HTTP_X_FORWARDED_FOR的第一个逗号前的字符串，有可能是unknown
	 * @return string
	 */
	public static function get_XFF_IP(){
	    $xip=getenv ( 'HTTP_X_FORWARDED_FOR' );
	    //$xip='120.120.121.1,120.120.121.13';
	    if(preg_match('/[\d\.]{7,15}(,[\d\.]{7,15})+/',$xip)){
	        $xips=explode(',',getenv ( 'HTTP_X_FORWARDED_FOR' ));
	        return $xips[0];
	    }else{
	        return $xip;
	    }
	}

	//获取客户端IP
	public static function get_client_ip() {
	    $cip = getenv ( 'HTTP_CLIENT_IP' );
	    $rip = getenv ( 'REMOTE_ADDR' );
	    $srip = $_SERVER ['REMOTE_ADDR'];
	    //多玩平台的HTTP_X_FORWARDED_FOR得到127.0.0.1，这里做一个临时处理
	    if ($cip && strcasecmp ( $cip, 'unknown' )) {
	        $onlineip = $cip;
	    } else{
	        $xip = get_XFF_IP();//getenv ( 'HTTP_X_FORWARDED_FOR' );
	        if ($xip && ($xip !="127.0.0.1") && strcasecmp ( $xip, 'unknown' )) {
	            $onlineip = $xip;
	        } elseif ($rip && strcasecmp ( $rip, 'unknown' )) {
	            $onlineip = $rip;
	        } elseif ($srip && strcasecmp ( $srip, 'unknown' )) {
	            $onlineip = $srip;
	        }
	        preg_match ( "/[\d\.]{7,15}/", $onlineip, $match );
	        return $match [0] ? $match [0] : 'unknown';
	    }
	}

	/**
	 * 输出变量的内容，通常用于调试
	 *
	 * @package Core
	 *
	 * @param mixed $vars 要输出的变量
	 * @param string $label
	 * @param boolean $return
	 */
	public static function dump($vars, $label = '', $return = false) {
	    if (ini_get ( 'html_errors' )) {
	        $content = "<pre>\n";
	        if ($label != '') {
	            $content .= "<strong>{$label} :</strong>\n";
	        }
	        $content .= htmlspecialchars ( print_r ( $vars, true ) );
	        $content .= "\n</pre>\n";
	    } else {
	        $content = $label . " :\n" . print_r ( $vars, true );
	    }
	    if ($return) {
	        return $content;
	    }
	    echo $content;
	    return null;
	}

	public static function dstripslashes($vars) {
	    return is_array ( $vars ) ? array_map ( array(self,__FUNCTION__), $vars ) : stripslashes ( $vars );
	}

	public static function daddslashes($vars) {
	    return is_array ( $vars ) ? array_map ( [get_called_class(),__FUNCTION__], $vars ) : addslashes ( $vars );
	}


	//获取加密串
	public static function get_sign($seccode, $param_arr)
	{
	    $sign = $seccode;
	    if (is_array($param_arr)) {
	        ksort($param_arr);
	        foreach ($param_arr as $key => $val) {
	            if ($key !='' && $val !='') {
	                $sign .= $key.$val;
	            }
	        }
	    }
	    $sign = strtoupper(md5($sign));
	    return $sign;
	}



	//秒数转化为时间
	public static function secondToString($diff)
	{
	    if ($diff < 60) {
	        return intval($diff % 60) . "秒";
	    } elseif ($diff < 60 * 60) {
	        return intval($diff / 60) . "分钟";
	    } elseif ($diff < 60 * 60 * 24) {
	        return intval($diff / 60 / 60) . "小时";
	    } elseif ($diff < 60 * 60 * 24 * 7) {
	        return intval($diff / 60 / 60/ 24) . "天";
	    } elseif ($diff < 60 * 60 * 24 * 30) {
	        return intval($diff / 60 / 60/ 24/7) . "星期";
	    } elseif ($diff < 60 * 60 * 24 * 365) {
	        return intval($diff / 60 / 60/ 24 / 30) . "月(".intval($diff / 60 / 60/ 24)."天)";
	    } else {
	        $year = intval($diff / 60 / 60/ 24 / 365);
	        return $year . "年(".intval($diff / 60 / 60/ 24)."天)";
	    }
	}


	//获取字符串中的时间戳，并以数组形式返回，找不到返回 false
	public static function get_timestamp_array($str)
	{
	    if(!preg_match_all('#\d{10}#', $str, $matches)){
	        return false;
	    }
	    return $matches[0];
	}

	// 打印json
	public static function exit_json($var){
	    die(json_encode($var));
	}

	/*
	 * 获得一个随机字符串
	 * */
	public static function rand_string($len = 32) {
	    $char_set = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
	    return do_rand_string($char_set, $len);
	}

	/*
	 * 扩展随机字符串 包含特殊字符
	 * */
	public static function randStringx($len = 32) {
	    $char_set = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890~!@#$%^&*()_+";
	    return do_rand_string($char_set, $len);
	}
	/*
	 * 随机字符串
	 * */
	public static function do_rand_string($char_set, $len = 32) {
	    $strLen = strlen($char_set);
	    $string = '';
	    for($i = 0; $i < $len; $i++) {
	        $string .= substr($char_set, mt_rand(0, $strLen), 1);
	    }
	    return $string;
	}

	/**
	 * 日志函数
	 * @param $vars 需要写log的变量
	 * @param string $file_name 文件名
	 * 为了debug方便，建议用类名和文件名命名log文件:debug_log($vars,__CLASS__.'-'.__public static FUNCTION__);
	 * logs目录与www目录同级，在boot.php中定义
	 */
	public static function debug_log($vars,$file_name=null){
		// if(!DEBUG) return;
		qlog($vars,$file_name);
	}
	/**
	 * 日志函数
	 * @param $vars 需要写log的变量
	 * @param string $file_name 文件名
	 * 忽略DEBUG变量
	 */
	public static function qlog($vars,$file_name=null){
		if(is_array($vars)||is_object($vars)){
			$vars=json_encode($vars);
		}
		$vars=date('h:i:s',time()).': '.$vars;
		$file_name=$file_name?$file_name:'qlog';
		if(!is_dir(LOG_DIR)){
			mkdir(LOG_DIR);
		}
		$log_file=fopen(LOG_DIR.'/'.$file_name.'_'.date('ymd',time()).'.log','a+');
		fputs($log_file,$vars."\r\n");
		fclose($log_file);
	}

	/**
	 * 对变量进行 trim 处理,支持多维数组.(截去字符串首尾的空格)
	 * @param mixed $vars
	 * @return mixed 
	 */
	public static function trimArr($vars) {
	    return is_array ( $vars ) ? array_map ( [get_called_class(),__FUNCTION__], $vars ) : trim ( $vars );
	}

	/**
	 * 对变量进行 nl2br 和 htmlspecialchars 操作,支持多维数组.（可将字符串中的换行符转成HTML的换行符号）
	 * @param mixed $vars
	 * @return mixed  
	 */
	public static function textFormat($vars) {
	    return is_array ( $vars ) ? array_map ([get_called_class(),__FUNCTION__], $vars ) : nl2br ( htmlspecialchars ( $vars ) );
	}

	/**
	 * 执行一个 HTTP 请求
	 * @param string    $Url    执行请求的Url
	 * @param mixed     $params 表单参数, 如果是get的话，此参数无效
	 * @param string    $method 请求方法 post / get
	 * @return array 结果数组
	 */
	 public static function request($url, $params = '', $method='get', $content_type='')
	{
	    $Curl = curl_init();//初始化curl

	    if ('get' === $method){//以GET方式发送请求
	        curl_setopt($Curl, CURLOPT_URL, $url);
	    }else{//以POST方式发送请求
	        curl_setopt($Curl, CURLOPT_URL, $url);
	        curl_setopt($Curl, CURLOPT_POST, 1);//post提交方式
	        curl_setopt($Curl, CURLOPT_POSTFIELDS, $params);//设置传送的参数
	    }
	    if($content_type){
	        curl_setopt($Curl, CURLOPT_HTTPHEADER, array("Content-type: {$content_type}" ));
	    }else{
	    	curl_setopt($Curl, CURLOPT_HEADER, false);//设置header
		}
	    curl_setopt($Curl, CURLOPT_RETURNTRANSFER, true);//要求结果为字符串且输出到屏幕上
	    curl_setopt($Curl, CURLOPT_CONNECTTIMEOUT, 3);//设置等待时间

	    $Res = curl_exec($Curl);//运行curl
	    $Err = curl_error($Curl);
	     
	    if (false === $Res || !empty($Err)){
	        $Errno = curl_errno($Curl);
	        $Info = curl_getinfo($Curl);
	        curl_close($Curl);
	        return array(
	                'result' => false,
	                'errno' => $Errno,
	                'msg' => $Err,
	                'info' => $Info,
	        );
	    }
	    curl_close($Curl);//关闭curl
	    return array(
	        'result' => true,
	        'msg' => $Res,
	    );
	}

	/*
	 * 获取当前时间戳属于一年中第几季度
	 * */
	public static function get_quarter($ts){
	    $month = date('m', $ts);
	    return ceil($month / 3);
	}

	/*
	 * 获取语言
	 * */
	public static function get_lang($key){
	    echo Lang::getLang($key);
	}


	/**
	 * 通过CURL POST
	 * @param data $data 是 json 字符串   
	 * 
	 */
	 public static function curl_post_json($url, $data)
	{
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_HEADER, 0);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_POST, 1);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type:application/json;charset=utf-8'));
	    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

	    $Res = curl_exec($ch);//运行curl
	    $Err = curl_error($ch);
	     
	    if (false === $Res || !empty($Err)){
	        $Errno = curl_errno($ch);
	        $Info = curl_getinfo($ch);
	        curl_close($ch);
	        return array(
	                'result' => false,
	                'errno' => $Errno,
	                'msg' => $Err,
	                'info' => $Info,
	        );
	    }
	    curl_close($ch);//关闭curl
	    return array(
	        'result' => true,
	        'msg' => $Res,
	    );
	}

	/**
	 * 保存上传文件
	 * @param array $file 上传文件数组
	 * @param string $dir 保存目录
	 * @param string $ext 保存文件扩展名(默认为空,即原始文件扩展名)
	 * @return array $res
	 */
	public static function save_upload_file($file, $dir, $ext = ''){
		$res = array();
		foreach($file['data']['tmp_name'] as $key => $val){
			$res[$key] = '';
			if(!empty($val)){
				
				if(!file_exists($dir)){
					mkdir($dir,0777,true);
				}
				
				//文件扩展名
				if(empty($ext)){
					$info = pathinfo($file['data']['name'][$key]);
					$ext = $info['extension'];
				}
				//保存文件
				$new_file_name = $dir.'/'.$key.'_'.date('YmdHis').'.'.$ext;
				if(rename($val,$new_file_name)){
					$res[$key] = ltrim($new_file_name,ADMIN_DIR);
				}
			}
		}
		return $res;
	}

	// xss 过滤
	public static function xssClean($string) {
        $antixss = new AntiXSS();
        $string = $antixss->xss_clean($string);
        return $string;
    }

    // 获取用户提交字段
    public static function parseInput($key,$default='',$trim = true, $xss = true){
    	$val = $_GET[$key] ?? $_POST[$key];
    	$val = $val ?? $default;
    	
    	if($val && $trim){
    		$val = trim($val);
    	}

    	if($xss){
    		$val = self::xssClean($val);
    	}

    	return $val;
    }

    // 文件写入，以追加方式
    public static function writeFile($filePath,$data='',$userLock=false){
    	if(! $fp = @fopen($filePath, 'a+')){
    		return false;
    	}

    	if($userLock){
    		flock($fp, LOCK_EX);
    	}

    	for ($written=0,$length = strlen($data); $written < $length; $written += $result) { 
    		if(($result = @fwrite($fp, substr($data, $written))) === false ){
    			break;
    		}
    	}

    	if($userLock){
    		flock($fp, LOCK_UN);
    	}
    	fclose($fp);
    }
}