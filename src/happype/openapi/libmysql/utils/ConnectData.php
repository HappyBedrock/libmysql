<?php

declare(strict_types=1);

namespace happype\openapi\libmysql\utils;

class ConnectData {

	/** @var string */
	private string $host;

	/** @var string */
	private string $user;
	/** @var string */
	private string $password;

	public function __construct(string $host, string $user, string $password) {
		$this->host = $host;
		$this->user = $user;
		$this->password = $password;
	}

	public function getHost(): string {
		return $this->host;
	}

	public function getUser(): string {
		return $this->user;
	}

	public function getPassword(): string {
		return $this->password;
	}
}