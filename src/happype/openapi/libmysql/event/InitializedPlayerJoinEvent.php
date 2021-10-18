<?php

declare(strict_types=1);

namespace happype\openapi\libmysql\event;

use pocketmine\event\Event;
use pocketmine\player\Player;

class InitializedPlayerJoinEvent extends Event {

	public function __construct(
		protected Player $player
	) {
	}

	public function getPlayer(): Player {
		return $this->player;
	}
}