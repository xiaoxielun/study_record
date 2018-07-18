<?php
require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;

$connect = new AMQPStreamConnection('127.0.0.1', '5672', 'guest', 'guest');
$channel = $connect->channel();

// 声明交换机
$channel->exchange_declare('q1', 'topic', false, false, false);
// 声明队列
list($queue_name) = $channel->queue_declare('', false, false, true, false);

// 队列绑定路由键
foreach(array_slice($argv, 1) as $v)
{
    $channel->queue_bind($queue_name, 'q1', $v);
}

$callback = function($message){
    echo $message->body;
};


// 队列绑定消息回调
$channel->basic_consume($queue_name, '', false, true, false, false, $callback);

while (count($channel->callbacks)) {
    $channel->wait();
}

$channel->close();
$connect->close();