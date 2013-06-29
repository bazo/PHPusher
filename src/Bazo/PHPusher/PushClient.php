<?php

namespace Bazo\PHPusher;

use Tembo\SocketIOClient;

/**
 * PushClient
 *
 * @author Martin Bažík <martin@bazo.sk>
 */
class PushClient
{

	/** @var SocketIOClient */
	private $client;

	/** @var bool */
	private $connected = FALSE;

	/**
	 * @param string $socketIOUrl
	 * @param string $socketIOPath
	 */
	public function __construct($socketIOUrl, $socketIOPath = 'socket.io')
	{
		$this->client = new SocketIOClient($socketIOUrl, $socketIOPath);
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
		if ($this->connected === false) {
			throw new NotConnectedException('You need to connect to server before pushing events.');
		}

		$this->client->emit('push', json_encode([
			'room' => $room,
			'event' => $event,
			'data' => $data
		]));

		return $this;
	}

	public function heartbeat()
	{
		$this->client->heartbeat();
	}

	public function connect($handshakeTimeout = NULL, $read = TRUE, $checkSslPeer = TRUE)
	{
		 if ($this->connected === FALSE) {
			$this->client->connect($handshakeTimeout, $read, $checkSslPeer);
			$this->connected = TRUE;
		}
	}

	public function disconnect($waitTime = 50)
	{
		$this->client->disconnect($waitTime);
		$this->connected = FALSE;
	}

}
