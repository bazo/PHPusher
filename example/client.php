<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Tembo\SocketIOClient;
use Tembo\Message;

$client = new SocketIOClient('http://localhost:8080');

$client->connect();

$client->emit('subscribe', ['room' => 'test']);

try {
	$client->listen(function($event, Message $message = null) {
		if($message !== null) {
			$args = current($message->getArgs());
			
			$msg = sprintf('%s: event: %s, message: %s', date('H:i:s', $args->timestamp), $message->getName(), $args->message);
			echo $msg."\n";
		}
	});
} catch(\RuntimeException $e) {
	echo $e->getMessage();
}