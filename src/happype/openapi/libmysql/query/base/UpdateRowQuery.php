<?php

declare(strict_types=1);

namespace happype\openapi\libmysql\query\base;

use happype\openapi\libmysql\condition\SearchCondition;
use happype\openapi\libmysql\AsyncQuery;
use happype\openapi\libmysql\utils\UpdateData;
use mysqli;

class UpdateRowQuery extends AsyncQuery {

    /** @var UpdateData */
    public UpdateData $updates;
    /** @var SearchCondition */
    public SearchCondition $condition;
    /** @var string  */
    public string $table;

    public function __construct(UpdateData $updates, SearchCondition $condition, string $table = "Values") {
        $this->updates = $updates;
        $this->condition = $condition;
        $this->table = $table;
    }

    public function query(mysqli $mysqli): void {
        $mysqli->query("UPDATE HB_$this->table SET {$this->updates->emit()} WHERE {$this->condition->emit()};");
    }
}