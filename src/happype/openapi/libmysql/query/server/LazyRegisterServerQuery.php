<?php

declare(strict_types=1);

namespace happype\openapi\libmysql\query;

use happype\openapi\libmysql\AsyncQuery;
use happype\openapi\libmysql\DatabaseData;
use mysqli;

class LazyRegisterServerQuery extends AsyncQuery {

    /** @var string */
    public string $serverName;
    /** @var int */
    public int $serverPort;

    public function __construct(string $serverName, int $serverPort) {
        $this->serverName = $serverName;
        $this->serverPort = $serverPort;
    }

    public function query(mysqli $mysqli): void {
        $result = $mysqli->query("SELECT * FROM HB_Servers WHERE ServerName='$this->serverName';");
        if($result->num_rows === 0) {
            $mysqli->query("INSERT INTO HB_Servers (ServerName, ServerAlias, ServerPort, IsOnline) VALUES ('$this->serverName', '{$this->serverName}', '$this->serverPort', '1');");
            return;
        }

        $mysqli->query("UPDATE HB_Servers SET IsOnline='1',ServerPort='$this->serverPort' WHERE ServerName='$this->serverName';");
    }
}