<?php

declare(strict_types=1);

namespace happype\openapi\libmysql\utils;

use Closure;
use happype\openapi\libmysql\query\FindPlayerNameQuery;
use happype\openapi\libmysql\QueryQueue;

class Utils {

	/**
	 * @param Closure(bool, string): void $callback Closure(bool $isRegistered, string $realName): void {}
	 */
	public static function isPlayerRegistered(string $name, Closure $callback): void {
		\pocketmine\utils\Utils::validateCallableSignature(function(bool $isRegistered, string $name): void { }, $callback);

		QueryQueue::submitQuery(new FindPlayerNameQuery($name), function(FindPlayerNameQuery $query) use ($callback, $name): void {
			if(!$query->found) {
				$callback(false, $name);
				return;
			}
			$callback(true, $query->player);
		});
	}
}