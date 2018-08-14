<?php
/* 后台管理功能菜单配置
 * 添加配置请参照此配置进行添加菜单
 * 注意：此配置目前只支持三层菜单
 */
return array(
    'a' => array(
        'title' => '测试测试',
        'css' => 'fa-home',
        'sub' => array(
            '1' => array(
                'title' => '测试测试', 
                'url' => '?mod=t_user&act=t_user', 
                'is_show' => true,
                'sub' => array(
                    '1' => array('title' => '添加用户帐号', 'url' => '?mod=t_user&act=t_user_edit', 'is_show'=>false),
                    '2' => array('title' => '编辑用户帐号', 'url' => '?mod=t_user&act=t_user_edit', 'is_show'=>false),
                    '3' => array('title' => '删除用户帐号', 'url' => '?mod=t_user&act=t_user_delete', 'is_show'=>false),
                ),
            ),
        ),
    ),
    'z' => array(
        'title' => '系统设置',
        'css' => 'fa fa-gear',
        'sub' => array(
            '1' => array(
                'title' => '用户帐号管理', 
                'url' => '?mod=users&act=admin_user', 
                'is_show' => true,
                'sub' => array(
                    '1' => array('title' => '添加用户帐号', 'url' => '?mod=users&act=admin_user_edit', 'is_show'=>false),
                    '2' => array('title' => '编辑用户帐号', 'url' => '?mod=users&act=admin_user_edit', 'is_show'=>false),
                    '3' => array('title' => '删除用户帐号', 'url' => '?mod=users&act=admin_user_delete', 'is_show'=>false),
                ),
            ),
            '2' => array('title' => '修改密码', 'url' => '?mod=users&act=change', 'is_show'=>true),
            '3' => array(
                'title' => '用户组管理',
                'url' => '?mod=user_group&act=list', 
                'is_show' => true,
                'sub' => array(
                    '1' => array('title' => '添加用户组', 'url' => '?mod=user_group&act=add', 'is_show'=>false),
                    '2' => array('title' => '编辑用户组', 'url' => '?mod=user_group&act=edit', 'is_show'=>false),
                    '3' => array('title' => '删除用户组', 'url' => '?mod=user_group&act=delete', 'is_show'=>false),
                ),
            ),
        ),
    ),
);

