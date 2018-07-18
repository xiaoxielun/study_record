<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;

$connect = new AMQPStreamConnection('localhost', '5672', 'guest', 'guest');
$channel = $connect->channel();

$channel->queue_declare('q1', false, true, false, false);

$callback = function($msg){
    echo "接收到:" . $msg->body . "\n";
    echo "处理中...\n";
    sleep(2);
    echo "done\n";
    $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
};
$channel->basic_qos(null, 1, null);
$channel->basic_consume('q1', '', false, false, false, false, $callback);

echo "[等待接收消息!]\n";

while(count($channel->callbacks))
{
    $channel->wait();
}

$channel->close();
$connect->close();
