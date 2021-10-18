<?php

declare(strict_types=1);

namespace happype\openapi\libmysql\utils;

class TableList {

	private SerializedArrayObject $tables;

	public function __construct() {
		$this->tables = new SerializedArrayObject();
	}

	/**
	 * @return $this
	 */
	public function addTable(string $table): self {
		$oldArray = $this->tables->getValue();
		$oldArray[] = $table;

		$this->tables = new SerializedArrayObject($oldArray);

		return $this;
	}

	public function getTables(): SerializedArrayObject {
		return $this->tables;
	}
}