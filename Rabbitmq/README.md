消息代理Rabbitmq学习笔记。

以下内容包括应用管理、用户管理、访问控制、服务器状态等的管理操作。其它文件夹是php-amqplib(php写的Rabbitmq库)的一些用法示例，可以根据目录下的文档进行测试。
***
### 用户管理
* 添加用户 `rabbitmqctl add_user username password`
* 删除用户 `rabbitmqctl delete_user username`
* 修改密码 `rabbitmqctl change_password username newpassword`
* 清除用户密码 `rabbitmqctl clear_password username`
