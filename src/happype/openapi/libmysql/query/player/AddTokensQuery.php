<?php

declare(strict_types=1);

namespace happype\openapi\libmysql\query;

use happype\openapi\libmysql\AsyncQuery;
use happype\openapi\libmysql\DatabaseData;
use mysqli;

class AddTokensQuery extends AsyncQuery {

    /** @var string */
    public string $player;
    /** @var int */
    public int $amount;

    public function __construct(string $player, int $amount) {
        $this->player = $player;
        $this->amount = $amount;
    }

    public function query(mysqli $mysqli): void {
        $mysqli->query("UPDATE HB_Values SET Tokens=Tokens+$this->amount WHERE Name='$this->player'");
    }
}