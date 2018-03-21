<?php

namespace Tests\API\Post;

use Tests\TestCase;

class UpdateTest extends TestCase
{
    /**
     * When all is well a post should be updated.
     */
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

    /**
     * When a post is not found this should be indicated in the response.
     */
    public function testPostMissing()
    {
        // Attempt to update a post that doesn't exist
        $result = $this->writedown->api()->post()->update(mt_rand(1000, 9999), [
            'title' => $this->faker->sentence,
        ]);

        // Check the result
        $this->assertFalse($result['success']);
        $this->assertEquals(['Not found.'], $result['data']);
    }

    /**
     * Only attributes marked as fillable should be fillable.
     */
    public function testOnlyFillable()
    {
        $post     = $this->resources->post();
        $newTitle = $this->faker->sentence;
        $result   = $this->writedown->api()->post()->update($post->id, [
            'not_fillable' => $this->faker->word,
        ]);

        $this->assertFalse(property_exists($result['data'], 'not_fillable'));
    }
}
