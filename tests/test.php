<?php
require_once __DIR__ . '/../vendor/autoload.php';

$pushClient = new Bazo\PHPusher\PushClient('http://localhost:8080', 'socket.io', true, true, true);

$data = [
	'id' => 1,
	'timestamp' => time(),
	'message' => 'lorem ipsum'
];

$pushClient->open();
$pushClient->push('test', 'test', $data);
$pushClient->close();