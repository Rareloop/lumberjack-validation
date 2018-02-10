<?php

namespace Rareloop\Lumberjack\Validation;

interface FormInterface
{
    public function values();

    public function validate(array $data) : bool;

    public function errors();
}
