<?php

declare(strict_types=1);

namespace happype\openapi\libmysql\utils;

use function serialize;
use function unserialize;

class SerializedArrayObject {
	protected string $arrayValue;

	/**
	 * @param mixed[] $value
	 */
	public function __construct(array $value = []) {
		$this->arrayValue = serialize($value);
	}

	/**
	 * @return mixed[]
	 */
	public function getValue(): array {
		return (array)unserialize($this->arrayValue);
	}
}