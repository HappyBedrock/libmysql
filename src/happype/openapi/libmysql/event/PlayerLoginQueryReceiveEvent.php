<?php

declare(strict_types=1);

namespace happype\openapi\libmysql\event;

use happype\openapi\libmysql\query\LazyRegisterQuery;
use pocketmine\event\Event;
use pocketmine\player\Player;

class PlayerLoginQueryReceiveEvent extends Event {

	public function __construct(
		public Player $player,
		public LazyRegisterQuery $query
	) {
	}

	public function getPlayer(): Player {
		return $this->player;
	}

	public function getQuery(): LazyRegisterQuery {
		return $this->query;
	}
}