# easyadmin
easyadmin是用于根据表结构及表字段字段注释作为参数生成crud的工具.

![image](https://github.com/hellozzj/easyAdmin/blob/dev/WechatIMG211.png)


## 注意
* 表字段需要注释，作为列表表头的名称.
* 菜单需要手工配置在conifg/menu.php中.
* session保持会话，新增菜单需要重新登录.

## 生成原理
* ob_start打开输出控制缓冲，include对应模板文件，ob_get_contents 获取模板文件内容并替换对应变量，ob_end_clean 关闭缓冲，写入文件
* 后台数据渲染与上同理

## 目录说明

	├── README.md						    // 项目唯一详细文档
	├── app.common		          // 通用函数
	├── 	helper.php						// 常用函数集合，字符串处理、时间处理、日志处理、curl、xss过滤等
	├── app.config              // 配置文件             
    ├──   db_dev.php						// 开发环境数据库配置文件，支持一主多从配置，多环境可加 db_env.php
    |──   redis_dev.php					// 开发环境redis配置文件，多环境可加 redis_env.php
    |──   menu.php						  // 菜单配置文件，需手工配置
	├── app.dal		              // 数据操作类
	├── 	admin_user.class.php	// 后台用户数据
	├── app.lang                // 语言包，未使用
    ├── app.lib		              // 类库，PDO、exception、加密、工具等类库
	├── app.public              // 入口启动文件，常量定义、自动加载命名空间类、引用composer加载文件
    ├── app.tools.crud_tool		  // 模板生成工具包，列表、异步列表、编辑、删除模板
	├── app.var               	// session以及log文件存放
	├── app.web                 // 管理后台具体文件


## 测试
* https://www.aifalse.com/tools/crud_tool




