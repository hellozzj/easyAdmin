<?php
/**----------------------------------------------------+
 * 自定义错误处理(加强错误显示和记录日志)
 * @author unchastity@163.com
 +-----------------------------------------------------*/
namespace app\lib\exception;
use ErrorException;
use app\common\Helper;

class ErrorHandler {
    // 自定错误处理
    public static function errorHandler($errno, $msg, $file, $line) {
        $errRpt = error_reporting();
        if (($errno & $errRpt) != $errno) return;
        throw new ErrorException("PHP Error:[$errno] $msg", $errno, 0, $file, $line);
    }

    // 自定义异常处理
    public static function exceptionHandler($e) {
        $msg = "Exception Message:\n[".$e->getCode().'] "'.$e->getMessage().'" in file '.$e->getFile()." (line:".$e->getLine().").\nDebug Trace:\n".$e->getTraceAsString()."\n\n";
        // 如果这个异常已定义输出方式，则使用它来输出信息
        Helper::writeFile(LOG_DIR.date('Y-m-d').'.log',$msg);
        $code = $e->getCode() ? $e->getCode() : 500;
        header("HTTP/1.1 $code error");
        exit($e->getMessage());
    }

    // debug 日志写入,以json格式写入
    public static function debugLog($fileName,$data,$level='DEBUG'){

        $data = is_array($data) ? json_encode($data,JSON_UNESCAPED_UNICODE):trim($data);
        $msg = $level.'----'.date('Y-m-d H:i:s').'----msg:'. $data ;
        Helper::writeFile(LOG_DIR.$fileName.'.log',$msg);
    } 
}
