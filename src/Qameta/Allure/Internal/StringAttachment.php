<?php

declare(strict_types=1);

namespace Qameta\Allure\Internal;

use Qameta\Allure\StreamFactory;
use RuntimeException;

use Throwable;
use function fclose;
use function fopen;
use function fwrite;
use function rewind;

final class StringAttachment implements StreamFactory
{

    public function __construct(private string $data)
    {
    }

    /**
     * @return resource
     */
    public function createStream()
    {
        $stream = @fopen('php://temp', 'r+b');
        if (false === $stream) {
            throw new RuntimeException("Failed to open memory stream");
        }
        try {
            if (false === @fwrite($stream, $this->data)) {
                throw new RuntimeException("Failed to write data in memory stream");
            }
            if (false == @rewind($stream)) {
                throw new RuntimeException("Failed to rewind memory stream");
            }
        } catch (Throwable $e) {
            @fclose($stream);
            throw $e;
        }

        return $stream;
    }
}
