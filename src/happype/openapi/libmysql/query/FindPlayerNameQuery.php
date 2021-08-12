<?php

declare(strict_types=1);

namespace happype\openapi\libmysql\query;

use happype\openapi\libmysql\AsyncQuery;
use mysqli;
use mysqli_result;
use function array_key_exists;

class FindPlayerNameQuery extends AsyncQuery {

	public bool $found = false;

	public function __construct(
		public string $player
	) {}

	public function query(mysqli $mysqli): void {
		$result = $mysqli->query("SELECT * FROM HB_Values WHERE Name='$this->player';");
		if(!$result instanceof mysqli_result) {
			return;
		}

		$result = $result->fetch_assoc();
		if(!$result) {
			return;
		}

		$this->found = true;
		if(array_key_exists("Name", $result)) {
			$this->player = $result["Name"];
		}
	}
}