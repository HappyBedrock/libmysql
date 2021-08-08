<?php

declare(strict_types=1);

namespace happype\openapi\libmysql\query;

use happype\openapi\libmysql\AsyncQuery;
use happype\openapi\libmysql\DatabaseData;
use mysqli;

class FindPlayerQuery extends AsyncQuery {

    /** @var string */
    public string $player;
    /** @var string */
    public string $table;

    /** @var bool */
    public bool $exists;

    public function __construct(string $player, string $table = "Values") {
        $this->player = $player;
        $this->table = $table;
    }

    public function query(mysqli $mysqli): void {
        $result = $mysqli->query("SELECT * FROM HB_$this->table WHERE Name='$this->player'");
        $this->exists = $result->num_rows !== 0;
    }
}