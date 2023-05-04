# Lumberjack Validation
![CI](https://travis-ci.org/Rareloop/lumberjack-validation.svg?branch=master)
![Coveralls](https://coveralls.io/repos/github/Rareloop/lumberjack-validation/badge.svg?branch=master)

This package provides a simple way to validate form input. At it's heart it is a thin wrapper around the Rakit Validation library. For documentation on the types of rules you can use refer to their (Github docs)[https://github.com/rakit/validation.

Once installed, register the Service Provider in `config/app.php`:

```php
'providers' => [
    ...

    Rareloop\Lumberjack\Validation\ValidationServiceProvider::class,

    ...
],
```

You can now create Form objects that can be used to validate for your form submissions:

## Create a Form Object

```php
class ContactForm extends AbstractForm
{
    protected $rules = [
        'name' => 'required',
        'email' => 'required|email'
    ];
}
```

## Use the form to validate input

Your form can be injected into your Lumberjack Controllers and then used this this:

```php
use App\Forms\ContactForm;

class IndexController
{
    public function handle(ContactForm $form)
    {
        if ($form->validate($_POST)) {
            // Everything's good - do something with the input
        } else {
            $errors = $form->errors();
            $values = $form->values();
            // Re-show the form with the errors and entered values
        }
    }
}
```

## Adding custom messages

You can add custom validation messages per rule by adding a `protected $messages` variable to your form.

[See the documentation](https://github.com/rakit/validation#custom-validation-message) for a list of the variables that are available within your message.

```php
class ContactForm extends AbstractForm
{
    protected $rules = [
        'name' => 'required',
        'email' => 'required|email'
    ];

    protected $messages = [
        'required' => ':attribute missing',
    ];
}
```

## Adding custom attribute aliases

If you need to change how a field's name is presented in the error message, you can add an alias for it.

For example, if we had the field `district_id`, by default any validation errors for this field would look something like this:

> The District id field is required

Instead, you can add an alias by adding a `protected $alias` variable to your form. For example we can change the output to be:

> The District field is required

[See the documentation](https://github.com/rakit/validation#attribute-alias) for more information.

```php
class ContactForm extends AbstractForm
{
    protected $rules = [
        'province_id' => 'required',
        'district_id' => 'required',
    ];

    protected $aliases = [
        'province_id' => 'Province',
        'district_id' => 'District',
    ];
}
```
