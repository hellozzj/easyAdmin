<?php
/*-----------------------------------------------------+
 * 通用常量类
 * @author unchastity@163.com
 * @since 2015.11.26
 +-----------------------------------------------------*/
namespace app\lib;
 
class CConstant{
    //user,user_role_info信息子表个数
    const ACC_USER_TABLE_NUM   = 200; 
    const ACC_ROLE_TABLE_NUM   = 200;              

    // 数据库主从类型
    const DB_POS_MASTER  =  'master';
    const DB_POS_SLAVE   =  'slave';

    // db数据类型
    const DB_USER = 'user';
    const DB_MAIN = 'main';
    const DB_LOG = 'log';
    const DB_SDK = 'sdk';

    // redis数据类型
    const REDIS_USER       = 'user';
    const REDIS_GAME       = 'game';
    const REDIS_LOG        = 'log';
    const REDIS_ROLE       = 'role';
    const REDIS_USER_LAST_INFO = 'user_last_info';

    // redis数据前缀
    const REDIS_PREX_USER          = 'u';      // 用户数据前缀
    const REDIS_PREX_USER_NEXT_UID = 'n';      // 用户全局uid前缀
    const REDIS_PREX_PAY           = 'p';      // 订单数据前缀
    const REDIS_PREX_GAME          = 'g';      // 产品数据前缀
    const REDIS_PREX_LOG           = 'l';      // 日志数据前缀
    const REDIS_PREX_MODE          = 'm';      // 登陆模式前缀
    const REDIS_PREX_ROLE          = 'r';      // 角色信息前缀

    // redis队列类型
    const QUEUE_LOGGER          = 'queue:logger';           // 日志队列
    const QUEUE_PAY_CALLBACK    = 'queue:pay_callback';     // 充值回调队列
    const QUEUE_USER_LOGIN      = 'queue:user_login';       // 登陆更新账号信息队列
    const QUEUE_PAY_INFO        = 'queue:user_pay';         // 支付信息更新
    const QUEUE_ROLE_INFO       = 'queue:role_info';        // 角色信息更新

    //game key的长度
    const GAME_KEY_LEN = 16;
    const API_KEY_LEN = 8;

    // 日志类型
    const LOG_TYPE_DATE     = 1;    //日表
    const LOG_TYPE_MONTH    = 2;    //月表
    const LOG_TYPE_QUARTER  = 3;    //季度表

    // 后台日志类型
    const ADMIN_LOG_TYPE_ADMIN      = 1; //后台操作
    const ADMIN_LOG_TYPE_CRONTAB    = 2; //crontab操作

    // 日志表的合并匹配格式
    public static $merge_type_arr = array(
        // 下划线代表一个字符
        self::LOG_TYPE_DATE       => '20________',
        self::LOG_TYPE_MONTH      => '20_____',
        self::LOG_TYPE_QUARTER    => '20___q_',

    );

    // 语言定义
    public static $lang_arr = array(
        'zh_cn' => '简体中文',
        'zh_tw' => '繁体中文',
        'en' => '英文',
    );

    //分表配置
    public static $need_create_arr = array(
        self::DB_USER => array(
            //Pay::PAY_ORDER_TABLE    => self::LOG_TYPE_MONTH,
        ),
        self::DB_MAIN => array(),
        self::DB_LOG => array(
            'log_create_user'       => self::LOG_TYPE_MONTH,
            'log_login_user'        => self::LOG_TYPE_DATE,

            'log_charge_order'      => self::LOG_TYPE_DATE,
            'log_czk_pay_param'     => self::LOG_TYPE_MONTH,
            'log_yt_pay_param'      => self::LOG_TYPE_DATE,
            'log_zfb_pay'           => self::LOG_TYPE_MONTH,
            'log_yl_pay'            => self::LOG_TYPE_MONTH,
            'log_appstore_pay'      => self::LOG_TYPE_QUARTER,
            'log_google_pay'        => self::LOG_TYPE_QUARTER,
            'log_pay_error'         => self::LOG_TYPE_QUARTER,

            'log_advertise'         => self::LOG_TYPE_DATE,
            'log_login_role'        => self::LOG_TYPE_DATE,

            'log_sdk_login_user'    => self::LOG_TYPE_MONTH,
            'log_sdk_create_user'   => self::LOG_TYPE_MONTH,
            'log_pay_callback'      => self::LOG_TYPE_MONTH,
        ),
    );

    //日志格式配置 默认都加上create_time字段
    public static $log_config = array(
        // 登陆日志
        'login' => array(
            'table' => 'log_login_user',
            'fields' => array('uname', 'client_ip', 'game_code', 'channel_code', 'device_id'),
        ),
        // 注册日志
        'create_user' => array(
            'table' => 'log_create_user',
            'fields' => array('uname', 'client_ip', 'game_code', 'channel_code', 'device_id', 'sys_type', 'device_type', 'device_version', 'ad_channel_code'),
        ),
        // 支付宝支付日志
        'zfb_pay' => array(
            'table' => 'log_zfb_pay',
            'fields' => array('game_code', 'order_num', 'trade_no', 'game_no', 'buyer', 'total_fee', 'subject', 'trade_status', 'pay_state'),
        ),
        // 苹果支付日志
        'apple_pay' => array(
            'table' => 'log_appstore_pay',
            'fields' => array('game_no', 'order_num', 'receipt_data', 'pay_state','response_data'),
        ),
        // 谷歌支付日志
        'google_pay' => array(
            'table' => 'log_google_pay',
            'fields' => array('game_no', 'order_num', 'pay_state', 'receipt_data'),
        ),
        //角色登陆日志
        'role_login' => array(
            'table' => 'log_login_role',
            'fields' => array('game_code', 'channel_code', 'uname','role_id', 'role_name', 'server_id', 'login_time','client_ip', 'sys_type', 'device_id'),
        ),
        // 银联支付日志
        'yl_pay' => array(
            'table' => 'log_yl_pay',
            'fields' => array('game_code','order_num','trade_no','game_no','total_fee','time','queryId','pay_state'),
        ),
        // 融合sdk创建账号日志
        'sdk_create_user' => array(
            'table'  => 'log_sdk_create_user',
            'fields' => array('uname','game_code', 'package_code','sys_type','device_id','device_version','client_ip','device_type'),
        ),
        // 融合sdk账号登陆日志
        'sdk_login_user' => array(
            'table'  => 'log_sdk_login_user',
            'fields' => array('uname','game_code', 'package_code', 'client_ip', 'device_id'),
        ),
        //支付回调记录日志
        'pay_callback' => array(
            'table' => 'log_pay_callback',
            'fields' => array('order_num','api_info','callback_data'),
        ),
    );
}
