<?php
require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connect = new AMQPStreamConnection('127.0.0.1', '5672', 'guest', 'guest');
$channel = $connect->channel();

// 声明交换机
$channel->exchange_declare('q1', 'topic', false, false, false);

$routing_key = $argv[1];

$message = new AMQPMessage('halo');
// 发送消息时附加路由键
$channel->basic_publish($message, 'q1', $routing_key);

$channel->close();
$connect->close();