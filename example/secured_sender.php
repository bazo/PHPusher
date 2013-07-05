<?php

require_once __DIR__ . '/../vendor/autoload.php';

$pushClient = new Bazo\PHPusher\PushClient('http://localhost:8080');
$pushClient->setKey('changeThisToSomethingRandomAndSecure');

$pushClient->connect();
$sent = 0;
while ($sent < 100000) {

	$data = [
		'id' => 1,
		'timestamp' => time(),
		'message' => 'lorem ipsum'
	];

	$pushClient->push('test', 'test', $data);
	$sent++;

	if ($sent % 20000 === 0) {
		$pushClient->heartbeat();
	}

	usleep(10 * 1000);
}

$pushClient->disconnect();