<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;

$connect = new AMQPStreamConnection('localhost', '5672', 'guest', 'guest');
$channel = $connect->channel();

$channel->queue_declare('q1', false, false, false, false);

$callback = function($msg){
    echo "接收到:" . $msg->body . "\n";
};

$channel->basic_consume('q1', '', false, true, false, false, $callback);

echo "[等待接收消息!]\n";

while(count($channel->callbacks))
{
    $channel->wait();
}

$channel->close();
$connect->close();
