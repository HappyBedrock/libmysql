<?php

declare(strict_types=1);

namespace happype\openapi\libmysql\query;

use happype\openapi\libmysql\AsyncQuery;
use mysqli;

class ConnectQuery extends AsyncQuery {
	public bool $connected = false;

	public function query(mysqli $mysqli): void {
		$this->connected = true;
	}
}