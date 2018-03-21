<?php

namespace Tests\API\Post;

use Tests\TestCase;

class UpdateTest extends TestCase
{
    public function testUpdated()
    {
        // Create a post, then update it.
        $post     = $this->resources->post();
        $newTitle = $this->faker->sentence;
        $result   = $this->writedown->api()->post()->update($post->id, [
            'title' => $newTitle,
        ]);

        // Re-retrieve the post from the database and check the change was saved
        $post = $this->writedown->database()->getRepository('WriteDown\Entities\Post')
            ->findOneBy(['id' => $post->id]);

        // Annnnnd check it
        $this->assertTrue($result['success']);
        $this->assertEquals($newTitle, $post->title);
    }
}
