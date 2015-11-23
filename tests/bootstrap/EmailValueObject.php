<?php

use RedCrystal\Cast\ValueObject;

class EmailValueObject implements ValueObject
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
