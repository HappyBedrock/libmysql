<?php

declare(strict_types=1);

namespace happype\openapi\libmysql\condition;

class SearchByNameCondition implements SearchCondition {

    public function __construct(
        private string $name
    ) {}

    public function emit(): string {
        return "Name='$this->name'";
    }
}