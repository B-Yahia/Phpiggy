<?php

declare(strict_types=1);

namespace Framework\Rules;

use Framework\Contracts\RuleInterface;


class MinRule implements RuleInterface
{
    public function validate(array $data, string $field, array $params): bool
    {
        if (empty($params[0])) {
            throw new \InvalidArgumentException("Min rule must have a parameter");
        }
        $length = (int) $params[0];
        return $data[$field] >= $length;
    }
    public function getMessage(array $data, string $field, array $params): string
    {
        return "The " . $field . " must be at least " . $params[0];
    }
}
