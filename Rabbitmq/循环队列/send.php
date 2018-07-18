<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connect = new AMQPStreamConnection('localhost', '5672', 'guest', 'guest');
$channel = $connect->channel();

$channel->queue_declare('q1', false, true, false, false);
$message = 'halo!';
echo "发送消息:{$message}\n";
$message = new AMQPMessage($message, array('delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT));

$channel->basic_publish($message, '', 'q1');

$channel->close();
$connect->close();