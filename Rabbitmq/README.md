消息代理Rabbitmq学习笔记。  
以下内容包括应用管理、用户管理、访问控制、服务器状态等的管理操作。其它文件夹是php-amqplib(php写的Rabbitmq库)的一些用法示例，可以根据目录下的文档进行测试。  
只有root和rabbit用户可以使用rabbitmqctl。
### 应用管理
* 启动Rabbitmq应用程序 `rabbitmqctl start_app`

    >执行stop_app命令后可以执行该命令来启动应用程序。但如果服务未启动可能需要执行service rabbitmq-server start命令来启动服务。
### 用户管理
* 添加用户 `rabbitmqctl add_user username password`
* 删除用户 `rabbitmqctl delete_user username`
* 修改密码 `rabbitmqctl change_password username newpassword`
* 清除用户密码 `rabbitmqctl clear_password username`
* 验证用户 `rabbitmqctl authenticate_user username password`
* 用户列表 `rabbitmqctl list_users`