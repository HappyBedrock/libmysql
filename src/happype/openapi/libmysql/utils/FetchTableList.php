<?php

declare(strict_types=1);

namespace happype\openapi\libmysql\utils;

use happype\openapi\libmysql\condition\SearchCondition;

class FetchTableList {

	private SerializedArrayObject $tables;

	public function __construct() {
		$this->tables = new SerializedArrayObject();
	}

	/**
	 * @return $this
	 */
	public function addTable(string $table, SearchCondition $searchCondition): self {
		$oldArray = $this->tables->getValue();
		$oldArray[$table] = $searchCondition->emit();

		$this->tables = new SerializedArrayObject($oldArray);

		return $this;
	}

	public function getTables(): SerializedArrayObject {
		return $this->tables;
	}
}