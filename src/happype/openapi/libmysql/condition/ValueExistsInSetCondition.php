<?php

declare(strict_types=1);

namespace happype\openapi\libmysql\condition;

class ValueExistsInSetCondition implements SearchCondition {
	public function __construct(
		public string $value,
		public string $column
	) {}

	public function emit(): string {
		return "FIND_IN_SET('$this->value', $this->column)";
	}
}