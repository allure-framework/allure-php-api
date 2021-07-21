<?php

declare(strict_types=1);

namespace Qameta\Allure;

use JsonSerializable;
use Qameta\Allure\Internal\StreamAttachment;
use Qameta\Allure\Internal\StringAttachment;

use function json_encode;

use const JSON_PRETTY_PRINT;
use const JSON_UNESCAPED_UNICODE;

final class AttachmentFactory
{

    public static function fromFile(string $file): StreamFactory
    {
        return self::fromStream("file://{$file}");
    }

    public static function fromStream(string $link): StreamFactory
    {
        return new StreamAttachment($link);
    }

    public static function fromString(string $data): StreamFactory
    {
        return new StringAttachment($data);
    }

    public static function fromSerializable(JsonSerializable $object): StreamFactory
    {
        return self::fromString(
            json_encode(
                $object,
                JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
            )
        );
    }
}
