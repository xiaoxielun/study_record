# 消息代理Rabbitmq学习笔记。

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
    >如何设置权限规则:匹配队列或交换机名称的正则表达式，比如"^q.*$"，允许拥有以"q"开头的所有队列或交换机的配置、读取或写入的权限。
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
>相关概念

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

### 访问控制（身份验证、权限）
新服务器有一个名为"/"的虚拟主机。名为guest的用户，密码为guest，其对"/"虚拟主机有完全访问权限 。

>默认"guest"用户只能通过localhost连接，可通过修改配置文件添加`loopback_users = none`来解决该问题。

### 虚拟主机

Rabbitmq中的连接，交换，队列，绑定，用户权限，策略和其他一些都属于虚拟主机。类似于apache的虚拟主机。只不过apache是通过配置文件实现虚拟主机，而Rabbitmq是通过rabbitmqctl创建。

客户端连接到Rabbitmq时，它指定要连接的vhost名称。如果身份验证成功并且提供的用户名被授予 vhost的权限，则建立连接。

* 限制客户端连接数:`rabbitmqctl set_vhost_limits -p vhost_name '{"max-connections"：256}'`
* 禁用客户端连接:`rabbitmqctl set_vhost_limits -p vhost_name '{"max-connections"：0}'`
* 不限制客户端连接数:`rabbitmqctl set_vhost_limits -p vhost_name '{"max-connections":-1}'`
* 限制虚拟主机对列数:`rabbitmqctl set_vhost_limits -p vhost_name '{"max-queues"：1024}'`
* 不限制虚拟主机对列数:`rabbitmqctl set_vhost_limits -p vhost_name '{"max-queues"：-1}'`