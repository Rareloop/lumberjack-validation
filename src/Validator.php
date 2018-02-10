<?php

namespace Rareloop\Lumberjack\Validation;

use Rakit\Validation\Rule;
use Rakit\Validation\Validator as RakitValidator;

class Validator extends RakitValidator
{
    protected static $customRules = [];

    public static function extend($name, Rule $rule)
    {
        static::$customRules[$name] = $rule;
    }

    public static function getRules() : array
    {
        return static::$customRules;
    }
}
