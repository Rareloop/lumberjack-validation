<?php

namespace Rareloop\Lumberjack\Validation\Test;

use PHPUnit\Framework\TestCase;
use Rareloop\Lumberjack\Validation\AbstractForm;
use Rareloop\Lumberjack\Validation\Validator;

class FormTest extends TestCase
{
    /** @test */
    public function can_declare_rules()
    {
        $form = new Form(new Validator);

        $this->assertFalse($form->validate([]));
        $this->assertTrue($form->validate(['name' => 'Joe']));
    }

    /** @test */
    public function error_messages_are_available_on_fail()
    {
        $form = new Form(new Validator);

        $form->validate([]);

        $this->assertSame([
            'name' => [
                'The Name is required',
            ],
        ], $form->errors());
    }

    /** @test */
    public function error_messages_are_empty_before_validate_is_called()
    {
        $form = new Form(new Validator);

        $this->assertSame([], $form->errors());
    }

    /** @test */
    public function can_retrieve_original_data_after_validation()
    {
        $data = ['name' => 'Joe'];
        $form = new Form(new Validator);

        $form->validate($data);

        $this->assertSame($data, $form->values());
    }

    /** @test */
    public function can_add_a_custom_message_for_errors()
    {
        $form = new FormWithCustomMessage(new Validator);

        $form->validate([]);

        $this->assertSame([
            'name' => [
                'Name missing',
            ],
        ], $form->errors());
    }

    /** @test */
    public function can_add_aliases_to_fields_with_custom_message()
    {
        $form = new FormWithAliases(new Validator);

        $form->validate([]);

        $this->assertSame([
            'name' => [
                'FOO missing',
            ],
            'email' => [
                'BAR missing',
            ],
        ], $form->errors());
    }

    /** @test */
    public function can_add_translations()
    {
        $form = new FormWithTranslations(new Validator);

        $form->validate(['nomor' => 10]);

        $this->assertSame([
            'nomor' => [
                "Nomor hanya memperbolehkan '1', '2', atau '3'",
            ],
        ], $form->errors());
    }

    /** @test */
    public function can_serialise_form_to_an_array()
    {
        $form = new Form(new Validator);

        $form->validate([
            'notname' => 'value'
        ]);

        $this->assertSame([
            'errors' => [
                'name' => [
                    'The Name is required',
                ],
            ],
            'values' => [
                'notname' => 'value',
            ]
        ], $form->toArray());
    }
}

class Form extends AbstractForm
{
    protected $rules = [
        'name' => 'required',
    ];
}

class FormWithCustomMessage extends AbstractForm
{
    protected $rules = [
        'name' => 'required',
    ];

    protected $messages = [
        'required' => ':attribute missing',
    ];
}

class FormWithAliases extends AbstractForm
{
    protected $rules = [
        'name' => 'required',
        'email' => 'required',
    ];

    protected $messages = [
        'required' => ':attribute missing',
    ];

    protected $aliases = [
        'name' => 'FOO',
        'email' => 'BAR',
    ];
}

class FormWithTranslations extends AbstractForm
{
    protected $rules = [
        'nomor' => 'in:1,2,3',
    ];

    protected $messages = [
        'in' => ':attribute hanya memperbolehkan :allowed_values'
    ];

    protected $translations = [
        'and' => 'dan',
        'or' => 'atau'
    ];
}
