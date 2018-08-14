# easyadmin
easyadmin是用于根据表结构及表字段字段注释作为参数生成简易增删查改的工具.

![image](https://github.com/hellozzj/easyAdmin/blob/dev/WechatIMG211.png)


## 注意
* 表字段需要注释，作为列表表头的名称.
* 菜单需要手工配置在conifg/menu.php中.
* session保持会话，新增菜单需要重新登录.



## 目录说明

	├── README.md						    // 项目唯一详细文档
	├── app.common		          // 通用函数
	├── 	helper.php						// 常用函数集合，字符串处理、时间处理、日志处理、curl、xss过滤等
	├── app.config              // 配置文件             
    ├──   db_dev.php						// 开发环境数据库配置文件，多环境可加 db_env.php
    |──   redis_dev.php					// 开发环境redis配置文件，多环境可加 redis_env.php
    |──   menu.php						  // 菜单配置文件，需手工配置
	├── app.dal		              // 数据操作类
	├── 	admin_user.class.php	// 后台用户数据
	├── app.lang                // 语言包，未使用
    ├── app.lib		              // 类库，PDO、exception、加密、工具等类库
	├── app.public              // 入口启动文件，常量定义、自动加载命名空间类、引用composer加载文件
    ├── app.tools.crud_tool		  // 模板生成工具包，列表、异步列表、编辑、删除模板
	├── app.var               	// session以及log文件存放
	├── app.web                 // 生成管理后台，需手动在admin/app目录下新建相应模块文件夹，并将生成文件移入


## 在线
* https://www.aifalse.com/tools/crud_tool
* https://www.aifalse.com/web/admin/?mod=default&act=login   admin/123123



