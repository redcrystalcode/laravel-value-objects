<?php

class CastsValueObjectTest extends TestCase
{
    public function testInstantiateModel()
    {
        $user = new UserModel();
        $this->assertInstanceOf(UserModel::class, $user);
    }

    public function testInstantiateValueObject()
    {
        $email = new EmailValueObject('user@example.com');
        $this->assertInstanceOf(EmailValueObject::class, $email);
    }

    public function testAttributeInObjectsHashIsCastToValueObject()
    {
        $user = new UserModel();
        $user->setInternalAttributes(['email' => $email = 'user@example.com']);

        $this->assertInstanceOf(EmailValueObject::class, $user->email);
        $this->assertEquals($email, $user->email->toScalar());
    }

    public function testAttributeInObjectsHashCanBeSetWithScalarValue()
    {
        $user = new UserModel();

        $user->email = $email = 'user@example.com';

        $this->assertInstanceOf(EmailValueObject::class, $user->email);
        $this->assertEquals($email, $user->email->toScalar());
    }

    public function testAttributeInObjectsHashCanBeSetWithValueObject()
    {
        $user = new UserModel();

        $user->email = $email = new EmailValueObject('user@example.com');
        $this->assertInstanceOf(EmailValueObject::class, $user->email);
        $this->assertEquals($email->toScalar(), $user->email->toScalar());
    }

    public function testCastedValueObjectRemainsTheSameInstance()
    {
        $user = new UserModel();

        $user->email = $instance1 = new EmailValueObject('user@example.com');
        $instance2 = $user->email;

        $this->assertTrue($instance1 === $instance2);

        $instance3 = $user->email;
        $this->assertTrue($instance1 === $instance3);
        $this->assertTrue($instance2 === $instance3);
    }

    public function testAttributeNotInObjectsHashRemainsUnaffected()
    {
        $user = new UserModel();
        $user->name = $name = 'John Doe';

        $this->assertTrue(is_string($user->name));
        $this->assertEquals($name, $user->name);
    }

    public function testCastableAttributeWithSetMutator()
    {
        $user = new UserModel();
        $user->uppercaseEmail = 'user@example.com';

        $this->assertInstanceOf(EmailValueObject::class, $user->uppercaseEmail);
        $this->assertEquals($user->getInternalAttributes()['uppercaseEmail'], $user->uppercaseEmail->toScalar());
    }

    public function testCastableAttributeWithGetMutator()
    {
        $user = new UserModel();
        $user->mutatedEmail = $original = 'user@example.com';

        $this->assertEquals($user->getInternalAttributes()['mutatedEmail'], $original);
        $this->assertInstanceOf(EmailValueObject::class, $user->mutatedEmail);
        $this->assertEquals($user->getMutatedEmailAttribute($original), $user->mutatedEmail->toScalar());
    }

    public function testValueObjectCacheIsInvalidatedWhenSettingScalar()
    {
        $user = new UserModel();

        $user->email = $email = 'user@example.com';

        $this->assertInstanceOf(EmailValueObject::class, $user->email);
        $this->assertEquals($email, $user->email->toScalar());

        $user->email = $email = 'someone@example.com';

        $this->assertInstanceOf(EmailValueObject::class, $user->email);
        $this->assertEquals($email, $user->email->toScalar());
    }

    public function testModelToArrayWithValueObjects()
    {
        $user = new UserModel();

        $user->email = $email = 'user@example.com';

        $array = $user->toArray();

        $this->assertArrayHasKey('email', $array);
        $this->assertTrue(is_string($array['email']));
        $this->assertFalse($array['email'] instanceof EmailValueObject);
    }

    public function testModelToJsonWithValueObjects()
    {
        $user = new UserModel();

        $user->email = $email = 'user@example.com';

        $json = $user->toJson();

        $this->assertJson($json);
        $this->assertJsonStringEqualsJsonString(json_encode(['email' => $email]), $json);
    }

    public function testNullValuesDontGetCast()
    {
        $user = new UserModel();

        $this->assertNull($user->email);
    }

    public function testEmptyStringValuesDontGetCast()
    {
        $user = new UserModel();

        $user->setInternalAttributes(['email' => '']);

        $this->assertNull($user->email);
    }
}
