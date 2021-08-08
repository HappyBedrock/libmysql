<?php

declare(strict_types=1);

namespace happype\openapi\libmysql\query\base;

use happype\openapi\libmysql\condition\SearchCondition;
use happype\openapi\libmysql\AsyncQuery;
use happype\openapi\libmysql\utils\SerializedArrayObject;
use mysqli;
use mysqli_result;

class FetchRowQuery extends AsyncQuery {

    /** @var SearchCondition */
    public SearchCondition $searchCondition;
    /** @var string */
    public string $table;

    /** @var SerializedArrayObject */
    public SerializedArrayObject $row;

    public function __construct(SearchCondition $condition, string $table = "Values") {
        $this->searchCondition = $condition;
        $this->table = $table;
    }
    public function query(mysqli $mysqli): void {
        $result = $mysqli->query("SELECT * FROM HB_$this->table WHERE {$this->searchCondition->emit()};");
        if(!$result instanceof mysqli_result || $result->num_rows === 0 || ($assocResult = $result->fetch_assoc()) === null) {
            return;
        }

        $this->row = new SerializedArrayObject($assocResult);
    }
}