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
