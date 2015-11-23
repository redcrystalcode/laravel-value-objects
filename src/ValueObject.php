<?php
namespace RedCrystal\Cast;

/**
 * Interface ValueObject
 *
 * @package RedCrystal\Cast
 */
interface ValueObject
{
    /**
     * @param $value
     */
    public function __construct($value);

    /**
     * @return mixed
     */
    public function toScalar();

    /**
     * @return string
     */
    public function __toString();

}
