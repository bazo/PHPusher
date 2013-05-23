PHPusher
========

NodePush PHP client

Usage:

$pushClient = new Bazo\PHPusher\PushClient('http://localhost:8080');
$data = [
	'id' => 1,
	'timestamp' => time(),
	'message' => 'lorem ipsum'
];

$pushClient->open();
$pushClient->push($room, $event, $data);
$pushClient->close();