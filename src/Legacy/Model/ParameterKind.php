<?php

namespace Yandex\Allure\Adapter\Model;

/**
 * Parameter kind
 *
 * @deprecated Used only with legacy annotation {@see \Yandex\Allure\Adapter\Annotation\Parameter} and ignored by
 *      this implementation.
 */
final class ParameterKind
{
    const ARGUMENT = 'argument';
    const SYSTEM_PROPERTY = 'system-property';
    const ENVIRONMENT_VARIABLE = 'environment-variable';
}
