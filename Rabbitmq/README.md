# 消息代理Rabbitmq学习笔记。
---
### 软件安装
>Rabbitmq依赖Erlang，详细安装细节见官方提供的文档:http://www.rabbitmq.com/install-debian.html

### php库 —— php-amqplib

该库的用法放在其它文件夹。
>github地址:https://github.com/php-amqplib/php-amqplib

---

>以下内容包括应用管理、用户管理、访问控制、服务器状态等的简单操作。
    
>官方文档:http://www.rabbitmq.com/rabbitmqctl.8.html#Access%20control

>只有root和rabbit用户可以使用rabbitmqctl。


### 应用管理
* 启动Rabbitmq应用程序 `rabbitmqctl start_app`

    >执行stop_app命令后可以执行该命令来启动应用程序。但如果服务未启动可能需要执行`service rabbitmq-server start`命令来启动服务。
* 停止运行Rabbitmq应用程序，但Erlang节点继续运行 `rabbitmqctl stop_app`
* 将Rabbitmq节点返回到原始状态 `rabbitmqctl reset`

    >从其所属的任何群集中删除节点，从管理数据库中删除所有数据，例如已配置的用户和vhost，并删除所有持久性消息。要使reset成功，RabbitMQ应用程序必须已经停止，例如使用stop_app。
* 强制将RabbitMQ节点返回到原始状态 `rabbitmqctl force_reset`
* 关闭运行RabbitMQ的Erlang进程 `rabbitmqctl shutdown`
* 停止运行RabbitMQ的Erlang节点 `rabbitmqctl stop`

    >如果需要重启节点，就需要重新开启服务器`service rabbitmq-server start`。

### 用户管理
* 添加用户 `rabbitmqctl add_user username password`
* 删除用户 `rabbitmqctl delete_user username`
* 修改密码 `rabbitmqctl change_password username newpassword`
* 清除用户密码 `rabbitmqctl clear_password username`
* 验证用户 `rabbitmqctl authenticate_user username password`
* 用户列表 `rabbitmqctl list_users`

### 访问控制
* 添加虚拟主机 `rabbitmqctl add_vhost hostname`
* 删除虚拟主机 `rabbitmqctl delete_vhost hostname`
* 虚拟主机列表 `rabbitmqctl list_vhosts`
* 设置用户权限 `rabbitmqctl set_permissions [-p vhost] username 可配置权限资源 可写入资源 可读取资源`
* 清除用户权限 `rabbitmqctl clear_permissions [-p vhost] username`
* 用户权限列表 `rabbitmqctl list_permissions`
* 用户权限 `rabbitmqctl list_user_permissions username`

### 服务器状态
* 队列详细信息 `rabbirmqctl list_queues`
* 交换信息 `rabbitmqctl list_exchanges`
* 绑定信息 `rabbitmqctl list_bindings`
* TCP/IP连接统计信息 `rabbitmqctl list_connections`
* 通道信息 `rabbitmqctl list_channels`
* 列出消费者 `rabbitmqctl list_consumers`

---
### 消息
消息可以声明为持久性消息，在Rabbitmq挂掉重启后，消息还会存在。

### 队列
默认在RabbitMQ挂掉后，队列都会丢失。可以定义队列为持久队列来解决这一问题。

### exchange（交换机）
实际上，生产者不会将消息直接发送到队列，而是交给交换机。消费者将队列通过binding_key绑定到交换机来接收消息。
交换机会根据定义时选择的交换类型，将获得的消息路由给队列。

默认的交换机类型为direct，名字为空字符串，队列会自动将队列名做为路由键绑定到这个交换机上。
>如果没有队列绑定到交换机，消费者发送的消息会立即丢失。

![binding](./binding.jpg)

交换机可以声明为持旧的，也可以是短暂的。Rabbitmq重新启动后持久的交换机依然存在，短暂的则不会。

### Message acknowledgment（消息应答）
默认RabbitMQ向消费者发送消息后（或消费者主动拉取），它立即将其标记为删除，如果消费者挂掉，消息将丢失。

消费者发回ack（nowledgement）告诉RabbitMQ已收到，消息已经处理，RabbitMQ可以自由删除它。

