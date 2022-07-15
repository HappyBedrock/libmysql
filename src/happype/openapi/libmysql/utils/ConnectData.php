<?php

declare(strict_types=1);

namespace happype\openapi\libmysql\utils;

class ConnectData {
	public function __construct(
		private string $host,
		protected string $user,
		private string $password,
		private string $database = "HappyBedrock"
	) {}

	public function getHost(): string {
		return $this->host;
	}

	public function getUser(): string {
		return $this->user;
	}

	public function getPassword(): string {
		return $this->password;
	}

	public function getDatabase(): string {
		return $this->database;
	}
}