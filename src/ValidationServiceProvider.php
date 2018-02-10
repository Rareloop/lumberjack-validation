<?php

namespace Rareloop\Lumberjack\Validation;

use Rareloop\Lumberjack\Providers\ServiceProvider;
use Rareloop\Lumberjack\Validation\Validator;

class ValidationServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->bind(Validator::class, function () {
            $validator = new Validator;

            foreach (Validator::getRules() as $name => $rule) {
                $validator->addValidator($name, $rule);
            }


            return $validator;
        });
    }
}
