<?php

namespace Tests\Slugs;

use Tests\TestCase;
use WriteDown\Slugs\Tools\UniqueSlug as Provider;

class UniqueSlug extends TestCase
{
    /**
     * The UniqueSlug class.
     *
     * @var \WriteDown\Slugs\Tools\UniqueSlug
     */
    private $uniqueSlug;

    /**
     * Set-up for the tests.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->uniqueSlug = new Provider($this->writedown->database());
    }

    /**
     * If the slug already exists in the database it should return isUnique()
     * should return false.
     */
    public function testIsUniqueReturnsFalse()
    {
        $post = $this->resources->post();
        $this->assertFalse($this->uniqueSlug->isUnique($post->slug));
    }

    /**
     * If the slug does not exist isUnique() should return true.
     */
    public function testIsUniqueReturnsTrue()
    {
        $this->assertTrue($this->uniqueSlug->isUnique($this->faker->slug));
    }

    /**
     * When the slug is unique, isUniqueExcept should return true.
     */
    public function testIsUniqueExceptReturnsTrue()
    {
        $post = $this->resources->post();
        $this->assertTrue($this->uniqueSlug->isUniqueExcept($this->faker->slug, $post->id));
    }

    /**
     * When the slug matches the post ID isUniqueExcept should return true.
     */
    public function testReturnsTrueWhenSlugMatchesID()
    {
        $post = $this->resources->post();
        $this->assertTrue($this->uniqueSlug->isUniqueExcept($post->slug, $post->id));
    }

    /**
     * When the slug can be matched and the ID does not match the post with the
     * slug, isUniqueExcept should return false.
     */
    public function testReturnsFalseWhenSlugDuplicate()
    {
        $post = $this->resources->post();
        $this->assertFalse($this->uniqueSlug->isUniqueExcept($post->slug, mt_rand(1000, 9000)));
    }
}
