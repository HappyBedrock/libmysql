<?php

declare(strict_types=1);

namespace happype\openapi\libmysql\condition;

class SimpleSearchCondition implements SearchCondition {

    public function __construct(
        private string $key,
        private string $value
    ) {}

    public function emit(): string {
        return "$this->key='$this->value'";
    }
}