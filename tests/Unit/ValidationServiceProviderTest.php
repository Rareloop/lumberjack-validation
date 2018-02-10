<?php

namespace Rareloop\Lumberjack\Validation\Test;

use PHPUnit\Framework\TestCase;
use Rareloop\Lumberjack\Application;
use Rareloop\Lumberjack\Validation\AbstractForm;
use Rareloop\Lumberjack\Validation\ValidationServiceProvider;
use Rareloop\Lumberjack\Validation\Validator;
use Rareloop\Lumberjack\Validator\Contracts\Validator as ValidatorInterface;

class ValidationServiceProviderTest extends TestCase
{
    /** @test */
    public function can_create_a_validator_from_container()
    {
        $app = new Application;

        $provider = new ValidationServiceProvider($app);
        $provider->boot();

        $validator1 = $app->make(Validator::class);
        $validator2 = $app->make(Validator::class);

        $this->assertInstanceOf(Validator::class, $validator1);
        $this->assertInstanceOf(Validator::class, $validator2);

        // Make sure these are unique objects - e.g. not a singleton
        $this->assertFalse($validator1 === $validator2);
    }

    /** @test */
    public function registered_rules_are_added_to_all_instances_created_from_the_container()
    {
        $app = new Application;
        $customRule = new TestRule;

        $provider = new ValidationServiceProvider($app);
        $provider->boot();

        $data = [
            'email' => 'non-valid-email'
        ];

        Validator::extend('emailtestrule', $customRule);

        $validator1 = $app->make(Validator::class);
        $validator2 = $app->make(Validator::class);

        $this->assertTrue($validator1->validate($data, [
            'email' => 'emailtestrule',
        ])->fails());

        $this->assertTrue($validator2->validate($data, [
            'email' => 'emailtestrule',
        ])->fails());
    }
}

class TestRule extends \Rakit\Validation\Rules\Email {}
