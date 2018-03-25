<?php

namespace Tests\Emails;

use Tests\TestCase;
use WriteDown\Emails\Emails as Provider;

class Emails extends TestCase
{
    /**
     * The UniqueSlug class.
     *
     * @var \WriteDown\Emails\Emails
     */
    private $emails;

    /**
     * Set-up for the tests.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->emails = new Provider($this->writedown->database());
    }

    /**
     * If the email already exists in the database it should return isUnique()
     * should return false.
     */
    public function testIsUniqueReturnsFalse()
    {
        $user = $this->resources->user();
        $this->assertFalse($this->emails->isUnique($user->email));
    }

    /**
     * If the email does not exist isUnique() should return true.
     */
    public function testIsUniqueReturnsTrue()
    {
        $this->assertTrue($this->emails->isUnique($this->faker->slug));
    }

    /**
     * When the slug is unique, isUniqueExcept should return true.
     */
    public function testIsUniqueExceptReturnsTrue()
    {
        $user = $this->resources->user();
        $this->assertTrue($this->emails->isUniqueExcept($this->faker->email, $user->id));
    }

    /**
     * When the email matches the post ID isUniqueExcept should return true.
     */
    public function testReturnsTrueWhenEmailMatchesID()
    {
        $user = $this->resources->user();
        $this->assertTrue($this->emails->isUniqueExcept($user->email, $user->id));
    }

    /**
     * When the email can be matched and the ID does not match the user with the
     * email, isUniqueExcept should return false.
     */
    public function testReturnsFalseWhenEmailDuplicate()
    {
        $user = $this->resources->user();
        $this->assertFalse($this->emails->isUniqueExcept($user->email, mt_rand(1000, 9000)));
    }
}
