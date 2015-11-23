## Laravel Value Objects

Cast your Eloquent model attributes to value objects with ease!

### Install

Require this package with composer using the following command:

```bash
composer require redcrystal/cast
```

### Set Up

This package lets you easily cast your model attributes to Value Objects that implement our `RedCrystal\Cast\ValueObject` interface. A simple example is provided below.

```php
<?php
namespace App\ValueObjects;

use RedCrystal\Cast\ValueObject;

class Email implements ValueObject
{
    protected $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function toScalar()
    {
        return $this->value;
    }

    public function __toString() {
        return $this->toScalar();
    }
}
```

Set up your model by using the included `Trait` and adding a tiny bit of configuration.

```php
<?php

namespace App;

use App\ValueObjects\Email;
use Illuminate\Database\Eloquent\Model;
use RedCrystal\Cast\CastsValueObjects;

class User extends extends Model {
	use CastsValueObjects;

	
	protected $objects = [
		// name of the attribute => name of the value object class
		'email' => Email::class
	];
	
	// ...
}
```

### Usage

When accessing attributes of your model normally, any attribute you've set up for casting will be returned as an instance of the Value Object.

```php
$user = User::find($id);

$user->email; // returns instance of App\ValueObjects\Email
$user->email->toScalar(); // "someone@example.com"
(string) $user->email; // "someone@example.com"
```

You can set an attribute set up for casting with either a scalar (native) value, or an instance of the Value Object.

```php
$user = new User();

$user->email = "someone@example.com";
$user->email = new Email("someone@example.com");
```

### License
This package is open-source software licensed under the [MIT license](http://opensource.org/licenses/MIT).
