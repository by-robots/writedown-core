<?php

namespace Tests\API\Post;

use Faker\Factory;
use Tests\TestCase;
use WriteDown\Entities\Post;

class CreateTest extends TestCase
{
    public function testCreated()
    {
        // Create a post
        $faker = Factory::create();
        $post  = $this->writedown->api()->post()->create([
            'title'      => $faker->sentence,
            'slug'       => $faker->slug,
            'body'       => $faker->paragraph,
            'publish_at' => new \DateTime('now'),
        ]);

        // Check we have something
        $this->assertTrue($post['success']);

        // Now attempt to retrieve it from the database to make sure it's been
        // stored
        $result = $this->writedown->database()
            ->getRepository('WriteDown\Entities\Post')
            ->findOneBy(['id' => $post->id]);

        // Check it
        $this->assertEquals($post['data']->id, $result->id);
    }
}
