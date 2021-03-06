<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connect = new AMQPStreamConnection('localhost', '5672', 'guest', 'guest');
$channel = $connect->channel();

$channel->exchange_declare('logs', 'fanout', false, false, false);
$message = 'halo!';
echo "发送消息:{$message}\n";
$message = new AMQPMessage($message);

$channel->basic_publish($message, 'logs');

$channel->close();
$connect->close();