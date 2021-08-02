<?php

declare(strict_types=1);

namespace Qameta\Allure\Internal;

use JetBrains\PhpStorm\Pure;

use function array_filter;
use function get_object_vars;
use function in_array;

use const ARRAY_FILTER_USE_KEY;

/**
 * @internal
 */
trait JsonSerializableTrait
{

    public function jsonSerialize(): array
    {
        $excludedKeys = $this->excludeFromSerialization();
        return array_filter(
            get_object_vars($this),
            static fn (string $key): bool => !in_array($key, $excludedKeys, true),
            ARRAY_FILTER_USE_KEY,
        );
    }

    /**
     * @return list<string>
     */
    #[Pure]
    protected function excludeFromSerialization(): array
    {
        return [];
    }
}
