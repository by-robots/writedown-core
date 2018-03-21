<?php

namespace Tests\API\Post;

use Tests\TestCase;
use WriteDown\Entities\Post;

class CreateTest extends TestCase
{
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
            ->getRepository('WriteDown\Entities\Post')
            ->findOneBy(['id' => $post['data']->id]);

        // Check it
        $this->assertEquals($post['data']->id, $result->id);
    }

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

    public function testValidationNoBody()
    {
        $result = $this->writedown->api()->post()->create([
            'slug'  => $this->faker->slug,
            'title' => $this->faker->sentence,
        ]);

        $this->assertFalse($result['success']);
        $this->assertArrayHasKey('body', $result['data']);
    }

    public function testOnlyFillable()
    {
        $result = $this->writedown->api()->post()->create([
            'title'        => $this->faker->sentence,
            'body'         => $this->faker->paragraph,
            'not_fillable' => $this->faker->word,
        ]);

        $this->assertFalse(property_exists($result['data'], 'not_fillable'));
    }
}
