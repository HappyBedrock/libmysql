<?php

declare(strict_types=1);

namespace happype\openapi\libmysql\query\player;

use happype\openapi\libmysql\AsyncQuery;
use happype\openapi\libmysql\utils\FetchTableList;
use happype\openapi\libmysql\utils\SerializedArrayObject;
use mysqli;
use mysqli_result;
use function str_replace;

class LazyRegisterQuery extends AsyncQuery {

    public SerializedArrayObject $tableList;

    /**
     * @param SerializedArrayObject $initList Array with tables, whose needs to have player inside of them
     * @param FetchTableList $fetchTableList Table list which is needed to read all data for specific condition on player join
     */
    public function __construct(
        public string $player,
        public SerializedArrayObject $initList,
        public FetchTableList $fetchTableList
    ) {}

    public function query(mysqli $mysqli): void {
        /** @var string $table */
        foreach ($this->initList->getValue() as $table) {
            $result = $mysqli->query("SELECT Name FROM $table WHERE Name='$this->player';");
            if(!$result instanceof mysqli_result || $result->num_rows === 0) {
                $mysqli->query("INSERT INTO $table (Name) VALUES ('$this->player');");
            }
        }

        $tableList = [];
        foreach ($this->fetchTableList->getTables()->getValue() as $table => $emittedSearchCondition) {
            $emittedSearchCondition = str_replace("{%player}", $this->player, $emittedSearchCondition);
            $result = $mysqli->query("SELECT * FROM $table WHERE $emittedSearchCondition;");
            if(!$result instanceof mysqli_result || $result->num_rows === 0) {
                $tableList[$table] = [];
                continue;
            }

            $tableList[$table] = $result->fetch_assoc();
        }

        $this->tableList = new SerializedArrayObject($tableList);
    }
}