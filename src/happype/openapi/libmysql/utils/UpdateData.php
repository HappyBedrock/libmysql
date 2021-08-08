<?php

declare(strict_types=1);

namespace happype\openapi\libmysql\utils;

use function array_values;
use function implode;

class UpdateData {

    /** @var SerializedArrayObject */
    private SerializedArrayObject $updates;

    /**
     * @phpstan-param array<string|int, string|int|float> $updates
     */
    public function __construct(array $updates) {
        $this->updates = new SerializedArrayObject($updates);
    }

    public function emit(): string {
        $updates = $this->updates->getValue();
        foreach ($updates as $key => $value) {
            $updates[$key] = "$key='$value'";
        }
        return implode(", ", array_values($updates));
    }
}