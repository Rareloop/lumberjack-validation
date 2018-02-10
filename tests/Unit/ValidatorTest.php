<?php

namespace Rareloop\Lumberjack\Validation\Test;

use PHPUnit\Framework\TestCase;
use Rareloop\Lumberjack\Application;
use Rareloop\Lumberjack\Validation\AbstractForm;
use Rareloop\Lumberjack\Validation\ValidationServiceProvider;
use Rareloop\Lumberjack\Validation\Validator;
use Rareloop\Lumberjack\Validator\Contracts\Validator as ValidatorInterface;

class ValidatorTest extends TestCase
{
    /** @test */
    public function can_register_new_rules()
    {
        $app = new Application;
        $customRule = new EmailTestRule;

        Validator::extend('testrule', $customRule);

        $rules = Validator::getRules();

        $this->assertArrayHasKey('testrule', $rules);
        $this->assertSame($customRule, $rules['testrule']);
    }
}

class EmailTestRule extends \Rakit\Validation\Rules\Email {}
