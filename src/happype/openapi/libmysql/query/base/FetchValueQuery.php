<?php

declare(strict_types=1);

namespace happype\openapi\libmysql\query\base;

use happype\openapi\libmysql\condition\SearchCondition;
use happype\openapi\libmysql\AsyncQuery;
use mysqli;
use mysqli_result;

class FetchValueQuery extends AsyncQuery {

    /** @var string */
    public string $columnName;
    /** @var SearchCondition */
    public SearchCondition $condition;
    /** @var string */
    public string $table;

    /** @var mixed */
    public mixed $value;

    public function __construct(string $columnName, SearchCondition $condition, string $table = "Values") {
        $this->columnName = $columnName;
        $this->condition = $condition;
        $this->table = $table;
    }

    public function query(mysqli $mysqli): void {
        $result = $mysqli->query("SELECT $this->columnName FROM $this->table WHERE {$this->condition->emit()}");
        if(!$result instanceof mysqli_result) {
            return;
        }

        $this->value = $result->fetch_assoc()[$this->columnName] ?? null;
    }
}