<?php

require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exchange\AMQPExchangeType;

$exchange = 'rabbit_exchange';
$queue = 'default';
$consumerTag = 'consumer';

$host = '127.0.0.1';
$port = 5672;
$user = 'guest';
$pass = 'guest';
$vhost = '/';

$connection = new AMQPStreamConnection($host, $port, $user, $pass, $vhost);
$channel = $connection->channel();


$channel->queue_declare($queue, false, true, false, false);

$channel->exchange_declare($exchange, AMQPExchangeType::DIRECT, false, true, false);

$channel->queue_bind($queue, $exchange);

function process_message($message)
{
    echo "<pre>";
    $msg = json_decode($message->body, true);
    print_r($msg['data']);
    echo "</pre>";

    $message->ack();

    // Send a message with the string "quit" to cancel the consumer.
    if ($message->body === 'quit') {
        $message->getChannel()->basic_cancel($message->getConsumerTag());
    }
}


$channel->basic_consume($queue, $consumerTag, false, false, false, false, 'process_message');

function shutdown($channel, $connection)
{
    $channel->close();
    $connection->close();
}

register_shutdown_function('shutdown', $channel, $connection);

// Loop as long as the channel has callbacks registered
$channel->consume();