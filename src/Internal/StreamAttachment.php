<?php

declare(strict_types=1);

namespace Qameta\Allure\Internal;

use Qameta\Allure\StreamFactoryInterface;
use RuntimeException;

use function fopen;

/**
 * @internal
 */
final class StreamAttachment implements StreamFactoryInterface
{

    public function __construct(private string $link)
    {
    }

    /**
     * @return resource
     */
    public function createStream()
    {
        $stream = @fopen($this->link, 'rb');
        if (false === $stream) {
            throw new RuntimeException("Failed to open stream {$this->link}");
        }

        return $stream;
    }
}
