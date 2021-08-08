<?php

declare(strict_types=1);

namespace happype\openapi\libmysql\query\base;

use happype\openapi\libmysql\AsyncQuery;
use happype\openapi\libmysql\utils\SerializedArrayObject;
use mysqli;
use mysqli_result;

class FetchTableQuery extends AsyncQuery {

    /** @var string */
    public string $table;

    /** @var SerializedArrayObject */
    public SerializedArrayObject $rows;

    public function __construct(string $table) {
        $this->table = $table;
    }

    public function query(mysqli $mysqli): void {
        $result = $mysqli->query("SELECT * FROM HB_$this->table;");
        if(!$result instanceof mysqli_result) {
            $this->rows = new SerializedArrayObject();
            return;
        }

        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }

        $this->rows = new SerializedArrayObject($rows);
    }
}