<?php

use RedCrystal\Cast\CastsValueObjects;

class UserModel extends \Illuminate\Database\Eloquent\Model
{
    use CastsValueObjects;

    protected $objects = [
        'email' => EmailValueObject::class,
        'uppercaseEmail' => EmailValueObject::class,
        'mutatedEmail' => EmailValueObject::class
    ];

    // Laravel/Eloquent magic mutator
    public function setUppercaseEmailAttribute($value)
    {
        $this->attributes['uppercaseEmail'] = strtoupper($value);
    }

    // Laravel/Eloquent magic mutator
    public function getMutatedEmailAttribute($value)
    {
        return str_replace('example.com', 'redcode.io', $value);
    }

    // In order to assist with testing, I've added a few methods to expose internals.
    public function getInternalAttributes()
    {
        return $this->attributes;
    }

    public function setInternalAttributes(array $attributes)
    {
        $this->attributes = $attributes;
    }
}
