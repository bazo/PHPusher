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

	/** @var string */
	private $key;
	
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
	 * Set the authentication key
	 * @param string $key
	 * @return PushClient
	 */
	public function setKey($key)
	{
		$this->key = $key;
		return $this;
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

		$payload = [
			'room' => $room,
			'event' => $event,
			'data' => $data,
			'timestamp' => time()
		];
		
		if($this->key !== NULL) {
			$signature = hash_hmac('md5', json_encode($payload), $this->key);
			$payload['signature'] = $signature;
		}
		
		$this->client->emit('push', $payload);

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
