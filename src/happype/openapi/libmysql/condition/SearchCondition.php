<?php

declare(strict_types=1);

namespace happype\openapi\libmysql\condition;

interface SearchCondition {
	/**
	 * Function which should return condition in string, for example
	 * "Name='Player'"
	 */
	public function emit(): string;
}