<?php

declare(strict_types=1);

namespace happype\openapi\libmysql;

use Closure;
use pocketmine\Server;
use function spl_object_id;

class QueryQueue {
	/** @var Closure[] $callbacks */
	private static array $callbacks = [];

	public static function submitQuery(AsyncQuery $query, ?callable $callbackFunction = null): void {
		self::$callbacks[spl_object_id($query)] = $callbackFunction;

		$query->connectData = DatabaseData::getConnectData();

		Server::getInstance()->getAsyncPool()->submitTask($query);
	}

	/** @internal */
	public static function activateCallback(AsyncQuery $query): void {
		$callable = self::$callbacks[spl_object_id($query)] ?? null;
		if($callable !== null) {
			$callable($query);
			unset(self::$callbacks[spl_object_id($query)]);
		}
	}
}