<?php

namespace Rareloop\Lumberjack\Validation;

use Rareloop\Lumberjack\Validation\FormInterface;
use Rareloop\Lumberjack\Validation\Validator;

abstract class AbstractForm implements FormInterface
{
    protected $data = [];
    protected $rules = [];
    protected $messages = [];
    protected $aliases = [];
    protected $translations = [];
    protected $validator;
    protected $validation;

    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    public function validate(array $data): bool
    {
        $this->data = $data;

        if (!empty($this->translations)) {
            $this->validator->setTranslations($this->translations);
        }

        $this->validation = $this->validator->make($this->data, $this->rules, $this->messages);

        if (!empty($this->aliases)) {
            $this->validation->setAliases($this->aliases);
        }


        $this->validation->validate();

        if ($this->validation->fails()) {
            return false;
        }

        return true;
    }

    public function errors()
    {
        if (!isset($this->validation)) {
            return [];
        }

        $errors = $this->validation->errors()->toArray();

        // Flatten the array so each field has an array of messages
        $errors = collect($errors)->map(function ($item) {
            return array_values($item);
        });

        return $errors->toArray();
    }

    public function values()
    {
        return $this->data;
    }

    public function toArray()
    {
        return [
            'errors' => $this->errors(),
            'values' => $this->values(),
        ];
    }
}
