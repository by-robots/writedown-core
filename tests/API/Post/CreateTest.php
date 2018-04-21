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
        $post = $this->writedown->api()->post()->create([
            'body'       => $this->faker->paragraph,
            'publish_at' => new \DateTime('now'),
            'slug'       => $this->faker->slug,
            'title'      => $this->faker->sentence,
        ]);

        // Check we have something
        $this->assertTrue($post['success']);

        // Now attempt to retrieve it from the database to make sure it's been
        // stored
        $result = $this->writedown->database()
            ->getRepository('WriteDown\Database\Entities\Post')
            ->findOneBy(['id' => $post['data']->id]);

        // Check it
        $this->assertEquals($post['data']->id, $result->id);
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
            'title'        => $this->faker->sentence,
            'body'         => $this->faker->paragraph,
            'not_fillable' => $this->faker->word,
        ]);

        $this->assertFalse(property_exists($result['data'], 'not_fillable'));
    }

    public function testSlugGenerated()
    {
        $result = $this->writedown->api()->post()->create([
            'title' => $this->faker->sentence,
            'body'  => $this->faker->paragraph,
        ]);

        $this->assertNotNull($result['data']->slug);
    }

    public function testSlugGeneratedWhenAttributeEmpty()
    {
        $result = $this->writedown->api()->post()->create([
            'title' => $this->faker->sentence,
            'body'  => $this->faker->paragraph,
            'slug'  => '',
        ]);

        $this->assertNotNull($result['data']->slug);
    }

    public function testSlugNotOverwritten()
    {
        $expected = $this->faker->slug;
        $result   = $this->writedown->api()->post()->create([
            'title' => $this->faker->sentence,
            'body'  => $this->faker->paragraph,
            'slug'  => $expected,
        ]);

        $this->assertEquals($expected, $result['data']->slug);
    }

    /**
     * It must not be possible to create a post with a slug that's already in
     * use. As such, the database will prevent this with a unique key but
     * WriteDown should handle it elegantly.
     */
    public function testCantDuplicateSlugManually()
    {
        // Create a post
        $post = $this->resources->post();

        // Now try to create another post with the same slug
        $result = $this->writedown->api()->post()->create([
            'title' => $this->faker->sentence,
            'body'  => $this->faker->paragraph,
            'slug'  => $post->slug,
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
            'title' => $post->title,
            'body'  => $this->faker->paragraph,
        ]);

        // Check the slugs are different
        $this->assertNotEquals($result['data']->slug, $post->slug);
    }
}
