<?php

namespace Tests\Misc;

use Tests\TestCase;
use WriteDown\Slugs\UniqueSlug as Provider;

class UniqueSlug extends TestCase
{
    /**
     * If the slug already exists in the database it should return isUnique()
     * should return false.
     */
    public function testIsUniqueReturnsFalse()
    {
        $uniqueSlug = new Provider($this->writedown->database());
        $post       = $this->resources->post();

        $this->assertFalse($uniqueSlug->isUnique($post->slug));
    }

    /**
     * If the slug does not exist isUnique() should return true.
     */
    public function testIsUniqueReturnsTrue()
    {
        $uniqueSlug = new Provider($this->writedown->database());
        $this->assertTrue($uniqueSlug->isUnique($this->faker->slug));
    }
}
