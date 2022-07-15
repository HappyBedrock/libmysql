<?php

declare(strict_types=1);

namespace happype\openapi\libmysql;

use Exception;
use happype\openapi\libmysql\utils\ConnectData;
use mysqli;
use pocketmine\scheduler\AsyncTask;
use SimpleLogger;

abstract class AsyncQuery extends AsyncTask {
	public ConnectData $connectData;

	final public function onRun(): void {
		try {
			$this->query($mysqli = new mysqli($this->connectData->getHost(), $this->connectData->getUser(), $this->connectData->getPassword(), $this->connectData->getDatabase()));
			$mysqli->close();
		} catch(Exception $exception) {
			(new SimpleLogger())->logException($exception);
		}
	}

	final public function onCompletion(): void {
		$this->complete();
		QueryQueue::activateCallback($this);
	}

	/**
	 * Function for executing the query.
	 */
	abstract public function query(mysqli $mysqli): void;

	/**
	 * This function should be used for any tasks
	 * whose should be executed on main thread after query
	 */
	public function complete(): void { }
}