<?php

declare(strict_types=1);

namespace Qameta\Allure\Internal;

use function array_pop;

final class ThreadContext implements ThreadContextInterface
{

    private const DEFAULT_THREAD = '__default';

    /**
     * @var array<string, list<string>>
     */
    private array $stacksByThread = [];

    private string $thread = self::DEFAULT_THREAD;

    public function switchThread(?string $thread): ThreadContextInterface
    {
        $this->thread = $thread ?? self::DEFAULT_THREAD;

        return $this;
    }

    public function reset(): ThreadContextInterface
    {
        unset($this->stacksByThread[$this->thread]);

        return $this;
    }

    public function push(string $uuid): ThreadContextInterface
    {
        $this->stacksByThread[$this->thread] ??= [];
        $this->stacksByThread[$this->thread][] = $uuid;

        return $this;
    }

    public function pop(): ThreadContextInterface
    {
        if (isset($this->stacksByThread[$this->thread])) {
            array_pop($this->stacksByThread[$this->thread]);

            if (empty($this->stacksByThread[$this->thread])) {
                $this->reset();
            }
        }

        return $this;
    }

    public function getCurrentTest(): ?string
    {
        return $this->stacksByThread[$this->thread][0] ?? null;
    }

    public function getCurrentStep(): ?string
    {
        $top = array_key_last($this->stacksByThread[$this->thread] ?? []);

        return isset($top) && $top > 0
            ? $this->stacksByThread[$this->thread][$top] ?? null
            : null;
    }
}
