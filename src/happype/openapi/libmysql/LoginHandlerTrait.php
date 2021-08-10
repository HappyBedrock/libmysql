<?php

declare(strict_types=1);

namespace happype\openapi\libmysql;

use happype\openapi\libmysql\event\PlayerLoginQueryReceiveEvent;
use happype\openapi\libmysql\query\LazyRegisterQuery;
use pocketmine\event\player\PlayerLoginEvent;

trait LoginHandlerTrait {

    public function onLogin(PlayerLoginEvent $event): void {
        QueryQueue::submitQuery(new LazyRegisterQuery($event->getPlayer()->getName(), DatabaseData::getInitTableList(), DatabaseData::getFetchTableList()), function (LazyRegisterQuery $query) use ($event): void {
            (new PlayerLoginQueryReceiveEvent($event->getPlayer(), $query))->call();
        });
    }
}