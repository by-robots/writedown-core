<?php

namespace Tests\API\Post;

use Tests\TestCase;

class CreateTest extends TestCase
{
    /**
     * Tests that a post can be created when the data is valid.
     */
    public function testCreated()
    {
        // Create a post
        $body      = $this->faker->paragraph;
        $publishAt = new \DateTime('now');
        $slug      = $this->faker->slug;
        $title     = $this->faker->title;
        $post      = $this->writedown->api()->post()->create([
            'body'       => $body,
            'publish_at' => $publishAt,
            'slug'       => $slug,
            'title'      => $title,
        ]);

        // Check we have something
        $this->assertTrue($post['success']);
        $this->assertEquals($body, $post['data']->body);
        $this->assertEquals($publishAt, $post['data']->publish_at);
        $this->assertEquals($slug, $post['data']->slug);
        $this->assertEquals($title, $post['data']->title);
    }

    /**
     * Tests that a post can't be created without a title.
     */
    public function testValidationNoTitle()
    {
        // Attempt to create a post without a title.
        $result = $this->writedown->api()->post()->create([
            'body' => $this->faker->paragraph,
            'slug' => $this->faker->slug,
        ]);

        // Check the error was as expected
        $this->assertFalse($result['success']);
        $this->assertArrayHasKey('title', $result['data']);
    }

    /**
     * Test a post can not be created with no body content.
     */
    public function testValidationNoBody()
    {
        $result = $this->writedown->api()->post()->create([
            'slug'  => $this->faker->slug,
            'title' => $this->faker->sentence,
        ]);

        $this->assertFalse($result['success']);
        $this->assertArrayHasKey('body', $result['data']);
    }

    /**
     * Test columns that aren't marked as fillable can't be populated.
     */
    public function testOnlyFillable()
    {
        $result = $this->writedown->api()->post()->create([
            'body'         => $this->faker->paragraph,
            'not_fillable' => $this->faker->word,
            'title'        => $this->faker->sentence,
        ]);

        $this->assertTrue($result['success']);
        $this->assertFalse(property_exists($result['data'], 'not_fillable'));
    }

    /**
     * A slug should be generated automatically when one isn't supplied.
     */
    public function testSlugGenerated()
    {
        $result = $this->writedown->api()->post()->create([
            'body'  => $this->faker->paragraph,
            'title' => $this->faker->sentence,
        ]);

        $this->assertTrue($result['success']);
        $this->assertNotNull($result['data']->slug);
    }

    /**
     * When the slug passed is an empty string it should be automatically
     * generated.
     */
    public function testSlugGeneratedWhenAttributeEmpty()
    {
        $result = $this->writedown->api()->post()->create([
            'body'  => $this->faker->paragraph,
            'slug'  => '',
            'title' => $this->faker->sentence,
        ]);

        $this->assertTrue($result['success']);
        $this->assertNotNull($result['data']->slug);
    }

    /**
     * When the slug is specified it should not be automatically generated
     * and replaced.
     */
    public function testSlugNotOverwritten()
    {
        $expected = $this->faker->slug;
        $result   = $this->writedown->api()->post()->create([
            'body'  => $this->faker->paragraph,
            'slug'  => $expected,
            'title' => $this->faker->sentence,
        ]);

        $this->assertTrue($result['success']);
        $this->assertEquals($expected, $result['data']->slug);
    }

    /**
     * It must not be possible to create a post with a slug that's already in
     * use. As such, the database will prevent this with a unique key but
     * ByRobots\WriteDown should handle it elegantly.
     */
    public function testCantDuplicateSlugManually()
    {
        // Create a post
        $post = $this->resources->post();

        // Now try to create another post with the same slug
        $result = $this->writedown->api()->post()->create([
            'body'  => $this->faker->paragraph,
            'slug'  => $post->slug,
            'title' => $this->faker->sentence,
        ]);

        // Check that was rejected
        $this->assertFalse($result['success']);
        $this->assertArrayHasKey('slug', $result['data']);
    }

    /**
     * A slug must not be duplicated when it's automatically generated.
     */
    public function testSlugDuplicationOnGeneration()
    {
        // Create a post
        $post = $this->resources->post();

        // Now try to create another post with the same title.
        $result = $this->writedown->api()->post()->create([
            'body'  => $this->faker->paragraph,
            'title' => $post->title,
        ]);

        // Check the slugs are different
        $this->assertNotEquals($result['data']->slug, $post->slug);
    }
}
