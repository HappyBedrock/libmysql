<?php

declare(strict_types=1);

namespace happype\openapi\libmysql;

use happype\openapi\libmysql\query\ConnectQuery;
use happype\openapi\libmysql\utils\ConnectData;
use happype\openapi\libmysql\utils\FetchTableList;
use happype\openapi\libmysql\utils\SerializedArrayObject;

class DatabaseData {

    public const DATABASE = "HappyBedrock";

    /** @var ConnectData */
    private static ConnectData $connectData;

    private static SerializedArrayObject $initTableList;
    private static FetchTableList $fetchTableList;

    public static function register(ConnectData $connectData, array $tablesToInit = [], ?FetchTableList $fetchTableList = null): void {
        self::$connectData = $connectData;
        self::$initTableList = new SerializedArrayObject($tablesToInit);
        self::$fetchTableList = $fetchTableList ?? new FetchTableList();

        QueryQueue::submitQuery(new ConnectQuery());
    }

    public static function getInitTableList(): SerializedArrayObject {
        return self::$initTableList;
    }

    public static function getFetchTableList(): FetchTableList {
        return self::$fetchTableList;
    }

    public static function getConnectData(): ConnectData {
        return self::$connectData;
    }
}