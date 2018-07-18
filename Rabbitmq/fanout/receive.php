<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;

$connect = new AMQPStreamConnection('localhost', '5672', 'guest', 'guest');
$channel = $connect->channel();

$channel->exchange_declare('logs', 'fanout', false, false, false);

list($queue_name) = $channel->queue_declare("", false, false, true, false);
$channel->queue_bind($queue_name, 'logs');

$callback = function($msg){
    echo "接收到:" . $msg->body . "\n";
};

$channel->basic_consume($queue_name, '', false, true, false, false, $callback);

echo "[等待接收消息!]\n";

while(count($channel->callbacks))
{
    $channel->wait();
}

$channel->close();
$connect->close();
