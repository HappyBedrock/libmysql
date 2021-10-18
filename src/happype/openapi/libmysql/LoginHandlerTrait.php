<?php

declare(strict_types=1);

namespace happype\openapi\libmysql;

use happype\openapi\libmysql\event\InitializedPlayerJoinEvent;
use happype\openapi\libmysql\event\PlayerLoginQueryReceiveEvent;
use happype\openapi\libmysql\query\LazyRegisterQuery;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerLoginEvent;
use function array_key_exists;

trait LoginHandlerTrait {

	/** @var bool[] */
	protected array $initializedPlayers = [];

	public function onLogin(PlayerLoginEvent $event): void {
		QueryQueue::submitQuery(new LazyRegisterQuery($event->getPlayer()->getName(), DatabaseData::getInitTableList(), DatabaseData::getFetchTableList()), function(LazyRegisterQuery $query) use ($event): void {
			(new PlayerLoginQueryReceiveEvent($event->getPlayer(), $query))->call();
			if($event->getPlayer()->isConnected() && $event->getPlayer()->spawned) {
				(new InitializedPlayerJoinEvent($event->getPlayer()))->call();
				return;
			}

			$this->initializedPlayers[$event->getPlayer()->getName()] = true;
		});
	}

	/**
	 * @priority HIGH
	 */
	public function onJoin(PlayerJoinEvent $event): void {
		if(array_key_exists($event->getPlayer()->getName(), $this->initializedPlayers)) {
			(new InitializedPlayerJoinEvent($event->getPlayer()))->call();
			unset($this->initializedPlayers[$event->getPlayer()->getName()]);
		}
	}
}