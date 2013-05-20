<?php

namespace Bazo\PHPusher;

use ElephantIO\Client as ElephantIOClient;

/**
 * PushClient
 *
 * @author Martin Bažík <martin@bazo.sk>
 */
class PushClient
{

	/** @var ElephantIOClient */
	private $client;

	/**
	 *
	 * @param string $socketIOUrl
	 * @param string $socketIOPath
	 * @param bool $read
	 * @param bool $checkSslPeer
	 * @param bool $debug
	 */
	public function __construct($socketIOUrl, $socketIOPath = 'socket.io', $read = true, $checkSslPeer = true, $debug = false)
	{
		$this->client = new ElephantIOClient($socketIOUrl, $socketIOPath, $protocol = 1, $read, $checkSslPeer, $debug);
	}

	/**
	 * Emit an event
	 * @param string $room
	 * @param string $event
	 * @param array $data
	 * @return \Bazo\PHPusher\PHPusher
	 */
	public function push($room, $event, array $data)
	{
		$this->client->emit('push', json_encode([
			'room' => $room,
			'event' => $event,
			'data' => $data
		]), null);

		return $this;
	}

}