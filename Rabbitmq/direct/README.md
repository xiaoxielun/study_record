# direct类型的交换机简单用法
---
* 运行多个receive.php，带参数error、warn、info接收特定消息并打印至终端
    >php receive.php error warn  
    >php receive.php info

* 运行send.php，带参数error、warn、info发送特定消息至exchange
    >php send.php warn  
    >php send.php info
* 消息在发送时有传binging_key参数，会被路由到绑定到该交换机且binding_key相同的队列上。
