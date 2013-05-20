<?php
require_once '/../vendor/autoload.php';

$pushClient = new Bazo\PHPusher\PushClient('http://localhost:8080');
$pushClient->push('test', 'test', ['message' => 'hello']);