PHPusher
========

NodePush PHP client

Usage:

$pushClient = new Bazo\PHPusher\PushClient('http://localhost:8080');
$pushClient->push('test', 'test', ['message' => 'hello']);