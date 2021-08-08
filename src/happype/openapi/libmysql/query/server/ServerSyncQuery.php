<?php

declare(strict_types=1);

namespace happype\openapi\libmysql\query;

use happype\openapi\libmysql\AsyncQuery;
use happype\openapi\libmysql\DatabaseData;
use happype\openapi\libmysql\SerializedArrayObject;
use mysqli;

class ServerSyncQuery extends AsyncQuery {

    /** @var string */
    public string $currentServer;
    /** @var int */
    public int $onlinePlayers;

    /** @var SerializedArrayObject */
    public SerializedArrayObject $table;

    public function __construct(string $currentServer, int $onlinePlayers) {
        $this->currentServer = $currentServer;
        $this->onlinePlayers = $onlinePlayers;
    }

    public function query(mysqli $mysqli): void {
        $mysqli->query("UPDATE HB_Servers SET OnlinePlayers='$this->onlinePlayers' WHERE ServerName='$this->currentServer';");
        $result = $mysqli->query("SELECT * FROM HB_Servers;");

        $table = [];
        while ($row = $result->fetch_assoc()) {
            $table[] = $row;
        }

        $this->table = new SerializedArrayObject($table);
    }
}